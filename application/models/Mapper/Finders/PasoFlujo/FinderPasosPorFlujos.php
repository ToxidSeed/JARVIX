<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'PasoFlujoMapper.php';

class FinderPasosPorFlujos extends PasoFlujoMapper{
    public function __construct(){
        parent::__construct();
    }
    public function Search($procesoFlujoId,$tipoFlujoId,$numeroFlujo){
        $this->load->database();    
        $this->db->select($this->fields);
        $this->db->from($this->tableName);        
        $this->db->where('procesoflujoid',$procesoFlujoId);
        $this->db->where('tipoflujoid',$tipoFlujoId);
        $this->db->where('numeroflujo',$numeroFlujo);
        $this->db->order_by('procesoflujoid,tipoflujoid,numeroflujo,numeropaso');
        $response = $this->db->get();
        
        
        //echo $this->db->last_query();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));            
    }    
}

?>
