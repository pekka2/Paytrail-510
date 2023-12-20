<?php 
class ModelExtensionPaymentPaytrail510 extends Model {
  	public function getMethod($address, $total) {
		$this->load->language('extension/payment/paytrail_510');
		if ($this->config->get('payment_paytrail_510_status')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('payment_paytrail_510_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
			if (!$this->config->get('payment_paytrail_510_geo_zone_id')) {
        		$status = true;
      		} elseif ($query->num_rows) {
      		  	$status = true;
      		} else {
     	  		$status = false;
			   }	
    } else {
			     $status = false;
	  }
	
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		    'code'       => 'paytrail_510',
                'title'      =>  '<div class="checkout-finland-text" style="font-size:"'. $this->config->get('payment_paytrail_510_font_size') . '>' . $this->language->get('text_title') . '</div>',
				        'terms'      => '',
				        'sort_order' => $this->config->get('payment_paytrail_510_sort_order')
      		);
    	}

    	return $method_data;
  	}
}
?>