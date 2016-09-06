<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASECONTROLLERPATH.'BaseController.php';
class Alcance extends BaseController{
    function __construct() {
        parent::__construct();
    }
    function search(){
        $this->load->model('Mapper/Finders/Alcance/AlcanceFRM1','AlcanceFRM1');
        $results = $this->AlcanceFRM1->search(array(
            'ProyectoId' => 4
        ));        
        
        //doing 
    }
}