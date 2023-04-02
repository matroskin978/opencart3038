<?php

namespace Template;

final class Twig
{
	private $data = array();

	public function set($key, $value)
	{
		$this->data[$key] = $value;
	}

	public function render($filename, $code = '')
	{
		if (!$code) {
			$file = DIR_TEMPLATE . $filename . '.twig';

			if (is_file($file)) {
				$code = file_get_contents($file);
			} else {
				throw new \Exception('Error: Could not load template ' . $file . '!');
				exit();
			}
		}

		// initialize Twig environment
		$config = array(
			'autoescape'  => false,
			'debug'       => true,
			'auto_reload' => true,
			'cache'       => DIR_CACHE . 'template/'
		);

		try {
			$loader = new \Twig\Loader\ArrayLoader(array($filename . '.twig' => $code));

			$twig = new \Twig\Environment($loader, $config);
			$twig->addExtension(new \Twig\Extension\DebugExtension);

			return $twig->render($filename . '.twig', $this->data);
		} catch (Exception $e) {
			trigger_error('Error: Could not load template ' . $filename . '!');
			exit();
		}
	}
}
