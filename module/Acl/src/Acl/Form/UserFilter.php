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
use Zend\Validator\Identical;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;


class UserFilter extends InputFilter
{
	protected $max;
	protected $min;

	public function __construct()
	{
		$this->max = 15;
		$this->min = 4;
		$this->add(
			[
				'name'       => 'name',
				'required'   => true,
				'filters'    => [
					['name' => 'StripTags'],
					['name' => 'StringTrim'],
				],
				'validators' => [
					[
						'name'    => NotEmpty::class,
						'options' => [
							'messages' => [NotEmpty::IS_EMPTY => 'Não pode estar vazio'],
						],
					],
				],
			]
		);
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
							'messages' => [NotEmpty::IS_EMPTY => 'Não pode estar vazio'],
						],
					],
					[
						'name'    => StringLength::class,
						'options' => [
							'min'      => $this->min,
							'max'      => $this->max,
							'messages' => [
								StringLength::TOO_SHORT => "Senha muito curta. Deve ter no minimo {$this->min} caracteres",
								StringLength::TOO_LONG  => "Senha muito grande. Deve ter no máximo {$this->max} caracteres",
							],
						],
					],
				],
			]
		);

		$this->add(
			[
				'name'       => 'confirmPassword',
				'required'   => true,
				'filters'    => [
					['name' => 'StripTags'],
					['name' => 'StringTrim'],
				],
				'validators' => [
					[
						'name'    => NotEmpty::class,
						'options' => [
							'messages' => [NotEmpty::IS_EMPTY => 'Não pode estar vazio'],
						],
					],
					[
						'name'    => Identical::class,
						'options' => [
							'token'    => 'password',
							'messages' => [
								Identical::NOT_SAME => 'Senha de confirmação invalida.',
							],
						],
					],
				],
			]
		);
	}

}