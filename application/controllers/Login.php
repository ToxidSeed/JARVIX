<?php
require_once BASECONTROLLERPATH.'BaseController.php';

class Login extends BaseController{
    function index(){
          $this->load->view('Login');
    }
    public function acceder(){        
        try{
              $request_body = file_get_contents('php://input');              
              $values = json_decode($request_body,true);
              
        }
        catch(Exception $ex){
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
}