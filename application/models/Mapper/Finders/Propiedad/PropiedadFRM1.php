<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'PropiedadMapper.php';
/**
 * Description of PropiedadFRM1
 *
 * @author usuario
 */
class PropiedadFRM1 extends PropiedadMapper {
    //put your code here
    public function __construct() {
        parent::__construct();
    }   
    
    public function search(array $filters = null){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('controlid',$filters['ControlId']);
        if(isset($filters['Nombre']) && strlen($filters['Nombre']) > 0){
            $this->db->like('nombre',$filters['Nombre']);
        }        
                
        $response = $this->db->get();
        //echo $this->db->last_query();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse,count($arrResponse));
    }
}
