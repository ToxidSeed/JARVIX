<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainControlEvento extends BaseDomain{
    protected $id;
    protected $control;
    protected $evento;
    
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

    public function getEvento() {
        require_once MAPPERPATH.'EventoMapper.php';        
        
        if($this->mapper == true && $this->evento != null && $this->evento->getId() != null){
            $mprEvento = new EventoMapper();
            $this->evento = $mprEvento->find($this->evento->getId());                    
        }        
        
        return $this->evento;
    }

    public function setEvento($evento) {
        $this->evento = $evento;
    }


}

?>
