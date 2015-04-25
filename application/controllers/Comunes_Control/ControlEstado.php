<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';

class ControlEstado extends BaseController{
    function __construct() {
        parent::__construct();
    }        
    
    function getControlesActivos(){
        $this->load->model('Mapper/Comunes_Control/ComunControlEstado','ComunControlEstado');
        $gpNombre = $this->getField('Nombre');
        $response = $this->ComunControlEstado->Search(ESTADO_ACTIVO,$gpNombre);
        echo json_encode(Response::asResults($response));
    }
}
