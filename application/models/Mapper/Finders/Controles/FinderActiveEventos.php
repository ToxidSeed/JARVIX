<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'/EventoMapper.php';

class FinderActiveEventos extends EventoMapper{
    protected $dmnControl;
    public function getDmnControl(){
        return $this->dmnControl;
    }
    public function setDmnControl($dmnControl){
        $this->dmnControl = $dmnControl;
    }
    
    public function search(){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        //$this->db->where('controlid',$this->dmnControl->getId());        
        $response = $this->db->get();
        
        //echo $this->db->last_query();
        
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));
    }
}
?>
