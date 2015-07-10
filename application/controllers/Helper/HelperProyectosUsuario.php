<?php
require_once BASECONTROLLERPATH.'BaseController.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HelperProyectosUsuario
 *
 * @author usuario
 */
class HelperProyectosUsuario extends BaseController {
    //put your code here
     function __construct() {
        parent::__construct();
    }
   public function search(){        
        $this->load->model('Mapper/Finders/Proyectos/ProyectoFRM1','ProyectosUsuario');        
        
        $response = $this->ProyectosUsuario->search(                
                    array(
                        'UsuarioId' => $this->session->userdata('id'),
                        'Nombre' =>$this->getField('NombreProyecto')
                    )
                );        
        echo json_encode(Response::asResults($response));                                  
   }      
}
