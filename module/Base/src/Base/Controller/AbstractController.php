<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 04/05/2016
 * Time: 20:21
 */

namespace Base\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Mvc\MvcEvent;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

abstract class AbstractController extends AbstractActionController
{
	/**
	 * @var EntityManager
	 */
	protected $entityManager;
	protected $service;
	protected $entity;
	protected $form;
	protected $route;
	protected $controller;

	/**
	 * Aqui verifica se o cara tem autenticação para acessar o recurso solicitado
	 *
	 * @param MvcEvent $e
	 * @return mixed|\Zend\Http\Response
	 */
	public function onDispatch(MvcEvent $e)
	{
		$privilege  = $e->getRouteMatch()->getParam('action', 'index');
		$privilege  = "{$privilege}Action";
		$aclService = $this->getServiceLocator()->get('Base\Service\AclService');
		if (!$aclService->isAuthorized(get_class($this), $privilege)) {
			$this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_ERROR)->addMessage('Você não tem permissão para acessar este recurso.');

			return $this->redirect()->toRoute('sistema-auth', ['controller' => 'index']);
		}

		return parent::onDispatch($e);
	}

	public function indexAction()
	{
		$repo = $this->getEntityManager()->getRepository($this->entity);
		$list = $repo->findAll();

		$page = $this->params()->fromRoute('page');

		$paginator = new Paginator(new ArrayAdapter($list));
		$paginator->setCurrentPageNumber($page);
		$paginator->setDefaultItemCountPerPage(10);

		return new ViewModel(['data' => $paginator, 'page' => $page]);
	}

	public function newAction()
	{
		$form    = new $this->form();
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$service = $this->getServiceLocator()->get($this->service);
				$service->insert($request->getPost()->toArray());
				$this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)->addMessage('Registro inserido com Sucesso');

				return $this->redirect()->toRoute($this->route, ['controller' => $this->controller]);
			}
		}

		return new ViewModel(['form' => $form]);
	}

	public function editAction()
	{
		$form    = new $this->form();
		$request = $this->getRequest();
		$repo    = $this->getEntityManager()->getRepository($this->entity);
		$entity  = $repo->find($this->params()->fromRoute('id', 0));
		if ($this->params()->fromRoute('id', 0)) {
			$form->setData($entity->toArray());
		}
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$service = $this->getServiceLocator()->get($this->service);
				$service->update($request->getPost()->toArray());
				$this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)->addMessage('Registro alterado com Sucesso');

				return $this->redirect()->toRoute($this->route, ['controller' => $this->controller]);
			}
		}

		return new ViewModel(['form' => $form]);
	}

	public function deleteAction()
	{
		$service = $this->getServiceLocator()->get($this->service);
		if ($service->delete($this->params()->fromRoute('id', 0))) {
			$this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)->addMessage('Registro deletado com Sucesso');

			return $this->redirect()->toRoute($this->route, ['controller' => $this->controller]);
		}

		return false;
	}


	protected function getEntityManager()
	{

		if ($this->entityManager === null) {
			$this->entityManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		}

		return $this->entityManager;
	}
}