<?php
/**
 * Created by PhpStorm.
 * User: Luiz Eduardo
 * Date: 30/04/2016
 * Time: 19:30
 */

namespace Acl\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;


class PrivilegeFilter extends InputFilter
{
	protected $max;
	protected $min;

	public function __construct()
	{
		$this->min = 4;
		$this->max = 40;
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
					[
						'name'    => StringLength::class,
						'options' => [
							'min'      => $this->min,
							'max'      => $this->max,
							'messages' => [
								StringLength::TOO_SHORT => "Nome de Privilégio muio curto. Deve ter no minimo {$this->min} caracteres",
								StringLength::TOO_LONG  => "Nome de Privilégio muio grande. Deve ter no máximo {$this->max} caracteres",
							],
						],
					],
					[
						'name'    => Regex::class,
						'options' => [
							'pattern'  => '/(Action)$/',
							'messages' => [Regex::NOT_MATCH => 'Um Privilégio deve conter a palavra "Action". Ex.: indexAction'],
						],
					],
					[
						'name'    => Regex::class,
						'options' => [
							'pattern'  => '/^([a-z][a-z]+)/',
							'messages' => [Regex::NOT_MATCH => 'Nome de Privilégio inválido. Deve iniciar com letra Minuscula. Ex.: indexAction'],
						],
					],
				],
			]
		);

	}

}