<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Site;

return [
	'router'          => [
		'routes' => [
			//rota para index principal do site
			'home' => [
				'type'    => 'Literal',
				'options' => [
					'route'    => '/',
					'defaults' => [
						'__NAMESPACE__' => 'Site\Controller',
						'controller'    => 'Index',
						'action'        => 'index',
					],
				],
			],
		],
	],
	'controllers'     => [
		'invokables' => [
			'Site\Controller\Index' => Controller\IndexController::class,
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
			'layout/site'    => __DIR__ . '/../view/layout/layout.phtml',
			'site/index/index' => __DIR__ . '/../view/site/index/index.phtml',
			'error/404'        => __DIR__ . '/../view/error/404.phtml',
			'error/index'      => __DIR__ . '/../view/error/index.phtml',
		],
		'template_path_stack'      => [
			__DIR__ . '/../view',
		],
	],
];
