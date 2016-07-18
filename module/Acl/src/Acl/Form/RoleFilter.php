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
use Zend\Validator\StringLength;


class RoleFilter extends InputFilter
{
	protected $min;
	protected $max;

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
								StringLength::TOO_SHORT => "Nome de Regra muio curto. Deve ter no minimo {$this->min} caracteres",
								StringLength::TOO_LONG  => "Nome de Regra muio grande. Deve ter no máximo {$this->max} caracteres",
							],
						],
					],
				],
			]
		);

	}

}