<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'TecnologiaMapper.php';
/**
 * Description of newPHPClass
 *
 * @author usuario
 */
class TecnologiaFRM1 extends TecnologiaMapper {
    //put your code here
    function __construct() {
        parent::__construct();
    }
    public function search(array $filter = null){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        if(isset($filter['Nombre']) && strlen($filter['Nombre']) > 0){
            $this->db->where('nombre',$filter['Nombre']);
        }
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));        
    }
}
