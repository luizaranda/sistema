<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Acl;

use Acl\Auth\Adapter as AuthAdapter;
use Acl\Form\Privilege as PrivilegeForm;
use Acl\Form\User as UserForm;
use Acl\Form\Role as RoleForm;
use Acl\Permission\AccessControl;
use Acl\View\Helper\UserIdentity;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

class Module
{

	public function onBootstrap(MvcEvent $e)
	{
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

		$e->getApplication()->getServiceManager()->get('viewhelpermanager')->setFactory('controllerName', function ($sm) use ($e) {
			$viewHelper = new View\Helper\ControllerName($e->getRouteMatch());

			return $viewHelper;
		});

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

	public function getServiceConfig()
	{
		return [
			'factories' => [
				'Acl\Mail\Transport'           => function ($serviceManager) {
					$config    = $serviceManager->get('Config');
					$transport = new SmtpTransport();
					$options   = new SmtpOptions($config['mail']);
					$transport->setOptions($options);

					return $transport;
				},
				'Acl\Service\User'             => function ($serviceManager) {
					return new Service\User($serviceManager->get('Doctrine\ORM\EntityManager'),
					                        $serviceManager->get('Acl\Mail\Transport'),
					                        $serviceManager->get('View'));
				},
				'Acl\Service\Role'             => function ($serviceManager) {
					return new Service\Role($serviceManager->get('Doctrine\ORM\EntityManager'));
				},
				'Acl\Service\Resource'         => function ($serviceManager) {
					return new Service\Resource($serviceManager->get('Doctrine\ORM\EntityManager'));
				},
				'Acl\Service\Privilege'        => function ($serviceManager) {
					return new Service\Privilege($serviceManager->get('Doctrine\ORM\EntityManager'));
				},
				'Acl\Form\User'                => function ($service) {
					$entityManager = $service->get('Doctrine\ORM\EntityManager');
					$repoRole      = $entityManager->getRepository('Acl\Entity\Role');
					$roles         = $repoRole->fetchParent();

					return new UserForm('user', [], $roles);
				},
				'Acl\Form\Role'                => function ($service) {
					$entityManager = $service->get('Doctrine\ORM\EntityManager');
					$repo          = $entityManager->getRepository('Acl\Entity\Role');
					$parent        = $repo->fetchParent();

					return new RoleForm('role', [], $parent);
				},
				'Acl\Form\Privilege'           => function ($service) {
					$entityManager = $service->get('Doctrine\ORM\EntityManager');
					$repoRole      = $entityManager->getRepository('Acl\Entity\Role');
					$repoResource  = $entityManager->getRepository('Acl\Entity\Resource');
					$roles         = $repoRole->fetchParent();
					$resources     = $repoResource->fetchPairs();

					return new PrivilegeForm('privilege', [], $roles, $resources);
				},
				'Acl\Auth\Adapter'             => function ($service) {
					return new AuthAdapter($service->get('Doctrine\ORM\EntityManager'));
				},
				/**
				 * Registro da Acl para controle de acesso
				 */
				'Acl\Permission\AccessControl' => function ($service) {
					$entityManager = $service->get('Doctrine\ORM\EntityManager');
					$repoRole      = $entityManager->getRepository('Acl\Entity\Role');
					$repoResource  = $entityManager->getRepository('Acl\Entity\Resource');
					$repoPrivilege = $entityManager->getRepository('Acl\Entity\Privilege');
					$roles         = $repoRole->findAll();
					$resources     = $repoResource->findAll();
					$privileges    = $repoPrivilege->findAll();

					return new AccessControl($roles, $resources, $privileges);
				},
				'UserLoged'                    => function ($service) {
					$auth = new AuthenticationService();
					$auth->setStorage(new SessionStorage('Sistema'));

					return !empty($auth->getIdentity()) ? $auth->getIdentity() : [];
				},
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
