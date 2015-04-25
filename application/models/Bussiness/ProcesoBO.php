<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'ProcesoMapper.php';
require_once MAPPERPATH.'ActualProyectoFinder.php';
class ProcesoBO extends BaseBO{
    function __construct() {
        parent::__construct();
    }
        function add(){
          try{
              $this->load->database();
              $this->db->trans_start();
              
              $mprProceso = new ProcesoMapper();
              $ActualProyectoFinder = new ActualProyectoFinder();
              $dmnProyectoUsuario = $ActualProyectoFinder->Get(1);
              //Setting Additional
              $dmnProyecto = $dmnProyectoUsuario->mapper()->getProyecto();
              $dmnAplicacion = $dmnProyecto->mapper()->getAplicacion();
              $this->getDomain()->setProyecto($dmnProyecto);
              $this->getDomain()->setAplicacion($dmnAplicacion);
              
              //print_r($this->getDomain());
              //Inserting Data
              $mprProceso->insert($this->getDomain());
              
              $this->db->trans_commit();
          }catch(Exception $ex){
              $this->db->trans_rollback();
              throw new Exception($ex->getMessage(),$ex->getCode());   
          }
    }
}
?>
