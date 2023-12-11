<?php
class ControllerExtensionModuleCustomModule extends Controller {
	public function index($setting = array()) {

		// Блок отображается
		if (isset($setting['status']) && (bool)$setting['status'] === true) {

			$this->load->language('extension/module/custom/module');

			$data['heading_module'] = $this->language->get('heading_module');

			$data['modules'] = array();
				
			$files = glob(DIR_APPLICATION . '/controller/extension/total/*.php');

			if ($files) {
				foreach ($files as $file) {
					$result = $this->load->controller('extension/total/' . basename($file, '.php'));
					
					if ($result) {
						$data['modules'][] = $result;
					}
				}
			}

			$data['setting'] = $setting;
			return $this->load->view('extension/module/custom/module', $data);

		// Блок отключен
		} else {
			
			return false;

		}

	}

}