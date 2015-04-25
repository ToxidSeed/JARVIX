<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'ProcesoControlEventoMapper.php';

class FinderProcesoControlEvento extends ProcesoControlEventoMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'procesocontrolevento.id',
        'procesocontrolevento.procesocontrolid',
        'procesocontrolevento.valor',
        'controlevento.eventoid',
        'procesocontrolevento.controleventoid'
    );
    
    public function search($parControlId,$parProcesoControlEventoId){
        if(empty($parProcesoControlEventoId)){
            $parProcesoControlEventoId = 0;
        }
        
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from('controlevento');
        $this->db->join('procesocontrolevento','controlevento.id = procesocontrolevento.controleventoid and IFNULL(procesocontrolevento.id,0) = '.$parProcesoControlEventoId,'left');
        $this->db->where('controlevento.controlid',$parControlId);
        $response = $this->db->get();
        
//        echo $this->db->last_query();
        
        $arrResponse = $this->getMultiResponse($response);      
        return new ResponseModel($arrResponse, count($arrResponse));
    }
    
}
