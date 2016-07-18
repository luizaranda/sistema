<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 30/04/2016
 * Time: 19:18
 */

namespace Acl\Form;

use Zend\Form\Element\Button;
use Zend\Form\Element\Password;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;


class Login extends Form
{

	public function __construct($name = 'login', array $options = [])
	{
		parent::__construct($name, $options);

		$this->setAttribute('method', 'post');
		$this->setInputFilter(new LoginFilter());

		$email = new Text('email');
		$email->setAttribute('placeholder', 'Entre com o email')
		      ->setAttribute('required', true)
		      ->setAttribute('class', 'form-control');

		$password = new Password('password');
		$password->setAttribute('placeholder', 'Entre com a senha')
		         ->setAttribute('required', true)
		         ->setAttribute('class', 'form-control');

		$submit = new Button('submit');
		$submit->setLabel('Entrar <i class="icon-arrow-right14 position-right"></i>')
		       ->setLabelOption('disable_html_escape', true)
		       ->setAttribute('type', 'submit')
		       ->setAttribute('class', 'btn bg-blue btn-block');

		$this->add($email);
		$this->add($password);
		$this->add($submit);

	}
}