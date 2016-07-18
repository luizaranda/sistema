<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 08/05/2016
 * Time: 21:51
 */

namespace Acl\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class Resource extends Form
{

	public function __construct($name = 'resource', array $options = [])
	{
		parent::__construct($name, $options);

		$this->setAttribute('method', 'post');
		$this->setInputFilter(new ResourceFilter());

		$id = new Hidden('id');

		$name = new Text('name');
		$name->setLabel('Nome: ')
		     ->setAttribute('placeholder', 'Entre com o nome')
		     ->setAttribute('class', 'form-control')
		     ->setAttribute('required', true);

		$csrf = new Csrf('security');

		$submit = new Button('submit');
		$submit->setLabel('Salvar')
		       ->setAttribute('type', 'submit')
		       ->setAttribute('class', 'btn btn-primary');

		$this->add($id);
		$this->add($name);
		$this->add($csrf);
		$this->add($submit);
	}
}