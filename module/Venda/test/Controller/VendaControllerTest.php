<?php
namespace VendaTest\Controller;

use Venda\Controller\VendaController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

use Venda\Model\VendaTable;
use Zend\ServiceManager\ServiceManager;

use Venda\Model\Venda;
use Prophecy\Argument;

class VendaControllerTest extends AbstractHttpControllerTestCase
{
    //Permitir mensagem de erro mais completa
    protected $traceError = true;
    //Variável para injeção do VendaTable
    protected $vendaTable;

    /** 
     * Configurações iniciais para o ambiente de testes
     * @return void
    */
    public function setUp() {        
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();

        $this->configureServiceManager($this->getApplicationServiceLocator());
    }

    /** 
     * Teste de adição de produto ao carrinho
     * @return boolean
    */
    public function testAddProductToCartShop()
    {        
        $postData = [
            'total'  => 12.00,
            'confirmado' => 0,
            'idProduto' => 2,
            'idDocumento' => 2,
            'produto' => 2,
            'documento' => 2,
        ];

        $this->dispatch('/venda/adicionar', 'POST', $postData);
        $this->assertResponseStatusCode(200);
    }

    /** 
     * Teste de confirmação de venda
     * @return boolean
    */
    public function testConfirmSales()
    {        
        $postData = [
            'idDocumento' => 7,
        ];

        $this->dispatch('/venda/confirmar', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/venda');
    }

    /** 
     * Acionamento do Service Manager para atualizações das configurações, invocando o modelo.
     * @return void
    */
    protected function configureServiceManager(ServiceManager $services) {
        $services->setAllowOverride(true);

        $services->setService('config', $this->updateConfig($services->get('config')));
        $services->setService(VendaTable::class, $this->mockVendaTable()->reveal());

        $services->setAllowOverride(false);
    }

    /** 
     * Chave db limpa
     * @return void
    */
    protected function updateConfig($config) {
        $config['db'] = [];
        return $config;
    }

    /** 
     * Acionamento do mock para VendaTable
     * @return void
    */
    protected function mockVendaTable() {
        $this->vendaTable = $this->prophesize(VendaTable::class);
        return $this->vendaTable;
    }
}