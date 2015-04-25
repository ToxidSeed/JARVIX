<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ErrorCollector{   
    private $errors = array();
    function getErrors() {
        return $this->errors;
    }

    function setErrors($errors) {
        $this->errors = $errors;
    }
    
    function add($error){
        $this->errors[] = $error; 
    }

    function hasErrors(){
        if(count($this->errors) > 0 ){
            return true;
        }else{
            return false;
        }
    }
}
