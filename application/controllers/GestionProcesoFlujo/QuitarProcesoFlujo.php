<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASECONTROLLERPATH.'BaseController.php';
require_once DOMAINPATH.'DomainProcesoFlujo.php';
require_once DOMAINPATH.'DomainProceso.php';
require_once DOMAINPATH.'DomainPasoFlujo.php';
require_once DOMAINPATH.'DomainTipoFlujo.php';
require_once DOMAINPATH.'DomainEstadoProcesoFlujo.php';

class QuitarProcesoFlujo extends BaseController{
	function __construct(){
		parent::__construct();
	}
        
        const STATUS_ELIMINADO = -1;
        
        public function Quitar(){
            try{                        
                $this->load->model('Bussiness/ProcesoFlujoBO/QuitarProcesoFlujoBO','QuitarProcesoFlujoBO');
                $this->QuitarProcesoFlujoBO->records = $this->getData();
                $this->QuitarProcesoFlujoBO->Quitar();
                $this->getAnswer()->setSuccess(true);
                $this->getAnswer()->setMessage('Actualizado Correctamente');
                $this->getAnswer()->setCode(0);
                echo $this->getAnswer()->getAsJSON();             
            } catch (Exception $ex) {
                if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                    echo $this->getAnswer()->getAsJSON();
                }else{
                    echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
                }
            }
        }
        public function getData(){
            $FlujosEliminar = $this->getField('flujosEliminar');
            $myFlujos = json_decode($FlujosEliminar,true);
            return $this->makeObjects($myFlujos);            
        }
        
        public function makeObjects(array $flujos = null){
            $localFlujos = array();
            foreach($flujos as $row){
                $dmnProcesoFlujo = new DomainProcesoFlujo($row['id']);
                $dmnProcesoFlujo->setNombre($row['nombre']);
                $dmnProcesoFlujo->setEstadoProcesoFlujo(new DomainEstadoProcesoFlujo(self::STATUS_ELIMINADO));
                $localFlujos[] = $dmnProcesoFlujo;
            }
            return $localFlujos;
        }
}
?>