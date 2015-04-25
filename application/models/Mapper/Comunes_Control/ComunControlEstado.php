<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'TipoControlMapper.php';

class ComunControlEstado extends TipoControlMapper{
    function __construct() {
        parent::__construct();
    }
    function Search($argEstado,$argNombre = ''){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('estadoid',$argEstado);
        if($argNombre != ''){
            $this->db->like('nombre',$argNombre);
        }        
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));       
    }
}
