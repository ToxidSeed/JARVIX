<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once FINDERPATH.'ProcesoRequerimiento/ProcesoRequerimientoFRM1.php';



class ProcesoBO extends BaseBO{
    function __construct() {
        parent::__construct();
        
    }
    
    private $ProcesoRequerimientoFRM1;
    
    public function getRequerimientos($ProcConId){
        $this->ProcesoRequerimientoFRM1 = new ProcesoRequerimientoFRM1();
        $params['ProcesoId'] = $ProcConId;
        $results =  $this->ProcesoRequerimientoFRM1->search($params);
        return $this->getRefRequerimientos($results);
    }
    private function getRefRequerimientos(ResponseModel $results){
        $objects = $results->getResults();
        foreach($objects as $record){
            $record->Mapper()->getRequerimientoFuncional();
        }        
        return $results;
    }
}