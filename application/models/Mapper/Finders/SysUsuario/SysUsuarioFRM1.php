<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'SysyUsuarioMapper.php';
/**
 * Description of SysUsuarioFRM1
 *
 * @author usuario
 */
class SysUsuarioFRM1 extends SysyUsuarioMapper{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    const ESTADO_ACTIVO = 1;
    
    function search($constraints = array()){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('estadoid',self::ESTADO_ACTIVO);
        $this->db->like('nombre',$constraints['Nombre']);
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));
        
    }
}
