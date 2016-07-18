<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 05/05/2016
 * Time: 21:02
 */

namespace Acl\Auth;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Doctrine\ORM\EntityManager;

class Adapter implements AdapterInterface
{

	protected $entityManager;
	protected $username;
	protected $password;

	/**
	 * @return mixed
	 */
	public function getEntityManager()
	{
		return $this->entityManager;
	}

	/**
	 * @param $entityManager
	 * @return $this
	 */
	public function setEntityManager($entityManager)
	{
		$this->entityManager = $entityManager;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param $username
	 * @return $this
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param $password
	 * @return $this
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * Performs an authentication attempt
	 *
	 * @return \Zend\Authentication\Result
	 * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface If authentication cannot be performed
	 */
	public function authenticate()
	{
		$repository = $this->entityManager->getRepository('Acl\Entity\User');
		$user       = $repository->findByEmailAndPassword($this->getUsername(), $this->getPassword());
		if ($user) {
			return new Result(Result::SUCCESS, ['user' => $user]);
		}

		return new Result(Result::FAILURE_CREDENTIAL_INVALID, null);
	}

}