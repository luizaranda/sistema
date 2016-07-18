<?php

namespace Acl\Controller;

use Base\Controller\AbstractController;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\View\Model\ViewModel;

class RoleController extends AbstractController
{

	public function __construct()
	{
		$this->service    = 'Acl\Service\Role';
		$this->entity     = 'Acl\Entity\Role';
		$this->form       = 'Acl\Form\Role';
		$this->route      = 'acl-home/default';
		$this->controller = 'role';
	}

	public function newAction()
	{
		$form    = $this->getServiceLocator()->get($this->form);
		$request = $this->getRequest();
		if ($request->isPost()) {
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
			$form->setData($entity->toArray());
		}
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$service = $this->getServiceLocator()->get($this->service);
				$service->update($request->getPost()->toArray());
				$this->flashMessenger()->setNamespace(FlashMessenger::NAMESPACE_SUCCESS)->addMessage('Registro alterado com sucesso.');

				return $this->redirect()->toRoute($this->route, ['controller' => $this->controller]);
			}
		}

		return new ViewModel(['form' => $form]);
	}

}
