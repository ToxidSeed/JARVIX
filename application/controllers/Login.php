<?php
require_once BASECONTROLLERPATH.'BaseController.php';


class Login extends BaseController{
    function index(){
          $this->load->view('Login');
    }
    public function acceder(){
        try{
               $email = $this->getField('email');
               print_r($email);
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