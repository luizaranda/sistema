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
use Zend\Form\Element\Password;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Form;


class User extends Form
{

	protected $role;

	public function __construct($name = 'user', array $options = [], array $role = [])
	{
		parent::__construct($name, $options);
		$this->role = $role;

		$this->setInputFilter(new UserFilter());
		$this->setAttribute('method', 'post');

		$id = new Hidden('id');

		$name = new Text('name');
		$name->setLabel('Nome: ')
		     ->setAttribute('placeholder', 'Entre com o nome')
		     ->setAttribute('class', 'form-control')
		     ->setAttribute('required', true)
		     ->setAttribute('style', 'width: 400px');

		$email = new Text('email');
		$email->setLabel('Email: ')
		      ->setAttribute('placeholder', 'Entre com o email')
		      ->setAttribute('class', 'form-control')
		      ->setAttribute('required', true)
		      ->setAttribute('style', 'width: 400px');

		$password = new Password('password');
		$password->setLabel('Senha: ')
		         ->setAttribute('placeholder', 'Entre com a senha')
		         ->setAttribute('class', 'form-control')
		         ->setAttribute('style', 'width: 200px');

		$confirmPassword = new Password('confirmPassword');
		$confirmPassword->setLabel('Confirme a senha: ')
		                ->setAttribute('placeholder', 'Digite novamente a senha')
		                ->setAttribute('class', 'form-control')
		                ->setAttribute('style', 'width: 200px');

		$role = new Select('role');
		$role->setLabel('Perfil: ')
		     ->setOptions(['value_options' => $this->role])
		     ->setAttribute('class', 'form-control')
		     ->setAttribute('style', 'width: 200px;');

		$csrf = new Csrf('security');

		$submit = new Button('submit');
		$submit->setLabel('Salvar')
		       ->setAttribute('type', 'submit')
		       ->setAttribute('class', 'btn btn-primary');

		$this->add($id);
		$this->add($name);
		$this->add($email);
		$this->add($password);
		$this->add($confirmPassword);
		$this->add($role);
		$this->add($csrf);
		$this->add($submit);

	}
}