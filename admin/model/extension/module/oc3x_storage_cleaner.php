<?php
class ModelExtensionModuleOc3xStorageCleaner extends Model {
	public function getSize() {
		$dirs = array(
			'cache-system' => DIR_CACHE,
			'cache-modification' => DIR_MODIFICATION,
			'cache-image' => DIR_IMAGE . 'cache/',
			'log-error' => DIR_LOGS . 'error.log',
			'log-modification' => DIR_LOGS . 'ocmod.log',
		);

		foreach ($dirs as $key => $dir) {
			$sizes[$key] = 0;

			$files = array();

			$path = array($dir . '*');

			while (count($path) != 0) {
				$next = array_shift($path);

				if (is_array(glob($next))) {
					foreach (glob($next) as $file) {
						if (is_dir($file)) {
							$path[] = $file . '/*';
						}

						$files[] = $file;
					}
				}
			}

			if (!empty($files)) {
				rsort($files);

				foreach ($files as $file) {
					if ($file != $dir . 'index.html' && $file != $dir . '.htaccess') {
						if (is_file($file)) {
							$sizes[$key] += filesize($file);
						}
					}
				}
			}
		}

		foreach ($sizes as $key => $size) {
			$output[$key] = $this->formatSize($size);
		}

		$output['all'] = $this->formatSize(array_sum($sizes));

		return $output;
	}

	protected function formatSize($size) {
		$sizenames = array(' B', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', 'YB');

		$item = 0;

		while ($size >= 1024) {
			$size /= 1024;

			$item++;
		}

		if ($item > 2) {
			$output = round($size, 2) . $sizenames[$item];
		} else {
			$output = round($size, 0) . $sizenames[$item];
		}

		return $output;
	}
}
