<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainPropiedad.php';

class PropiedadMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
      'id'  ,
        'nombre',
        'fecharegistro',
        'fechaultact'        
    );
    protected $uniqueValues = array(
        array('id')
    );
    
    protected $tableName = 'propiedad';
    

    
    public function insert(DomainPropiedad $dmnPropiedad){
        $this->doInsert($dmnPropiedad);
    }
    protected function doInsert(DomainPropiedad $dmnPropiedad){
        $fields['nombre'] = $dmnPropiedad->getNombre();
        $fields['fecharegistro'] = $dmnPropiedad->getFechaRegistro();
        $fields['fechaultact'] = $dmnPropiedad->getFechaUltAct();
        $fields['controlid'] = $dmnPropiedad->getControl()->getId();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        $dmnPropiedad->setId($this->db->insert_id());
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la Base de Datos PropiedadMapper',-1);
        }        
    }
    
    public function update(DomainPropiedad $dmnPropiedad){
        $this->doUpdate($dmnPropiedad);
    }
    protected function doUpdate(DomainPropiedad $dmnPropiedad){
        $fields['nombre'] = $dmnPropiedad->getNombre();
        $this->db->set($fields);
        $this->db->where('id',$dmnPropiedad->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Atualizar en la base de Datos PropiedadMapper',-1);
        }
    }
    
    protected function doCreateObject(array $record = null){
        $dmnPropiedad = new DomainPropiedad($record['ID']);
        $dmnPropiedad->setNombre($record['NOMBRE']);
        $dmnPropiedad->setFechaRegistro($record['FECHAREGISTRO']);
        $dmnPropiedad->setFechaUltAct($record['FECHAULTACT']);
        return $dmnPropiedad;
    }
}
?>
