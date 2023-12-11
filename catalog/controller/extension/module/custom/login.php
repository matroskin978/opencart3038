<?php
class ControllerExtensionModuleCustomLogin extends Controller {
	public function index($setting = array()) {

		$this->load->language('extension/module/custom/login');

		// Блок отображается
		if (isset($setting['status']) && (bool)$setting['status'] === true) {

			$data['heading_login'] = $this->language->get('heading_login');

			$data['text_auth'] = $this->language->get('text_auth');
			$data['text_register'] = $this->language->get('text_register');
			$data['text_guest'] = $this->language->get('text_guest');
			$data['text_forgotten'] = $this->language->get('text_forgotten');
			$data['text_loading'] = $this->language->get('text_loading');

			$data['entry_email'] = $this->language->get('entry_email');
			$data['entry_password'] = $this->language->get('entry_password');

			$data['button_login'] = $this->language->get('button_login');

			$data['checkout_guest'] = ($this->config->get('config_checkout_guest') && !$this->config->get('config_customer_price') && !$this->cart->hasDownload());

			if (isset($this->session->data['account'])) {
				$data['account'] = $this->session->data['account'];
			} else {
				$data['account'] = $this->session->data['account'] = 'register';
			}

			$data['forgotten'] = $this->url->link('account/forgotten', '', true);

			return $this->load->view('extension/module/custom/login', $data);

		// Блок скрыт
		} else {

			if ( $this->config->get('config_checkout_guest') && !$this->config->get('config_customer_price') && !$this->cart->hasDownload() ) {
				$this->session->data['account'] = 'guest';
			} else {
				$this->session->data['account'] = 'register';
			}

			return false;
		}

	}

	public function save(){

		$json = array();

		if (isset($this->request->post['account'])) {
			$this->session->data['account'] = $this->request->post['account'];
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}

}