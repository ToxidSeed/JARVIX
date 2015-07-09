<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainRequerimiento.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainProyecto.php';

class RequerimientoMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
        'id',
        'codigo',
        'proyectoid',
        'nombre',
        'descripcion',
        'estadoid',
        'fecharegistro',
        'fechamodificacion',
        'orden'
    );
    
    protected $uniqueValues = array(     
        array('id'),
        array('codigo')
    );
    
    protected $tableName = 'RequerimientoFuncional';
    
    protected function doCreateObject(array $record = null){
        $dmnRequerimiento = new DomainRequerimiento($record['ID']);
        $dmnRequerimiento->setNombre($record['NOMBRE']);
        $dmnRequerimiento->setDescripcion($record['DESCRIPCION']);
        $dmnRequerimiento->setCodigo($record['CODIGO']);
        $dmnRequerimiento->setProyecto(new DomainProyecto($record['PROYECTOID']));
        $dmnRequerimiento->setEstado(new DomainEstado($record['ESTADOID']));
        $dmnRequerimiento->setFechaRegistro($record['FECHAREGISTRO']);
        $dmnRequerimiento->setFechaModificacion($record['FECHAMODIFICACION']);
        $dmnRequerimiento->setOrden($record['ORDEN']);
        return $dmnRequerimiento;
    }
    
    public function insert(DomainRequerimiento $dmnRequerimiento){
        $this->doInsert($dmnRequerimiento);
    }
    
    protected function doInsert(DomainRequerimiento $dmnRequerimiento){
        $fields['codigo'] = $dmnRequerimiento->getCodigo();
        $fields['nombre'] = $dmnRequerimiento->getNombre();
        $fields['descripcion'] = $dmnRequerimiento->getDescripcion();
        $fields['proyectoid'] = $dmnRequerimiento->getProyecto()->getId();
        $fields['estadoid'] = $dmnRequerimiento->getEstado()->getId();
        $fields['fecharegistro'] = $dmnRequerimiento->getFechaRegistro();
        $fields['fechamodificacion'] = $dmnRequerimiento->getFechaModificacion();
        $fields['orden'] = $dmnRequerimiento->getOrden();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al insertar un requerimiento');
        }
    }
    
    public function update(DomainRequerimiento $dmnRequerimiento){
        $this->doUpdate($dmnRequerimiento);
    }
    protected function doUpdate(DomainRequerimiento $dmnRequerimiento){
        $fields['codigo'] = $dmnRequerimiento->getCodigo();
        $fields['nombre'] = $dmnRequerimiento->getNombre();
        $fields['descripcion'] = $dmnRequerimiento->getDescripcion();
        $fields['proyectoid'] = $dmnRequerimiento->getProyecto()->getId();
//        $fields['estadoid'] = $dmnRequerimiento->getEstado()->getId();
        $fields['fecharegistro'] = $dmnRequerimiento->getFechaRegistro();
        $fields['fechamodificacion'] = $dmnRequerimiento->getFechaModificacion();
        $this->db->set($fields);
        $this->db->where('id',$dmnRequerimiento->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar el Requerimiento',-1);
        }
    }
    
}

?>
