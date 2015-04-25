<?php
require_once BASEMODELPATH.'Condition.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Equal extends Condition{
    function __construct($value){
        $this->value = $value;
    }
    public function execute(){
        $db = $this->constraints->getDB();
        $db->where($this->field,$this->value);
    }
}
?>
