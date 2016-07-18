<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 15/05/2016
 * Time: 20:30
 */

namespace Acl\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ControllerName extends AbstractHelper
{

	protected $routeMatch;

	public function __construct($routeMatch)
	{
		$this->routeMatch = $routeMatch;
	}

	public function __invoke()
	{
		if ($this->routeMatch) {
			$controller = $this->routeMatch->getParam('controller', 'index');

			$controller = explode("\\", $controller);
			$controller = end($controller);

			return $this->getControlerName($controller);
		}
	}

	protected function getControlerName($controller)
	{
		$controller = strtolower($controller);
		switch ($controller) {
			case 'resource':
				return 'Recurso';
			case 'user':
				return 'Usuario';
			case 'role':
				return 'Perfil';
			case 'privilege':
				return 'Privilégio';
			case 'index':
				return 'Home';
		}

	}
}
