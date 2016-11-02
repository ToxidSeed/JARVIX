<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once MAPPERPATH.'EntregaMapper.php';

class EntregaFRM1 extends EntregaMapper{
    
    public function search($filters){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        if(isset($filters['ProyectoId']) && strlen($filters['ProyectoId']) > 0 ){
            $this->db->where('ProyectoId',$filters['ProyectoId']);
        }
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));
    }
}
