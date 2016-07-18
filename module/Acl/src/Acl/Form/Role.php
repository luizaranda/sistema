<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 30/04/2016
 * Time: 19:18
 */

namespace Acl\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Form;


class Role extends Form
{

	protected $parent;

	public function __construct($name = 'role', array $options = [], array $parent = null)
	{
		parent::__construct($name, $options);

		$this->parent = $parent;

		$this->setAttribute('method', 'post');
		$this->setInputFilter(new RoleFilter());

		$id = new Hidden('id');

		$name = new Text('name');
		$name->setLabel('Nome: ')
		     ->setAttribute('placeholder', 'Entre com o nome')
		     ->setAttribute('class', 'form-control')
		     ->setAttribute('required', true);

		$listParent = [0 => 'Nenhum'] + $this->parent;
		$parent     = new Select('parent');
		$parent->setLabel('Herda: ')
		       ->setAttribute('class', 'form-control')
		       ->setOptions(['value_options' => $listParent]);

		$isAcl = new Select('is_admin');
		$isAcl->setLabel('Administrador: ');
		$isAcl->setValueOptions([
			                        '0' => 'Não',
			                        '1' => 'Sim',
		                        ])
		      ->setAttribute('class', 'form-control');

		$csrf = new Csrf('security');

		$submit = new Button('submit');
		$submit->setLabel('Salvar')
		       ->setAttribute('type', 'submit')
		       ->setAttribute('class', 'btn btn-primary');

		$this->add($id);
		$this->add($name);
		$this->add($parent);
		$this->add($isAcl);
		$this->add($csrf);
		$this->add($submit);
	}
}