<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Sistema;

return [
	'router'          => [
		'routes' => [
			'sistema-auth'   => [
				'type'    => 'Literal',
				'options' => [
					'route'    => '/auth',
					'defaults' => [
						'__NAMESPACE__' => 'Acl\Controller',
						'controller'    => 'Auth',
						'action'        => 'index',
					],
				],
			],
			'sistema-logout' => [
				'type'    => 'Literal',
				'options' => [
					'route'    => '/auth/logout',
					'defaults' => [
						'__NAMESPACE__' => 'Acl\Controller',
						'controller'    => 'Auth',
						'action'        => 'logout',
					],
				],
			],
			'sistema-home'   => [
				'type'          => 'Literal',
				'options'       => [
					//tive que colocar /admin pq /sistema nao funciona de jeito nenhum
					'route'    => '/admin',
					'defaults' => [
						'__NAMESPACE__' => 'Sistema\Controller',
						'controller'    => 'Index',
						'action'        => 'index',
					],
				],
				'may_terminate' => true,
				'child_routes'  => [
					'default'   => [
						'type'    => 'Segment',
						'options' => [
							'route'       => '/[:controller][/:action[/:id]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9\-\_]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9\-\_]*',
								'id'         => '[0-9]+',
							],
							'defaults'    => [
								'__NAMESPACE__' => 'Sistema\Controller',
								'controller'    => 'Index',
								'action'        => 'index',
							],
						],
					],
					'paginator' => [
						'type'    => 'Segment',
						'options' => [
							'route'       => '/[:controller[/page/:page]]',
							'constraints' => [
								'controller' => '[a-zA-Z][a-zA-Z0-9\-\_]*',
								'page'       => '[0-9]+',
							],
							'defaults'    => [
								'__NAMESPACE__' => 'Sistema\Controller',
								'controller'    => 'Index',
							],
						],
					],
				],
			],
		],
	],
	'controllers'     => [
		'invokables' => [
			'Sistema\Controller\Index' => Controller\IndexController::class,
			'Acl\Controller\Auth'      => \Acl\Controller\AuthController::class,
		],
	],
	'service_manager' => [
		'abstract_factories' => [
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		],
		'aliases'            => [
		],
	],
	'view_manager'    => [
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map'             => [
			'layout/sistema'       => __DIR__ . '/../view/layout/layout.phtml',
			'layout/sistema-login' => __DIR__ . '/../view/layout/layout-login.phtml',
			'error/404'            => __DIR__ . '/../view/error/404.phtml',
			'error/index'          => __DIR__ . '/../view/error/index.phtml',
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
];
