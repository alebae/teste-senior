<?php  
namespace Application\Model;  
class Produto { 
   public $codigo; 
   public $descricao; 
   public $preco; 

   public function exchangeArray($data) { 
        $this->codigo = (!empty($data['codigo'])) ? $data['codigo'] : null; 
        $this->descricao = (!empty($data['descricao'])) ? $data['descricao'] : null; 
        $this->preco = (!empty($data['preco'])) ? $data['preco'] : null; 
   } 
}