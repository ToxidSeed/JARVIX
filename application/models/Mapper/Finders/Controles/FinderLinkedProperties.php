<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'Finders/Controles/BaseFinderProperties.php';

class FinderLinkedProperties extends BaseFinderProperties{
    protected $dmnControl;
    public function getDmnControl() {
        return $this->dmnControl;
    }

    public function setDmnControl($dmnControl) {
        $this->dmnControl = $dmnControl;
    }
        
    public function search(){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('controlid',$this->dmnControl->getId());
        
        //Optional Parameteres
        if($this->dmnControl->getNombre() != '' || $this->dmnControl->getNombre() != null){
            $this->db->like('nombre',$this->dmnControl->getNombre(),'both');
        }
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));
    }
}
?>
