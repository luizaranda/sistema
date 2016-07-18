<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Acl;

return [
	'router'          => [
		'routes' => [
			'acl-home' => [
				'type'          => 'Literal',
				'options'       => [
					'route'    => '/acl',
					'defaults' => [
						'__NAMESPACE__' => 'Acl\Controller',
						'controller'    => 'Index',
						'action'        => 'index',
					],
				],
				'may_terminate' => true,
				'child_routes'  => [
					'default'       => [
						'type'    => 'Segment',
						'options' => [
							'route'       => '/[:controller][/:action[/:id]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9\-\_]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9\-\_]*',
								'id'         => '[0-9]+',
							],
							'defaults'    => [
								'__NAMESPACE__' => 'Acl\Controller',
								'controller'    => 'Index',
								'action'        => 'index',
							],
						],
					],
					'paginator'     => [
						'type'    => 'Segment',
						'options' => [
							'route'       => '/[:controller[/page/:page]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9\-\_]*',
								'page'       => '[0-9]+',
							],
							'defaults'    => [
								'__NAMESPACE__' => 'Acl\Controller',
								'controller'    => 'Index',
							],
						],
					],
					'user-activate' => [
						'type'    => 'Segment',
						'options' => [
							'route'    => '/activate[/:key]',
							'defaults' => [
								'__NAMESPACE__' => 'Acl\Controller',
								'controller'    => 'User',
								'action'        => 'activate',
							],
						],
					],
				],
			],
		],
	],
	'controllers'     => [
		'invokables' => [
			'Acl\Controller\Index'     => Controller\IndexController::class,
			'Acl\Controller\User'      => Controller\UserController::class,
			'Acl\Controller\Auth'      => Controller\AuthController::class,
			'Acl\Controller\Role'      => Controller\RoleController::class,
			'Acl\Controller\Resource'  => Controller\ResourceController::class,
			'Acl\Controller\Privilege' => Controller\PrivilegeController::class,
		],
	],
	'service_manager' => [
		'abstract_factories' => [
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		],
		'factories'          => [
			'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
		],
	],
	'view_manager'    => [
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map'             => [
			'error/404'   => __DIR__ . '/../view/error/404.phtml',
			'error/index' => __DIR__ . '/../view/error/index.phtml',
		],
		'template_path_stack'      => [
			__DIR__ . '/../view',
		],
	],
	'doctrine'        => [
		'driver' => [
			__NAMESPACE__ . '_driver' => [
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'],
			],
			'orm_default'             => [
				'drivers' => [
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
				],
			],
		],
	],
	'navigation'      => [
		'default' => [
			'sistema'=>[
				'label' => 'Sistema',
				'route' => 'acl-home',
				'pages' => [
					'user'      => [
						'label' => 'Usuário',
						'route' => 'acl-home/default',
						'pages' => [
							'index' => [
								'label'      => 'Listar',
								'route'      => 'acl-home/default',
								'controller' => 'user',
								'action'     => 'index',
							],
							'new'   => [
								'label'      => 'Cadastrar',
								'route'      => 'acl-home/default',
								'controller' => 'user',
								'action'     => 'new',
							],
						],
					],
					'role'      => [
						'label' => 'Perfil',
						'route' => 'acl-home/default',
						'pages' => [
							'index' => [
								'label'      => 'Listar',
								'route'      => 'acl-home/default',
								'controller' => 'role',
								'action'     => 'index',
							],
							'new'   => [
								'label'      => 'Cadastrar',
								'route'      => 'acl-home/default',
								'controller' => 'role',
								'action'     => 'new',
							],
						],
					],
					'privilege' => [
						'label' => 'Privilégio',
						'route' => 'acl-home/default',
						'pages' => [
							'index' => [
								'label'      => 'Listar',
								'route'      => 'acl-home/default',
								'controller' => 'privilege',
								'action'     => 'index',
							],
							'new'   => [
								'label'      => 'Cadastrar',
								'route'      => 'acl-home/default',
								'controller' => 'privilege',
								'action'     => 'new',
							],
						],
					],
					'resource'  => [
						'label' => 'Recurso',
						'route' => 'acl-home/default',
						'pages' => [
							'index' => [
								'label'      => 'Listar',
								'route'      => 'acl-home/default',
								'controller' => 'resource',
								'action'     => 'index',
							],
							'new'   => [
								'label'      => 'Cadastrar',
								'route'      => 'acl-home/default',
								'controller' => 'resource',
								'action'     => 'new',
							],
						],
					],
				],
			],
		],
	],
];
