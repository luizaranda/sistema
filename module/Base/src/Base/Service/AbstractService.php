<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractService
 *
 * @author Luiz
 */

namespace Base\Service;

use Doctrine\ORM\EntityManager;
use Zend\Hydrator\ClassMethods;
use Zend\Stdlib\Hydrator;

abstract class AbstractService
{

	/**
	 * @var EntityManager
	 */
	protected $entityManager;
	protected $entity;

	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function insert(array $data)
	{
		$entity = new $this->entity($data);
		$this->entityManager->persist($entity);
		$this->entityManager->flush();

		return $entity;
	}

	public function update(array $data)
	{
		$entity = $this->entityManager->getReference($this->entity, $data['id']);
		(new ClassMethods())->hydrate($data, $entity);
		$this->entityManager->persist($entity);
		$this->entityManager->flush();

		return $entity;
	}

	public function delete($id)
	{
		$entity = $this->entityManager->getReference($this->entity, $id);
		if ($entity) {
			$this->entityManager->remove($entity);
			$this->entityManager->flush();

			return $id;
		}

		return false;
	}

}