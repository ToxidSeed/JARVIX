<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseMapper.php';

class AlcanceFRM1 extends BaseMapper{
    public function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
       'proceso.id',
        'proceso.nombre'
    );
    
    private $Proceso = array();
    private $ProcesoFlujo = array();
    private $ProcesoControl = array();
    
    private $results = array();
    
    function search($filters){
        $this->db->select($this->fields);
        $this->db->from('proceso');
        $this->db->where('proyectoid',$filters['ProyectoId']);
        $res  = $this->db->get();   
        $this->Proceso = $res->result_array();
        //Getting Flujos
        $result = $this->armarDependencia();
        print_r($result);
        //Getting Controles        
    }
    
    private function getFlujos($ProyectoId){
        $fields = array(
            'proceso.id as proceso_id',
            'proceso.nombre as proceso_nombre',
            'procesoflujo.id as procesoflujo_id',
            'procesoflujo.nombre as procesoflujo_nombre'            
        );
        
        $this->db->select($fields);
        $this->db->from('proceso');
        $this->db->join('proceso.id = procesoflujo.procesoid','left');        
        $this->db->where('proyectoid',$ProyectoId);
        $res = $this->db->get();
        $this->ProcesoFlujo = $res->result_array();
    }
    
    private function getControles($ProyectoId){
        $fields = array(
            'proceso.id as proceso_id',
            'proceso.nombre as proceso_nombre',
            'procesocontrol.id as procesocontrol_id',
            'procesocontrol.nombre as procesocontrol_nombre'
        );
        
        $this->db->select($fields);
        $this->db->from('proceso');
        $this->db->join('proceso.id = procesoflujo.procesoid','left');
        $this->db->where('proyectoid',$ProyectoId);
        $res = $this->db->get();
        $this->ProcesoControl = $res->result_array();
    }
    
    private function armarDependencia(){
        
       foreach($this->Proceso as $row => $key){
           $this->Proceso[$key]['Flujos'] = 0;
           $this->Proceso[$key]['Controles'] = 0;
       }
    }
    
    private function getProcesoFlujo($ProcesoId){
        $flujos = array();
        
    }
    
    private function getProcesoControl(){
        
    }
}
