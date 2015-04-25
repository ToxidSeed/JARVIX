<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once BUSSINESSPATH.'ProcesoFlujoBO/ProcesoFlujoAddBO.php';
require_once FINDERPATH.'PasoFlujo/FinderPasoFlujo.php';

class ProcesoFlujoUpdateBO extends ProcesoFlujoAddBO{
    public function __construct() {
        parent::__construct();    
        $this->finderPasoFlujo = new FinderPasoFlujo();        
    }
    protected $finderPasoFlujo;
    
    public function update(){
        try{
              $this->load->database();
              $this->db->trans_start();
              
              $this->mprProcesoFlujoMapper->update($this->getDomain());
              
              //Borrar los pasos que ya no se envian(Se entiende que se han quitado del flujo)
              $this->deleteSteps();
                                      
              //Guardamos los pasos Nuevos
              $this->AddNewSteps();
              
              //Actualizamos los pasos que ya existen
              $this->updateSteps();
                      
              $this->db->trans_commit();
        }catch(Exception $ex){
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    private function deleteSteps(){       
       $this->currentSteps = $this->finderPasoFlujo->Search($this->getDomain()->getId());
       foreach($this->currentSteps as $dmnPasoFlujoActual){
           if ($this->getStepToDelete($dmnPasoFlujoActual) == true){
               $this->mprPasoFlujo->delete($dmnPasoFlujoActual);
           }                          
       }
   }
   
   private function getStepToDelete(DomainPasoFlujo $dmnStep ){       
       foreach($this->Steps as $dmnPasoFlujoNuevo){
               if ($dmnStep->getId() == $dmnPasoFlujoNuevo->getId()){
                   return false;
               }
       }
       return true;
   }  
   /*
    * Metodo que es utilizado para obtener los pasos que son nuevos
    */
   protected function getNewSteps(){
       foreach($this->Steps as $dmnPasoFlujo){
           if($dmnPasoFlujo->getId() == null){
               $this->newSteps[] = $dmnPasoFlujo;
           }
       }       
   }
   
   private function updateSteps(){
       foreach($this->Steps as $dmnPasoActualizar){
           if($this->getStepToUpdate($dmnStep) == true){
               $this->mprPasoFlujo->update($dmnStep);
           }
       }
   }
   
   private function getStepToUpdate(DomainPasoFlujo $dmnStep){
       foreach($this->currentSteps as $dmnPasoFlujoActual){
               if ($dmnStep->getId() == $dmnPasoFlujoActual->getId()){
                   return true;
               }
       }
       return false;
   }
}

?>
