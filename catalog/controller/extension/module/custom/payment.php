<?php
class ControllerExtensionModuleCustomPayment extends Controller {
	public function index($setting) {

		$this->load->language('extension/module/custom/payment');

		// Customer Group
		if ($this->customer->isLogged()) {
			$data['customer_group_id'] = $this->customer->getGroupId();
		} else {
			$data['customer_group_id'] = $this->config->get('config_customer_group_id');
		}
		
		// Totals
		$result = $this->load->controller('extension/module/custom/total/gettotals');
		$total = $result['total'];

		$recurring = $this->cart->hasRecurringProducts();

		if (!empty($this->sesstion->data['shipping_address']['country_id'])) {
			$country_id = $this->sesstion->data['shipping_address']['country_id'];
		} else {
			$country_id = $this->config->get('config_country_id');
		}

		if (!empty($this->sesstion->data['shipping_address']['zone_id'])) {
			$zone_id = $this->sesstion->data['shipping_address']['zone_id'];
		} else {
			$zone_id = $this->config->get('config_zone_id');
		}

		// Payment Methods
		$method_data = array();
		$results = $this->model_setting_extension->getExtensions('payment');

		foreach ($results as $result) {
			if ($this->config->get('payment_' . $result['code'] . '_status')) {

				$this->load->model('extension/payment/' . $result['code']);
				$method = $this->{'model_extension_payment_' . $result['code']}->getMethod(array(
					'country_id' => $country_id,
					'zone_id' => $zone_id
				), $total);

				if ($method)  {
					if ($recurring) {
						if (property_exists($this->{'model_extension_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_extension_payment_' . $result['code']}->recurringPayments()) {
							$method_data[$result['code']] = $method;
						}
					} else {
						$method_data[$result['code']] = $method;
					}
				}
			}
		} 

		$sort_order = array();

		foreach ($method_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $method_data);

		$this->session->data['payment_methods'] = $method_data;

		$data['heading_payment'] = $this->language->get('heading_payment');

		if (empty($this->session->data['payment_methods'])) {
			$data['error_warning'] = sprintf($this->language->get('error_no_payment'), $this->url->link('information/contact'));
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['payment_methods'])) {
			$data['payment_methods'] = $this->session->data['payment_methods'];
		} else {
			$data['payment_methods'] = array();
		}

		if (isset($this->session->data['payment_method']['code'])) {
			$data['code'] = $this->session->data['payment_method']['code'];
		} else {
			$data['code'] = '';
		}

		$data['scripts'] = $this->document->getScripts();

		return $this->load->view('extension/module/custom/payment', $data);
	}

	public function update(){
		$json = array();

		// Customer Group
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getGroupId();
		} elseif (isset($this->request->get['customer_group_id'])) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$this->load->model('setting/setting');

		$setting = json_decode($this->model_setting_setting->getSettingValue('module_custom_payment'), true);
		foreach($setting['methods'] as $method){

			if (isset($method['customer_group']) && in_array($customer_group_id, $method['customer_group'])){
				$json[] = array(
					'name' => str_replace('_', '-', $method['name'])
				);
			}
		}



		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function save(){

		$json = array();

		$this->load->language('extension/module/custom/payment');

		if (!isset($this->request->post['payment_method'])) {
			$json['error']['payment_method'] = $this->language->get('error_payment1');
		} elseif (!isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
			$json['error']['payment_method'] = $this->language->get('error_payment2');
		}

		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ($information_info && !isset($this->request->post['agree'])) {
				$json['error']['agree'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}

		if (!$json) {
			$this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];
		}

		$json['session'] = $this->request->post['payment_method'];

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

}