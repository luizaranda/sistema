<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 08/05/2016
 * Time: 17:44
 */

namespace Acl\Repository;

use Doctrine\ORM\EntityRepository;

class Role extends EntityRepository
{
	public function fetchParent()
	{
		$entities = $this->findAll();
		$retorno  = [];
		foreach ($entities as $entity) {
			$retorno[$entity->getId()] = $entity->getName();
		}

		return $retorno;
	}

}