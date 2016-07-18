<?php

namespace Acl\Controller;

use Base\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractController
{

	public function indexAction()
	{
		return new ViewModel();
	}
}
