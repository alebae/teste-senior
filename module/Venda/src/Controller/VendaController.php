<?php
/** 
* 
* Controller para realização das vendas
*
* @author alexandre.baehr
* @version 0.1 
* @access public  
* @example Classe VendaController 
*/ 

namespace Venda\Controller;

use Venda\Form\VendaForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class VendaController extends AbstractActionController {
    /** 
    * 
    * Variável que é utilizada para injetar as operações com banco de dados 
    * @access private 
    * @name $table 
    */
    private $table;

    /** 
    * Método construtor injeta as operações com banco de dados
    * @access public 
    * @param Object $table
    * @return void 
    */
    public function __construct($table) {
        $this->table = $table;
    }

    /** 
    * Método que retorna a página inicial (dashboard)
    * @access public 
    * @return Object 
    */
    public function indexAction() {
        $valorTotalPedidos = number_format($this->table->getInfoPedidoConfirmado()['valorTotalPedidos'],2,",",".");
        $totalPedidos = $this->table->getInfoPedidoConfirmado()['totalPedidos'];
        $totalProdutos = $this->table->getQtdeProdutos();      

        return new ViewModel(['valorTotalPedidos' => $valorTotalPedidos, 'totalPedidos' => $totalPedidos, 'totalProdutos' => $totalProdutos]);
    }

    /** 
    * Método que retorna a página de carrinho
    * @access public 
    * @return Object 
    */
    public function carrinhoAction() {
        //Puxar id atual + 1, caso não haja
        $idDocumento = $this->table->getUltimoNumero();     

        return new ViewModel(['idDocumento' => $idDocumento]);
    }

    /** 
    * Método que executa a ação de adição do produto ao carrinho
    * @access public 
    * @return Object 
    */
    public function adicionarAction() {
        //Inserir na tabela item com id do documento e id do produto
        $request = $this->getRequest();        
        $valor = $request->getPost();
        //Verificar se código de documento está vazio. Se estiver insere documento, se não não faz nada
        if(!$valor->documento) {
            $valor->documento = $this->table->adicionarDocumento();
        }       

        $data = ['idDocumento' => $valor->documento, 'idProduto' => $valor->produto];
        $this->table->insereItem($data);

        //Atualizar na tabela documento com o total somado
        $this->table->atualizarDocumento($valor->documento);

        //Chamar a tabela de produto com os dados para $info
        $info = $this->table->infoProduto($valor->produto);

        $data = [
            'achou' => true,    
            'numero' => $valor->documento, 
            'id' => ($info) ? $info->id : 0,
            'codigo' => ($info) ? $info->codigo : 0,
            'descricao' => ($info) ? $info->descricao : '',   
            'preco' => ($info) ? $info->preco: 0,     
        ];
        
        $result = new JsonModel($data);

        return $result;
    }

    /** 
    * Método que executa a confirmação da venda
    * @access public 
    * @return Object 
    */
    public function confirmarAction() {
        
        $request = $this->getRequest();  
        $valor = $request->getPost();
        $this->table->confirmarVenda($valor->idDocumento);
        $this->flashMessenger()->addMessage('Venda confirmada!');
        return $this->redirect()->toRoute('venda', ['action' => 'carrinho']);
    }

    /** 
    * Método que executa o cancelamento da venda
    * @access public 
    * @return Object 
    */
    public function cancelarAction() {        
        //Realizar a exclusão na tabela documento
        $request = $this->getRequest();        
        $valor = $request->getPost();
        $this->table->deletarVenda($valor->documento);

        $data = [
            'achou' => true,                    
        ];

        $result = new JsonModel($data);

        return $result;
    }
}