<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'PasoFlujoMapper.php';
require_once FINDERPATH.'PasoFlujo/FinderFlujos.php';
require_once FINDERPATH.'PasoFlujo/FinderPasosPorFlujos.php';



class PasoFlujoUpdateBO extends BaseBO{
	function __construct(){
		parent::__construct();
		$this->mprPasoFlujoMapper = new PasoFlujoMapper();
    $this->FinderFlujos = new FinderFlujos();
    $this->FinderPasosPorFlujos = new FinderPasosPorFlujos();
	}  

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
	public function update(){
		try{
              $this->load->database();
              $this->db->trans_start();           
              
              $dmnCurrentStep = $this->mprPasoFlujoMapper->find($this->domain->getId());  
              $dmnCurrentStep->setDescripcion($this->domain->getDescripcion());
              $this->mprPasoFlujoMapper->update($dmnCurrentStep);
              $this->db->trans_commit();
          }catch(Exception $ex){
              $this->db->trans_rollback();
              throw new Exception($ex->getMessage(),$ex->getCode());   
          }	
	}
}
