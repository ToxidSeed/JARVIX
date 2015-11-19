<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
/**
 * Description of con_cuenta
 *
 * @author usuario
 */
class con_cuenta extends BaseController{
    //put your code here
    function __index(){
        $this->load->view('Base/Header.php');
        $this->load->view('view_cuenta.php');
        $this->load->view('Base/Footer.php');
    }
}
