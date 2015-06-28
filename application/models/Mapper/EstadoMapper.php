<?php

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainEstado.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class EstadoMapper extends BaseMapper{        
    function __construct($tipoEstadoId) {
        parent::__construct();
        $this->tipoEstadoId = $tipoEstadoId;
    }
    
    protected $tipoEstadoId;
    
    protected $fields = array(        
          'id',
          'nombre'
    );
      protected $uniqueValues = array(
        array('id','tipoEstadoId')
    );
      
    public function  find($id){
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('id',$id);
        $this->db->where('tipoestadoid',$this->tipoEstadoId);
        $res = $this->db->get();
        $response = $this->getSingleResponse($res);
        return $response;
    }
        
    
    
    protected $tableName = 'Estado';
    
    protected function doCreateObject(array $record = null){
        $dmnEstado = new DomainEstado($record['ID']);
        $dmnEstado->setNombre($record['NOMBRE']);
        return $dmnEstado;
    }
}
?>
