<?php
/*
Author: Denise (rei7092@gmail.com)
Page: http://www.opencart.com/index.php?route=extension/extension/info&token=862f82b6be28a025c788dfff38c7a550&extension_id=26240
*/

class ControllerExtensionModuleLiveSearch extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/live_search');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_live_search', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}
		if (isset($this->error['view_all_results'])) {
			$data['error_view_all_results'] = $this->error['view_all_results'];
		} else {
			$data['error_view_all_results'] = '';
		}

		if (isset($this->error['limit'])) {
			$data['error_limit'] = $this->error['limit'];
		} else {
			$data['error_limit'] = '';
		}
		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}
		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
		}
		if (isset($this->error['title_length'])) {
			$data['error_title_length'] = $this->error['title_length'];
		} else {
			$data['error_title_length'] = '';
		}
		if (isset($this->error['description_length'])) {
			$data['error_description_length'] = $this->error['description_length'];
		} else {
			$data['error_description_length'] = '';
		}

		if (isset($this->error['min_length'])) {
			$data['error_min_length'] = $this->error['min_length'];
		} else {
			$data['error_min_length'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		    unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

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
			'href' => $this->url->link('extension/module/live_search', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/live_search', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		// 取得語系圖片路徑
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages(array('sort' => 'code'));
		$default_view_all_results = array();
		foreach ($data['languages'] as $key => $language) {
			$flag_img = 'language/'.$language['code'].'/'.$language['image'];
			if(!is_file($flag_img)){
				$flag_img = 'language/'.$language['code'].'/'.$language['code'].'.png';
				if(!is_file($flag_img)) $flag_img = null;
			}

			$data['languages'][$key]['flag_img'] = $flag_img;
			// 多國語系支援：預設文字
			$default_view_all_results[$language['language_id']]['name'] = $this->language->get('text_view_all_results');
		}

		// 多國語系支援：檢視更多 連結文字
		if (isset($this->request->post['module_live_search_view_all_results'])) {
			$data['module_live_search_view_all_results'] = $this->request->post['module_live_search_view_all_results'];
		} elseif( null !== $this->config->get('module_live_search_view_all_results') ) {
			$data['module_live_search_view_all_results'] = $this->config->get('module_live_search_view_all_results');
		} else {
			$data['module_live_search_view_all_results'] = $default_view_all_results;
		}

		// 搜尋筆數
		if (isset($this->request->post['module_live_search_limit'])) {
			$data['module_live_search_limit'] = $this->request->post['module_live_search_limit'];
		} elseif( null !== $this->config->get('module_live_search_limit') ) {
			$data['module_live_search_limit'] = $this->config->get('module_live_search_limit');
		} else {
			$data['module_live_search_limit'] = 5;
		}

		// 縮圖寬度
		if (isset($this->request->post['module_live_search_image_width'])) {
			$data['module_live_search_image_width'] = $this->request->post['module_live_search_image_width'];
		} elseif( null !== $this->config->get('module_live_search_image_width') ) {
			$data['module_live_search_image_width'] = $this->config->get('module_live_search_image_width');
		} else {
			$data['module_live_search_image_width'] = 50;
		}

		// 縮圖高度
		if (isset($this->request->post['module_live_search_image_height'])) {
			$data['module_live_search_image_height'] = $this->request->post['module_live_search_image_height'];
		} elseif( null !== $this->config->get('module_live_search_image_height') ) {
			$data['module_live_search_image_height'] = $this->config->get('module_live_search_image_height');
		} else {
			$data['module_live_search_image_height'] = 50;
		}

		// 標題長度
		if (isset($this->request->post['module_live_search_title_length'])) {
			$data['module_live_search_title_length'] = $this->request->post['module_live_search_title_length'];
		} elseif( null !== $this->config->get('module_live_search_title_length') ) {
			$data['module_live_search_title_length'] = $this->config->get('module_live_search_title_length');
		} else {
			$data['module_live_search_title_length'] = 100;
		}

		// 簡述長度
		if (isset($this->request->post['module_live_search_description_length'])) {
			$data['module_live_search_description_length'] = $this->request->post['module_live_search_description_length'];
		} elseif( null !== $this->config->get('module_live_search_description_length') ) {
			$data['module_live_search_description_length'] = $this->config->get('module_live_search_description_length');
		} else {
			$data['module_live_search_description_length'] = 100;
		}

		// 最小搜尋字數
		if (isset($this->request->post['module_live_search_min_length'])) {
			$data['module_live_search_min_length'] = $this->request->post['module_live_search_min_length'];
		} elseif( null !== $this->config->get('module_live_search_min_length') ) {
			$data['module_live_search_min_length'] = $this->config->get('module_live_search_min_length');
		} else {
			$data['module_live_search_min_length'] = 1;
		}

		// 下拉選單：顯示商品縮圖
		if (isset($this->request->post['module_live_search_show_image'])) {
			$data['module_live_search_show_image'] = $this->request->post['module_live_search_show_image'];
		} else {
			$data['module_live_search_show_image'] = $this->config->get('module_live_search_show_image');
		}

		// 下拉選單：顯示售價
		if (isset($this->request->post['module_live_search_show_price'])) {
			$data['module_live_search_show_price'] = $this->request->post['module_live_search_show_price'];
		} else {
			$data['module_live_search_show_price'] = $this->config->get('module_live_search_show_price');
		}

		// 下拉選單：顯示簡述
		if (isset($this->request->post['module_live_search_show_description'])) {
			$data['module_live_search_show_description'] = $this->request->post['module_live_search_show_description'];
		} else {
			$data['module_live_search_show_description'] = $this->config->get('module_live_search_show_description');
		}

		// 顯示加入購物車按鈕
		if (isset($this->request->post['module_live_search_show_add_button'])) {
			$data['module_live_search_show_add_button'] = $this->request->post['module_live_search_show_add_button'];
		} else {
			$data['module_live_search_show_add_button'] = $this->config->get('module_live_search_show_add_button');
		}

		// 下拉選單：啟用狀態
		if (isset($this->request->post['module_live_search_status'])) {
			$data['module_live_search_status'] = $this->request->post['module_live_search_status'];
		} else {
			$data['module_live_search_status'] = $this->config->get('module_live_search_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        $data['current_lang_id'] = $this->config->get('config_language_id');

		$this->response->setOutput($this->load->view('extension/module/live_search', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/live_search')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['module_live_search_view_all_results'] as $language_id => $sort_order) {
			if (!$sort_order['name']) {
				$this->error['view_all_results'][$language_id] = $this->language->get('error_view_all_results');
			}
		}

		if (!$this->request->post['module_live_search_limit']) {
			$this->error['limit'] = $this->language->get('error_limit');
		}
		if (!$this->request->post['module_live_search_image_width']) {
			$this->error['width'] = $this->language->get('error_width');
		}
		if (!$this->request->post['module_live_search_image_height']) {
			$this->error['height'] = $this->language->get('error_height');
		}
		if (!$this->request->post['module_live_search_title_length']) {
			$this->error['title_length'] = $this->language->get('error_title_length');
		}
		if (!$this->request->post['module_live_search_description_length']) {
			$this->error['description_length'] = $this->language->get('error_description_length');
		}
		if (!$this->request->post['module_live_search_description_length']) {
			$this->error['description_length'] = $this->language->get('error_description_length');
		}

		return !$this->error;
	}

	public function install() {
		$this->load->model('setting/event');
        $this->model_setting_event->addEvent('ajax_live_search', 'catalog/view/common/header/after', 'extension/module/live_search/injectLiveSearch');
	}

	public function uninstall() {
		$this->load->model('setting/event');
		$this->model_setting_event->deleteEventByCode('ajax_live_search');
	}
}
?>