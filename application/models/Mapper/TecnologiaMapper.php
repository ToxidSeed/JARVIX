<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainTecnologia.php';
/**
 * Description of TecnologiaMapper
 *
 * @author usuario
 */
class TecnologiaMapper extends BaseMapper{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
        'id',
        'nombre',
        'estadoid'
    );
    
    protected $tableName = 'Tecnologia';
    
    public function insert(DomainTecnologia $dmnTecnologia){
        $this->doInsert($dmnTecnologia);
    }
    protected function doInsert(DomainTecnologia $dmnTecnologia){
        $fields['nombre'] = $dmnTecnologia->getNombre();
        $fields['estadoid'] = $dmnTecnologia->getEstado()->getId();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);        
        $dmnTecnologia->setId($this->db->insert_id());
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la Base de Datos TecnologiaMapper',-1);
        }              
    }
    public function update(DomainTecnologia $dmnTecnologia){
        $this->doUpdate($dmnTecnologia);
    }
    public function doUpdate(DomainTecnologia $dmnTecnologia){
        $fields['nombre'] = $dmnTecnologia->getNombre();
        $fields['estadoid'] = $dmnTecnologia->getEstado()->getId();
        $this->db->set($fields);
        $this->db->where('id',$dmnTecnologia->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Atualizar en la base de Datos TecnologiaMapper',-1);
        }
    }
    public function doCreateObject(array $record = null){
        $dmnTecnologia = new DomainTecnologia($record['ID']);
        $dmnTecnologia->setNombre($record['NOMBRE']);
        $dmnTecnologia->setEstado(new DomainEstado($record['ESTADOID']));
        return $dmnTecnologia;
    }
}