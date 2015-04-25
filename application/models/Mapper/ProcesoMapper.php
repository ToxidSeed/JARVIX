<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainProceso.php';
require_once DOMAINPATH.'DomainAplicacion.php';
require_once DOMAINPATH.'DomainEstado.php';

class ProcesoMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
       'id',
        'nombre',
        'fecharegistro',
        'aplicacionid',
        'fechaultact',
        'descripcion',
//        'estado',
        'rutaprototipo'
    );
    
    protected $uniqueValues = array(
            array('id')
    );
    
    protected $tableName = 'Proceso';
    
    protected function doCreateObject(array $record = null){
        $dmnProceso =  new DomainProceso($record['ID']);
        $dmnProceso->setNombre($record['NOMBRE']);
        $dmnProceso->setFechaRegistro($record['FECHAREGISTRO']);
        $dmnProceso->setAplicacion(new DomainAplicacion($record['APLICACIONID']));
        $dmnProceso->setFechaUltAct($record['FECHAULTACT']);
        $dmnProceso->setDescripcion($record['DESCRIPCION']);
//        $dmnProceso->setEstado(new DomainEstado($record['ESTADOID']));
        $dmnProceso->setRutaPrototipo($record['RUTAPROTOTIPO']);
        return $dmnProceso;
    }
    
    public function insert(DomainProceso $dmnProceso){
        $this->doInsert($dmnProceso);
    }
    protected function doInsert(DomainProceso $dmnProceso){
        $fields['nombre'] = $dmnProceso->getNombre();
        $fields['fechaRegistro'] = $dmnProceso->getFechaRegistro();
        $fields['fechaultact'] = $dmnProceso->getFechaUltAct();
        $fields['aplicacionid'] = $dmnProceso->getAplicacion()->getId();
        $fields['proyectoid'] = $dmnProceso->getProyecto()->getId();
        $fields['descripcion'] = $dmnProceso->getDescripcion();
        $fields['estadoid'] = $dmnProceso->getEstado()->getId();
        $fields['rutaprototipo'] = $dmnProceso->getRutaPrototipo();
        $this->db->set($fields);        
        $res = $this->db->insert($this->tableName);
        
        $dmnProceso->setId($this->db->insert_id());
        
        
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la Base de Datos Proyecto Mapper',-1);
        }        
    }
    public function update(DomainProceso $dmnProceso){
        $this->doUpdate($dmnProceso);
    }
    protected function doUpdate(DomainProceso $dmnProceso){
        $fields['nombre'] = $dmnProceso->getNombre();
        $fields['fecharegistro'] = $dmnProceso->getFechaRegistro();
        $fields['fechaultact'] = $dmnProceso->getFechaUltAct();
        $fields['aplicacionid'] = $dmnProceso->getAplicacion()->getId();
        $fields['descripcion'] = $dmnProceso->getDescripcion();
        $fields['estado'] = $dmnProceso->getEstado()->getId();
        $fields['rutaprototipo'] = $dmnProceso->getRutaPrototipo();
        $this->db->set($fields);
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar el proceso',-1);
        }
    }
}

?>
