<?php
class ControllerExtensionModuleLiveSearch extends Controller {
	public function index() {
		$json = array();
		if (isset($this->request->get['filter_name'])) {
			$search = $this->request->get['filter_name'];
		} else {
			$search = '';
		}
		if (isset($this->request->get['cat_id'])) {
			$cat_id = (int)$this->request->get['cat_id'];
		} else {
			$cat_id = 0;
		}

		$tag           = $search;
		$description   = '';
		$category_id   = $cat_id;
		$sub_category  = '';
		$sort          = 'p.sort_order';
		$order         = 'ASC';
		$page          = 1;
		$limit         = $this->config->get('module_live_search_limit');
		$search_result = 0;
		$error         = false;
		if( version_compare(VERSION, '3.0.0.0', '>=') ){
			$currency_code = $this->session->data['currency'];
		}
		else{
			$error = true;
			$json[] = array(
				'product_id' => 0,
				'minimum'    => 0,
				'image'      => null,
				'name'       => 'Version Error: '.VERSION,
				'extra_info' => null,
				'price'      => 0,
				'special'    => 0,
				'url'        => '#'
			);
		}

		if(!$error){
			if (isset($this->request->get['filter_name'])) {
				$this->load->model('catalog/product');
				$this->load->model('tool/image');
				$filter_data = array(
					'filter_name'         => $search,
					'filter_tag'          => $tag,
					'filter_description'  => $description,
					'filter_category_id'  => $category_id,
					'filter_sub_category' => $sub_category,
					'sort'                => $sort,
					'order'               => $order,
					'start'               => ($page - 1) * $limit,
					'limit'               => $limit
				);
				$results = $this->model_catalog_product->getProducts($filter_data);
				$search_result = $this->model_catalog_product->getTotalProducts($filter_data);
				$image_width        = $this->config->get('module_live_search_image_width') ? $this->config->get('module_live_search_image_width') : 0;
				$image_height       = $this->config->get('module_live_search_image_height') ? $this->config->get('module_live_search_image_height') : 0;
				$title_length       = $this->config->get('module_live_search_title_length');
				$description_length = $this->config->get('module_live_search_description_length');

				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $image_width, $image_height);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $image_width, $image_height);
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $currency_code);
					} else {
						$price = false;
					}

					if ((float)$result['special']) {
						$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $currency_code);
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $currency_code);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = (int)$result['rating'];
					} else {
						$rating = false;
					}
					$json['total'] = (int)$search_result;
					$json['products'][] = array(
						'product_id' => $result['product_id'],
						'minimum'    => $result['minimum'],
						'image'      => $image,
						'name'       => utf8_substr(strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')), 0, $title_length) . '..',
						'extra_info' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $description_length) . '..',
						'price'      => $price,
						'special'    => $special,
						'url'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);
				}
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	// Extensions Events
	public function injectLiveSearch(&$route, &$data, &$output) {
		if($this->config->get('module_live_search_status')){
			$this->load->language('product/search', 'search');
        	$text_view_all_results = $this->config->get('module_live_search_view_all_results');

        	$liveSearch = [
				'text_view_all_results'               => htmlspecialchars($text_view_all_results[$this->config->get('config_language_id')]['name']),
				'text_empty'                          => $this->language->get('search')->get('text_empty'),
				'module_live_search_show_image'       => (int)$this->config->get('module_live_search_show_image'),
				'module_live_search_show_price'       => (int)$this->config->get('module_live_search_show_price'),
				'module_live_search_show_description' => (int)$this->config->get('module_live_search_show_description'),
				'module_live_search_min_length'       => (int)$this->config->get('module_live_search_min_length'),
				'module_live_search_show_add_button'  => (int)$this->config->get('module_live_search_show_add_button'),
        	];

            $liveSearchJS = '<link href="catalog/view/javascript/live_search/live_search.css" rel="stylesheet" type="text/css">'."\n";
            $liveSearchJS .= '<script src="catalog/view/javascript/live_search/live_search.js"></script>'."\n";
            $liveSearchJS .= '<script type="text/javascript"><!--'."\n";
			$liveSearchJS .= '$(document).ready(function() {'."\n";
			$liveSearchJS .= 'var options = '.json_encode($liveSearch).';'."\n";
			$liveSearchJS .= 'LiveSearchJs.init(options); '."\n";
			$liveSearchJS .= '});'."\n";
			$liveSearchJS .= '//--></script>'."\n";
			$liveSearchJS .= '</head>'."\n";
			$output = str_replace('</head>', $liveSearchJS, $output);
			

			
		}
	}
}

