<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
require_once BASEMODELPATH.'Constraints.php';
require_once DOMAINPATH.'DomainPropiedad.php';
/*
/**
 * Description of Tecnologias
 *
 * @author usuario
 */
class Tecnologias extends BaseController{
    //put your code here    
     public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('TecnologiasView.php');
        $this->load->view('Base/Footer.php');
    }
    
    const STATUS_ACTIVO = 1;
    
    public function add(){
        try{
            $dmnTecnologia = new DomainTecnologia();
            $dmnTecnologia->setNombre($this->getField('Nombre'));
            $dmnTecnologia->setEstado(new DomainEstado(self::STATUS_ACTIVO));
            $this->load->model('Mapper/TecnologiaMapper','TecnologiaMapper');
            $this->TecnologiaMapper->insert($dmnTecnologia);
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
}