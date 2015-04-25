<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Filter{    
    private $field = null;    
    private $value = null;
        
    public function setField($field){
        $this->field = $field;        
    }    
    public function setValue($value){
        $this->value = $value;
    }
}
?>
