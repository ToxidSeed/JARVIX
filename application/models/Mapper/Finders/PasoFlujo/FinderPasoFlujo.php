<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'PasoFlujoMapper.php';

class FinderPasoFlujo extends PasoFlujoMapper{
	public function __construct(){
		parent::__construct();
	}
    public function Search($procesoFlujoId){
        $this->load->database();    
        $this->db->select($this->fields);
        $this->db->from($this->tableName);        
        $this->db->where('procesoflujoid',$procesoFlujoId);
        $this->db->order_by('numeropaso');
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        //print_r($arrResponse);
        //echo $this->db->last_query();
        return new ResponseModel($arrResponse, count($arrResponse));            
    }    
}

?>
