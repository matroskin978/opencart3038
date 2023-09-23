<?php
class ControllerExtensionModuleOc3xStorageCleaner extends Controller {
	private $error = array();
	private $maintenance = 0;

	public function index() {
		$this->load->language('extension/module/oc3x_storage_cleaner');

		$this->document->setTitle($this->language->get('page_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('oc3x_storage_cleaner', $this->request->post);
			$this->model_setting_setting->editSetting('module_oc3x_storage_cleaner', array('module_oc3x_storage_cleaner_status' => $this->request->post['oc3x_storage_cleaner_status']));

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['tab_settings'] = $this->language->get('tab_settings');
		$data['tab_help'] = $this->language->get('tab_help');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_documentation'] = $this->language->get('text_documentation');
		$data['text_developer'] = $this->language->get('text_developer');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_size'] = $this->language->get('entry_size');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('page_title'),
			'href' => $this->url->link('extension/module/oc3x_storage_cleaner', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/oc3x_storage_cleaner', 'user_token=' . $this->session->data['user_token'], true);
		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'], true);

		if (isset($this->request->post['oc3x_storage_cleaner_status'])) {
			$data['oc3x_storage_cleaner_status'] = $this->request->post['oc3x_storage_cleaner_status'];
		} else {
			$data['oc3x_storage_cleaner_status'] = $this->config->get('oc3x_storage_cleaner_status');
		}

		if (isset($this->request->post['oc3x_storage_cleaner_size'])) {
			$data['oc3x_storage_cleaner_size'] = $this->request->post['oc3x_storage_cleaner_size'];
		} else {
			$data['oc3x_storage_cleaner_size'] = $this->config->get('oc3x_storage_cleaner_size');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/oc3x_storage_cleaner', $data));
	}

	public function clearCache() {
		$this->load->language('extension/module/oc3x_storage_cleaner');

		$json = array();

		if (!$this->validateWidget() || empty($this->request->post['key'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$key = $this->request->post['key'];

			if ($key == 'system') {
				$dir = DIR_CACHE;
			} elseif ($key == 'modification') {
				// Just before files are deleted, if config settings say maintenance mode is off then turn it on
				$this->maintenance = $this->config->get('config_maintenance');

				$this->load->model('setting/setting');

				$this->model_setting_setting->editSettingValue('config', 'config_maintenance', true);

				$dir = DIR_MODIFICATION;
			} elseif ($key == 'image') {
				$dir = DIR_IMAGE . 'cache/';
			} else {
				$dir = false;
			}

			if ($dir) {
				$files = array();

				// Make path into an array
				$path = array($dir . '*');

				// While the path array is still populated keep looping through
				while (count($path) != 0) {
					$next = array_shift($path);

					foreach (glob($next) as $file) {
						// If directory add to path array
						if (is_dir($file)) {
							$path[] = $file . '/*';
						}

						// Add the file to the files to be deleted array
						$files[] = $file;
					}
				}

				// Reverse sort the file array
				rsort($files);

				// Clear all files
				foreach ($files as $file) {
					if ($file != $dir . 'index.html' && $file != $dir . '.htaccess') {
						// If file just delete
						if (is_file($file)) {
							unlink($file);

						// If directory use the remove directory function
						} elseif (is_dir($file)) {
							rmdir($file);
						}
					}
				}

				if ($key == 'modification') {
					$this->refreshModification();
				}

				$this->load->model('extension/module/oc3x_storage_cleaner');

				if ($this->config->get('oc3x_storage_cleaner_size')) {
					$json['size'] = $this->model_extension_module_oc3x_storage_cleaner->getSize();
				}

				$json['success'] = $this->language->get('text_success_clear');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function clearLog() {
		$this->load->language('extension/module/oc3x_storage_cleaner');

		$json = array();

		if (!$this->validateWidget() || empty($this->request->post['key'])) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$key = $this->request->post['key'];

			if ($key == 'error') {
				$file = DIR_LOGS . $this->config->get('config_error_filename');
			} elseif ($key == 'modification') {
				$file = DIR_LOGS . 'ocmod.log';
			} else {
				$file = false;
			}

			if ($file) {
				$handle = fopen($file, 'w+');

				fclose($handle);

				$this->load->model('extension/module/oc3x_storage_cleaner');

				if ($this->config->get('oc3x_storage_cleaner_size')) {
					$json['size'] = $this->model_extension_module_oc3x_storage_cleaner->getSize();
				}

				$json['success'] = $this->language->get('text_success_clear');
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function refreshModification() {
		$this->load->model('setting/modification');
		$this->load->model('setting/setting');

		//Log
		$log = array();

		// Begin
		$xml = array();

		// Load the default modification XML
		$xml[] = file_get_contents(DIR_SYSTEM . 'modification.xml');

		// This is purly for developers so they can run mods directly and have them run without upload sfter each change.
		$files = glob(DIR_SYSTEM . '*.ocmod.xml');

		if ($files) {
			foreach ($files as $file) {
				$xml[] = file_get_contents($file);
			}
		}

		// Get the default modification file
		$results = $this->model_setting_modification->getModifications();

		foreach ($results as $result) {
			if ($result['status']) {
				$xml[] = $result['xml'];
			}
		}

		$modification = array();

		foreach ($xml as $xml) {
			if (empty($xml)){
				continue;
			}
			
			$dom = new DOMDocument('1.0', 'UTF-8');
			$dom->preserveWhiteSpace = false;
			$dom->loadXml($xml);

			// Log
			$log[] = 'MOD: ' . $dom->getElementsByTagName('name')->item(0)->textContent;

			// Wipe the past modification store in the backup array
			$recovery = array();

			// Set the a recovery of the modification code in case we need to use it if an abort attribute is used.
			if (isset($modification)) {
				$recovery = $modification;
			}

			$files = $dom->getElementsByTagName('modification')->item(0)->getElementsByTagName('file');

			foreach ($files as $file) {
				$operations = $file->getElementsByTagName('operation');

				$files = explode('|', $file->getAttribute('path'));

				foreach ($files as $file) {
					$path = '';

					// Get the full path of the files that are going to be used for modification
					if ((substr($file, 0, 7) == 'catalog')) {
						$path = DIR_CATALOG . substr($file, 8);
					}

					if ((substr($file, 0, 5) == 'admin')) {
						$path = DIR_APPLICATION . substr($file, 6);
					}

					if ((substr($file, 0, 6) == 'system')) {
						$path = DIR_SYSTEM . substr($file, 7);
					}

					if ($path) {
						$files = glob($path, GLOB_BRACE);

						if ($files) {
							foreach ($files as $file) {
								// Get the key to be used for the modification cache filename.
								if (substr($file, 0, strlen(DIR_CATALOG)) == DIR_CATALOG) {
									$key = 'catalog/' . substr($file, strlen(DIR_CATALOG));
								}

								if (substr($file, 0, strlen(DIR_APPLICATION)) == DIR_APPLICATION) {
									$key = 'admin/' . substr($file, strlen(DIR_APPLICATION));
								}

								if (substr($file, 0, strlen(DIR_SYSTEM)) == DIR_SYSTEM) {
									$key = 'system/' . substr($file, strlen(DIR_SYSTEM));
								}

								// If file contents is not already in the modification array we need to load it.
								if (!isset($modification[$key])) {
									$content = file_get_contents($file);

									$modification[$key] = preg_replace('~\r?\n~', "\n", $content);
									$original[$key] = preg_replace('~\r?\n~', "\n", $content);

									// Log
									$log[] = PHP_EOL . 'FILE: ' . $key;
								}

								foreach ($operations as $operation) {
									$error = $operation->getAttribute('error');

									// Ignoreif
									$ignoreif = $operation->getElementsByTagName('ignoreif')->item(0);

									if ($ignoreif) {
										if ($ignoreif->getAttribute('regex') != 'true') {
											if (strpos($modification[$key], $ignoreif->textContent) !== false) {
												continue;
											}
										} else {
											if (preg_match($ignoreif->textContent, $modification[$key])) {
												continue;
											}
										}
									}

									$status = false;

									// Search and replace
									if ($operation->getElementsByTagName('search')->item(0)->getAttribute('regex') != 'true') {
										// Search
										$search = $operation->getElementsByTagName('search')->item(0)->textContent;
										$trim = $operation->getElementsByTagName('search')->item(0)->getAttribute('trim');
										$index = $operation->getElementsByTagName('search')->item(0)->getAttribute('index');

										// Trim line if no trim attribute is set or is set to true.
										if (!$trim || $trim == 'true') {
											$search = trim($search);
										}

										// Add
										$add = $operation->getElementsByTagName('add')->item(0)->textContent;
										$trim = $operation->getElementsByTagName('add')->item(0)->getAttribute('trim');
										$position = $operation->getElementsByTagName('add')->item(0)->getAttribute('position');
										$offset = $operation->getElementsByTagName('add')->item(0)->getAttribute('offset');

										if ($offset == '') {
											$offset = 0;
										}

										// Trim line if is set to true.
										if ($trim == 'true') {
											$add = trim($add);
										}

										// Log
										$log[] = 'CODE: ' . $search;

										// Check if using indexes
										if ($index !== '') {
											$indexes = explode(',', $index);
										} else {
											$indexes = array();
										}

										// Get all the matches
										$i = 0;

										$lines = explode("\n", $modification[$key]);

										for ($line_id = 0; $line_id < count($lines); $line_id++) {
											$line = $lines[$line_id];

											// Status
											$match = false;

											// Check to see if the line matches the search code.
											if (stripos($line, $search) !== false) {
												// If indexes are not used then just set the found status to true.
												if (!$indexes) {
													$match = true;
												} elseif (in_array($i, $indexes)) {
													$match = true;
												}

												$i++;
											}

											// Now for replacing or adding to the matched elements
											if ($match) {
												switch ($position) {
													default:
													case 'replace':
														$new_lines = explode("\n", $add);

														if ($offset < 0) {
															array_splice($lines, $line_id + $offset, abs($offset) + 1, array(str_replace($search, $add, $line)));

															$line_id -= $offset;
														} else {
															array_splice($lines, $line_id, $offset + 1, array(str_replace($search, $add, $line)));
														}

														break;
													case 'before':
														$new_lines = explode("\n", $add);

														array_splice($lines, $line_id - $offset, 0, $new_lines);

														$line_id += count($new_lines);
														break;
													case 'after':
														$new_lines = explode("\n", $add);

														array_splice($lines, ($line_id + 1) + $offset, 0, $new_lines);

														$line_id += count($new_lines);
														break;
												}

												// Log
												$log[] = 'LINE: ' . $line_id;

												$status = true;
											}
										}

										$modification[$key] = implode("\n", $lines);
									} else {
										$search = trim($operation->getElementsByTagName('search')->item(0)->textContent);
										$limit = $operation->getElementsByTagName('search')->item(0)->getAttribute('limit');
										$replace = trim($operation->getElementsByTagName('add')->item(0)->textContent);

										// Limit
										if (!$limit) {
											$limit = -1;
										}

										// Log
										$match = array();

										preg_match_all($search, $modification[$key], $match, PREG_OFFSET_CAPTURE);

										// Remove part of the the result if a limit is set.
										if ($limit > 0) {
											$match[0] = array_slice($match[0], 0, $limit);
										}

										if ($match[0]) {
											$log[] = 'REGEX: ' . $search;

											for ($i = 0; $i < count($match[0]); $i++) {
												$log[] = 'LINE: ' . (substr_count(substr($modification[$key], 0, $match[0][$i][1]), "\n") + 1);
											}

											$status = true;
										}

										// Make the modification
										$modification[$key] = preg_replace($search, $replace, $modification[$key], $limit);
									}

									if (!$status) {
										// Abort applying this modification completely.
										if ($error == 'abort') {
											$modification = $recovery;
											// Log
											$log[] = 'NOT FOUND - ABORTING!';
											break 5;
										}
										// Skip current operation or break
										elseif ($error == 'skip') {
											// Log
											$log[] = 'NOT FOUND - OPERATION SKIPPED!';
											continue;
										}
										// Break current operations
										else {
											// Log
											$log[] = 'NOT FOUND - OPERATIONS ABORTED!';
										 	break;
										}
									}
								}
							}
						}
					}
				}
			}

			// Log
			$log[] = '----------------------------------------------------------------';
		}

		// Log
		$ocmod = new Log('ocmod.log');
		$ocmod->write(implode("\n", $log));

		// Write all modification files
		foreach ($modification as $key => $value) {
			// Only create a file if there are changes
			if ($original[$key] != $value) {
				$path = '';

				$directories = explode('/', dirname($key));

				foreach ($directories as $directory) {
					$path = $path . '/' . $directory;

					if (!is_dir(DIR_MODIFICATION . $path)) {
						@mkdir(DIR_MODIFICATION . $path, 0777);
					}
				}

				$handle = fopen(DIR_MODIFICATION . $key, 'w');

				fwrite($handle, $value);

				fclose($handle);
			}
		}

		// Maintance mode back to original settings
		$this->model_setting_setting->editSettingValue('config', 'config_maintenance', $this->maintenance);
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/oc3x_storage_cleaner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateWidget() {
		if (!$this->user->hasPermission('access', 'extension/module/oc3x_storage_cleaner') || !$this->user->hasPermission('modify', 'extension/module/oc3x_storage_cleaner') || !$this->config->get('oc3x_storage_cleaner_status')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
