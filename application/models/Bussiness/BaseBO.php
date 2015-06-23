<?php
require_once LIBATH.'messages/MessageHandler.php';
require_once LIBATH.'Answer.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class BaseBO extends CI_Model{
    protected $answer;
    function __construct(){
        parent::__construct();
        $this->answer = new Answer();
        //Por default esta todo bien
        $this->answer->setCode(0);
        $this->answer->setSuccess(true);
        //$this->errors = new ErrorCollector(); 
    }
    protected $domain;
    protected $message;
    
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
    function getMessage() {
        return $this->message;
    }

    function setMessage($message) {
        $this->message = $message;
    }
    function getAnswer() {
        return $this->answer;
    }




}
?>
