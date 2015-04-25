<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Condition{    
    protected $constraints;
    protected $field;
    protected $value;

    public function setConstraints(Constraints $constraints){
        $this->constraints = $constraints;
        return $this;
    }
    public function setField($field){
        $this->field = $field;
        return $this;
    }
    
}

?>
