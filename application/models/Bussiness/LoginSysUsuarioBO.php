<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'SysUsuarioMapper.php';

 class LoginSysUsuarioBO extends BaseBO{
     function __construct() {
         parent::__construct();
     }
     function Login(){
        try{
            $this->load->database();
            $this->checkObject();
            
            $mprSysUsuario = new SysUsuarioMapper();
            $mprSysUsuario->addUnique('email', $this->domain->getEmail());
            $dmnCurrentDomain = $mprSysUsuario->find();
            if($dmnCurrentDomain == null){
                throw new Exception('Error al Ingresar el Usuario o el Password',-1);
            }
            if($dmnCurrentDomain->getPassusr() != $this->domain->getPassusr()){
                throw new Exception('Error al Ingresar el Usuario o el Password',-1);
            }
        }catch(Exception $ex){
            throw new Exception($ex->getMessage(),$ex->getCode());
        }
     }
 }
 
?>
