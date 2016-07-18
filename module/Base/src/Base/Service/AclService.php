<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 10/05/2016
 * Time: 18:42
 */

namespace Base\Service;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclService extends AbstractPlugin
{

	protected $serviceLocator;

	public function __construct(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
	}

	public function isAuthorized($resource, $privilege)
	{
		/**
		 * pegando o nome da classe
		 */
		$resource = explode("/", str_replace("\\", "/", $resource));
		$resource = end($resource);
		if ($resource != "AuthController") {
			$userLoged = $this->serviceLocator->get('UserLoged');
			if (empty($userLoged)) {
				return false;
			}
			$acl = $this->serviceLocator->get('Acl\Permission\AccessControl');
			if ($acl->isAllowed($userLoged->getRole()->getName(), $resource, $privilege)) {
				return true;
			} else {
				return false;
			}
		}

		return true;
	}

}