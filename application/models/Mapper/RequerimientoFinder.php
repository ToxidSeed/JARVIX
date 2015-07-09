<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once MAPPERPATH.'RequerimientoMapper.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RequerimientoFinder extends RequerimientoMapper{
    protected $paramNombre;

    function __construct() {
        parent::__construct();
    }
    public function getList($ProyectoId,$NombreRequerimiento){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        //$this->db->where('estadoid',1);
        $this->db->like('nombre',$NombreRequerimiento,'both');
        $this->db->where('proyectoid',$ProyectoId);
        $response = $this->db->get();
        
//        print_r($this->db->last_query());
        
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse,count($arrResponse));
    }
}
?>
