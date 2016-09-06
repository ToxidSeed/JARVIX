<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainEntrega.php';
require_once DOMAINPATH.'DomainProyecto.php';
require_once DOMAINPATH.'DomainAlcance.php';

class EntregaMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'id',
        'proyectoid',
        'nombre',
        'fecha',
        'alcanceid'
    );
    
    protected $uniqueValues = array(
        array('id')
    );
            
    protected $tableName = 'entrega';
    
    protected function doCreateObject(array $records = null){
        $dmnEntrega = new DomainEntrega($records['ID']);
        $dmnEntrega->setProyecto(DomainProyecto($records['PROYECTOID']));
        $dmnEntrega->setNombre($records['NOMBRE']);
        $dmnEntrega->setFecha($records['FECHA']);
        $dmnEntrega->setAlcance(new DomainAlcance($records['ALCANCEID']));
        
        return $dmnEntrega;
    }
    
    public function insert(DomainEntrega $dmnEntrega){
        $this->doInsert($dmnEntrega);
    }
    
    protected function doInsert(DomainEntrega $dmnEntrega){
        $field['proyectoid'] = $dmnEntrega->getProyecto()->getId();
        $field['nombre'] = $dmnEntrega->getNombre();
        $field['fecha'] = $dmnEntrega->getFecha();
        $field['alcanceid'] = $dmnEntrega->getAlcance()->getId();
        
        $this->db->set($field);
        $res = $this->db->insert($this->tableName);
        $dmnEntrega->setId($this->db->insert_id());
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar entrega',-1);
        }
    }
    
    public function update(DomainEntrega $dmnEntrega){
        $this->doUpdate($dmnEntrega);
    }
    
    protected function doUpdate(DomainEntrega $dmnEntrega){
        $field['proyectoid'] = $dmnEntrega->getProyecto()->getId();
        $field['nombre'] = $dmnEntrega->getNombre();
        $field['fecha'] = $dmnEntrega->getFecha();
        $field['alcanceid'] = $dmnEntrega->getAlcance()->getId();
        
        $this->db->set($field);
        $this->db->where('id',$dmnEntrega->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al actualizar entrega',-1);
        }
    }            
}