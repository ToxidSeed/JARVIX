<?php
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainSysOpcionAplicacion.php';
require_once DOMAINPATH.'DomainSysAplicacion.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class SysOpcionAplicacionMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
      'id',
        'sysAplicacionId',
        'nombre',
        'fechaRegistro',
        'parentid',
        'viewloader'
    );
    
    protected $uniqueValues = array(
        array('id')
    );
    protected $tableName = 'SysOpcionAplicacion';
    
    
    
    protected function doCreateObject(array $record = null){
        $dmnSysOpcionAplicacion = new DomainSysOpcionAplicacion();
        $dmnSysOpcionAplicacion->setId($record['ID']);
        $dmnSysOpcionAplicacion->setSysAplicacion(new DomainSysAplicacion($record['SYSAPLICACIONID']));
        $dmnSysOpcionAplicacion->setNombre($record['NOMBRE']);
        $dmnSysOpcionAplicacion->setFechaRegistro($record['FECHAREGISTRO']);
        $dmnSysOpcionAplicacion->setParent(new DomainSysOpcionAplicacion($record['PARENTID']));        
        $dmnSysOpcionAplicacion->setViewLoader($record['VIEWLOADER']);
                
        return $dmnSysOpcionAplicacion;
    }
    public function insert(DomainSysOpcionAplicacion $dmnSysOpcionAplicacion){
        $this->doInsert($dmnSysOpcionAplicacion);
    }
    protected function doInsert(DomainSysOpcionAplicacion $dmnSysOpcionAplicacion){
        $fields = array(
            'id'=> $dmnSysOpcionAplicacion->getId(),
            'sysaplicacionid' => $dmnSysOpcionAplicacion->getSysAplicacion()->getId(),
            'nombre' =>$dmnSysOpcionAplicacion->getNombre(),
            'fecharegistro' => $dmnSysOpcionAplicacion->getFechaRegistro()
         );
        $this->db->set($fields);
        $this->db->insert($this->tableName);        
    }
    public function update(DomainUsuario $dmnUsuario){
        $this->doUpdate($dmnUsuario);
    }
    protected function doUpdate(DomainSysOpcionAplicacion $dmnSysOpcionAplicacion){
        $fields = array(
            'sysaplicacionid' => $dmnSysOpcionAplicacion->getSysAplicacion()->getId(),
            'nombre' =>$dmnSysOpcionAplicacion->getNombre(),
            'fecharegistro' => $dmnSysOpcionAplicacion->getFechaRegistro()
         );
        $this->db->set($fields);
        $this->db->insert($this->tableName);
    }    
}
?>