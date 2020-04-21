<?php
/** 
* 
* Classe para criação do Model de Produto
*
* @author alexandre.baehr
* @version 0.1 
* @access public  
* @example Classe Produto 
*/ 

namespace Venda\Model;

class Produto implements \Zend\Stdlib\ArraySerializableInterface {
    /** 
    * 
    * Variável que passa o campo ID da base de dados
    * @access private 
    * @name $id 
    */
    private $id;
    /** 
    * 
    * Variável que passa o campo CODIGO da base de dados
    * @access private 
    * @name $codigo 
    */
    private $codigo;
    /** 
    * 
    * Variável que passa o campo DESCRICAO da base de dados
    * @access private 
    * @name $descricao 
    */
    private $descricao;
    /** 
    * 
    * Variável que passa o campo PRECO da base de dados
    * @access private 
    * @name $preco 
    */
    private $preco;

    /** 
    * Método que copia os dados dos arrays para os objetos
    * @access public 
    * @param Array $data
    * @return void 
    */
    public function exchangeArray(array $data){
        $this->id = !empty($data['id']) ? $data['id'] : null; 
        $this->codigo = !empty($data['codigo']) ? $data['codigo'] : null; 
        $this->descricao = !empty($data['descricao']) ? $data['descricao'] : null; 
        $this->preco = !empty($data['preco']) ? $data['preco'] : null; 
    }

    /** 
    * Método que retorna o ID
    * @access public 
    * @return Integer 
    */
    public function getId() {
        return $this->id;
    }

    /** 
    * Método que seta o ID
    * @access public 
    * @param Integer $id
    * @return Integer 
    */
    public function setId($id) {
        $this->id = $id;
    }

    /** 
    * Método que retorna o CODIGO
    * @access public 
    * @return Integer 
    */
    public function getCodigo() {
        return $this->codigo;
    }

    /** 
    * Método que seta o CODIGO
    * @access public 
    * @param Integer $codigo
    * @return Integer 
    */
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    /** 
    * Método que retorna a DESCRICAO
    * @access public 
    * @return String 
    */
    public function getDescricao() {
        return $this->descricao;
    }

    /** 
    * Método que seta a DESCRICAO
    * @access public 
    * @param String $id
    * @return String 
    */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    /** 
    * Método que retorna o PRECO
    * @access public 
    * @return Double 
    */
    public function getPreco() {
        return $this->preco;
    }

    /** 
    * Método que seta o PRECO
    * @access public 
    * @param Double $preco
    * @return Double 
    */
    public function setPreco($preco) {
        $this->preco = $preco;
    }

    /** 
    * Método para uso do Zend Hydrator
    * @access public 
    * @return Array 
    */
    public function getArrayCopy(): array {
        return [
            'id' => $this->id,
            'codigo' => $this->codigo,
            'descricao' => $this->descricao,
            'preco' => $this->preco            
        ];
    }
}