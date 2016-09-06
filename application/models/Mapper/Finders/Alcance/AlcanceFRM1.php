<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AlcanceFRM1 extends ProcesoMapper{
    public function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
       'proceso.id',
        'proceso.nombre'
    );
    
    private $results = array();
    
    function search($filters){
        $this->db->select($this->fields);
        $this->db->from('proceso');
        $this->db->where('proyectoid',$filters['ProyectoId']);
        $res  = $this->db->get();        
    }
    
    private function getFlujos($ProyectoId){
        $fields = array(
            'procesoflujo.id',
            'procesoflujo.nombre'
        );
        
        $this->db->select()
    }
    
    private function getControles($ProyectoId){
        $fields = array(
            'procesocontrol.id',
            'procesoflujo.nombre'
        );
    }
}
