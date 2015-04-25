<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'ProcesoFlujoMapper.php';
require_once MAPPERPATH.'PasoFlujoMapper.php';


class ProcesoFlujoAddBO extends BaseBO{
    public function __construct() {        
        parent::__construct();
        $this->mprProcesoFlujoMapper = new ProcesoFlujoMapper();
    }
    protected $Steps;
    protected $currentSteps;
    protected $StepsToUpdate;
    protected $mprPasoFlujo;
    protected $newSteps;
    protected $mprProcesoFlujoMapper;
    public function getSteps() {
        return $this->Steps;
    }

    public function setSteps($Steps) {
        $this->Steps = $Steps;
    }
    public function getCurrentSteps() {
        return $this->currentSteps;
    }

    public function setCurrentSteps($currentSteps) {
        $this->currentSteps = $currentSteps;
    }    
          
    public function add(){
        try{
              $this->load->database();
              $this->db->trans_start();
              //
              
              

              
              //Insertando la cabecera o el Nombre del FLujo
              $mprProcesoFlujoMapper = new ProcesoFlujoMapper();
              $dmnProcesoFlujoMapper = $this->getDomain();
              $mprProcesoFlujoMapper->insert($dmnProcesoFlujoMapper); 
              
             
              //
              $this->db->trans_commit();
          }catch(Exception $ex){
              $this->db->trans_rollback();
              throw new Exception($ex->getMessage(),$ex->getCode());   
          }
    }
    
//    protected function AddNewSteps(){     
//        $this->getNewSteps();
//        foreach($this->newSteps as $myStep ){
//            $this->mprPasoFlujo->insert($myStep);
//        }
//    }    
//    
//    protected function getNewSteps(){
//        $this->newSteps = $this->Steps;
//    }
    
    Private function AddNonRelatedSteps(){
        foreach($this->Steps as $dmnStep){
            if($dmnStep->getPasoFlujoReferencia() == null){
                $this->mprPasoFlujo->insert($dmnStep);
            }    
        }
    }
    Private Function AddRelatedSteps(){        
        foreach($this->Steps as $dmnStep){
//            var_dump($dmnStep->getPasoFlujoReferencia());
            if($dmnStep->getPasoFlujoReferencia() != null && $dmnStep->getPasoFlujoReferencia()->getId() == null ){
                
                //Obtener el Paso Insertado
                $dmnRelatedStep = $dmnStep->getPasoFlujoReferencia();
                $this->mprPasoFlujo->addUnique('NumeroPaso',$dmnRelatedStep->getNumeroPaso());
                $this->mprPasoFlujo->addUnique('NumeroFlujo',$dmnRelatedStep->getNumeroFlujo());
                $this->mprPasoFlujo->addUnique('TipoFlujoId',$dmnRelatedStep->getTipoFlujo()->getId());                                
                $dmnUnique = $this->mprPasoFlujo->findByUnique();                
                $dmnRelatedStep->setId($dmnUnique->getId());
                $this->mprPasoFlujo->insert($dmnStep);
            }
        }
    }
   
    
}