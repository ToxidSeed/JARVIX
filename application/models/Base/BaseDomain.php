<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class BaseDomain{
    protected $mapper = false;  
    
    public function getValues(){
        return get_object_vars($this);
    }
    public function mapper(){
        $this->mapper = true;
        return $this;
    }
    
}
?>
