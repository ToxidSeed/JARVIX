<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'SysUsuarioMapper.php';
/**
 * Description of SysUsuarioFRM1
 *
 * @author usuario
 */
class SysUsuarioFRM1 extends SysUsuarioMapper{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    const ESTADO_ACTIVO = 1;
    
    function search(array $constraints = null){
                
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->join('participante','sysusuario.id = participante.sysusuarioid and participante.proyectoid = '.$constraints['ProyectoId'],'left');
        $this->db->where('estadoid',self::ESTADO_ACTIVO);
        $this->db->where('ifnull(participante.sysusuarioid,0)',0);
        $this->db->like('nombre',$constraints['Nombre']);
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));
        
    }
}
