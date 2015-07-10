<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProyectoFRM1
 *
 * @author usuario
 */
require_once MAPPERPATH.'ProyectoMapper.php';

class ProyectoFRM1 extends ProyectoMapper{
    //put your code here
    function __construct(){
        parent::__construct();
    }
    
    public function search($params){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->join('participante','participante.proyectoid = '.$this->tableName.'.id');
        $this->db->where('participante.sysusuarioid',$params['UsuarioId']);
        if (isset($params['Nombre']) && strlen($params['Nombre']) > 0){
            $this->db->where($this->tableName.'.nombre',$params['Nombre']);
        }        
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));
    }
}
