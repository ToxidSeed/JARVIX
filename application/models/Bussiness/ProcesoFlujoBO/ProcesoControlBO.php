<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'ProcesoControlMapper.php';
require_once MAPPERPATH.'ProcesoControlPropiedadMapper.php';
require_once MAPPERPATH.'ProcesoControlEventoMapper.php';

class ProcesoControlBO extends BaseBO{
    function __construct() {
        parent::__construct();
        $this->ProcesoControlMapper = new ProcesoControlMapper();
        $this->ProcesoControlPropiedadMapper = new ProcesoControlPropiedadMapper();
        $this->ProcesoControlEventoMapper = new ProcesoControlEventoMapper();
    }
    
//    private $dmnProcesoControl;
    public $propiedades = array();
    public $propiedades_borrar = array();
//    private $events = array();
    private $ProcesoControlMapper;
    private $ProcesoControlPropiedadMapper;
    private $ProcesoControlEventoMapper;
    
//    function getDmnProcesoControl() {
//        return $this->dmnProcesoControl;
//    }

//    function getProperties() {
//        return $this->properties;
//    }
//
//    function getEvents() {
//        return $this->events;
//    }

//    function setDmnProcesoControl($dmnProcesoControl) {
//        $this->dmnProcesoControl = $dmnProcesoControl;
//    }

//    function setProperties($properties) {
//        $this->properties = $properties;
//    }
//
//    function setEvents($events) {
//        $this->events = $events;
//    }

        
    public function add(){
        try{
            $this->load->database();            
            $this->db->trans_start();
            
            //Check if exist object
            if($this->hasObject() === false){
                return;
            }
            $this->ProcesoControlMapper->insert($this->domain);
              
            $this->db->trans_commit();            
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    
    public function upd(){
        try{
            $this->load->database();            
            $this->db->trans_start();
            
            //Check if exist object
            if($this->hasObject() === false){
                return;
            }
            $this->ProcesoControlMapper->update($this->domain);
              
            $this->db->trans_commit();            
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    
    
    //Realiza el guardado de las propiedades
    //consideraciones
    //1.- Al Intentar Insertar una propiedad para un control en especifico hay que validar
    //2.- si la propiedad ya se encuentra asociada al control para el proceso en curso
    
    public function add_propiedades(){
        try{
            $this->load->database();            
            $this->db->trans_start();

            foreach($this->propiedades as $dmnProcesoControlPropiedad){            
                $this->addProperty($dmnProcesoControlPropiedad);
            }

            $this->db->trans_commit(); 
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    
    
    //Realiza el borrado de las propiedades
    //consideraciones
    public function del_propiedades(){
          try{
            $this->load->database();            
            $this->db->trans_start();

            foreach($this->propiedades as $dmnProcesoControlPropiedad){            
                $this->delProperty($dmnProcesoControlPropiedad);
            }

            $this->db->trans_commit(); 
        } catch (Exception $ex) {
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());   
        }
    }
    
    //
    public function saveEvents(){
        foreach($this->events as $dmnProcesoControlEvento){
            $dmnProcesoControlEvento->setProcesoControl($this->domain);
            if($dmnProcesoControlEvento->getId() == null){
                $this->addEvent($dmnProcesoControlEvento);
            }else{
                $this->updEvent($dmnProcesoControlEvento);
            }
        }
    }
    
    public function addSingleProperty(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $this->addProperty($dmnProcesoControlPropiedad);
    }
    public function updSingleProperty(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $this->updProperty($dmnProcesoControlPropiedad);
    }
    
    protected function addProperty(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $this->ProcesoControlPropiedadMapper->insert($dmnProcesoControlPropiedad);
    }
    protected function delProperty(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $this->ProcesoControlPropiedadMapper->delete($dmnProcesoControlPropiedad);
    }
    
    
    
    protected function updProperty(DomainProcesoControlPropiedad $dmnProcesoControlPropiedad){
        $curDmnProcesoControlPropiedad = $this->ProcesoControlPropiedadMapper->find($dmnProcesoControlPropiedad->getId());
        $curDmnProcesoControlPropiedad->setValor($dmnProcesoControlPropiedad->getValor());
        $this->ProcesoControlPropiedadMapper->update($curDmnProcesoControlPropiedad);        
    }
    
    public function addSingleEvent(DomainProcesoControlEvento $dmnProcesoControlEvento){
        $this->addEvent($dmnProcesoControlEvento);
    }
    public function updSingleEvent(DomainProcesoControlEvento $dmnProcesoControlEvento){
        $this->updEvent($dmnProcesoControlEvento);
    }    
    
    protected function addEvent(DomainProcesoControlEvento $dmnProcesoControlEvento){
        $this->ProcesoControlEventoMapper->insert($dmnProcesoControlEvento);
    }
    
    protected function updEvent(DomainProcesoControlEvento $dmnProcesoControlEvento){
        $curDmnProcesoControlEvento = $this->ProcesoControlEventoMapper->find($dmnProcesoControlEvento->getId());
        $curDmnProcesoControlEvento->setValor($dmnProcesoControlEvento->getValor());
        $this->ProcesoControlEventoMapper->update($dmnProcesoControlEvento);
        
    }
    protected function hasObject() {
        if($this->domain == null){
            $this->errors->add(new ErrorObject('El Objeto no ha sido enviado',-1));
            return false;
        }
        return true;
    }
    
}
