<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'ProcesoControlMapper.php';

class FinderControles extends ProcesoControlMapper {
    public function search($ProcesoId){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from('procesocontrol');
        $this->db->where('procesoid',$ProcesoId);
        $response = $this->db->get();
//        echo $this->db->last_query();
        $arrResponse = $this->getMultiResponse($response);
        
        //Por cada uno de los controles traidos, traemos sus referencias
        foreach($arrResponse as $dmnProcesoControl){
            $dmnProcesoControl->Mapper()->getControl();
        }
        
        return new ResponseModel($arrResponse, count($arrResponse));
    }
}
