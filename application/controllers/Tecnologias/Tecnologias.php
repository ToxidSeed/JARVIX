<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
require_once BASEMODELPATH.'Constraints.php';
require_once DOMAINPATH.'DomainTecnologia.php';
require_once DOMAINPATH.'DomainEstado.php';
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
            $this->load->model('Bussiness/TecnologiaBO','TecnologiaBO');
            $this->TecnologiaBO->setDomain($dmnTecnologia);
            $this->TecnologiaBO->add();
            
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Registrado Correctamente');
            $this->getAnswer()->setCode(0);
            $this->getAnswer()->AddExtraData('TecnologiaId',$dmnTecnologia->getId());
            echo $this->getAnswer()->getAsJSON(); 
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    public function getList(){
        $this->load->model('Mapper/Finders/Tecnologia/TecnologiaFRM1','TecnologiaFRM1');
        $response = $this->TecnologiaFRM1->search(array(
            'Nombre' => $this->getField('Nombre')
        ));
        echo json_encode(Response::asResults($response));        
    }
}