<?php
namespace Venda;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Venda\Controller\VendaController;
use Venda\Controller\ProdutoController;

class Module implements ConfigProviderInterface {

    public function getConfig() {
        return include __DIR__ . "/../config/module.config.php";
    }

    public function getServiceConfig() {
        return [
            'factories' => [
                Model\VendaTable::class => function($container) {
                    $tableGateway = $container->get(Model\VendaTableGateway::class);
                    return new Model\VendaTable($tableGateway);
                },
                Model\VendaTableGateway::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Venda());
                    return new TableGateway('documento', $dbAdapter, null, $resultSetPrototype);
                },
                Model\ProdutoTable::class => function($container) {
                    $tableGateway = $container->get(Model\ProdutoTableGateway::class);
                    return new Model\ProdutoTable($tableGateway);
                },
                Model\ProdutoTableGateway::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Produto());
                    return new TableGateway('produto', $dbAdapter, null, $resultSetPrototype);
                },
            ]
        ];
    }

    public function getControllerConfig() {
        return [
            'factories' => [
                VendaController::class => function($container) {
                    $tableGateway = $container->get(Model\VendaTable::class);
                    return new VendaController($tableGateway);
                },
                ProdutoController::class => function($container) {
                    $tableGateway = $container->get(Model\ProdutoTable::class);
                    return new ProdutoController($tableGateway);
                },
            ]
        ];
    }

}