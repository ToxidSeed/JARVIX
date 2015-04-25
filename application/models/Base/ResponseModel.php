<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class ResponseModel{
    protected $results;
    protected $count;
    public function __construct($results,$count){
        $this->results = $results;
        $this->count = $count;        
    }
    public function getResults(){
        return $this->results;
    }
    public function getCount(){
        return $this->count;
    }
    
}
?>
