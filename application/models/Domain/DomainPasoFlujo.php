<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';


class DomainPasoFlujo extends BaseDomain{
    protected $id;
    protected $procesoFlujo;
    protected $tipoFlujo;    
    protected $descripcion;
    protected $responsable;
    protected $numeroPaso;
    protected $numeroFlujo;
    protected $pasoFlujoReferencia;
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getProcesoFlujo() {
        return $this->procesoFlujo;
    }

    public function getTipoFlujo() {
        require_once MAPPERPATH.'TipoFlujoMapper.php';        
        if($this->mapper == true && $this->tipoFlujo != null && $this->tipoFlujo->getId() != null){
            $mprTipoFlujo = new TipoFlujoMapper();
            $this->tipoFlujo = $mprTipoFlujo->find($this->tipoFlujo->getId());            
        }
        return $this->tipoFlujo;
    }


    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getResponsable() {
        return $this->responsable;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setProcesoFlujo($procesoFlujo) {
        $this->procesoFlujo = $procesoFlujo;
    }

    public function setTipoFlujo($tipoFlujo) {
        $this->tipoFlujo = $tipoFlujo;

       
    }


    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setResponsable($responsable) {
        $this->responsable = $responsable;
    }
    public function getNumeroPaso() {
        return $this->numeroPaso;
    }

    public function setNumeroPaso($numeroPaso) {
        $this->numeroPaso = $numeroPaso;
    }

    public function getPasoFlujoReferencia() {
        require_once MAPPERPATH.'PasoFlujoMapper.php';             
        if($this->mapper == true && $this->pasoFlujoReferencia != null && $this->pasoFlujoReferencia->getId() != null){
            $mprPasoFlujo = new PasoFlujoMapper();
            $this->pasoFlujoReferencia = $mprPasoFlujo->find($this->pasoFlujoReferencia->getId());
        }   
        return $this->pasoFlujoReferencia;
    }

    public function setPasoFlujoReferencia($pasoFlujoReferencia) {
        $this->pasoFlujoReferencia = $pasoFlujoReferencia;
    }
    public function getNumeroFlujo() {
        return $this->numeroFlujo;
    }

    public function setNumeroFlujo($numeroFlujo) {
        $this->numeroFlujo = $numeroFlujo;
    }




}
