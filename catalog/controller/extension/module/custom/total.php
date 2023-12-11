<?php
class ControllerExtensionModuleCustomTotal extends Controller {
	public function index($setting = array()) {

		// Блок отображается
		if (isset($setting['status']) && (bool)$setting['status'] === true) {

			$this->load->language('extension/module/custom/total');

			$data['heading_total'] = $this->language->get('heading_total');

			$data['totals'] = array();

			$result = $this->getTotals();

			foreach ($result['totals'] as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $total['value'] !== 0 ? $this->currency->format($total['value'], $this->session->data['currency']) : $this->language->get('text_free')
				);
			}

			$data['setting'] = $setting;
			return $this->load->view('extension/module/custom/total', $data);

		// Блок отключен
		} else {
			return false;
		}

	}
	
	public function getTotals(){
		
		$this->load->model('setting/extension');

		$totals = array();
		$taxes = $this->cart->getTaxes();
		$total = 0;
		
		// Because __call can not keep var references so we put them into an array.
		$total_data = array(
			'totals' => &$totals,
			'taxes'  => &$taxes,
			'total'  => &$total
		);
		
		// Display prices
		if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
			$sort_order = array();

			$results = $this->model_setting_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get('total_' . $result['code'] . '_status')) {
					$this->load->model('extension/total/' . $result['code']);

					// We have to put the totals in an array so that they pass by reference.
					$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
				}
			}

			$sort_order = array();

			foreach ($totals as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $totals);

		}
		
		return array(
			'total' => $total,
			'totals' => $totals
		);
		
	}

}