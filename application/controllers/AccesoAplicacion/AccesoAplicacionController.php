<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainSysUsuario.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AccesoAplicacionController extends BaseController{
    public function __construct() {
        parent::__construct();
    }
    public function Login(){
        try{
            $this->formValidation(__CLASS__, '', __FUNCTION__);
            
            $dmnSysUsuario = new DomainSysUsuario();
            $dmnSysUsuario->setEmail($this->getField('email'));
            $dmnSysUsuario->setPassusr($this->getField('password'));
            $this->load->model('Bussiness/LoginSysUsuarioBO','LoginSysUsuarioBO');
            $this->LoginSysUsuarioBO->setDomain($dmnSysUsuario);
            $this->LoginSysUsuarioBO->Login();
            echo Answer::setSuccessMessage('Bienvenido',0);                        
        }catch(Exception $ex){
            echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
        }
    }
}
?>
