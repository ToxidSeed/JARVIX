<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainEntrega.php';

class Entrega extends BaseController{
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('EntregaView.php');
        $this->load->view('Base/Footer.php');
    }
    public function wrt(){
        try{
            $this->load->model('Bussiness/EntregaBO','EntregaBO');
            $dmnEntrega = new DomainEntrega($this->getField('Id'));
            $dmnEntrega->setProyecto(new DomainProyecto($this->getField('ProyectoId')));
            $dmnEntrega->setNombre($this->getField('Entrega'));
            $dmnEntrega->setFecha($this->getField('Fecha'));
            $this->EntregaBO->wrt($dmnEntrega);
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Registrado Correctamente');
            $this->getAnswer()->setCode(0);
            $this->getAnswer()->addExtraData('EntregaId',$dmnEntrega->getId());
            echo $this->getAnswer()->getAsJSON(); 
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    public function search(){
        $this->load->model('Mapper/Finders/Entrega/EntregaFRM1','EntregaFRM1');
        $response = $this->EntregaFRM1->search(array(
           'ProyectoId'=>$this->getField('ProyectoId')
        ));
        echo json_encode(Response::asResults($response));
    }
    
    public function find(){
        $this->load->model('Mapper/EntregaMapper','EntregaMapper');
        $dmnEntrega = $this->EntregaMapper->find($this->getField('EntregaId'));
        $dmnEntrega->mapper()->getProyecto();
        echo json_encode(Response::asSingleObject($dmnEntrega));
    }
}