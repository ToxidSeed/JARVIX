<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainProyecto.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainAplicacion.php';

class ProyectoMapper extends BaseMapper{
    function __construct(){
        parent::__construct();
    }
    protected $fields = array(
      'id',
        'nombre',
        'descripcion',
        'aplicacionid',
        'fecharegistro',
        'fechamodificacion',
        'estadoid'
    );
    protected $uniqueValues = array(
        array('id')
    );
    
    protected $tableName = 'Proyecto';
    
    protected function doCreateObject(array $record = null){
        $dmnProyecto = new DomainProyecto($record['ID']);
        $dmnProyecto->setNombre($record['NOMBRE']);
        $dmnProyecto->setDescripcion($record['DESCRIPCION']);
        $dmnProyecto->setAplicacion(new DomainAplicacion($record['APLICACIONID']));
        $dmnProyecto->setFechaRegistro($record['FECHAREGISTRO']);
        $dmnProyecto->setFechaModificacion($record['FECHAMODIFICACION']);
        $dmnProyecto->setEstado(new DomainEstado($record['ESTADOID']));
        return $dmnProyecto;
    }
    
    public function insert(DomainProyecto $dmnProyecto){
        $this->doInsert($dmnProyecto);
    }
    protected function doInsert(DomainProyecto $dmnProyecto){
        $fields['nombre'] = $dmnProyecto->getNombre();
        $fields['descripcion'] = $dmnProyecto->getDescripcion();
        $fields['aplicacionid'] = $dmnProyecto->getAplicacion()->getId();
        $fields['fecharegistro'] = $dmnProyecto->getFechaRegistro();
        $fields['fechamodificacion'] = $dmnProyecto->getFechaModificacion();        
        $fields['estadoid'] = $dmnProyecto->getEstado()->getId();
        $this->db->set($fields);        
        $res = $this->db->insert($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la Base de Datos Proyecto Mapper',-1);
        }
        $dmnProyecto->setId($this->db->insert_id());
    }
    public function update(DomainProyecto $dmnProyecto){
        $this->doUpdate($dmnProyecto);
    }
    
    protected function doUpdate(DomainProyecto $dmnProyecto){
        $fields['nombre'] = $dmnProyecto->getNombre();
        $fields['estadoid'] = $dmnProyecto->getEstado()->getId();
        $fields['fecharegistro'] = $dmnProyecto->getFechaRegistro();
        $fields['fechamodificacion'] = $dmnProyecto->getFechaModificacion();
        $fields['aplicacionid'] = $dmnProyecto->getAplicacion()->getId();
        $this->db->set($fields);
        $this->db->where('id',$dmnProyecto->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Atualizar en la base de Datos ProyectoMapper',-1);
        }
    }
}

?>
