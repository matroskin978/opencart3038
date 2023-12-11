<?php
class ModelExtensionModuleCustomCustom extends Model {

	public function validate(){

		$this->load->language('extension/module/custom/error');

		$errors = array();

		// Валидация на все то, что есть в наличии (стандартный ф-л)
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$errors[] = $this->language->get('error_stock');
		}

		// Валидация на то, что можно заказать в минимуме (стандартный ф-л)
		$products = $this->cart->getProducts();
		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$errors[] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
			}
		}

		return $errors;
	}

	public function addAddressInfo($address = array()){

		if (!empty($address['country_id'])) {

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$address['country_id'] . "'");

			if ($country_query->num_rows) {
				$address['country'] 				= $country_query->row['name'];
				$address['iso_code_2'] 			= $country_query->row['iso_code_2'];
				$address['iso_code_3']			= $country_query->row['iso_code_3'];
				$address['address_format'] 	= $country_query->row['address_format'];
			}

		}

		if (!empty($address['zone_id'])) {

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$address['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$address['zone'] 				= $zone_query->row['name'];
				$address['zone_code'] 	= $zone_query->row['code'];
			}

		}

		return $address;

	}

}