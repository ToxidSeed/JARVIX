<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'ProcesoRequerimientoFuncionalMapper.php';

Class ProcesoRequerimientoFRM1 extends   ProcesoRequerimientoFuncionalMapper{
    /*
     * Busqueda por los campos:
     *  - ProcesoId
     */
    public function search($params){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from('ProcesoRequerimientoFuncional');
        $this->db->where('procesoid',$params['ProcesoId']);
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);              
        return new ResponseModel($arrResponse, count($arrResponse));
    }
}
