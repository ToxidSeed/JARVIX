<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Field{
    protected $constraints;
    protected $name;
    protected $condition = array();
    
    
    public function __construct($name,Constraints $refConstraints){
        $this->name = $name;
        $this->constraints = $refConstraints;
    }
        
    public function setName($name){
        $this->name = $name;
        return $this;
    }        
    public function addCondition($condition){
        $condition->setConstraints($this->constraints);
        $condition->setField($this->name);
        $this->condition[] = $condition;
        return $this;
    }
    public function getConditions(){
        return $this->condition;
    }
}
?>
