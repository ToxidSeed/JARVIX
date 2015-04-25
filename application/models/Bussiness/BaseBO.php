<?php
require_once LIBATH.'messages/Message.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class BaseBO extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->errors = new ErrorCollector();
    }
    protected $domain;
    protected $errors;
    public function setDomain($domain){
        $this->domain = $domain;
    }
    public function getDomain(){
        return $this->domain;
    }
    protected function checkObject(){
        if($this->domain == null){
            throw new Exception('El Objecto de Dominio no ha sido enviado',-1);
        }
    }
}
?>
