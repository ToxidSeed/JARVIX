<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainProyectoUsuario extends BaseDomain{
    protected $id;
    protected $proyecto;
    protected $aplicacion;
    protected $usuario;
    protected $flgProyectoActual;
    
    function __construct($id) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getProyecto() {
        require_once MAPPERPATH.'ProyectoMapper.php';        
        if($this->mapper == true && $this->proyecto != null && $this->proyecto->getId() != null){
            $mprProyecto = new ProyectoMapper();
            $this->proyecto = $mprProyecto->find($this->proyecto->getId());            
        }        
        return $this->proyecto;
    }

    public function setProyecto($proyecto) {
        $this->proyecto = $proyecto;
    }
    public function getAplicacion() {
        require_once MAPPERPATH.'AplicacionMapper.php';        
        if($this->mapper == true && $this->aplicacion != null && $this->aplicacion->getId() != null){
            $mprAplicacion = new AplicacionMapper();
            $this->aplicacion = $mprAplicacion->find($this->aplicacion->getId());            
        }                
        return $this->aplicacion;
    }

    public function setAplicacion($aplicacion) {
        $this->aplicacion = $aplicacion;
    }

    
    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getFlgProyectoActual() {
        return $this->flgProyectoActual;
    }

    public function setFlgProyectoActual($flgProyectoActual) {
        $this->flgProyectoActual = $flgProyectoActual;
    }


}

?>
