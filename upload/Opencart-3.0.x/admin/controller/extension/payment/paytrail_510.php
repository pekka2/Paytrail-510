<?php
class ControllerExtensionPaymentPaytrail510 extends Controller {
	private $error = array(); 

	public function index() {
		$data = array();
		$data = array_merge($data,$this->load->language('extension/payment/paytrail_510'));
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {	
			$this->model_setting_setting->editSetting('payment_paytrail_510', $this->request->post, $this->request->post['payment_paytrail_510_store_id']);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('marketplace/extension','user_token=' . $this->session->data['user_token'] . '&type=payment',true));
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->error['merchant'])) {
			$data['error_merchant'] = $this->error['merchant'];
		} else {
			$data['error_merchant'] = '';
		}

 		if (isset($this->error['security'])) {
			$data['error_security'] = $this->error['security'];
		} else {
			$data['error_security'] = '';
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/dashboard','user_token=' . $this->session->data['user_token'], true),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
		);

   		$data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('extension/payment/paytrail_510','user_token=' . $this->session->data['user_token'],true),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
				
		$data['action'] = $this->url->link('extension/payment/paytrail_510','user_token=' . $this->session->data['user_token'],true);
		$data['clear'] = $this->url->link('extension/payment/paytrail_510/clear','user_token=' . $this->session->data['user_token'],true);
		
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment',true);
		
		if (isset($this->request->post['payment_paytrail_510_merchant'])) {
			$data['payment_paytrail_510_merchant'] = $this->request->post['payment_paytrail_510_merchant'];
		} else {
			$data['payment_paytrail_510_merchant'] = $this->config->get('payment_paytrail_510_merchant');
		}

		if (isset($this->request->post['paytrail_510_security'])) {
			$data['payment_paytrail_510_security'] = $this->request->post['payment_paytrail_510_security'];
		} else {
			$data['payment_paytrail_510_security'] = $this->config->get('payment_paytrail_510_security');
		}
		
		if (isset($this->request->post['payment_paytrail_510_order_status_id'])) {
			$data['payment_paytrail_510_order_status_id'] = $this->request->post['payment_paytrail_510_order_status_id'];
		} else {
			$data['payment_paytrail_510_order_status_id'] = $this->config->get('payment_paytrail_510_order_status_id'); 
		} 
		
		if (isset($this->request->post['payment_paytrail_510_order_cancel_status_id'])) {
			$data['payment_paytrail_510_order_cancel_status_id'] = $this->request->post['payment_paytrail_510_order_cancel_status_id'];
		} else {
			$data['payment_paytrail_510_order_cancel_status_id'] = $this->config->get('payment_paytrail_510_order_cancel_status_id'); 
		} 
		
		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();			

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['payment_paytrail_510_geo_zone_id'])) {
			$data['payment_paytrail_510_geo_zone_id'] = $this->request->post['payment_paytrail_510_geo_zone_id'];
		} else {
			$data['payment_paytrail_510_geo_zone_id'] = $this->config->get('payment_paytrail_510_geo_zone_id'); 
		} 
		
		if (isset($this->request->post['paytrail_510_status'])) {
			$data['payment_paytrail_510_status'] = $this->request->post['payment_paytrail_510_status'];
		} else {
			$data['payment_paytrail_510_status'] = $this->config->get('payment_paytrail_510_status');
		}
		
		if (isset($this->request->post['payment_paytrail_510_sort_order'])) {
			$data['payment_paytrail_510_sort_order'] = $this->request->post['payment_paytrail_510_sort_order'];
		} else {
			$data['payment_paytrail_510_sort_order'] = $this->config->get('payment_paytrail_510_sort_order');
		}
		
		if (isset($this->request->post['payment_paytrail_510_sandbox'])) {
			$data['payment_paytrail_510_sandbox'] = $this->request->post['payment_paytrail_510_sandbox'];
		} else {
			$data['payment_paytrail_510_sandbox'] = $this->config->get('payment_paytrail_510_sandbox');
		}
		
		if (isset($this->request->post['payment_paytrail_510_text'])) {
			$data['payment_paytrail_510_text'] = $this->request->post['payment_paytrail_510_text'];
		} else {
			$data['payment_paytrail_510_text'] = $this->config->get('payment_paytrail_510_text');
		}

		if (isset($this->request->post['payment_paytrail_510_font_size'])) {
			$data['payment_paytrail_510_font_size'] = $this->request->post['payment_paytrail_510_font_size'];
		} elseif($this->config->get('payment_paytrail_510_font_size')) {
			$data['payment_paytrail_510_font_size'] = $this->config->get('payment_paytrail_510_font_size');
		} else {
			$data['payment_paytrail_510_font_size'] = 16;
		}
		

		$this->load->model('setting/store');

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}

		$this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		$data['images'] = HTTP_CATALOG . 'image/';

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$file = DIR_LOGS . 'paytrail-510.log';

		if (file_exists($file)) {
			$data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$data['log'] = '';
		}
		$file2 = DIR_LOGS . 'paytrail-510-failed.log';

		if (file_exists($file2)) {
			$data['failed_log'] = file_get_contents($file2, FILE_USE_INCLUDE_PATH, null);
		} else {
			$data['failed_log'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/payment/paytrail_510', $data));
	}

	public function clear() {
		$this->language->load('extension/payment/paytrail_510');

		$file = DIR_LOGS . 'paytrail-510.log';
        if (file_exists($file) && $this->validateClear()) {
		   $handle = fopen($file, 'w+'); 

	    	fclose($handle); 			

		    $this->session->data['success'] = $this->language->get('text_clear_success');
	   }

		$this->response->redirect($this->url->link('extension/payment/paytrail_510', 'user_token=' . $this->session->data['user_token'], true));		
	}

	protected function validateClear() {
		if (!$this->user->hasPermission('modify', 'extension/payment/paytrail_510')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/paytrail_510')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['payment_paytrail_510_sandbox'])  {
		    if (!$this->request->post['payment_paytrail_510_merchant']) {
			   $this->error['merchant'] = $this->language->get('error_merchant');
		   }

		   if (!$this->request->post['payment_paytrail_510_security']) {
			  $this->error['security'] = $this->language->get('error_security');
		   }
		}

		return !$this->error;
	}
}
?>
