<?php

/*
 * Clase de negocio que se encarga de borrar las relaciones entre el control y la propiedad
 * se deberia considerar un standart para realizar este borrado, ya que el agregar y el quitar
 * utilizan las mismas acciones y objetos
 */
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'ControlPropiedadMapper.php';
require_once DOMAINPATH.'DomainControlPropiedad.php';

class DropLinkedPropertyBO extends BaseBO{
    private $records = array();
    
    public function addRecord(DomainControlPropiedad $record){
        $this->records[] = $record;
    }
    public function setRecords($records){
        $this->records = $records;
    } 
    
    function __construct() {
        parent::__construct();
    }
    
    public function Drop(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $this->DropLinkedProperties();
            
            $this->db->trans_complete();
        }catch(Exception $e){
            $this->db->trans_rollbac();
            throw new Exception($e->getMessage());
        }
    }
    
    private function DropLinkedProperties(){
        $mprControlPropiedad = new ControlPropiedadMapper();
        foreach($this->records as $dmnControlPropiedad){
            $mprControlPropiedad->Delete($dmnControlPropiedad);
        }
    }
    
}
?>
