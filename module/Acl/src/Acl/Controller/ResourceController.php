<?php

namespace Acl\Controller;

use Base\Controller\AbstractController;

class ResourceController extends AbstractController
{

	public function __construct()
	{
		$this->service    = 'Acl\Service\Resource';
		$this->entity     = 'Acl\Entity\Resource';
		$this->form       = 'Acl\Form\Resource';
		$this->route      = 'acl-home/default';
		$this->controller = 'resource';
	}

}
