<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 08/05/2016
 * Time: 21:14
 */

namespace Acl\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;

class Resource extends AbstractService
{
	public function __construct(EntityManager $entityManager)
	{
		parent::__construct($entityManager);
		$this->entity = \Acl\Entity\Resource::class;
	}
}