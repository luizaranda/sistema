<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 30/04/2016
 * Time: 18:38
 */

namespace Acl\Service;

use Doctrine\ORM\EntityManager;
use Zend\Hydrator\ClassMethods;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Base\Mail\Mail;
use Base\Service\AbstractService;

class User extends AbstractService
{
	protected $transport;
	protected $view;

	public function __construct(EntityManager $entityManager, SmtpTransport $transport, $view)
	{
		parent::__construct($entityManager);
		$this->entity    = \Acl\Entity\User::class;
		$this->transport = $transport;
		$this->view      = $view;
	}

	public function insert(array $data)
	{
		$entity = new $this->entity($data);

		if ($data['role']) {
			$entity->setRole($this->entityManager->getReference($this->entity, $data['role']));
		}

		$this->entityManager->persist($entity);
		$this->entityManager->flush();

		$dataEmail = ['name' => $data['name'], 'activationKey' => $entity->getActivationKey()];
		if ($entity) {
			$mail = new Mail($this->transport, $this->view, 'add-user');
			$mail->setSubject('Confirmação de Cadastro')
			     ->setTo($data['email'])
			     ->setData($dataEmail)
			     ->prepare();
			$mail->send();

			return $entity;
		}

		return false;
	}

	public function activate($key)
	{
		$repo = $this->entityManager->getRepository('Acl\Entity\User');
		$user = $repo->findOneByActivationKey($key);
		if ($user && !(boolean)$user->getActive()) {
			$user->setActive(true);
			$this->entityManager->persist($user);
			$this->entityManager->flush();

			return $user;
		}

		return false;
	}

	public function update(array $data)
	{
		$entity = $this->entityManager->getReference($this->entity, $data['id']);
		/**
		 * Sobrescrito pq se o cara nao passar o password nao pode alterar para uma senha em branco
		 */
		if (empty($data['password']) || $data['password'] == "") {
			unset($data['password']);
		}

		$entity = (new ClassMethods)->hydrate($data, $entity);
		if ($data['role']) {
			$entity->setRole($this->entityManager->getReference($this->entity, $data['role']));
		}

		$this->entityManager->persist($entity);
		$this->entityManager->flush();

		return $entity;
	}
}