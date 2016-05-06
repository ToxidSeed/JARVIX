<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'EditorMapper.php';
/**
 * Description of PropiedadFRM1
 *
 * @author usuario
 * @descripcion: Clase que obtiene todas aquellas propiedades que NO se encuentran seleccionadas
 * por un control de un proceso en particular
 */
class EditorFRM1 extends EditorMapper {
    //put your code here
    public function __construct() {
        parent::__construct();
    }   
    
    public function search(){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);        
        $response = $this->db->get();    
        
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse,count($arrResponse));
    }
}
