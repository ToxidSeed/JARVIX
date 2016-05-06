<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainPropiedad extends BaseDomain{
    protected $id;
    protected $nombre;
    protected $fechaRegistro;
    protected $fechaUltAct;
    protected $control;
    protected $editor;
    
    function __construct($id = null) {
        $this->id = $id;
    }
    function setId($id = null){
        $this->id = $id;
    }
    function getId(){
        return $this->id;
    }
    function setNombre($nombre){
        $this->nombre = $nombre;
    }
    function getNombre(){
        return $this->nombre;
    }
    public function setFechaRegistro($fechaRegistro){
        $this->fechaRegistro = $fechaRegistro;
    }
    public function getFechaRegistro(){
       return $this->fechaRegistro; 
    }
    public function setFechaUltAct($fechaUltAct){
        $this->fechaUltAct = $fechaUltAct;
    }
    public function getFechaUltAct(){
        return $this->fechaUltAct;
    }
    function getControl() {
        return $this->control;
    }

    function setControl($control) {
        $this->control = $control;
    }
    function getEditor(){        
        require_once MAPPERPATH.'EditorMapper.php';   
        if($this->mapper == true && $this->editor != null && $this->editor->getId() != null){            
           $mprEditor = new EditorMapper();
           $this->editor = $mprEditor->find($this->editor->getId());
        }
        return $this->editor;
        
        
    }
    function setEditor($editor){
        $this->editor = $editor;
    }


}
?>
