<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'ProcesoMapper.php';

class FinderProcesos extends ProcesoMapper{    
    public function search($parameters = array()){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        if(isset($parameters['ProyectoId'])){
            $this->db->where('proyectoid',$parameters['ProyectoId']);
        }
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));        
    }
}

?>
