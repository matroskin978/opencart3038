<?php
class ControllerExtensionModuleCustomcustomer extends Controller {
	public function index($setting) {
		$this->load->language('extension/module/custom/customer');

		$data['heading_customer'] = $this->language->get('heading_customer');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_firstname'] = $this->language->get('entry_firstname');
		$data['entry_lastname'] = $this->language->get('entry_lastname');
		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_telephone'] = $this->language->get('entry_telephone');
		$data['entry_fax'] = $this->language->get('entry_fax');
		$data['entry_password'] = $this->language->get('entry_password');
		$data['entry_confirm'] = $this->language->get('entry_confirm');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');

		// Customer groups 
		$data['customer_groups'] = array();
		if (is_array($this->config->get('config_customer_group_display'))) {
			$this->load->model('account/customer_group');

			$customer_groups = $this->model_account_customer_group->getCustomerGroups();

			foreach ($customer_groups  as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$data['customer_groups'][] = $customer_group;
				}
			}
		}
		$data['customer_group_id'] = $this->config->get('config_customer_group_id');

		if (isset($this->session->data['guest']['firstname'])) {
			$data['firstname'] = $this->session->data['guest']['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->session->data['guest']['lastname'])) {
			$data['lastname'] = $this->session->data['guest']['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->session->data['guest']['telephone'])) {
			$data['telephone'] = $this->session->data['guest']['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->session->data['guest']['email'])) {
			$data['email'] = $this->session->data['guest']['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->session->data['guest']['fax'])) {
			$data['fax'] = $this->session->data['guest']['fax'];
		} else {
			$data['fax'] = '';
		}

		if (isset($this->session->data['guest']['password'])) {
			$data['password'] = $this->session->data['guest']['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->session->data['guest']['confirm'])) {
			$data['confirm'] = $this->session->data['guest']['confirm'];
		} else {
			$data['confirm'] = '';
		}

		// Custom Fields
		$this->load->model('account/custom_field');

		$data['custom_fields'] = $this->model_account_custom_field->getCustomFields();

		

		foreach($data['custom_fields'] as $key => $field){

			if ($field['location'] != 'account') {
					unset($data['custom_fields'][$key]);
					continue;
				}

			$custom_field_id = $field['custom_field_id'];

			if ( isset($this->session->data['guest']['custom_field'][$custom_field_id]) ) {
				$data['custom_fields'][$key]['value'] = $this->session->data['guest']['custom_field'][$custom_field_id];
			}

		}

		// Setting
		$data['setting'] = $setting;
		
		return $this->load->view('extension/module/custom/customer', $data);

	}

	public function update(){
		$json = array();

		$this->load->model('account/custom_field');
		$this->load->model('setting/setting');

		// Customer Group
		if (isset($this->request->get['customer_group_id'])) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$setting = json_decode($this->model_setting_setting->getSettingValue('module_custom_customer'), true);
		foreach($setting['fields'] as $field){

			if ( ($field['name'] == 'password' || $field['name'] == 'confirm') ){

				if ($this->session->data['account'] == 'register') {
					$json[] = array(
						'name' => str_replace('_', '-', $field['name']),
						'required' => true
					);
				}
				continue;

			}

			if (isset($field['customer_group']) && in_array($customer_group_id, $field['customer_group'])){

				if (isset($field['required']) && in_array($customer_group_id, $field['required'])){
					$required = true;
				} else {
					$required = false;
				}

				$json[] = array(
					'name' => str_replace('_', '-', $field['name']),
					'required' => $required
				);

			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function save(){

		$json = array();
		$customer = array();

		$this->load->language('extension/module/custom/customer');
		$this->load->model('account/custom_field');

		$this->load->model('setting/setting');
		$setting = json_decode($this->model_setting_setting->getSettingValue('module_custom_customer'), true);

		if (!empty($this->request->post['customer_group_id'])) {
			$customer_group_id = $this->request->post['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$customer['customer_group_id'] = $customer_group_id;

		// Залогинен
		if (!$this->customer->isLogged()) { 

			unset($this->session->data['guest']);

			// Пробегаемся по полям
			foreach($setting['fields'] as $field){

				$name = $field['name'];

				// На госте не проверяем пароль и подстверждение
				if ( $this->session->data['account'] == 'guest' && ( $name == 'password' || $name == 'confirm' ) ){
					continue;
				}

				$value = $this->request->post['customer_'.$name];
				$validation = $field['validation'];

				// Поле приминено для этого выборанного метода 
				if (isset($field['customer_group']) && array_search($customer_group_id, (array)$field['customer_group']) !== false) {

					// Если поле обязательно, то проверяем его 
					if (isset($field['required']) && array_search($customer_group_id, (array)$field['required']) !== false) {

						// Если есть ошибка, то запомниаем её
						if ($this->validate($name, $value, $validation)) {

							if (stripos($name, 'custom_field') === false) {
								$json['error'][$name] = $this->language->get('error_'.$name);
							} else {
								$custom_field = $this->model_account_custom_field->getCustomField((int)substr($name, 12));
								$json['error'][$name] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
							}

						} else {
							$customer[$name] = $value;
						}

					// Записываем без проверки
					}	else {
						$customer[$name] = $value;
					}
				}
			}		

			// Дополнительная проверка для паролей
			if ( $this->session->data['account'] == 'register'){

				// Если поля пароль нет
				if ( !isset($customer['password']) ){

					$customer['password'] = '';
					$customer['confirm'] = '';

				// Если есть только поле пароль
				} elseif (isset($customer['password']) && !isset($customer['confirm'])) {

					if (!empty($customer['password'])) {
						$customer['confirm'] = $customer['password'];
					}

				// Если есть оба поля
				} elseif (isset($customer['password']) && isset($customer['confirm'])) {

					if ($customer['password'] !== $customer['confirm']) {
						$json['error']['confirm'] = $this->language->get('error_confirm');
					}

				}
			}

			if (!$json){

				// Приводим к стандарту
				$full_customer = $this->full($customer);

				// Регистрация, либо гость
				if ($this->session->data['account'] === 'register') {
					$json = $this->addCustomer($full_customer);
				} else {
					$this->session->data['guest'] = $full_customer;
				}

			}

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

	private function full($customer){

		// Восстанавливаем custom-поля
		foreach($customer as $key => $field){

			if (stripos($key, 'custom_field') !== false) {
				$id = (int)str_replace('custom_field', '', $key);
				if ($this->session->data['account'] === 'register') {
					$customer['custom_field']['account'][$id] = $field;
				} else {
					$customer['custom_field'][$id] = $field;
				}
				unset($customer[$key]);
			}

		}

		// Какие поля должны быть
		$default = array(
			'customer_group_id' => '',
			'firstname' => '',
			'lastname' => '',
			'email' => $this->config->get('config_email'),
			'telephone' => '',
			'password' => '',
			'confirm' => '',
			'fax' => '',
			'custom_field' => array()
		);

		$result = array_merge($default, $customer);
		
		// Добавляем емейл, если он в итоге пустой
		if (empty($result['email'])) {
			$result['email'] = $this->config->get('config_email');
		}

		return $result;

	}

	private function addCustomer($customer){

		$json = array();

		$this->load->model('account/customer');
		
		// Проверяем, нет ли с таким email
		if ($this->model_account_customer->getTotalCustomersByEmail($customer['email'])) {
			$this->load->language('account/register');
			$json['error']['warning'] = $this->language->get('error_exists');
		}

		// Регистририуем
		if (!$json) {

			$this->load->model('extension/module/custom/custom');
			$customer_id = $this->model_account_customer->addCustomer($customer);

			// Clear any previous login attempts for unregistered accounts.
			$this->model_account_customer->deleteLoginAttempts($customer['email']);

			// Смиотрим, что там с этой группой можно делать
			$this->load->model('account/customer_group');
			$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer['customer_group_id']);

			if ($customer_group_info && !$customer_group_info['approval']) {
				$this->customer->login($customer['email'], $customer['password']);
			} else {
				$json['redirect'] = $this->url->link('account/success');
			}

			// Add to activity log
			if ($this->config->get('config_customer_activity')) {

				$this->load->model('account/activity');
				$activity_data = array(
					'customer_id' => $customer_id,
					'name'        => $customer['firstname'] . ' ' . $customer['lastname']
				);
				$this->model_account_activity->addActivity('register', $activity_data);

			}

		}

		return $json;
	}

	private function validate($name, $value, $validation = ''){

		// Проверяем на пустоту
		if (empty($value)) {
			return true;

		// Особая проверка для email	
		} elseif ($name == 'email' && !preg_match("/.+@.+\..+/i", $value)) {
			return true;

		// Проверка на регулярное выражение		
		} elseif (!empty($validation) && !filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $validation )))){
			return true;
		}

		return false;

	}

}