<?php
class ControllerExtensionModuleCustom extends Controller {
	private $error = array();
	private $version = '2.1.5';

	public function index() {

		$this->load->model('setting/setting');
		$this->load->model('customer/customer_group');

		$this->load->language('extension/module/custom');
		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_custom', $this->request->post);
			$data['success'] = $this->language->get('text_success');
		}

		if (isset($this->error['cart'])) {
			$data['error_cart'] = $this->error['cart'];
			$data['tab_cart'] = sprintf($this->language->get('error_tab'), $this->language->get('tab_cart'));
		} else {
			$data['error_cart'] = '';
			$data['tab_cart'] = $this->language->get('tab_cart');
		}

		if (isset($this->error['customer'])) {
			$data['error_customer'] = $this->error['customer'];
			$data['tab_customer'] = sprintf($this->language->get('error_tab'), $this->language->get('tab_customer'));
		} else {
			$data['error_customer'] = '';
			$data['tab_customer'] = $this->language->get('tab_customer');
		}

		if (isset($this->error['payment'])) {
			$data['error_payment'] = $this->error['payment'];
			$data['tab_payment'] = sprintf($this->language->get('error_tab'), $this->language->get('tab_payment'));
		} else {
			$data['error_payment'] = '';
			$data['tab_payment'] = $this->language->get('tab_payment');
		}

		if (isset($this->request->post['module_custom_status'])) {
			$data['module_custom_status'] = $this->request->post['module_custom_status'];
		} else {
			$data['module_custom_status'] = $this->config->get('module_custom_status');
		}

		$result = $this->model_setting_setting->getSetting('module_custom');

		// General SETTING
		if (isset($result['module_custom_general'])) {
			$data['module_custom_general'] = $result['module_custom_general'];
		} else {
			$data['module_custom_general'] = array(
				'theme' => 'bootstrap3', 
				'setting' => 0
			);
		}

		// Time SETTING
		if (isset($result['module_custom_time'])) {
			$data['module_custom_time'] = $result['module_custom_time'];
		} else {
			$data['module_custom_time'] = array(
				'status' => false
			);
		}

		// LOGIN SETTING
		if (isset($result['module_custom_login'])) {
			$data['module_custom_login'] = $result['module_custom_login'];
		} else {
			$data['module_custom_login'] = array(
				'status' => 0, 
				'sort' => 0
			);
		}
		
		// CART SETTING
		if (isset($result['module_custom_cart'])) {
			$data['module_custom_cart'] = $result['module_custom_cart'];
		} else {
			$data['module_custom_cart'] = array(
				'status' => 0, 
				'sort' => 0,
				'column' => array()
			);
		}
		$data['module_custom_cart']['list'] = $this->getCartColumns();

		// customer SETTING
		if (isset($result['module_custom_customer'])) {
			$data['module_custom_customer'] = $result['module_custom_customer'];
		} else {
			$data['module_custom_customer'] = array(
				'status' => 1, 
				'sort' => 0,
				'fields' => array()
			);
		}
		$data['module_custom_customer']['list'] = $this->getСustomerFieldlist();
		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		// SHIPPING SETTING
		if (isset($result['module_custom_shipping'])) {
			$data['module_custom_shipping'] = $result['module_custom_shipping'];
		} else {
			$data['module_custom_shipping'] = array(
				'status' => 1, 
				'sort' => 0,
				'fields' => array()
			);
		}
		$data['module_custom_shipping']['list'] = $this->getShippingFieldlist();
		$data['module_custom_shipping']['methods'] = $this->getShippingMethodList();
		
		// PAYMENT SETTING
		if (isset($result['module_custom_payment'])) {
			$data['module_custom_payment'] = $result['module_custom_payment'];
		} else {
			$data['module_custom_payment'] = array(
				'status' => 1, 
				'sort' => 0
			);
		}

		$data['module_custom_payment']['list'] = $this->getPaymentMethodList();

		// comment SETTING
		if (isset($result['module_custom_comment'])) {
			$data['module_custom_comment'] = $result['module_custom_comment'];
		} else {
			$data['module_custom_comment'] = array(
				'status' => 0, 
				'sort' => 0
			);
		}

		// module SETTING
		if (isset($result['module_custom_module'])) {
			$data['module_custom_module'] = $result['module_custom_module'];
		} else {
			$data['module_custom_module'] = array(
				'status' => 0, 
				'sort' => 0
			);
		}

		// total SETTING
		if (isset($result['module_custom_total'])) {
			$data['module_custom_total'] = $result['module_custom_total'];
		} else {
			$data['module_custom_total'] = array(
				'status' => 0, 
				'sort' => 0
			);
		}

		$this->load->language('extension/module/custom');

