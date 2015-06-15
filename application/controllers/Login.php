<?php
require_once BASECONTROLLERPATH.'BaseController.php';


class Login extends BaseController{
    function index(){
          $this->load->view('Login');
    }
}