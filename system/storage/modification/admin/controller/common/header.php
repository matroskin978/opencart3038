<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		if ($this->request->server['HTTPS']) {
            $server = HTTPS_CATALOG;
        } else {
            $server = HTTP_CATALOG;
        }

        if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
        }

		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$this->load->language('common/header');

		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->user->getUserName());

		if (!isset($this->request->get['user_token']) || !isset($this->session->data['user_token']) || ($this->request->get['user_token'] != $this->session->data['user_token'])) {
			$data['logged'] = '';

			$data['home'] = $this->url->link('common/login', '', true);
		} else {
			$data['logged'] = true;

			if ($this->config->get('oc3x_storage_cleaner_status') && $this->user->hasPermission('access', 'extension/module/oc3x_storage_cleaner') && $this->user->hasPermission('modify', 'extension/module/oc3x_storage_cleaner')) {
				$this->load->language('extension/module/oc3x_storage_cleaner');
				$data['heading_title'] = $this->language->get('page_title');
				$data['text_clear'] = $this->language->get('text_clear');
				$data['text_clear_all'] = $this->language->get('text_clear_all');
				$data['text_refresh'] = $this->language->get('text_refresh');
				$data['text_cache'] = $this->language->get('text_cache');
				$data['text_cache_system'] = $this->language->get('text_cache_system');
				$data['text_cache_modification'] = $this->language->get('text_cache_modification');
				$data['text_cache_image'] = $this->language->get('text_cache_image');
				$data['text_log'] = $this->language->get('text_log');
				$data['text_log_error'] = $this->language->get('text_log_error');
				$data['text_log_modification'] = $this->language->get('text_log_modification');

				$this->load->model('extension/module/oc3x_storage_cleaner');

				if ($this->config->get('oc3x_storage_cleaner_size')) {
					$data['text_cleaner_size'] = $this->model_extension_module_oc3x_storage_cleaner->getSize();
				} else {
					$data['text_cleaner_size'] = false;
				}

				$data['storage_cleaner'] = true;
			}
			

			$data['home'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true);
			$data['logout'] = $this->url->link('common/logout', 'user_token=' . $this->session->data['user_token'], true);
			$data['profile'] = $this->url->link('common/profile', 'user_token=' . $this->session->data['user_token'], true);

			$this->load->model('user/user');

			$this->load->model('tool/image');

			$user_info = $this->model_user_user->getUser($this->user->getId());

			if ($user_info) {
				$data['firstname'] = $user_info['firstname'];
				$data['lastname'] = $user_info['lastname'];
				$data['username']  = $user_info['username'];
				$data['user_group'] = $user_info['user_group'];

				if (is_file(DIR_IMAGE . $user_info['image'])) {
					$data['image'] = $this->model_tool_image->resize($user_info['image'], 45, 45);
				} else {
					$data['image'] = $this->model_tool_image->resize('profile.png', 45, 45);
				}
			} else {
				$data['firstname'] = '';
				$data['lastname'] = '';
				$data['user_group'] = '';
				$data['image'] = '';
			}

			// Online Stores
			$data['stores'] = array();

			$data['stores'][] = array(
				'name' => $this->config->get('config_name'),
				'href' => HTTP_CATALOG
			);

			$this->load->model('setting/store');

			$results = $this->model_setting_store->getStores();

			foreach ($results as $result) {
				$data['stores'][] = array(
					'name' => $result['name'],
					'href' => $result['url']
				);
			}
		}

		return $this->load->view('common/header', $data);
	}
}
