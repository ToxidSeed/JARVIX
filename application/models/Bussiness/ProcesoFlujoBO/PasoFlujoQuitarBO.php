<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'PasoFlujoMapper.php';
require_once FINDERPATH.'PasoFlujo/FinderFlujos.php';
require_once FINDERPATH.'PasoFlujo/FinderPasosPorFlujos.php';
require_once FINDERPATH.'PasoFlujo/PasoFlujoFRM1.php';
require_once FINDERPATH.'PasoFlujo/PasoFlujoFRM2.php';
/**
 * Description of PasoFlujoQuitarBO
 *
 * @author usuario
 */
class PasoFlujoQuitarBO extends BaseBO{
    //put your code here
    function __construct(){
		parent::__construct();		
//                $this->FinderFlujos = new FinderFlujos();
//                $this->FinderPasosPorFlujos = new FinderPasosPorFlujos();
                $this->mprPasoFlujoMapper = new PasoFlujoMapper();
                $this->FinderPasos = new PasoFlujoFRM1();
                $this->FinderPasosReenumerar = new PasoFlujoFRM2();
                
	}
	
	const FLUJO_PRINCIPAL_ID = 1;
	const NUMERO_FLUJO_INICIAL = 1;
	const NUMERO_PASO_INICIAL = 1;
	
    private $mprPasoFlujoMapper; 
    private $FinderPasosReenumerar;
    private $FinderPasos;
    
    public function quitar(){
        try{
            $this->load->database();
            $this->db->trans_start();
            //Verificar si es que existen flujos alternativos relacionados al paso nro 2
            //De existir, eliminarlos antes    
            $this->quitarConReferencias($this->domain->getId());
            //
            $this->db->trans_commit();
        }catch(Exception $ex){
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }        
    }
    
    public function quitarConReferencias(DomainPasoFlujo $dmnPasoFlujo){
        //Obtener referencias
        $response = $this->getReferencias($dmnPasoFlujo->getId());
        if($response->getCount() > 0){
            foreach($response->getResults() as $dmnPasoFlujo){
                $this->quitarReferencias($dmnPasoFlujo->getId());
            }
            //Borrar el original
            $this->mprPasoFlujoMapper->delete($dmnPasoFlujo);
        }else{
            $this->mprPasoFlujoMapper->delete($dmnPasoFlujo);
        }
    }
    
    public function getReferencias($id){
        //Obtener referencias
        $response = null;
        $response = $this->FinderPasos->Search(
                    array(
                        'PasoFlujoReferenciaId' => $id
                    )
                );
        return $response;
    }
    
    private function reenumerar(){
		$varArrayFlujosReenumerar = array();
		
        //Reenumerar Flujo Principal
		$varTipoFlujoAct = self::FLUJO_PRINCIPAL_ID;
		$varNumeroFlujoAct = self::NUMERO_FLUJO_INICIAL;		
		$varNumeroPasoAct = self::NUMERO_PASO_INICIAL;
        //Obtener solo los numeros
        $response = $this->getPasosReenumerar();
        //Reenumerar Flujos Afectados
		foreach($response as $dmnPasoFlujo){
			//...........$varNumeroFlujoAnt = $dmnPasoFlujo->getNumeroFlujo();
		}		
    }
    private function getPasosReenumerar(){
        $response = $this->FinderPasosReenumerar->search(array(
           'ProcesoFlujoId' => $this->domain->getProcesoFlujo()->getId() 
        ));
        return $response;
    }
}