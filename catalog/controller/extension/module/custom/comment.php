<?php
class ControllerExtensionModuleCustomComment extends Controller {
	public function index($setting = array()) {

		if (isset($setting['status']) && (bool)$setting['status'] === true) {
			$this->load->language('extension/module/custom/comment');

			$data['heading_comment'] = $this->language->get('heading_comment');
			$data['entry_comment'] = $this->language->get('entry_comment');

			if (isset($this->session->data['comment'])) {
				$data['comment'] = $this->session->data['comment'];
			} else {
				$data['comment'] = '';
			}

			$data['setting'] = $setting;
			return $this->load->view('extension/module/custom/comment', $data);

		} else {

			$this->session->data['comment'] = '';
			return false;

		}

	}

	public function save(){

		$json = array();

		$this->load->language('extension/module/custom/comment');

		if (!isset($this->request->post['comment'])) {
			$json['error']['warning'] = $this->language->get('error_payment');
		} else {
			$this->session->data['comment'] = $this->request->post['comment'];
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

}