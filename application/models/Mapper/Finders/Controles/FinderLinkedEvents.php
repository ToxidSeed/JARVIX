<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'ControlEventoMapper.php';

class FinderLinkedEvents extends ControlEventoMapper{
    protected $dmnControl;
    public function getDmnControl(){
        return $this->dmnControl;
    }
    public function setDmnControl($dmnControl){
        $this->dmnControl  = $dmnControl;
    }
    
    public function search(){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('controlid',$this->dmnControl->getId());
        $response = $this->db->get();
//        echo $this->db->last_query();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));
    }
}
