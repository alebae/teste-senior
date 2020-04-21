<?php
/** 
* 
* Classe para criação do formulário para produto
*
* @author alexandre.baehr
* @version 0.1 
* @access public  
* @example Classe ProdutoForm 
*/ 

namespace Venda\Form;
use Zend\Form\Form;

class ProdutoForm extends Form {

    /** 
    * Método construtor que cria o formulário
    * @access public 
    * @param Object $table
    * @return void 
    */
    public function __construct() {
        parent::__construct('produto', []);
        $this->add(new \Zend\Form\Element\Hidden('id'));
        $this->add(new \Zend\Form\Element\Text("codigo",['label' => "Código"]));
        $this->add(new \Zend\Form\Element\Text("descricao",['label' => "Descrição"]));
        $this->add(new \Zend\Form\Element\Text("preco",['label' => "Preço"]));

        $submit = new \Zend\Form\Element\Submit('submit');
        $submit->setAttributes(['value' => 'Salvar', 'id' => 'submitbutton']);
        $this->add($submit);
    }
}