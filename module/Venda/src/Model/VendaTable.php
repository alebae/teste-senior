<?php
/** 
* 
* Classe para criação do Table Model de Venda, para ações a serem realizadas com a tabela documentos e itens (venda)
*
* @author alexandre.baehr
* @version 0.1 
* @access public  
* @example Classe VendaTable 
*/
namespace Venda\Model;

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use RuntimeException;

class VendaTable {
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
    * Método que retorna todos os registros de vendas
    * @access public 
    * @return Object 
    */
    public function getAll() {
        return $this->tableGateway->select();
    }

    /** 
    * Método que retorna uma venda em específico
    * @access public 
    * @param Integer $numero
    * @return Object 
    */
    public function getVenda($numero) {
        $numero = (int) $numero;
        $rowset = $this->tableGateway->select(['numero' => $numero]);
        $row = $rowset->current();

        if (!$row) {
            throw new RuntimeException(sprintf('Venda %d não encontrada!', $numero));
        }

        return $row;
    }

    /** 
    * Método que retorna o último número de venda e adiciona mais um para ser exibido a próxima venda
    * @access public 
    * @return Integer 
    */
    public function getUltimoNumero() { 
        $query = 'SELECT MAX(numero) AS ultimoNumero FROM documento;';
        $stmt = $this->tableGateway->getAdapter()->driver->getConnection()->execute($query);
        $result = $stmt->current();

        return (int) $result['ultimoNumero']+1;
    }

    /** 
    * Método que adiciona um registro na tabela documento e retorna seu NUMERO (ID) registrado
    * @access public 
    * @return Integer 
    */
    public function adicionarDocumento() {
        $data = ['total' => 0.00, 'confirmado' => 0];
        $this->tableGateway->insert($data);
        $idDocumento = $this->tableGateway->lastInsertValue;
        return $idDocumento;
    }

    /** 
    * Método que insere item (produto e documento) na tabela item
    * @access public 
    * @param Array $data
    * @return Object 
    */
    public function insereItem($data) {
        $adapter = $this->tableGateway->getAdapter();
        $item = new TableGateway('item', $adapter); 

        $item->insert($data);
    }

    /** 
    * Método que retorna os dados do produto inserido no carrinho
    * @access public 
    * @param Integer $idProduto
    * @return Object 
    */
    public function infoProduto($idProduto) {
        $adapter = $this->tableGateway->getAdapter();
        $item = new TableGateway('produto', $adapter); 
        $rowset = $item->select(['id' => $idProduto]);
        
        return $rowset->current();
    }

    /** 
    * Método que calcula o valor total da venda pelo número do documento
    * @access public 
    * @param Integer $numero
    * @return Double 
    */
    public function calculaValorTotal($numero) {        
        $query = 'CALL procTotalVenda('.$numero.');';
        $stmt = $this->tableGateway->getAdapter()->driver->getConnection()->execute($query);
        $result = $stmt->current();
      
        return $result['totalVenda'] ? $result['totalVenda'] : 0;        
    }

    /** 
    * Método que atualiza o documento com o valor total, conforme adição de produtos no carrinho
    * @access public 
    * @param Integer $numero
    * @return void 
    */
    public function atualizarDocumento($numero) {
        $valorTotal = $this->calculaValorTotal($numero);
        $data = ['total' => $valorTotal];
        $this->tableGateway->update($data, ['numero' => $numero]);
    }

    /** 
    * Método que confirma a venda
    * @access public 
    * @param Integer $numero
    * @return void 
    */
    public function confirmarVenda($numero) {
        $data = ['confirmado' => 1];
        $this->tableGateway->update($data, ['numero' => $numero]);
    }

    /** 
    * Método que exclui uma venda
    * @access public 
    * @param Integer $numero
    * @return void 
    */
    public function deletarVenda($numero) {
        $this->tableGateway->delete(['numero' => $numero]);
    }

    /** 
    * Método que retorna a soma total de pedidos confirmados e a quantidade total
    * @access public 
    * @return Object 
    */
    public function getInfoPedidoConfirmado() {
        $query = 'SELECT 
                        SUM(total) AS valorTotalPedidos
                        , COUNT(numero) AS totalPedidos 
                        FROM documento 
                       WHERE confirmado=1';
        $stmt = $this->tableGateway->getAdapter()->driver->getConnection()->execute($query);
        $result = $stmt->current();

        return $result;
    }
    /** 
    * Método que retorna a quantidade de produtos cadastrados
    * @access public 
    * @return Object 
    */
    public function getQtdeProdutos() {
        $query = 'SELECT COUNT(id) AS totalProdutos FROM produto';
        $stmt = $this->tableGateway->getAdapter()->driver->getConnection()->execute($query);
        $result = $stmt->current();
        
        return $result['totalProdutos'];
    }
}