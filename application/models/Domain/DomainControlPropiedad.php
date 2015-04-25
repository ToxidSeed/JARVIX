<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';
 
class DomainControlPropiedad extends BaseDomain{
    protected $id;
    protected $control;
    protected $propiedad;
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getControl() {
        require_once MAPPERPATH.'TipoControlMapper.php';        
        if($this->mapper == true && $this->control != null && $this->control->getId() != null){
            $mprTipoControl = new TipoControlMapper();
            $this->control = $mprTipoControl->find($this->control->getId());            
        }                
        return $this->control;
    }

    public function setControl($control) {
        $this->control = $control;
    }

    public function getPropiedad() {
        require_once MAPPERPATH.'PropiedadMapper.php';        
        if($this->mapper == true && $this->propiedad != null && $this->propiedad->getId() != null){
            $mprPropiedad = new PropiedadMapper();
            $this->propiedad = $mprPropiedad->find($this->propiedad->getId());            
        }                        
        return $this->propiedad;
    }

    public function setPropiedad($propiedad) {
        $this->propiedad = $propiedad;
    }


    
}
?>
