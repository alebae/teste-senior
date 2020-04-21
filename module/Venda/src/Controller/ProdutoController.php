<?php
/** 
* 
* Controller para os produtos
*
* @author alexandre.baehr
* @version 0.1 
* @access public  
* @example Classe ProdutoController 
*/

namespace Venda\Controller;

use Venda\Form\ProdutoForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ProdutoController extends AbstractActionController {
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
    * Método que retorna a página inicial (lista de produtos)
    * @access public 
    * @return Object 
    */
    public function indexAction() {
        return new ViewModel(['messages' => $this->flashMessenger()->getMessages(), 'produtos' => $this->table->getAll()]);
    }

    /** 
    * Método que adiciona produto à base de dados
    * @access public 
    * @return Object 
    */
    public function adicionarAction() {
        $form = new ProdutoForm();
        $form->get('submit')->setValue('Adicionar');
        $request = $this->getRequest();

        if (!$request->isPost()) {
            return new ViewModel(['form' => $form]);
        }
        $produto = new \Venda\Model\Produto();
        $valor = $request->getPost();
        $valor->preco = str_replace('.', '',$valor->preco);
        $valor->preco = str_replace(',', '.',$valor->preco);
        $valor->preco = str_replace('R$ ', '',$valor->preco);

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return new ViewModel(['form' => $form]);
        }

        $produto->exchangeArray($form->getData());
        $this->table->salvarProduto($produto);
        
        $this->flashMessenger()->addMessage('Produto incluído!');

        return $this->redirect()->toRoute('produto');
    }

    /** 
    * Método que realiza a pesquisa do produto na tela de vendas
    * @access public 
    * @return Object 
    */
    public function pesquisarAction() {
        $request = $this->getRequest();
        $info = $request->getPost();

        $p = $this->table->getProduto($info->produto);
        
        $data = [
            'achou' => ($p) ? true : false,
            'id' => ($p) ? $p->getId() : 0,
            'codigo' => ($p) ? $p->getCodigo() : 0,
            'descricao' => ($p) ? $p->getDescricao() : 0,
            'preco' => ($p) ? $p->getPreco() : 0,
            'success' => ($p) ? true : false,
        ];
        
        $result = new JsonModel($data);
     
        return $result;
    }

    /** 
    * Método que realiza a verificação se o código já existe na base de dados
    * @access public 
    * @return Object 
    */
    public function verificadorAction() {
        $request = $this->getRequest();
        $info = $request->getPost();

        $c = $this->table->getProdutoCodigo($info->codigo);

        $data = ['achou' => ($c) ? true : false];

        $result = new JsonModel($data);
     
        return $result;
    }


}