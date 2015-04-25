<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'PasoFlujoMapper.php';
require_once FINDERPATH.'PasoFlujo/FinderFlujos.php';
require_once FINDERPATH.'PasoFlujo/FinderPasosPorFlujos.php';



class PasoFlujoAlternativoAddBO extends BaseBO{
	function __construct(){
		parent::__construct();
		$this->mprPasoFlujoMapper = new PasoFlujoMapper();
    $this->FinderFlujos = new FinderFlujos();
    $this->FinderPasosPorFlujos = new FinderPasosPorFlujos();
	}
  private $mprPasoFlujoMapper; 
  private $FinderFlujos;
  private $responseWorkFlows;
  private $reenumerar = false;
  private $workFlowsToReenum;
  private $stepsToReenum = array();

  const DEFAULTWORKFLOWNUMBER = 1; //Numero de flujo por defecto cuando no se encuentra registros para un tipo determinado
  const DEFAULTSTEPNUMBER = 1; //Numero de Paso por defecto cuando no se encuentra ningun registro para un tipo determinado
  const ALTERNATIVEWORKFLOWID = 2; //Identificador del flujo alternativo

  //Pendientes
  //Falta determinar, si es el primer paso que se agrega para el proceso
  //En Caso sea el primer paso para el proceso, es necesario que los valores sean los siguientes
  //1.- Tipo de Flujo: Flujo Principal; este dato es obtenido como parametro
  //2.- Numero de Flujo: 1; Se envia como parametro y es el Numero de Flujo de la ultima fila seleccionada
  //3.- Numero de Paso: 1; Se envia desde la web y es el Numero de paso que se envia desde la web
  //4.- Paso de Referencia: Se Envia como parametro desde la web.
	public function add(){
		try{
              $this->load->database();
              $this->db->trans_start();
              
              $this->getInformationWorkFlowAlternative();
              
              if($this->reenumerar == true){
                  $this->reenumFlujos();
              }

              $this->mprPasoFlujoMapper->insert($this->domain);           
              //
              $this->db->trans_commit();
          }catch(Exception $ex){
              $this->db->trans_rollback();
              throw new Exception($ex->getMessage(),$ex->getCode());   
          }	
	}

  public function getInformationWorkFlowAlternative(){
    /*
            Escenario 1: 
                1.- Obtener la lista de flujos alternativos
                2.- Si no existe ningun flujo alternativo, los valores quedarian de la siguiente manera
                    Numero de Flujo = 1
                    Numero de Paso = 1
            Escenario 2:
                1.- Si existe algun flujo alternativo, se debera realizar lo siguiente:
                    1.- Obtener los flujos alternativos, incluyendo los siguientes valores
                      - Numero de Flujo
                      - Paso de Referencia                      
                    2.- Verificar si es que el paso de referencia es mayor al de todos los pasos obtenidos,
                      de ser esto asi, entonces hay que obtener el numero de Flujo maximo y a este agregarle 1
                      quedando de la siguiente manera
                      - Numero de Flujo = Maximo Numero de Flujo de los flujos alternativos + 1
                      - Numero de Paso = 1
                    3.- Si es que el paso de referencia es menor al de todos los pasos de referencia, entonces
                      los valores quedarian de la sigueinte manera:
                        - Numero de Flujo 1
                        - Numero de Paso = 1
                        - Se tendra que reenumerar los otros flujos, a todos se les aplicaria un valor adicional,
                        quedando de la siguiente manera                                                 
                        - Numero de Flujo = Numero de Flujo Actual + 1
                    4.- Si es que el paso de referencia se encuentra en el medio de los flujos obtenidos, se tendra que
                      reenumerar los flujos de la siguiente manera:
                        - Reenumerar todos los flujos alternativos cuyo paso de referencia sea mayor al flujo de referencia que
                        se esta agregando.
                    5.- Si es que el paso de referencia que se esta intentando agregar coincide con uno de los pasos de referencia obtenidos,
                      Se tendria que realizar lo siguiente
                        5.1.- Obtener los Flujos de referencia para aquellos pasos de referencia iguales
                        5.2.- Obtener el mayor Numero de flujo
                        5.3.- El Numero de Flujo = mayor numero de flujo + 1
                        5.4.- Reenumerar los flujos a partir del mayor Numero de Flujo insertado 
    */
    

    //Case 1
    if($this->getInformationFromCase1() == true){
        return;
    }

    //Case 2
    if($this->getInformationFromCase2() == true){
        return;
    }

    //Case 3
    if($this->getInformationFromCase3() == true){
        return;
    }

    //Case 4
    if($this->getInformationFromCase4() == true){
        return;
    }



  }
    //1.- Obtener la lista de flujos alternativos
    //           2.- Si no existe ningun flujo alternativo, los valores quedarian de la siguiente manera
    //                Numero de Flujo = 1
    //                Numero de Paso = 1
  private function getInformationFromCase1(){
      $dmnProcesoFlujo = $this->domain->getProcesoFlujo();
      $dmnTipoFlujo = $this->domain->getTipoFlujo();

      //Escenario 1
      $this->responseWorkFlows = $this->FinderFlujos->search($dmnProcesoFlujo->getId(),$dmnTipoFlujo->getId());                   
      
      
      
      if ($this->responseWorkFlows->getCount() == 0){          
          $this->domain->setNumeroFlujo(self::DEFAULTWORKFLOWNUMBER);
          $this->domain->setNumeroPaso(self::DEFAULTSTEPNUMBER);
          return true;
      }
      return false;
  }
  //Revisa si es que el paso que se esta intentando insertar es mayor a todos los pasos de referencia ya insertados
  //para este tipo de flujo
  private function getInformationFromCase2(){
      $dmnPasoReferencia = $this->domain->mapper()->getPasoFlujoReferencia();



      $numeroPasoReferencia = $dmnPasoReferencia->getNumeroPaso();
      $steps = $this->responseWorkFlows->getResults();
      $dmnMaxPasoFlujo = end($steps);
      if($dmnMaxPasoFlujo->getPasoFlujoReferencia() < $numeroPasoReferencia){
          $this->domain->setNumeroFlujo($dmnMaxPasoFlujo->getNumeroFlujo() + 1);
          $this->domain->setNumeroPaso(self::DEFAULTSTEPNUMBER);
          return true;
      }
      return false;
  }

