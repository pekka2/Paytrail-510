<?php
class ControllerPaymentPaytrail510 extends Controller {
  private $paytrail_merchant = false;
  private $checkout_secret = '';
	public function index() {
    require_once(DIR_SYSTEM . 'library/paytrail_510.php');

		$data = array();
		$data = array_merge($data,$this->load->language('payment/paytrail_510'));
    
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
        if($this->config->get('paytrail_510_sandbox')){
           $this->paytrail_merchant = 375917;
           $this->checkout_secret = 'SAIPPUAKAUPPIAS';
        } else {
            $this->paytrail_merchant = trim($this->config->get('paytrail_510_merchant'));
            $this->checkout_secret = trim($this->config->get('paytrail_510_security'));
        }
        $checked = $this->getBody();

        $error = false;

        if(isset($checked['error'])){
          echo "<pre>";
          echo $checked['error'];
          echo "</pre>";
          $error = true;
        }

        if(!$error){
            $paytrail = new paytrail_510($this->paytrail_merchant,$this->checkout_secret, $this->getHeader(), $this->getBody());

            $response = $paytrail->send();
            $cof_request_id = $paytrail->getRequestId();

            $payment = json_decode($response);

            $data['providers'] = array();
            $data['error'] = '';

            if(isset($payment->providers)){
                $data['providers'] = $payment->providers;
            } else {
                $data['error'] = $response;
            }
      }

        $data['back'] = $this->url->link('checkout/cart');

		return $this->load->view('payment/paytrail_510', $data);
	}

  public function getHeader() {
        $headers = array(
                         'checkout-account' => $this->paytrail_merchant,
                         'checkout-algorithm' => 'sha256',
                         'checkout-method' => 'POST',
                         'checkout-nonce' => '564635208570151',
                         'checkout-timestamp' => date('Y-m-d\TH:i:s.Z\Z', time()),
                         'content-type' => 'application/json; charset=utf-8',
                         'checkout-transaction-id' => $this->session->data['order_id']
                );
          
            $headers['signature'] = $this->calculateHmac($headers, $this->getBody());
        return $headers;
  }
  public function getBody() {


        $this->load->model("payment/paytrail_510");
        $this->load->model('checkout/order');
        $this->load->language('payment/paytrail_510');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
      
             // Käsittelykult
        if($order_info['total'] > 0) {

                 $item[] = array(
                                      'unitPrice' => (int)round($order_info['total'] * 100,0),
                                      'units' => (int)1,
                                      'vatPercentage' => (int)24,
                                      'productCode' => '#'. $this->session->data['order_id'],
                                      'deliveryDate' => date('Y-m-d')
                 );
            }
        
       $product_total = $this->cart->getTotal();
       $products = round($product_total,2);
     
        $error = '';
        $shipping = 0;

            if(isset($this->session->data['shipping_method']['cost'])){
               $shipping = round($this->tax->calculate($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id'], $this->config->get('config_tax')),2);
            }

        if($products == $order_info['total'] && $shipping > 0){
              $error = $this->language->get('error_order_totals');
        }

     if(!$error){  
        $body = json_encode(array(
            'stamp' => '#' . $this->session->data['order_id'] . '_' . date('Y-m-d G:i:s'),
            'reference' => (string)$this->session->data['order_id'],
            'amount' => round($order_info['total'] * 100,0),
            'currency' => 'EUR',
            'language' => 'FI',
            'items' => $item,
            'customer' => array(
                'email' => $order_info['email'],
                'firstName' => $order_info['firstname'],
                'lastName' => $order_info['lastname'],
                'phone' => $order_info['telephone']
            ),
            'deliveryAddress' => array(
                'streetAddress' => $order_info['shipping_address_1'],
                'postalCode' => $order_info['shipping_postcode'],
                'city' => $order_info['shipping_city'],
                'county' => $order_info['shipping_zone'],
                'country' => 'FI'
            ),
            'invoicingAddress' => array(
                'streetAddress' => $order_info['payment_address_1'],
                'postalCode' => $order_info['payment_postcode'],
                'city' => $order_info['payment_city'],
                'county' => $order_info['shipping_zone'],
                'country' => 'FI'
            ),
            'redirectUrls' => array(
                'success' => $this->url->link('payment/paytrail_510/complete'),
                'cancel' => $this->url->link('payment/paytrail_510/cancel')
            ),
                    'callbackUrls' => array(
                       'success' => $this->url->link('payment/paytrail_510/complete'),
                       'cancel' => $this->url->link('payment/paytrail_510/cancel')
                    )
                ), JSON_UNESCAPED_SLASHES
        );
      } else {
        $body = array( 'error' => $error );
      }
        return $body; 
    }

    public function complete() {
    
      $this->language->load('payment/paytrail_510');
      $this->load->model('checkout/order');

      $amount = $this->request->get['checkout-amount'];
      $return_authcode = $this->request->get['signature'];
      $reference = trim($this->request->get['checkout-reference']);
      $transaction_id = $this->request->get['checkout-transaction-id'];
      $status = $this->request->get['checkout-status'];
      $provider = $this->request->get['checkout-provider'];
      $str_len = strlen($return_authcode);

      $order_id = $reference;

            $order_info = $this->model_checkout_order->getOrder($order_id);

     if($order_id && $str_len > 20 && $amount > 0 && $status == 'ok'){

        if($order_info['order_status_id'] != $this->config->get('paytrail_510_order_status_id')){
    
            $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `payment_method` = '" . $this->language->get('text_title') . "  (" . $provider . ")', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('paytrail_510_order_status_id'), "", true);
           
          $string =  'STATUS: ' . $status . ', ' . $this->language->get('text_paid_success') . '; CHECKOUT TRANSACTION ID: ' . $transaction_id . '; MAKSAJAN PANKKI: ' . $provider . ', ORDER ID: ' . $order_id . '; SUMMA: ' . $amount/100;
          $log = new Log("paytrail-510.log");
          $log->write($string);
        }

        $this->response->redirect($this->url->link('checkout/success', true));   
     } elseif($status !='ok'){
          $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `payment_method` = '" . $this->language->get('text_title') . " (" . $provider . ")', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
          $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('paytrail_510_order_cancel_status_id'), "", true);
       
          $string =  'STATUS: ' . $status . ', ' .$this->language->get('text_paid_cancel') . '; CHECKOUT TRANSACTION ID: ' . $transaction_id . '; MAKSAJAN PANKKI: ' . $provider . '; ORDER ID: ' . $order_id . '; SUMMA: ' . $amount/100;

          $log = new Log('paytrail-510.log');
          $log->write($string);
          $log2 = new Log('paytrail-510-failed.log');
          $log2->write($string);
          $this->response->redirect($this->url->link('checkout/cart', true));   
     }
    }

