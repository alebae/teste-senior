<?php
/** 
* 
* Classe para criação do Model de Venda
*
* @author alexandre.baehr
* @version 0.1 
* @access public  
* @example Classe Venda 
*/ 
namespace Venda\Model;

class Venda implements \Zend\Stdlib\ArraySerializableInterface {
    /** 
    * 
    * Variável que passa o campo NUMERO da base de dados
    * @access private 
    * @name $numero 
    */
    private $numero;
    /** 
    * 
    * Variável que passa o campo TOTAL da base de dados
    * @access private 
    * @name $total 
    */
    private $total;
    /** 
    * 
    * Variável que passa o campo CONFIRMADO da base de dados
    * @access private 
    * @name $total 
    */
    private $confirmado;

    /** 
    * Método que copia os dados dos arrays para os objetos
    * @access public 
    * @param Array $data
    * @return void 
    */
    public function exchangeArray(array $data){
        $this->numero = !empty($data['numero']) ? $data['numero'] : null; 
        $this->total = !empty($data['total']) ? $data['total'] : null; 
        $this->confirmado = !empty($data['confirmado']) ? $data['confirmado'] : null; 
    }

    /** 
    * Método que retorna o NUMERO
    * @access public 
    * @return Integer 
    */
    public function getNumero() {
        return $this->numero;
    }

    /** 
    * Método que seta o NUMERO
    * @access public 
    * @param Integer $id
    * @return Integer 
    */
    public function setNumero($numero) {
        $this->numero = $numero;
    }

    /** 
    * Método que retorna o TOTAL
    * @access public 
    * @return Double 
    */
    public function getTotal() {
        return $this->total;
    }

    /** 
    * Método que seta o TOTAL
    * @access public 
    * @param Double $total
    * @return Double 
    */
    public function setTotal($total) {
        $this->total = $total;
    }

    /** 
    * Método que retorna o CONFIRMADO (Confirmação de venda ou não)
    * @access public 
    * @return Integer 
    */
    public function getConfirmado() {
        return $this->confirmado;
    }

    /** 
    * Método que seta o CONFIRMADO (Confirmação de venda ou não)
    * @access public 
    * @param Integer $confirmado
    * @return Integer 
    */
    public function setConfirmado($confirmado) {
        $this->confirmado = $confirmado;
    }

    /** 
    * Método para uso do Zend Hydrator
    * @access public 
    * @return Array 
    */
    public function getArrayCopy(): array {
        return [
            'numero' => $this->numero,
            'total' => $this->total,
            'confirmado' => $this->confirmado            
        ];
    }
}