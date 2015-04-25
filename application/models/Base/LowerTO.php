<?php
require_once BASEMODELPATH.'Condition.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class LowerTO extends Condition{
    protected $equal = false;
    function __construct($value,$equal = false){
        $this->value = $value;
        $this->equal = $equal;
    }
    public function execute(){
        $db = $this->constraints->getDB();
        $field = $this->field;        
        if($this->equal == true){
            $field = $field.' <= ';
        }else{
            $field = $field.' < ';                        
        }                        
        $db->where($field,$this->value);        
    }
}
?>
