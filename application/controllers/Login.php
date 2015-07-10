<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainSysUsuario.php';


class Login extends BaseController{
    public function __construct() {        
        parent::__construct();
        
    }
    function index(){
        //Verificar session        
          $this->load->view('Login');
    }
    public function acceder(){        
        try{
            
              $request_body = file_get_contents('php://input');              
              $values = json_decode($request_body,true);
              $dmnSysUsuario = new DomainSysUsuario();
              $dmnSysUsuario->setEmail($values['email']);
              $dmnSysUsuario->setPassusr($values['password']);
              
              $this->load->model('Bussiness/Usuario/LoginBO','LoginBO');
              $this->LoginBO->setDomain(
                          $dmnSysUsuario
                      );
              
              if($this->LoginBO->login()){
                  $this->createSession();
              }
                  
              $result = $this->LoginBO->getAnswer();
              $result->showSuccessMessage('Logeado Correctamente');
        }
        catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    private function createSession(){                        
        $sessionInform = array(
            'email' => $this->LoginBO->getDomain()->getEmail(),
            'id' => $this->LoginBO->getDomain()->getId()
        );
        
        $this->session->set_userdata($sessionInform);
    }
    
}