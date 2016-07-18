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
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class Privilege extends Form
{

	protected $role;
	protected $resource;

	public function __construct($name = 'privilege', array $options = [], array $role = null, array $resource = null)
	{
		parent::__construct($name, $options);

		$this->role     = $role;
		$this->resource = $resource;

		$this->setAttribute('method', 'post');
		$this->setInputFilter(new PrivilegeFilter());

		$id = new Hidden('id');

		$name = new Text('name');
		$name->setLabel('Nome: ')
		     ->setAttribute('placeholder', 'Entre com o nome')
		     ->setAttribute('class', 'form-control')
		     ->setAttribute('required', true);


		$role = new Select('role');
		$role->setLabel('Regra: ')
		     ->setAttribute('class', 'form-control')
		     ->setOptions(['value_options' => $this->role]);

		$resource = new Select('resource');
		$resource->setLabel('Recurso: ')
		         ->setAttribute('class', 'form-control')
		         ->setOptions(['value_options' => $this->resource]);

		$csrf = new Csrf('security');

		$submit = new Button('submit');
		$submit->setLabel('Salvar')
		       ->setAttribute('type', 'submit')
		       ->setAttribute('class', 'btn btn-primary');

		$this->add($id);
		$this->add($name);
		$this->add($role);
		$this->add($resource);
		$this->add($csrf);
		$this->add($submit);
	}
}