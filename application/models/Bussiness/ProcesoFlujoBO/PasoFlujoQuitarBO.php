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
            $this->quitarConReferencias($this->domain);
            //
            $arrReenum = $this->buscarFlujos();
            //print_r($arrReenum);
            //reenumerar
            $this->reenumerar($arrReenum);
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
                $this->quitarConReferencias($dmnPasoFlujo);
            }
            //Borrar el original
            $this->mprPasoFlujoMapper->delete($dmnPasoFlujo);
        }else{
            $this->mprPasoFlujoMapper->delete($dmnPasoFlujo);
        }
    }
    
    public function getReferencias($id){
        //Obtener referencias        
        $response = $this->FinderPasos->Search(
                    array(
                        'PasoFlujoReferenciaId' => $id
                    )
                );
        return $response;
    }
    private function reenumerar(array $flujos = null){        
        foreach($flujos as $dmnPasoFlujo){
            $dmnPasoFlujoCurr = $this->mprPasoFlujoMapper->find($dmnPasoFlujo->getId());
            if($dmnPasoFlujoCurr){
                $dmnPasoFlujoCurr->setNumeroPaso($dmnPasoFlujo->getNumeroPaso());
                $dmnPasoFlujoCurr->setNumeroFlujo($dmnPasoFlujo->getNumeroFlujo());
                $this->mprPasoFlujoMapper->update($dmnPasoFlujoCurr);
            }
        }
        
    }
    
    private function buscarFlujos(){
        
        $varArrayFlujosReenum = array();		
        //Reenumerar Flujo Principal        
        $varNumeroFlujoAct = 0;		
        $varNumeroPasoAct = 0;
        $varTipoFlujoAct = self::FLUJO_PRINCIPAL_ID;
        $varNumeroFlujoAnt = 0;        
        
        //Obtener solo los numeros
        $response = $this->getPasosReenumerar();
        
        $array = array();
        
        //print_r($response);
        //Reenumerar Flujos Afectados
        //echo 'hola1';
        foreach($response->getResults() as $dmnPasoFlujo){
            $array[] = array(
                'NumeroFlujo' => $dmnPasoFlujo->getNumeroFlujo(),
                'NumeroPaso' => $dmnPasoFlujo->getNumeroPaso()
            );
          //  echo 'hola1';
            if($dmnPasoFlujo->getTipoFlujo()->getId() != $varTipoFlujoAct ){
                $varTipoFlujoAct = $dmnPasoFlujo->getTipoFlujo()->getId();   
                $varNumeroFlujoAct = self::NUMERO_FLUJO_INICIAL;
                $varNumeroPasoAct = self::NUMERO_PASO_INICIAL;
            }else{
                $this->NumerarPaso($dmnPasoFlujo->getNumeroFlujo(), $varNumeroFlujoAnt, $varNumeroFlujoAct,$varNumeroPasoAct);                    
            }            
            //echo 'hola2';
            
            //Valores anteriores
            $varNumeroFlujoAnt = $dmnPasoFlujo->getNumeroFlujo();            
                        //echo 'hola3';
            $this->selecFlujosReenumerar($dmnPasoFlujo, $varTipoFlujoAct, $varNumeroFlujoAct, $varNumeroPasoAct, $varArrayFlujosReenum);      
        }
        //print_r($array);
        return $varArrayFlujosReenum;
    }
    private function selecFlujosReenumerar(DomainPasoFlujo $dmnPasoFlujo,$parTipoFlujo,$parNumeroFlujo,$parNumeroPaso,&$arrFlujosReenum){
        /*echo 'hola';
        echo $dmnPasoFlujo->getTipoFlujo();
        echo '';
        echo $dmnPasoFlujo->getNumeroFlujo();
        echo '';
        echo $dmnPasoFlujo->getNumeroPaso();
        echo '';*/
        
        if($dmnPasoFlujo->getTipoFlujo()->getId() != $parTipoFlujo ||
                $dmnPasoFlujo->getNumeroFlujo() != $parNumeroFlujo || 
                $dmnPasoFlujo->getNumeroPaso() != $parNumeroPaso){
            
            $dmnPasoFlujo->setNumeroFlujo($parNumeroFlujo);
            $dmnPasoFlujo->setNumeroPaso($parNumeroPaso);
            $arrFlujosReenum[] = $dmnPasoFlujo;            
        }
        
    }
    
    private function NumerarPaso($parNumeroFlujoEvaluar,$parNumeroFlujoAnterior,&$parNumeroFlujoActual,&$parNumeroPasoActual){
        $array = array(
            'NumeroFlujoEvaluar' => $parNumeroFlujoEvaluar,
            '$parNumeroFlujoAnterior' => $parNumeroFlujoAnterior
        );
        
//        print_r($array);
        
        if($parNumeroFlujoEvaluar != $parNumeroFlujoAnterior){
            $parNumeroFlujoActual++;
            $parNumeroPasoActual = self::NUMERO_PASO_INICIAL;
        }else{
            $parNumeroPasoActual++;
        }        
    }
        
    
    private function getPasosReenumerar(){
        
        //print_r($this->domain);
        
        $response = $this->FinderPasosReenumerar->search(array(
           'ProcesoFlujoId' => $this->domain->getProcesoFlujo()->getId() 
        ));
        return $response;
    }
}