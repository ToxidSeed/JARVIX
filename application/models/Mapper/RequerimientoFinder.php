<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once MAPPERPATH.'RequerimientoMapper.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class RequerimientoFinder extends RequerimientoMapper{
    protected $paramNombre;

    public function getParamNombre() {
        return $this->paramNombre;
    }

    public function setParamNombre($paramNombre) {
        $this->paramNombre = $paramNombre;
    }
    
    function __construct() {
        parent::__construct();
    }
    public function getList(){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        //$this->db->where('estadoid',1);
        $this->db->like('nombre',$this->getParamNombre(),'both');
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse,count($arrResponse));
    }
}
?>
