<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainFormato.php';


class GestionFormatos extends BaseController{
    function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->view('Base/Header.php');
        $this->load->view('GestionFormatosView.php');
        $this->load->view('Base/Footer.php');
    }
    
    public function add(){
        try{
            $this->formValidation(__CLASS__, '',__FUNCTION__);
            
            $dmnFormato = new DomainFormato();
            $dmnFormato->setTipoDato($this->getField('TipoDato'));                        
            $dmnFormato->setFlgPermiteTamano($this->getField('flgPermiteTamano'));           
            $dmnFormato->setFlgPermitePrecision($this->getField('flgPermitePrecision'));
            $dmnFormato->setFlgPermiteMascara($this->getField('flgPermiteMascara'));
            $dmnFormato->setFlgPermiteMayusculas($this->getField('flgPermiteMayusculas'));
            $dmnFormato->setFlgPermiteMinusculas($this->getField('flgPermiteMinusculas'));            
            $dmnFormato->setFlgPermiteDetalle($this->getField('flgPermiteDetalle'));
            $dmnFormato->setFechaRegistro(date(APPDATESTNFORMAT));
            $dmnFormato->setFechaUltAct(date(APPDATESTNFORMAT));
            
            
            
            $this->load->model('Bussiness/FormatoBO','FormatoBO');
            $this->FormatoBO->setDomain($dmnFormato);
            $this->FormatoBO->add();
            echo Answer::setSuccessMessage('Se guardo correctamente Formato Para el Tipo de Dato: '.$dmnFormato->getTipoDato());                        
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    public function update(){
        try{
            $this->formValidation(__CLASS__, '',__FUNCTION__);
            
            $dmnFormato = new DomainFormato($this->getField('id'));
            $dmnFormato->setTipoDato($this->getField('TipoDato'));                        
            $dmnFormato->setFlgPermiteTamano($this->getField('flgPermiteTamano'));           
            $dmnFormato->setFlgPermitePrecision($this->getField('flgPermitePrecision'));
            $dmnFormato->setFlgPermiteMascara($this->getField('flgPermiteMascara'));
            $dmnFormato->setFlgPermiteMayusculas($this->getField('flgPermiteMayusculas'));
            $dmnFormato->setFlgPermiteMinusculas($this->getField('flgPermiteMinusculas'));            
            $dmnFormato->setFlgPermiteDetalle($this->getField('flgPermiteDetalle'));
            $dmnFormato->setFechaRegistro(date(APPDATESTNFORMAT));
            $dmnFormato->setFechaUltAct(date(APPDATESTNFORMAT));
            
            
            
            $this->load->model('Bussiness/FormatoBO','FormatoBO');
            $this->FormatoBO->setDomain($dmnFormato);
            $this->FormatoBO->update();
            echo Answer::setSuccessMessage('Se guardo correctamente Formato Para el Tipo de Dato: '.$dmnFormato->getTipoDato());                        
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){                
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }
    
    public function GetList(){
        $this->load->model('Mapper/FormatoMapper','FormatoMapper');
        $response = $this->FormatoMapper->search(); 
        foreach($response->getResults() as $dmnFormato){            
            if($dmnFormato->getFlgPermiteTamano() == 0){
                $dmnFormato->setFlgPermiteTamano(null);                
            }  
            if($dmnFormato->getFlgPermitePrecision()==0){
                $dmnFormato->setFlgPermitePrecision(null);
            }
            if($dmnFormato->getFlgPermiteMascara() == 0){
                $dmnFormato->setFlgPermiteMascara(null);
            }
            if($dmnFormato->getFlgPermiteMayusculas() == 0){
                $dmnFormato->setFlgPermiteMayusculas(null);
            }
            if($dmnFormato->getFlgPermiteMinusculas() == 0){
                $dmnFormato->setFlgPermiteMinusculas(null);
            }
            if($dmnFormato->getFlgPermiteDetalle() == 0){
                $dmnFormato->setFlgPermiteDetalle(null);
            }
        }
        echo json_encode(Response::asResults($response));
    }
    
    public function find(){
        try{
            $this->load->model('Mapper/FormatoMapper','FormatoMapper');
            $dmnFormato = $this->FormatoMapper->find($this->getField('id'));
            echo json_encode(Response::asSingleObject($dmnFormato));
        } catch (Exception $ex) {
            echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
        }
    }
    
 
    
    
}
