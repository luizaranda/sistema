<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Sistema;

use Acl\View\Helper\UserIdentity;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Authentication\AuthenticationService;

class Module
{
	public function onBootstrap(MvcEvent $e)
	{
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

	}

	public function init(ModuleManager $moduleManager)
	{
		$sharedEvents = $moduleManager->getEventManager()->getSharedManager();
		$sharedEvents->attach('Zend\Mvc\Controller\AbstractActionController', MvcEvent::EVENT_DISPATCH, [$this, 'authenticateSession'], 99);

	}

	/**
	 * Evento para verificar se o cara esta logado
	 *
	 * @param mixed $e
	 */
	public function authenticateSession($e)
	{
		$authService = new AuthenticationService();
		$authService->setStorage(new SessionStorage('Sistema'));

		$controller   = $e->getTarget();
		$matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
		if (!$authService->hasIdentity() && strpos($matchedRoute, "sistema-home") !== false) {
			return $controller->redirect()->toRoute('sistema-auth');
		}

	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return [
			'Zend\Loader\StandardAutoloader' => [
				'namespaces' => [
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				],
			],
		];
	}

	public function getViewHelperConfig()
	{
		return [
			'invokables' => [
				'UserIdentity' => UserIdentity::class,
			],
		];
	}
}
