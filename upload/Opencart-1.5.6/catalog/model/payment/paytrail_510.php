<?php 
class ModelPaymentPaytrail510 extends Model {
  	public function getMethod($address) {
		$this->load->language('payment/paytrail_510');
		if ($this->config->get('paytrail_510_status')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('paytrail_510_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
			if (!$this->config->get('paytrail_510_geo_zone_id')) {
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

    public function taxRate($tax_class_id){
        $tax = $this->db->query("SELECT * FROM `" . DB_PREFIX . "tax_rule` tr LEFT JOIN `" . DB_PREFIX . "tax_rate` tr2 ON(tr.tax_rate_id = tr2.tax_rate_id) WHERE tr.tax_class_id = '" . (int)$tax_class_id . "'");

        if(!empty($tax->row['rate'])){
           return round($tax->row['rate'],2);
        }
    }

    public function findShipping($order_id){
        $result = array();
        $q = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE `order_id` = '" . $order_id . "' AND `code` = 'shipping'");

        if(isset($q->row['value']) && $q->row['value'] > 0){
           $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE `order_id` = '" . $order_id . "'");

           $code = explode('.',$query->row['shipping_code']);

            if($code[0] == 'xshipping'){

               $number = str_replace('xshipping','', $code[1]);

               $tax_class_id = $this->config->get('xshipping_tax_class_id' . $number);

           } else {
              $tax_class_id = $this->config->get($code[0] . '_tax_class_id');
           }

           $result['shipping'] = array('title' => $q->row['title'],
                                       'price' => $q->row['value'],
                                       'tax_class_id' => $tax_class_id,
                                       'tax_rate' => $this->taxRate($tax_class_id)
                                );
         } else {
            $result['shipping'] = array();
         }

        $query2 = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE `order_id` = '" . $order_id . "' AND `code` = 'handling'");
         if(isset($query2->row['value']) && $query2->row['value'] > 0){

         $result['handling'] = array('title' => $query2->row['title'],
                                     'price' => $query2->row['value'],
                                     'tax_class_id' => $this->config->get('handling_tax_class_id'),
                                     'tax_rate' => $this->taxRate($this->config->get('handling_tax_class_id'))
                                );
         } else {
            $result['handling'] = array();
         }

         $query3 = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_total` WHERE `order_id` = '" . $order_id . "' AND `code` = 'low_order_fee'");
         if(isset($query3->row['value']) && $query3->row['value'] > 0){

              $result['fee'] = array('title' => $query3->row['title'],
                                     'price' => $query3->row['value'],
                                     'tax_class_id' => $this->config->get('low_order_fee_tax_class_id'),
                                     'tax_rate' => $this->taxRate($this->config->get('low_order_fee_tax_class_id'))
                                );
           } else {
               $result['fee'] = array();
           }

          return $result;

    }
    
    public function getCoupon($price, $product_id, $category, $code=''){
       $query = $this->db->query("SELECT `discount` FROM `" . DB_PREFIX . "coupon_product` cp LEFT JOIN `" . DB_PREFIX . "coupon` c ON(cp.coupon_id = c.coupon_id) WHERE c.type = 'P' AND c.code = '" . $code . "' AND cp.product_id = '" . $product_id . "'");

       $query2 = $this->db->query("SELECT `discount` FROM `" . DB_PREFIX . "coupon_product` cp LEFT JOIN `" . DB_PREFIX . "coupon` c ON(cp.coupon_id = c.coupon_id) WHERE c.type = 'F' AND c.code = '" . $code . "' AND cp.product_id = '" . $product_id . "'");

        $one = $price/100;

      if($query->num_rows){
         $min = $one * $query->row['discount'];
         return $price - $min;
      } elseif ($query2->num_rows){
            $dis2 = $query2->row['discount'];
            return $price - $dis2;
      } elseif (!empty($category)) {
            $discount = 0;
            foreach($category as $id){
                  $find = $this->db->query("SELECT `discount` FROM `" . DB_PREFIX . "coupon_category` cc LEFT JOIN `" . DB_PREFIX . "coupon` c ON(cc.coupon_id = c.coupon_id) WHERE type = 'P' AND c.code = '" . $code . "' AND cc.category_id = '" . $id . "'");
                  $find2 = $this->db->query("SELECT `discount` FROM `" . DB_PREFIX . "coupon_category` cc LEFT JOIN `" . DB_PREFIX . "coupon` c ON(cc.coupon_id = c.coupon_id) WHERE type = 'F' AND c.code = '" . $code . "' AND cc.category_id = '" . $id . "'");
                  if(!empty($find->row['discount'])){
                     $min = $one * $find->row['discount'];
                     $discount = $price - $min;
                  } elseif (!empty($find2->row['discount'])){
                          $dis2 = $find2->row['discount'];
                          $discount = $price - $dis2;
                  }
            }

            if($discount){
               return $discount;
            }
      }
      return $price;
    }
}
?>