<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'TecnologiaMapper.php';
/**
 * Description of TecnologiaFRM2
 *
 * @author usuario
 */
class TecnologiaFRM2 extends TecnologiaMapper{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    const STATUS_ACTIVO = 1;
    
    public function search(array $filter = null){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        if(isset($filter['Nombre']) && strlen($filter['Nombre']) > 0){
            $this->db->like('UPPER(nombre)',  strtoupper($filter['Nombre']));
        }
        $this->db->where('estadoid',self::STATUS_ACTIVO);
        $response = $this->db->get();
        //echo $this->db->last_query();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));        
    }
}
