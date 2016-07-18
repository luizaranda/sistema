<?php

if (!function_exists("pre")) {

	function pre($x, $titulo = '', $exit = false)
	{
		echo "<fieldset style='min-width: 50%; word-wrap: break-word; background-color: #FAFAFA; border: 2px groove #ddd !important; padding: 1.4em 1.4em 1.4em 1.4em !important;'>";
		if (!empty($titulo)) {
			echo "<legend style='color:rgb(0, 0, 123); padding: 3px 10px 3px 10px; font-weight: bold; font-size: 14px; text-transform: uppercase; border: 1px groove #ddd !important;'> $titulo </legend>";
		}
		echo "<pre>";
		print_r($x);
		echo "</pre>";
		echo "</fieldset>";
		if ($exit) {
			exit;
		}
	}
}
if (!function_exists("pred")) {

	function pred($valor = '', $titulo = '')
	{
		pre($valor, $titulo, true);
		exit;
	}
}
if (!function_exists("hr")) {

	function hr($valor)
	{
		echo $valor . "<hr />\n";
	}
}

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

/**
 * This autoloading setup is really more complicated than it needs to be for most
 * applications. The added complexity is simply to reduce the time it takes for
 * new developers to be productive with a fresh skeleton. It allows autoloading
 * to be correctly configured, regardless of the installation method and keeps
 * the use of composer completely optional. This setup should work fine for
 * most users, however, feel free to configure autoloading however you'd like.
 */

// Composer autoloading
if (file_exists('vendor/autoload.php')) {
	$loader = include 'vendor/autoload.php';
}

if (class_exists('Zend\Loader\AutoloaderFactory')) {
	return;
}

$zf2Path = false;

if (getenv('ZF2_PATH')) {            // Support for ZF2_PATH environment variable
	$zf2Path = getenv('ZF2_PATH');
} elseif (get_cfg_var('zf2_path')) { // Support for zf2_path directive value
	$zf2Path = get_cfg_var('zf2_path');
}

if ($zf2Path) {
	if (isset($loader)) {
		$loader->add('Zend', $zf2Path);
		$loader->add('ZendXml', $zf2Path);
	} else {
		include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
		Zend\Loader\AutoloaderFactory::factory(array(
			                                       'Zend\Loader\StandardAutoloader' => array(
				                                       'autoregister_zf' => true,
			                                       ),
		                                       ));
	}
}

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
	throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
}
