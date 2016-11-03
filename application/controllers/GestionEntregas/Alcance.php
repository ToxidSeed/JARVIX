<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainTipoAlcance.php';
require_once DOMAINPATH.'DomainAlcance.php';
require_once DOMAINPATH.'DomainEntrega.php';
require_once DOMAINPATH.'DomainProceso.php';
require_once DOMAINPATH.'DomainProcesoFlujo.php';
require_once DOMAINPATH.'DomainProcesoControl.php';


class Alcance extends BaseController{
    function __construct() {
        parent::__construct();
    }
    
    private $Procesos = array();
    private $Flujos = array();
    private $Controles = array();
    
    function search(){
        $this->load->model('Mapper/Finders/Alcance/AlcanceFRM1','AlcanceFRM1');
        $this->AlcanceFRM1->search(array(
            'parProyectoId' => $this->getField('ProyectoId')
        ));
        
        $this->Procesos = $this->AlcanceFRM1->getProcesos();
        $this->Flujos = $this->AlcanceFRM1->getFlujos();
        $this->Controles = $this->AlcanceFRM1->getControles();    

        //print_r($results);
        echo json_encode($this->makeStructure());
    }

//    private function makeTree    
    private function makeStructure(){
        $JSONTreeData = array(
          'text' => '.',
          'nombre' => ".",
          'expanded' => true,
          'checked' => false,
          'children' => array()
        );
        foreach($this->Procesos as $key => $row){
            $JSONTreeData['children'][] = array(
                "AlcanceId" =>  $row['id'],
                "nombre" => $row['nombre'],
                'checked' => false,
                "iconCls" => "icon-list_packages",
                "expanded" => "true",
                "tipo" => "PROCESO",
                "children" => $this->getNodes($row['id'])
            );
        }
        return $JSONTreeData;
    }
    //
    private function getNodes($parProcesoId){
        $varNodes = array();            
        $this->addNodeFlujos(&$varNodes,$parProcesoId);        
        $this->addNodeControles(&$varNodes,$parProcesoId);
        return $varNodes;
    }
    //
    private function addNodeFlujos(&$varNodes,$parProcesoId){
        $node = array(
            'nombre'  => "Flujos",
            'iconCls' => "icon-proceso_flujo",
            'expanded' => true,
            'checked' => false,
            'tipo' => 'CNT',
            "children" => array()
        );
        
        foreach($this->Flujos as $key => $row){
            if($parProcesoId == $row['proceso_id']){
                $node['children'] = array(
                     "nombre" => $row["procesoflujo_nombre"],
                    'checked' => false,
                    'AlcanceId' => $row["procesoflujo_id"],
                    'tipo' => 'FLUJO',
                    "leaf"  => "true"
                );    
                unset($this->Flujos[$key]);
            }
        }
        (count($node['children'])==0)?array():$varNodes[]=$node;
    }    
    //
    private function addNodeControles(&$varNodes,$parProcesoId){
        $node = array(
            "nombre" => "Controles",
            "iconCls" => "icon-proceso_control",
            'expanded' => true,
            'checked' => false,
            'tipo' => 'CNT',
            "children" => array()
          );
        
        foreach($this->Controles as $key => $row){
            if($parProcesoId == $row['proceso_id']){
                $node['children'] = array(
                     "nombre" => $row["procesocontrol_nombre"],
                    'checked' => false,
                    'AlcanceId' => $row["procesocontrol_id"],
                    'tipo' => 'CONTROL',
                    "leaf"  => "true"
                );              
                unset($this->Controles[$key]);
            }
        }
        (count($node['children'])==0)?array():$varNodes[]=$node;
    }
    public function Add(){
        $inputArrAlcance = json_decode($this->getField('Alcance'),true);
        $arrDmnAlcance = array();
        $dmnEntrega = new DomainEntrega($this->getField('EntregaId'));
        foreach($inputArrAlcance as $row){            
            $dmnAlcance = new DomainAlcance();
            $dmnAlcance->setEntrega($dmnEntrega);            
            $dmnAlcance->setTipo(new DomainTipoAlcance($row['tipo']));
            $dmnAlcance->setItem($item);
            $arrDmnAlcance[] = $dmnAlcance;
        }                        
        //
    }
}