    public function cancel() {
    
        $this->language->load('payment/paytrail_510');
        $this->load->model('checkout/order');

        $amount = $this->request->get['checkout-amount'];
        $return_authcode = $this->request->get['signature'];
        $reference = trim($this->request->get['checkout-reference']);
        $transaction_id = $this->request->get['checkout-transaction-id'];
        $status = $this->request->get['checkout-status'];
        $provider = $this->request->get['checkout-provider'];
        $str_len = strlen($return_authcode);

      $order_id = $reference;

            $order_info = $this->model_checkout_order->getOrder($order_id);

     if($order_id && $str_len > 20 && $amount > 0 && $status == 'ok'){


        if($order_info['order_status_id'] != $this->config->get('paytrail_510_order_status_id')){
    
            $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `payment_method` = '" . $this->language->get('text_title') . "  (" . $provider . ")', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");

            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('paytrail_510_order_status_id'), "", true);
           
          $string =  'STATUS: ' . $status . ', ' . $this->language->get('text_paid_success') . '; CHECKOUT TRANSACTION ID: ' . $transaction_id . '; MAKSAJAN PANKKI: ' . $provider . ', ORDER ID: ' . $order_id . '; SUMMA: ' . $amount/100;
          $log = new Log("paytrail-510.log");
          $log->write($string);
       }

        $this->response->redirect($this->url->link('checkout/success', true));   
     } elseif($status !='ok'){  
    
        if($order_info['order_status_id'] != $this->config->get('paytrail_510_order_cancel_status_id')){
            $this->db->query("UPDATE `" . DB_PREFIX . "order` SET `payment_method` = '" . $this->language->get('text_title') . "  (" . $provider . ")', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
            $this->model_checkout_order->addOrderHistory($order_id, $this->config->get('paytrail_510_order_cancel_status_id'), "", true);
           
          $string =  'STATUS: ' . $status . ', ' .$this->language->get('text_paid_cancel') . '; CHECKOUT TRANSACTION ID: ' . $transaction_id . '; MAKSAJAN PANKKI: ' . $provider . '; ORDER ID: ' . $order_id . '; SUMMA: ' . $amount/100;
          $log = new Log("paytrail-510.log");
          $log->write($string);
          $log2 = new Log('paytrail-510-failed.log');
          $log2->write($string);
        }

        $this->response->redirect($this->url->link('checkout/failure', true));  
     }
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
    
}
?>