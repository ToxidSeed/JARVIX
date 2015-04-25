<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainProyectoUsuario.php';
require_once DOMAINPATH.'DomainProyecto.php';
require_once DOMAINPATH.'DomainSysUsuario.php';

class ProyectoUsuarioMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
      'id' ,
        'proyectoid',
        'sysusuarioid',
        'flgproyectoactual'
    );
    
    protected $uniqueValues = array(
        array('id')
    );
    
    protected $tableName = 'ProyectoUsuario';
    
    protected function doCreateObject(array $record = null){
        $dmnProyectoUsuario = new DomainProyectoUsuario($record['ID']);
        $dmnProyectoUsuario->setProyecto(new DomainProyecto($record['PROYECTOID']));
        $dmnProyectoUsuario->setUsuario(new DomainSysUsuario($record['SYSUSUARIOID']));
        $dmnProyectoUsuario->setFlgProyectoActual($record['FLGPROYECTOACTUAL']);
        return $dmnProyectoUsuario;
    }   
    
    public function insert(DomainProyectoUsuario $dmnProyectoUsuario){
        $this->doInsert($dmnProyectoUsuario);
    }
    
    protected function doInsert(DomainProyectoUsuario $dmnProyectoUsuario){
        $fields['proyectoid'] = $dmnProyectoUsuario->getProyecto()->getId();
        $fields['sysusuarioid'] = $dmnProyectoUsuario->getUsuario()->getId();
        $fields['flgproyectoactual'] = $dmnProyectoUsuario->getFlgProyectoActual();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al insertar la relacion entre un proyecto y un usuario');
        }
    }
    
    public function update(DomainProyectoUsuario $dmnProyectoUsuario){
        $this->doUpdate($dmnProyectoUsuario);
    }
    
    protected function doUpdate(DomainProyectoUsuario $dmnProyectoUsuario){
        $fields['proyectoid'] = $dmnProyectoUsuario->getProyecto()->getId();
        $fields['sysusuarioid'] = $dmnProyectoUsuario->getUsuario()->getId();
        $fields['flgproyectoactual'] = $dmnProyectoUsuario->getFlgProyectoActual();
        $this->db->set($fields);
        $this->db->where('id',$dmnProyectoUsuario->getId());
        $res = $this->db->update();
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al actualizar la relacion entre un proyecto y un usuario');
        }
                
    }
}
?>