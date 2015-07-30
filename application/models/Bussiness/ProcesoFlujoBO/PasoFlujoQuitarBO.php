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
	}
    private $mprPasoFlujoMapper; 
    private $FinderFlujos;
    
    public function quitar(){
        try{
            $this->load->database();
            $this->db->trans_start();
            //Verificar si es que existen flujos alternativos relacionados al paso nro 2
            //De existir, eliminarlos antes.
            
            
            $this->mprPasoFlujoMapper->delete($this->domain);
            $this->db->trans_commit();
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }        
    }
}
