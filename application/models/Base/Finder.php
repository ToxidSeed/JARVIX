<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Finder{
    protected $database;
    protected $field;
    protected $constraints = array();    
    
    public function connection($db){
        $this->database = $db;
    }
    
    public function field($field){
        $this->field = $field;
        return $this;
    }
    public function eq($value){
        $this->database->where($this->field,$value);
        return $this;
    }        
    public function like($value,$both){
        $this->database->like($this->field,$value,$both);
    }    
}
?>
