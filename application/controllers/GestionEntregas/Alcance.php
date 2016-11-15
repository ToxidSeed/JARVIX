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

    const __TIPO_PROCESO = 1;
    const __TIPO_PROCESO_FLUJO = 2;
    const __TIPO_PROCESO_CONTROL = 3;

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
                "tipo" => "1",
                "children" => $this->getNodes($row['id'])
            );
        }
        //print_r($this->Procesos);
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
                    'tipo' => '2',
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
                    'tipo' => '3',
                    "leaf"  => "true"
                );
                unset($this->Controles[$key]);
            }
        }
        (count($node['children'])==0)?array():$varNodes[]=$node;
    }
    public function Add(){
      try{
        $inputArrAlcance = json_decode($this->getField('Alcance'),true);
        $arrDmnAlcance = array();
        $dmnEntrega = new DomainEntrega($this->getField('EntregaId'));
        foreach($inputArrAlcance as $row){
            $dmnAlcance = new DomainAlcance();
            $dmnAlcance->setEntrega($dmnEntrega);
            $dmnAlcance->setTipo(new DomainTipoAlcance($row['tipo']));
            $this->setItem($dmnAlcance,$row['AlcanceId']);
            $arrDmnAlcance[] = $dmnAlcance;
        }
        //print_r($arrDmnAlcance);
        $this->load->model('Bussiness/AlcanceBO','AlcanceBO');
        $this->AlcanceBO->Add($arrDmnAlcance);
        $this->getAnswer()->setSuccess(true);
        $this->getAnswer()->setMessage('Registrado Correctamente');
        $this->getAnswer()->setCode(0);
        echo $this->getAnswer()->getAsJSON();
      }catch (Exception $ex) {
          if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
              echo $this->getAnswer()->getAsJSON();
          }else{
              echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
          }
      }
    }

    private function setItem(DomainAlcance $dmnAlcance,$parAlcanceId){
        switch($dmnAlcance->getTipo()->getId()){
            case self::__TIPO_PROCESO:
                $dmnAlcance->setItem(new DomainProceso($parAlcanceId));
                break;
            case self::__TIPO_PROCESO_FLUJO:
                $dmnAlcance->setItem(new DomainProcesoFlujo($parAlcanceId));
                break;
            case self::__TIPO_PROCESO_CONTROL:
                $dmnAlcance->setItem(new DomainProcesoControl($parAlcanceId));
                break;
        }
    }
    public function SearchAsignados(){
      $this->load->model('Mapper/Finders/Alcance/AlcanceFRM2','AlcanceFRM2');
      $this->AlcanceFRM2->search(array(
          'parEntregaId' => $this->getField('EntregaId')
      ));

      $this->Procesos = $this->AlcanceFRM2->getProcesos();
      //print_r($this->Procesos);
      $this->Flujos = $this->AlcanceFRM2->getFlujos();
      //print_r($this->Flujos);
      $this->Controles = $this->AlcanceFRM2->getControles();
      //print_r($this->Controles);

      //print_r($results);
      echo json_encode($this->makeStructure());
    }
}