  /*
  3.- Si es que el paso de referencia es menor al de todos los pasos de referencia, entonces
                      los valores quedarian de la sigueinte manera:
                        - Numero de Flujo 1
                        - Numero de Paso = 1
                        - Se tendra que reenumerar los otros flujos, a todos se les aplicaria un valor adicional,
                        quedando de la siguiente manera                                                 
                        - Numero de Flujo = Numero de Flujo Actual + 1
  */

  private function getInformationFromCase3(){
      $dmnPasoReferencia = $this->domain->mapper()->getPasoFlujoReferencia();
                  
      $numeroPasoReferencia = $dmnPasoReferencia->getNumeroPaso();

      $steps = $this->responseWorkFlows->getResults();
      $dmnMinPasoFlujo = reset($steps);
         
      if($dmnMinPasoFlujo->mapper()->getPasoFlujoReferencia()->getNumeroPaso() > $numeroPasoReferencia){
          $this->domain->setNumeroFlujo(self::DEFAULTWORKFLOWNUMBER);
          $this->domain->setNumeroPaso(self::DEFAULTSTEPNUMBER);
          $this->reenumerar = true;
          $this->workFlowsToReenum = $steps;
          return true;
      }
      return false;
  }

  /*Verificar si es que el paso de referencia que se esta agregando, ya existe dentro de los flujos alternativos*/
  private function getInformationFromCase4(){
      $dmnPasoReferencia = $this->domain->getPasoFlujoReferencia();
      $numeroPasoReferencia = $dmnPasoReferencia->getNumeroPaso();
      $steps = $this->responseWorkFlows->getResults();
      $finded = false;

      foreach($steps as $dmnPasoFlujo){
          $dmnPasoFlujoReferencia = $dmnPasoFlujo->getPasoFlujoReferencia();
          if($dmnPasoFlujoReferencia->getNumeroPaso() == $numeroPasoReferencia){
              $finded = true;
          }elseif( $dmnPasoFlujoReferencia->getNumeroPaso() != $numeroPasoReferencia && $finded == true){
              $this->reenumerar = true;
              $this->workFlowsToReenum[] = $dmnPasoFlujo;
          }
      }     
      return $finded;       
  }
  /*
    Metodo para reenumerar los flujos de los pasos
  */
  private function reenumFlujos(){      
      foreach($this->workFlowsToReenum as $dmnPasoFlujo){
          $dmnProcesoFlujo = $dmnPasoFlujo->getProcesoFlujo();  
          
          $dmnTipoFlujo = $dmnPasoFlujo->getTipoFlujo();
          $numeroFlujo = $dmnPasoFlujo->getNumeroFlujo();       
                    
          $responseSteps = $this->FinderPasosPorFlujos->search($dmnProcesoFlujo->getId(),$dmnTipoFlujo->getId(),$numeroFlujo);                    
          $this->reenumPasos($responseSteps->getResults());          
      }            
      $this->updateReenumeredSteps();
  }

  private function reenumPasos(array $steps = null){      
        
      foreach($steps as $dmnPasoFlujo){                      
          $dmnPasoFlujo->setNumeroFlujo($dmnPasoFlujo->getNumeroFlujo() + 1);                                 
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