<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainAplicacion extends BaseDomain{
    protected $id;
    protected $nombre;
    protected $rutaPublicacion;
    protected $baseDatos;
    protected $servidor;
    protected $username;
    protected $password;
    protected $estado;
    protected $fechaRegistro;
    protected $fechaModificacion;
    
    function __construct($id = null) {
        $this->id = $id;
    }
    function setId($id){
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
    public function setRutaPublicacion($value){
        $this->rutaPublicacion = $value;
    }
    public function getRutaPublicacion(){
        return $this->rutaPublicacion;
    }
    public function setBaseDatos($value){
        $this->baseDatos = $value;
    }
    public function getBaseDatos(){
        return $this->baseDatos;
    }
    public function setServidor($value){
        $this->servidor = $value;
    }
    public function getServidor(){
        return $this->servidor;
    }
    public function setUsername($value){
        $this->username = $value;
    }
    public function getUsername(){
        return $this->username;
    }
    public function setPassword($value){
        $this->password = $value;        
    }
    public function getPassword(){
        return $this->password;
    }
    public function setEstado($value){
        $this->estado = $value;
    }
    public function getEstado(){        
        require_once MAPPERPATH.'EstadoMapper.php';        
        if($this->mapper == true && $this->estado != null && $this->estado->getId() != null){
            $mprEstado = new EstadoMapper();
            $this->estado = $mprEstado->find($this->estado->getId());            
        }
        return $this->estado;
    }
    public function setFechaRegistro($value){
        $this->fechaRegistro = $value;
    }
    public function getFechaRegistro(){
        return $this->fechaRegistro;
    }
    public function setFechaModificacion($value){
        $this->fechaModificacion = $value;
    }
    public function getFechaModificacion(){
        return $this->fechaModificacion;
    }
}
?>
