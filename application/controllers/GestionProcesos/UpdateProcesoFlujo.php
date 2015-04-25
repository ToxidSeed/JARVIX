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

class UpdateProcesoFlujo extends BaseController{
	public function __construct(){
		parent::__construct();
	}
	public function update(){
		try{
                $dmnProcesoFlujo = new DomainProcesoFlujo();
                $dmnProcesoFlujo->setProceso(new DomainProceso($this->getField('ProcesoId')));
                $dmnProcesoFlujo->setId($this->getField('ProcesoFlujoId'));
                $dmnProcesoFlujo->setNombre($this->getField('Nombre'));
                $dmnProcesoFlujo->setDescripcion($this->getField('Descripcion'));                                                

                $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoFlujoUpdateBO','ProcesoFlujoUpdateBO');
                $this->ProcesoFlujoAddBO->setDomain($dmnProcesoFlujo);
                $this->ProcesoFlujoAddBO->setSteps($this->getSteps($dmnProcesoFlujo));
                $this->ProcesoFlujoAddBO->add();

                $this->getAnswer()->setSuccess(true);
                $this->getAnswer()->setMessage('Registrado Correctamente');
                $this->getAnswer()->setCode(0);
                $this->getAnswer()->AddExtraData('ProcesoFlujoId',$dmnProcesoFlujo->getId());     
                echo $this->getAnswer()->getAsJSON(); 
            } catch (Exception $ex) {
                if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                    echo $this->getAnswer()->getAsJSON();
                }else{
                    echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
                }
            }
	}
        public function find(){
            $procesoFlujoId = $this->getField('ProcesoFlujoId');
            $this->load->model('Mapper/ProcesoFlujoMapper','ProcesoFlujoMapper');
            $dmnProcesoFlujo = $this->ProcesoFlujoMapper->find($procesoFlujoId);
            echo json_encode(Response::asSingleObject($dmnProcesoFlujo));
        }
}

?>