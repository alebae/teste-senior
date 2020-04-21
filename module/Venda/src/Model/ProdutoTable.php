<?php
/** 
* 
* Classe para criação do Table Model de Produto, para ações a serem realizadas com a tabela produto
*
* @author alexandre.baehr
* @version 0.1 
* @access public  
* @example Classe ProdutoTable 
*/ 
namespace Venda\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use RuntimeException;

class ProdutoTable {
    /** 
    * 
    * Variável que é utilizada para injetar as operações com banco de dados 
    * @access private 
    * @name $tableGateway 
    */
    private $tableGateway;

    /** 
    * Método construtor injeta as operações com banco de dados
    * @access public 
    * @param Object $tableGateway
    * @return void 
    */
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    /** 
    * Método que retorna todos os registros de produtos
    * @access public 
    * @return Object 
    */
    public function getAll() {
        return $this->tableGateway->select();
    }

    /** 
    * Método que retorna um produto em específico
    * @access public 
    * @param Integer $id
    * @return Object 
    */
    public function getProduto($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();

        return $row;
    }

    /** 
    * Método que busca um produto pelo seu número de código
    * @access public 
    * @param Integer $id
    * @return Object 
    */
    public function getProdutoCodigo($codigo) {
        $codigo = (int) $codigo;
        $rowset = $this->tableGateway->select(['codigo' => $codigo]);
        $row = $rowset->current();

        return $row;
    }

    /** 
    * Método que salva o produto na base de dados
    * @access public 
    * @param Produto $produto
    * @return Object 
    */
    public function salvarProduto(Produto $produto) {
        $data = [
            'codigo' => $produto->getCodigo(),
            'descricao' => $produto->getDescricao(),
            'preco' => $produto->getPreco()
        ];

        $id = (int) $produto->getId();
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        } else {
            $this->tableGateway->update($data, ['id' => $id]);
        }
    }
}