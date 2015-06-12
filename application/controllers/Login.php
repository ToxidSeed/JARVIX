<?php
require_once BASECONTROLLERPATH.'BaseController.php';


class PrincipalController extends BaseController{
    function index(){
          $this->load->view('Login');
    }
}