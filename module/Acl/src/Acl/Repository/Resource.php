<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 08/05/2016
 * Time: 17:44
 */

namespace Acl\Repository;

use Doctrine\ORM\EntityRepository;

class Resource extends EntityRepository
{
	public function fetchPairs()
	{
		$entities = $this->findAll();
		$retorno  = [];
		foreach ($entities as $entity) {
			$retorno[$entity->getId()] = $entity->getName();
		}

		return $retorno;
	}

}