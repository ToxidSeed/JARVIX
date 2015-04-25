<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once MAPPERPATH.'ProcesoControlPropiedadMapper.php';

class FinderProcesoControlPropiedad extends ProcesoControlPropiedadMapper{
    
   protected $fields = array(
        'procesocontrolpropiedad.id',
        'procesocontrolpropiedad.procesocontrolid',
        'procesocontrolpropiedad.valor',
        'controlpropiedad.propiedadid',
        'controlpropiedad.id as controlpropiedadid'
    ); 
    
   public function getPropiedades($parControlId,$parProcesoControlPropiedadId){
       
       if(empty($parProcesoControlPropiedadId)){
           $parProcesoControlPropiedadId = 0;
       }              
       
       $this->load->database();       
       $this->db->select($this->fields);
       $this->db->from('controlpropiedad');
       $this->db->join('procesocontrolpropiedad','controlpropiedad.id = procesocontrolpropiedad.controlpropiedadid and IFNULL(procesocontrolpropiedad.procesocontrolid,0) = '.$parProcesoControlPropiedadId,'left');
       $this->db->where('controlpropiedad.controlid',$parControlId);
       $response = $this->db->get();
       
//       echo $this->db->last_query();
       $arrResponse = $this->getMultiResponse($response);
       
       return new ResponseModel($arrResponse, count($arrResponse));               
   } 
}