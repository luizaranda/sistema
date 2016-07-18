<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

use Base\Service\AclService;

return [
	'doctrine' => [
		'connection' => [
			'orm_default' => [
				'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
				'params'      => [
					'host'     => 'localhost',
					'port'     => '5432',
					'user'     => 'luiz',
					'password' => '321rje',
					'dbname'   => 'sistema',
				],
			],
		],
	],
	'mail'     => [
		'name'              => 'smtp.gmail.com',
		'port'              => 465,
		'host'              => 'smtp.gmail.com',
		'connection_class'  => 'login',
		'connection_config' => [
			'ssl'      => 'ssl',
			'username' => 'luizeduardotk@gmail.com',
			'password' => '#########',
			'from'     => 'luizeduardotk@gmail.com',
		],
	],

	'module_layouts'  => [
		'Sistema' => 'layout/sistema',
		'Acl'     => 'layout/sistema',
		'Site'    => 'layout/site',
	],
	'navigation'      => [
		'sistema' => [
			'home'    => [
				'label' => 'Home',
				'route' => 'sistema-home',
				'icon'  => 'icon-home4',
			],
			'sistema' => [
				'label'      => 'Sistema',
				'route'      => 'acl-home',
				'controller' => 'index',
				'icon'       => 'icon-cog3',
				'pages'      => [
					'user'      => [
						'label'      => 'Usuário',
						'route'      => 'acl-home/default',
						'controller' => 'user',
						'pages'      => [
							'new'   => [
								'label'      => 'Cadastrar',
								'route'      => 'acl-home/default',
								'controller' => 'user',
								'action'     => 'new',
							],
							'index' => [
								'label'      => 'Listar',
								'route'      => 'acl-home/default',
								'controller' => 'user',
								'action'     => 'index',
							],
							'edit'  => [
								'label'      => 'Editar',
								'route'      => 'acl-home/default',
								'controller' => 'user',
								'action'     => 'edit',
							],
						],
					],
					'role'      => [
						'label'      => 'Perfil',
						'route'      => 'acl-home/default',
						'controller' => 'role',
						'pages'      => [
							'new'   => [
								'label'      => 'Cadastrar',
								'route'      => 'acl-home/default',
								'controller' => 'role',
								'action'     => 'new',
							],
							'index' => [
								'label'      => 'Listar',
								'route'      => 'acl-home/default',
								'controller' => 'role',
								'action'     => 'index',
							],
							'edit'  => [
								'label'      => 'Editar',
								'route'      => 'acl-home/default',
								'controller' => 'role',
								'action'     => 'edit',
							],
						],
					],
					'privilege' => [
						'label'      => 'Privilégio',
						'route'      => 'acl-home/default',
						'controller' => 'privilege',
						'pages'      => [
							'new'   => [
								'label'      => 'Cadastrar',
								'route'      => 'acl-home/default',
								'controller' => 'privilege',
								'action'     => 'new',
							],
							'index' => [
								'label'      => 'Listar',
								'route'      => 'acl-home/default',
								'controller' => 'privilege',
								'action'     => 'index',
							],
							'edit'  => [
								'label'      => 'Editar',
								'route'      => 'acl-home/default',
								'controller' => 'privilege',
								'action'     => 'edit',
							],
						],
					],
					'resource'  => [
						'label'      => 'Recurso',
						'route'      => 'acl-home/default',
						'controller' => 'resource',
						'pages'      => [
							'new'   => [
								'label'      => 'Cadastrar',
								'route'      => 'acl-home/default',
								'controller' => 'resource',
								'action'     => 'new',
							],
							'index' => [
								'label'      => 'Listar',
								'route'      => 'acl-home/default',
								'controller' => 'resource',
								'action'     => 'index',
							],
							'edit'  => [
								'label'      => 'Editar',
								'route'      => 'acl-home/default',
								'controller' => 'resource',
								'action'     => 'edit',
							],
						],
					],
				],
			],
		],
	],
	'service_manager' => [
		'abstract_factories' => [
			'Zend\Navigation\Service\NavigationAbstractServiceFactory',
		],
		'factories'          => [
			'Base\Service\AclService' => function ($service) {
				return new AclService($service);
			},
		],
	],
];