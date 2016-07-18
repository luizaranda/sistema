<?php

namespace Acl\Controller;

use Base\Controller\AbstractController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class UserController extends AbstractController
{

	public function __construct()
	{
		$this->service    = 'Acl\Service\User';
		$this->entity     = 'Acl\Entity\User';
		$this->form       = 'Acl\Form\User';
		$this->route      = 'acl-home/default';
		$this->controller = 'user';
	}

	public function indexAction()
	{
		$repo = $this->getEntityManager()->getRepository($this->entity);
		$list = $repo->findAll();
		foreach ($list as $i => $obj) {
			if ((bool)$obj->getActive()) {
				$obj->setActive('Ativo');
			} else {
				$obj->setActive('Inativo');
			}
			$list[$i] = $obj;
		}

		$page = $this->params()->fromRoute('page');

		$paginator = new Paginator(new ArrayAdapter($list));
		$paginator->setCurrentPageNumber($page);
		$paginator->setDefaultItemCountPerPage(10);

		return new ViewModel(['data' => $paginator, 'page' => $page]);
	}

	public function newAction()
	{
		$form    = $this->getServiceLocator()->get($this->form);
		$request = $this->getRequest();
		if ($request->isPost()) {

			/**
			 * Valida se ja existe um usuario cadastrado para o e-mail informado
			 */
			$entity = new $this->entity($request->getPost()->toArray());
			$repo   = $this->getEntityManager()->getRepository($this->entity);
			$exists = $repo->findOneByEmail($entity->getEmail());
			if ($exists) {
				$this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_ERROR)->addMessage('Usuario ja existe para o e-mail informado.');

				return $this->redirect()->toRoute($this->route, ['controller' => $this->controller]);
			}
			unset($entity);
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$service = $this->getServiceLocator()->get($this->service);
				$service->insert($request->getPost()->toArray());
				$this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)->addMessage('Registro inserido com sucesso.');

				return $this->redirect()->toRoute($this->route, ['controller' => $this->controller]);
			}
		}

		return new ViewModel(['form' => $form]);
	}

	public function editAction()
	{
		$form    = $this->getServiceLocator()->get($this->form);
		$request = $this->getRequest();
		$repo    = $this->getEntityManager()->getRepository($this->entity);
		$entity  = $repo->find($this->params()->fromRoute('id', 0));
		if ($this->params()->fromRoute('id', 0)) {
			$array = $entity->toArray();
			unset($array['password']);
			$form->setData($array);
		}
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if (empty($form->get('password')->getValue()) || $form->get('password')->getValue() == "") {
				$form->getInputFilter()->remove('password');
				$form->getInputFilter()->remove('confirmPassword');
			}
			if ($form->isValid()) {
				$service = $this->getServiceLocator()->get($this->service);
				$service->update($request->getPost()->toArray());
				$this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)->addMessage('Registro alterado com Sucesso');

				return $this->redirect()->toRoute($this->route, ['controller' => $this->controller]);
			}
		}

		return new ViewModel(['form' => $form]);
	}


	public function activateAction()
	{
		$activationKey = $this->params()->fromRoute('key');
		$userService   = $this->getServiceLocator()->get($this->service);
		$result        = $userService->activate($activationKey);
		if ($result) {
			return new ViewModel(['user' => $result, 'message' => 'Usuário Ativado com Sucesso.']);
		}

		return new ViewModel(['message' => 'Usuário não encontrado ou já esta Ativo.']);
	}

}
