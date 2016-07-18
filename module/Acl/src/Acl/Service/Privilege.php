<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 08/05/2016
 * Time: 22:04
 */

namespace Acl\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Zend\Hydrator\ClassMethods;

class Privilege extends AbstractService
{
	public function __construct(EntityManager $entityManager)
	{
		parent::__construct($entityManager);
		$this->entity = \Acl\Entity\Privilege::class;
	}

	public function insert(array $data)
	{
		$entity = new $this->entity($data);

		$role = $this->entityManager->getReference('Acl\Entity\Role', $data['role']);
		$entity->setRole($role);//injeta a entidade carregada, se for o id vai dar pau

		$resource = $this->entityManager->getReference('Acl\Entity\Resource', $data['resource']);
		$entity->setResource($resource);//injeta a entidade carregada, se for o id vai dar pau

		$this->entityManager->persist($entity);
		$this->entityManager->flush();

		return $entity;
	}

	public function update(array $data)
	{
		$entity = $this->entityManager->getReference($this->entity, $data['id']);
		(new ClassMethods())->hydrate($data, $entity);

		$role = $this->entityManager->getReference('Acl\Entity\Role', $data['role']);
		$entity->setRole($role);//injeta a entidade carregada, se for o id vai dar pau

		$resource = $this->entityManager->getReference('Acl\Entity\Resource', $data['resource']);
		$entity->setResource($resource);//injeta a entidade carregada, se for o id vai dar pau

		$this->entityManager->persist($entity);
		$this->entityManager->flush();

		return $entity;
	}
}