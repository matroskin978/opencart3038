<?php
class ModelExtensionModuleCustom extends Model {

	public function addSeoUrl($store_id, $language_id, $alias){
		$this->db->query("INSERT INTO " . DB_PREFIX . "seo_url SET store_id = '" . (int)$store_id . "', language_id = '" . (int)$language_id . "', query = 'extension/module/custom', keyword = '" . $this->db->escape($alias) . "'");
	}

	public function removeSeoUrl(){
		$this->db->query("DELETE FROM " . DB_PREFIX . "seo_url WHERE query = 'extension/module/custom'");
	}

}