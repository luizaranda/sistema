<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 05/05/2016
 * Time: 21:30
 */

namespace Acl\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Acl\Form\Login as LoginForm;
use Acl\Entity\Role;

class AuthController extends AbstractController
{
	public function indexAction()
	{
		$form    = new LoginForm();
		$request = $this->getRequest();
		$error   = false;
		if ($request->isPost()) {
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $request->getPost()->toArray();
				/**
				 * Criando storage para sessao de autenticação
				 */
				$sessionStorage = new SessionStorage('Sistema');
				$authService    = new AuthenticationService();
				$authService->setStorage($sessionStorage);

				$authAdapter = $this->getServiceLocator()->get('Acl\Auth\Adapter');
				$authAdapter->setUsername($data['email']);
				$authAdapter->setPassword($data['password']);

				$result = $authService->authenticate($authAdapter);
				if ($result->isValid()) {
					$user = $authService->getIdentity()['user'];

					$roleRepo = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager')->getRepository('Acl\Entity\Role');
					/**
					 * Tem que carregar a entidade role antes de armazenar a sessao para poder saber
					 * qual role o usuario tem
					 **/

					$role = new Role($roleRepo->findOneById($user->getRole()->getId())->toArray());
					$user->setRole($role);

					$sessionStorage->write($user);

					return $this->redirect()->toRoute('sistema-home');
				} else {
					$error = true;
				}
			}
		}

		$this->layout('layout/sistema-login');

		return new ViewModel(['form' => $form, 'error' => $error]);
	}

	public function logoutAction()
	{
		$auth = new AuthenticationService();
		$auth->setStorage(new SessionStorage('Sistema'));
		$auth->clearIdentity();

		return $this->redirect()->toRoute('sistema-auth');
	}
}