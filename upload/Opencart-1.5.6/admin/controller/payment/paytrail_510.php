<?php
class ControllerPaymentPaytrail510 extends Controller {
	private $error = array(); 

	public function index() {
		$this->data = array();
		$this->data = array_merge($this->data,$this->load->language('payment/paytrail_510'));
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {	
			$this->model_setting_setting->editSetting('paytrail_510', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/payment','token=' . $this->session->data['token'],true));
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['merchant'])) {
			$this->data['error_merchant'] = $this->error['merchant'];
		} else {
			$this->data['error_merchant'] = '';
		}

 		if (isset($this->error['security'])) {
			$this->data['error_security'] = $this->error['security'];
		} else {
			$this->data['error_security'] = '';
		}

 		if (isset($this->error['vendor'])) {
			$this->data['error_vendor'] = $this->error['vendor'];
		} else {
			$this->data['error_vendor'] = '';
		}
		

		$this->document->addStyle('view/javascript/bootstrap/opencart/opencart.css');
		$this->document->addStyle('view/javascript/font-awesome/css/font-awesome.min.css');
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('common/dashboard','token=' . $this->session->data['token'], true),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

		$this->data['breadcrumbs'][] = array(
			'text' =>  $this->language->get('text_payment'),
			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], true)
		);

   		$this->data['breadcrumbs'][] = array(
       		'href'      => $this->url->link('payment/paytrail_510','token=' . $this->session->data['token'],true),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('payment/paytrail_510','token=' . $this->session->data['token'],true);
		$this->data['clear'] = $this->url->link('payment/paytrail_510/clear','token=' . $this->session->data['token'],true);
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'],true);
		
		if (isset($this->request->post['paytrail_510_merchant'])) {
			$this->data['paytrail_510_merchant'] = $this->request->post['paytrail_510_merchant'];
		} else {
			$this->data['paytrail_510_merchant'] = $this->config->get('paytrail_510_merchant');
		}

		if (isset($this->request->post['paytrail_510_security'])) {
			$this->data['paytrail_510_security'] = $this->request->post['paytrail_510_security'];
		} else {
			$this->data['paytrail_510_security'] = $this->config->get('paytrail_510_security');
		}
		
		if (isset($this->request->post['paytrail_510_order_status_id'])) {
			$this->data['paytrail_510_order_status_id'] = $this->request->post['paytrail_510_order_status_id'];
		} else {
			$this->data['paytrail_510_order_status_id'] = $this->config->get('paytrail_510_order_status_id'); 
		} 
		
		if (isset($this->request->post['paytrail_510_order_cancel_status_id'])) {
			$this->data['paytrail_510_order_cancel_status_id'] = $this->request->post['paytrail_510_order_cancel_status_id'];
		} else {
			$this->data['paytrail_510_order_cancel_status_id'] = $this->config->get('paytrail_510_order_cancel_status_id'); 
		} 
		
		
		if (isset($this->request->post['paytrail_510_font_size'])) {
			$this->data['paytrail_510_font_size'] = $this->request->post['paytrail_510_font_size'];
		} elseif ($this->config->get('paytrail_510_font_size')) {
			$this->data['paytrail_510_font_size'] = $this->config->get('paytrail_510_font_size');
		} else {
			$this->data['paytrail_510_font_size'] = 16;
		}
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();			

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['paytrail_510_geo_zone_id'])) {
			$this->data['paytrail_510_geo_zone_id'] = $this->request->post['paytrail_510_geo_zone_id'];
		} else {
			$this->data['paytrail_510_geo_zone_id'] = $this->config->get('paytrail_510_geo_zone_id'); 
		} 
		
		if (isset($this->request->post['paytrail_510_status'])) {
			$this->data['paytrail_510_status'] = $this->request->post['paytrail_510_status'];
		} else {
			$this->data['paytrail_510_status'] = $this->config->get('paytrail_510_status');
		}
		
		if (isset($this->request->post['paytrail_510_sort_order'])) {
			$this->data['paytrail_510_sort_order'] = $this->request->post['paytrail_510_sort_order'];
		} else {
			$this->data['paytrail_510_sort_order'] = $this->config->get('paytrail_510_sort_order');
		}
		
		if (isset($this->request->post['paytrail_510_sandbox'])) {
			$this->data['paytrail_510_sandbox'] = $this->request->post['paytrail_510_sandbox'];
		} else {
			$this->data['paytrail_510_sandbox'] = $this->config->get('paytrail_510_sandbox');
		}

		$this->load->model('setting/store');

		$this->data['stores'] = array();
		
		$this->data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$this->data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}

		$this->load->model('tool/image');

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);	
		$this->data['token'] = $this->session->data['token'];
		$this->data['images'] = HTTP_CATALOG . 'image/';

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();


		$file = DIR_LOGS . 'paytrail-510.log';

		$this->data['flag'] = HTTP_SERVER . 'view/image/flags/';

		if (file_exists($file)) {
			$this->data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['log'] = '';
		}

		$file2 = DIR_LOGS . 'paytrail-510-failed.log';

		if (file_exists($file)) {
			$this->data['failed_log'] = file_get_contents($file2, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['failed_log'] = '';
		}


		$this->template = 'payment/paytrail_510.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	public function clear() {
		$this->language->load('payment/paytrail_510');

		$file = DIR_LOGS . 'paytrail-510.log';
        if (file_exists($file) && $this->validateClear()) {
		   $handle = fopen($file, 'w+'); 

	    	fclose($handle); 			

		    $this->session->data['success'] = $this->language->get('text_clear_success');
	   }

		$this->response->redirect($this->url->link('payment/paytrail_510', 'token=' . $this->session->data['user_token'], true));		
	}

	protected function validateClear() {
		if (!$this->user->hasPermission('modify', 'payment/paytrail_510')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/paytrail_510')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['paytrail_510_sandbox'])  {
		   if (!$this->request->post['paytrail_510_merchant']) {
			  $this->error['merchant'] = $this->language->get('error_merchant');
		   }

		   if (!$this->request->post['paytrail_510_security']) {
			  $this->error['security'] = $this->language->get('error_security');
		   }
		}

		return !$this->error;
	}
}
?>