		// BreadCrumbs
		$data['breadcrumbs'] = array();
 
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/custom', 'user_token=' . $this->session->data['user_token'], true)
		);

		// cart
		$data['entry_cart_status'] = $this->language->get('entry_cart_status');

		// about
		$data['version'] = sprintf($this->language->get('version'), $this->version);
		$data['about_module'] = $this->language->get('about_module');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['action'] = $this->url->link('extension/module/custom', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/custom', $data));
	}

	protected function validate() {
		
		if (!$this->user->hasPermission('modify', 'extension/module/custom')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ($this->request->post['module_custom_cart']['status'] == 1 && (!isset($this->request->post['module_custom_cart']['column']) || count($this->request->post['module_custom_cart']['column']) == 0)) {
			$this->error['cart'] = $this->language->get('error_cart_nocolumns');
		} elseif (isset($this->request->post['module_custom_cart']['column']) && count($this->request->post['module_custom_cart']['column']) > 0) {
			$column_temp = array();
			foreach($this->request->post['module_custom_cart']['column'] as $column){
				if (!in_array($column, $column_temp)) {
					$column_temp[] = $column;
				} else {
					$this->error['cart'] = $this->language->get('error_cart_double');
				}
			}
		}

		if (!isset($this->request->post['module_custom_customer']['fields']) || count($this->request->post['module_custom_customer']['fields']) == 0) {
			$this->error['customer'] = $this->language->get('error_customer_nofields');
		} elseif (isset($this->request->post['module_custom_customer']['fields']) && count($this->request->post['module_custom_customer']['fields']) > 0) {
			$field_temp = array();
			foreach($this->request->post['module_custom_customer']['fields'] as $field){
				if (!in_array($field['name'], $field_temp)) {
					$field_temp[] = $field['name'];
				} else {
					$this->error['customer'] = $this->language->get('error_customer_double');
				}
			}
		}

		if (!isset($this->request->post['module_custom_payment']['methods']) || count($this->request->post['module_custom_payment']['methods']) == 0) {
			$this->error['payment'] = $this->language->get('error_payment_nomethods');
		} elseif (isset($this->request->post['module_custom_payment']['methods']) && count($this->request->post['module_custom_payment']['methods']) > 0) {
			$method_temp = array();
			foreach($this->request->post['module_custom_payment']['methods'] as $method){
				if (!in_array($method['name'], $method_temp)) {
					$method_temp[] = $method['name'];
				} else {
					$this->error['payment'] = $this->language->get('error_payment_double');
				}
			}
		}

		return !$this->error;
	}
	
	private function getCartColumns(){

		$this->load->language('extension/module/custom');

		return array(
			'image' => array(
				'label' => $this->language->get('label_image')
			),
			'name' => array(
				'label' => $this->language->get('label_name')
			),
			'model' => array(
				'label' => $this->language->get('label_model')
			),
			'sku' => array(
				'label' => $this->language->get('label_sku')
			),
			'quantity' => array(
				'label' => $this->language->get('label_quantity')
			),
			'price' => array(
				'label' => $this->language->get('label_price')
			),
			'total' => array(
				'label' => $this->language->get('label_total')
			),
			'remove' => array(
				'label' => $this->language->get('label_remove')
			)
		);

	}

	private function getСustomerFieldlist(){

		$this->load->language('extension/module/custom');
		$this->load->model('customer/custom_field');

		$result = array(
			'firstname' => array(
				'label' => $this->language->get('label_firstname')
			),
			'lastname' => array(
				'label' => $this->language->get('label_lastname')
			),
			'telephone' => array(
				'label' => $this->language->get('label_telephone')
			),
			'email' => array(
				'label' => $this->language->get('label_email')
			),
			'fax' => array(
				'label' => $this->language->get('label_fax')
			),
			'password' => array(
				'label' => $this->language->get('label_password')
			),
			'confirm' => array(
				'label' => $this->language->get('label_confirm')
			)
		);

		foreach($this->model_customer_custom_field->getCustomFields() as $field){
			$field_id = $field['custom_field_id'];
			if ($field['location'] === 'account' ){
				$result['custom_field'.$field_id] = array(
					'label' => $field['name']
				);
			}
		}

		return $result;

	}

	private function getShippingFieldlist(){

		$this->load->language('extension/module/custom');
		$this->load->model('customer/custom_field');

		$result = array(
			'address_1' => array(
				'label' => $this->language->get('label_address_1')
			),
			'address_2' => array(
				'label' => $this->language->get('label_address_2')
			),
			'city' => array(
				'label' => $this->language->get('label_city')
			),
			'postcode' => array(
				'label' => $this->language->get('label_postcode')
			),
			'country_id' => array(
				'label' => $this->language->get('label_country_id')
			),
			'zone_id' => array(
				'label' => $this->language->get('label_zone_id')
			),
			'company' => array(
				'label' => $this->language->get('label_company')
			)
		);

		foreach($this->model_customer_custom_field->getCustomFields() as $field){
			$field_id = $field['custom_field_id'];
			if ($field['location'] === 'address' ){
				$result['custom_field'.$field_id] = array(
					'label' => $field['name']
				);
			}
		}

		return $result;

	}

	private function getShippingMethodList(){

		$this->load->model('setting/extension');

		$methods = array();

		foreach($this->model_setting_extension->getInstalled('shipping') as $key => $method){

			$this->load->language('extension/shipping/'.$method);
			
			$methods[$key]['code'] = $method;
			$methods[$key]['label'] = $this->language->get('heading_title');

		}

		return $methods;

	}

	private function getPaymentMethodList(){

		$this->load->model('setting/extension');

		$methods = array();

		foreach($this->model_setting_extension->getInstalled('payment') as $key => $method){

			$this->load->language('extension/payment/'.$method);
			
			$methods[$key]['code'] = $method;
			$methods[$key]['label'] = $this->language->get('heading_title');

		}

		return $methods;

	}

	// public function install() {
	// 	// if ($this->user->hasPermission('modify', 'marketplace/extension')) {

	// 		$this->load->model('extension/module/custom');
	// 		$this->load->model('setting/store');
	// 		$this->load->model('localisation/language');

	// 		$stores = $this->model_setting_store->getStores();
	// 		$languages = $this->model_localisation_language->getLanguages();

	// 		foreach($stores as $store){
	// 			foreach($languages as $language){
	// 				$this->model_extension_module_custom->addSeoUrl($store['store_id'], $language['language_id'], 'custom_checkout_'.substr($language['code'], 0, 2));
	// 			}
	// 		}

	// 	// }
	// }

	// public function uninstall() {
	// 	// if ($this->user->hasPermission('modify', 'marketplace/extension')) {
	// 		$this->load->model('extension/module/custom');
	// 		$this->model_extension_module_custom->removeSeoUrl();
	// 	// }
	// }

}