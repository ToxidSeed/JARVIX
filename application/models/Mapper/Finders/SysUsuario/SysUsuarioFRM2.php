<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'SysUsuarioMapper.php';

class SysUsuarioFRM2 extends SysUsuarioMapper{
    function __construct(){
        parent::__construct();
    }
    public function search(array $constraints = null){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->join('participante','sysusuario.id = participante.sysusuarioid');
        $this->db->where('participante.proyectoid',$constraints['ProyectoId']);
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));        
    }
}
