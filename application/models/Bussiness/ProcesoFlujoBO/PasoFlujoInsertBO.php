<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'PasoFlujoMapper.php';
require_once FINDERPATH.'PasoFlujo/FinderFlujos.php';
require_once FINDERPATH.'PasoFlujo/FinderPasosPorFlujos.php';



class PasoFlujoInsertBO extends BaseBO{
    function __construct(){
        parent::__construct();
        $this->mprPasoFlujoMapper = new PasoFlujoMapper();
        $this->FinderFlujos = new FinderFlujos();
        $this->FinderPasosPorFlujos = new FinderPasosPorFlujos();        
    }  

    const DEFAULTWORKFLOWNUMBER = 1; //Numero de flujo por defecto cuando no se encuentra registros para un tipo determinado
    const DEFAULTSTEPNUMBER = 1; //Numero de Paso por defecto cuando no se encuentra ningun registro para un tipo determinado
    const ALTERNATIVEWORKFLOWID = 2; //Identificador del flujo alternativo

    
    private $stepsToReenum = array();
    
    //Pendientes
    //Falta determinar, si es el primer paso que se agrega para el proceso
    //En Caso sea el primer paso para el proceso, es necesario que los valores sean los siguientes
    //1.- Tipo de Flujo: Flujo Principal; este dato es obtenido como parametro
    //2.- Numero de Flujo: 1; Se envia como parametro y es el Numero de Flujo de la ultima fila seleccionada
    //3.- Numero de Paso: 1; Se envia desde la web y es el Numero de paso que se envia desde la web
    //4.- Paso de Referencia: Se Envia como parametro desde la web.
	public function insert(){
            try{
              $this->load->database();
              $this->db->trans_start();           
              
              $this->FindFlujosToReenum();
              $this->reenumPasos();
              
//              print_r($this->stepsToReenum);
//              print_r($this->domain);
              $this->updateReenumeredSteps();
              $this->domain->setNumeroPaso($this->domain->getNumeroPaso() + 1);
              $this->mprPasoFlujoMapper->insert($this->domain);           
              //
              $this->db->trans_commit();
            }catch(Exception $ex){
                $this->db->trans_rollback();
                throw new Exception($ex->getMessage(),$ex->getCode());   
            }	
	}
        
        //$responseSteps = $this->FinderPasosPorFlujos->search($dmnProcesoFlujo->getId(),$dmnTipoFlujo->getId(),$numeroFlujo);                    
        
        
         /*
    Metodo para reenumerar los flujos de los pasos
  */
  private function FindFlujosToReenum(){   
      $dmnProcesoFlujo = $this->domain->getProcesoFlujo();
      $dmnTipoFlujo = $this->domain->getTipoFlujo();
      $numeroFlujo = $this->domain->getNumeroFlujo();
      
      $responseSteps = $this->FinderPasosPorFlujos->search($dmnProcesoFlujo->getId(),$dmnTipoFlujo->getId(),$numeroFlujo);                    
      
      $finded = false;
      
      foreach($responseSteps->getResults() as $dmnPasoFlujo){
          if($this->domain->getNumeroPaso() == $dmnPasoFlujo->getNumeroPaso()){              
              $finded = true;
          }elseif($finded == true){
              $this->stepsToReenum[] = $dmnPasoFlujo;
          }
      }     
  }

  private function reenumPasos(){      
        
      foreach($this->stepsToReenum as $dmnPasoFlujo){                      
          $dmnPasoFlujo->setNumeroPaso($dmnPasoFlujo->getNumeroPaso() + 1);                                 
          $this->stepsToReenum[] = $dmnPasoFlujo;
      }
  }
  private function updateReenumeredSteps(){
      if(count($this->stepsToReenum ) > 0){
          foreach($this->stepsToReenum as $dmnPasoFlujo){
                $this->mprPasoFlujoMapper->update($dmnPasoFlujo); 
          }
      }
       
  }
}
