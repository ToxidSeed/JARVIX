<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ErrorObject{
    private $code;
    private $msg;
    private $line;
    
    function __construct($msg = null,$code = null) {
        $this->code = $code;
        $this->msg = $msg;
    }
    
    function getCode() {
        return $this->code;
    }

    function getMsg() {
        return $this->msg;
    }

    function getLine() {
        return $this->line;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setMsg($msg) {
        $this->msg = $msg;
    }

    function setLine($line) {
        $this->line = $line;
    }

    
}
