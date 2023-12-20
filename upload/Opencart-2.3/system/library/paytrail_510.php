<?php
class Paytrail_510 {

	public function __construct($checkout_merchant, $checkout_secret, $headers, $body){

        $this->checkout_merchant = $checkout_merchant;
        $this->checkout_secret = $checkout_secret;
        $this->headers = $headers;
        $this->body = $body;
        $this->cof_request_id = null;

	}

	public function send(){

        require_once( DIR_SYSTEM . 'pm-extension/vendor/autoload.php');
        require_once( DIR_SYSTEM . 'pm-extension/vendor/guzzlehttp/guzzle/src/Client.php');
            $client = new \Guzzlehttp\Client(array('headers' => $this->headers));
            $response = null;
            try {
               $response = $client->post('https://services.paytrail.com/payments', array('body' => $this->body));
            } catch (\GuzzleHttp\Exception\ClientException $e) {
               if ($e->hasResponse()) {
                  $response = $e->getResponse();
                  echo "Unexpected HTTP status code: {$response->getStatusCode()}\n\n";
              }
           }

           $data['response'] = '';

           $responseBody = $response->getBody()->getContents();
              // Flatten Guzzle response headers
              $responseHeaders = array_column(array_map(function ($key, $value) {
                return [ $key, $value[0] ];
             }, array_keys($response->getHeaders()), array_values($response->getHeaders())), 1, 0);
             
            $responseHmac = $this->calculateHmac($responseHeaders,$responseBody);
              if (!isset( $response->getHeader('signature')[0]) || isset($response->getHeader('signature')[0]) && $responseHmac !== $response->getHeader('signature')[0]) {
                  echo "<pre>
                    Response HMAC signature mismatch!
                   </pre>";
              } else {
                  $data['response'] =  json_encode(json_decode($responseBody), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
              }


            $this->cof_request_id =  "\n\nRequest ID: {$response->getHeader('request-id')[0]}\n\n";

          return $data['response'];
	}
    
	protected function calculateHmac($params, $body){
       $includedKeys = array_filter(array_keys($params), function ($key) {
           return  preg_match('/^checkout-/', $key);
       });
        sort($includedKeys, SORT_STRING);
        $hmacPayload = array_map(
            function ($key) use ($params) {
                return join(':', [ $key, $params[$key] ]);
            },
            $includedKeys
        );

        array_push($hmacPayload, $body);

       return hash_hmac('sha256', join("\n", $hmacPayload), $this->checkout_secret);
    }

	public function getRequestId(){
		return $this->cof_request_id;
    }
}
?>