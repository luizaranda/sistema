<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 30/04/2016
 * Time: 19:30
 */

namespace Acl\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;


class LoginFilter extends InputFilter
{
	protected $min;
	protected $max;

	public function __construct()
	{
		$this->min = 4;
		$this->max = 40;

		$this->add(
			[
				'name'       => 'email',
				'validators' => [
					[
						'name'    => NotEmpty::class,
						'options' => [
							'messages' => [NotEmpty::IS_EMPTY => 'Digite o e-mail'],
						],
					],
					[
						'name'    => EmailAddress::class,
						'options' => [
							'domain'   => true,
							'messages' => [
								EmailAddress::INVALID_FORMAT     => 'Formato de e-mail Inválido',
								EmailAddress::INVALID_HOSTNAME   => 'Dominio de e-mail Inválido',
								EmailAddress::INVALID            => 'E-mail Inválido',
								EmailAddress::INVALID_SEGMENT    => 'E-mail Inválido',
								EmailAddress::INVALID_MX_RECORD  => 'E-mail Inválido',
								EmailAddress::INVALID_LOCAL_PART => 'E-mail Inválido',
								EmailAddress::QUOTED_STRING      => 'E-mail Inválido',
								EmailAddress::DOT_ATOM           => 'E-mail Inválido',
							],
						],
					],
				],
			]
		);
		$this->add(
			[
				'name'       => 'password',
				'required'   => true,
				'filters'    => [
					['name' => 'StripTags'],
					['name' => 'StringTrim'],
				],
				'validators' => [
					[
						'name'    => NotEmpty::class,
						'options' => [
							'messages' => [NotEmpty::IS_EMPTY => 'Digite a senha'],
						],
					],
				],
			]
		);

	}

}