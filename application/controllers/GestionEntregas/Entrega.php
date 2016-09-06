<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';

class Entrega extends BaseController{
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('EntregaView.php');
        $this->load->view('Base/Footer.php');
    }
}