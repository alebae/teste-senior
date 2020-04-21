<?php

namespace Venda;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
	'router' => [
		'routes' => [
			'venda' => [
				'type' => \Zend\Router\Http\Segment::class,
				'options' => [
					'route' => '/venda[/:action[/:id]]',
					'constraints' => [
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+'
					],
					'defaults' => [
						'controller' => Controller\VendaController::class,
						'action' => 'index',
					],
				],
			],
			'produto' => [
				'type' => \Zend\Router\Http\Segment::class,
				'options' => [
					'route' => '/venda/produto[/:action[/:id]]',
					'constraints' => [
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[0-9]+'
					],
					'defaults' => [
						'controller' => Controller\ProdutoController::class,
						'action' => 'index',
					],
				],
			],
		],
	],
	'controllers' => [
		'factories' => [
		],
	],
	'view_manager' => [
        'template_path_stack' => [
		   'venda' => __DIR__ . '/../view',
        ],
	],	
	'strategies' => [
		'ViewJsonStrategy',
	],
    'db' => [
    	'driver' => 'Pdo_Mysql',
    	'database' => 'teste_senior',
    	'username' => 'root',
    	'password' => 'ycUSvR6RCL^b',
    	'hostname' => '127.0.0.1'
    ],
];