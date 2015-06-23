<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'SysUsuarioMapper.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccederBO
 *
 * @author usuario
 */
class LoginBO extends BaseBO{
    public function __construct() {
        
        parent::__construct();
    }
    public function setDomain(DomainSysUsuario $dmnUsuario) {
        parent::setDomain($dmnUsuario);        
    }
    
    public function login(){        
        return $this->VerCredenciales();       
    }        
    
    //put your code here   
    private function VerCredenciales(){
        $mprSysUsuario = new SysUsuarioMapper();
        $mprSysUsuario->addUnique('email', $this->domain->getEmail());
        $dmnSysUsuario  = $mprSysUsuario->find();                    
        if ($dmnSysUsuario == null ){
            $this->answer->addFailMessage('No se encuentra al usuario con email '.$this->domain->getEmail());                        
            return false;
        }        
        if ($dmnSysUsuario->getPassusr() != sha1($this->domain->getEmail().$this->domain->getPassusr())){            
            $this->answer->addFailMessage('El Usuario o Password no coincide');                                    
            return false;
        }
        
        //Setting additional values
        $this->domain->setId($dmnSysUsuario->getId()); 
        return true;
    }
}
