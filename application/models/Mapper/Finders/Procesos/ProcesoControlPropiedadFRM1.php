<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @descripcion: muestra todas aquellas propiedades que se encuentran seleccionadas para un proceso y control especifico
 */

require_once MAPPERPATH.'ProcesoControlPropiedadMapper.php';

class ProcesoControlPropiedadFRM1 extends ProcesoControlPropiedadMapper{
    
   protected $fields = array(
        'procesocontrolpropiedad.id',
        'procesocontrolpropiedad.procesocontrolid',
        'procesocontrolpropiedad.controlid',
        'procesocontrolpropiedad.valor',
        'procesocontrolpropiedad.propiedadid',
    ); 
    
   public function search(array $filter = null){              
       
       $this->load->database();       
       $this->db->select($this->fields);
       $this->db->from($this->tableName);
       $this->db->join('propiedad',
                            'propiedad.id = procesocontrolpropiedad.propiedadid and '.
                            'propiedad.controlid = procesocontrolpropiedad.controlid ');                            
       $this->db->where('procesocontrolpropiedad.controlid',$filter['ControlId']);
       $this->db->where('procesocontrolpropiedad.procesocontrolid',$filter['ProcesoControlId']);
       $response = $this->db->get();
       
//       echo $this->db->last_query();
       $arrResponse = $this->getMultiResponse($response);
       
       return new ResponseModel($arrResponse, count($arrResponse));               
   } 
}