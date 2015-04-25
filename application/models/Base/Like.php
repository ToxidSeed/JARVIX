<?php
require_once BASEMODELPATH.'Condition.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Like extends Condition{    
    
    protected $field;
    protected $value;
    protected $type;
    
    public function __construct($value,$type='both'){        
        $this->value = $value;
        $this->type = $type;
    }            
    public function execute(){
        $db = $this->constraints->getDB();
        $db->like($this->field,$this->value,$this->type);
    }           
}
?>
