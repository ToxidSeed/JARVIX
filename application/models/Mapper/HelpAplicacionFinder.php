<?php
require_once MAPPERPATH.'AplicacionMapper.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class HelpAplicacionFinder extends AplicacionMapper{
    protected $paramNombre;
    public function getParamNombre() {
        return $this->paramNombre;
    }

    public function setParamNombre($value) {
        $this->paramNombre = $value;
    }

    function __construct() {
        parent::__construct();
    }
    
    
    public function getList(){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('estadoid',1);//Aplicaciones Activas
        $this->db->like('nombre',$this->getParamNombre(),'both');
        $response = $this->db->get(); 
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse,count($arrResponse));
    }
}
?>
