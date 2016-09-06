<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'ProcesoControlPropiedadMapper.php';

class ProcesoControlPropiedadBO extends BaseBO{
    function __construct(){
        parent::__construct();
        $this->ProcesoControlPropiedadMapper = new ProcesoControlPropiedadMapper();        
    }
    public function updValorPropiedad($id,$valor){
        $dmnProcesoControlPropiedad = $this->ProcesoControlPropiedadMapper->find($id);
        $dmnProcesoControlPropiedad->setValor($valor);
        $this->ProcesoControlPropiedadMapper->update($dmnProcesoControlPropiedad);
    }
}
