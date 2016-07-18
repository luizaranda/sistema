<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 08/05/2016
 * Time: 18:25
 */

namespace Acl\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Zend\Hydrator\ClassMethods;

class Role extends AbstractService
{

	public function __construct(EntityManager $entityManager)
	{
		parent::__construct($entityManager);
		$this->entity = \Acl\Entity\Role::class;
	}

	public function insert(array $data)
	{
		$entity = new $this->entity($data);
		$entity->setParent(null);
		if ($data['parent']) {
			$entity->setParent($this->entityManager->getReference($this->entity, $data['parent']));
		}
		$this->entityManager->persist($entity);
		$this->entityManager->flush();

		return $entity;
	}

	public function update(array $data)
	{
		$entity = $this->entityManager->getReference($this->entity, $data['id']);
		(new ClassMethods())->hydrate($data, $entity);
		$entity->setParent(null);
		if ($data['parent']) {
			$entity->setParent($this->entityManager->getReference($this->entity, $data['parent']));
		}
		$this->entityManager->persist($entity);
		$this->entityManager->flush();

		return $entity;
	}
}