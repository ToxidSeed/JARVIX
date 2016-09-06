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

    private $Procesos = array();
    private $ProcesoFlujos = array();
    private $ProcesoControls = array();

    //private $results = array();

    function search($filters){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from('proceso');
        $this->db->where('proyectoid',$filters['ProyectoId']);
        $res  = $this->db->get();
        //echo $this->db->last_query();
        $this->Procesos = $res->result_array();
        //Getting Flujos
        $this->getFlujos($filters['ProyectoId']);
        //Getting Controles
        $this->getControles($filters['ProyectoId']);
        //build dependency
        $this->armarDependencia();
        //devolver resultados
        return $this->Procesos;
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
        $this->db->join('procesoflujo','proceso.id = procesoflujo.procesoid');
        $this->db->where('proyectoid',$ProyectoId);
        $res = $this->db->get();
        $this->ProcesoFlujos = $res->result_array();
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
        $this->db->join('procesocontrol','proceso.id = procesocontrol.procesoid');
        $this->db->where('proyectoid',$ProyectoId);
        $res = $this->db->get();
        //echo $this->db->last_query();
        $this->ProcesoControls = $res->result_array();
        //print_r($this->ProcesoControl);
    }

    private function armarDependencia(){
        //print_r($this->Proceso);
       foreach($this->Procesos as $key => $row){
           $this->Procesos[$key]['Flujos'] = $this->getFlujoPorProceso($row['id']);
           $this->Procesos[$key]['Controles'] = $this->getControlPorProceso($row['id']);
       }
    }

    private function getFlujoPorProceso($ProcesoId){
        $flujos = array();

        foreach($this->ProcesoFlujos as $key => $row){
            if($this->ProcesoFlujos[$key]['proceso_id'] === $ProcesoId  ){
                $flujos[] = $row;
            }
        }
        return $flujos;
    }

    private function getControlPorProceso($ProcesoId){
        $controles = array();

        foreach($this->ProcesoControls as $key => $row){
            if($this->ProcesoControls[$key]['proceso_id'] === $ProcesoId){
                $controles[] = $row;
            }
        }

        return $controles;
    }
}
