<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainValorPropiedad.php';
require_once DOMAINPATH.'DomainPropiedad.php';
/**
 * Description of ValorPropiedadMapper
 *
 * @author usuario
 */
class ValorPropiedadMapper extends BaseMapper{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'id',
        'valor',
        'propiedadid',
        'flgdefault'
    );
    
    protected $tableName = 'ValorPropiedad';
    
    public function insert($domain){
        $this->doInsert($domain);
    }
    
    protected function doCreateObject(array $record = null){
        $dmnValorPropiedad = new DomainValorPropiedad($record['ID']);
        $dmnValorPropiedad->setValor($record['VALOR']);
        $dmnValorPropiedad->setPropiedad(new DomainPropiedad($record['PROPIEDADID']));
        $dmnValorPropiedad->setFlgDefault($record['FLGDEFAULT']);
        return $dmnValorPropiedad;
    }
    
    protected function doInsert(DomainValorPropiedad $dmnValorPropiedad){
        $fields['valor']       = $dmnValorPropiedad->getValor();
        $fields['propiedadid'] = $dmnValorPropiedad->getPropiedad()->getId();
        $fields['flgdefault']  = $dmnValorPropiedad->getFlgDefault(); 
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        $dmnValorPropiedad->setId($this->db->insert_id());
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la Base de Datos ValorPropiedad',-1);
        }                
    }
    public function update($dmnValorPropiedad){
        $this->doUpdate($dmnValorPropiedad);
    }
    public function doUpdate(DomainValorPropiedad $dmnValorPropiedad){
        $fields['valor'] = $dmnValorPropiedad->getValor();
        $fields['propiedadid'] = $dmnValorPropiedad->getPropiedad()->getId();
        $fields['flgdefault']  = $dmnValorPropiedad->getFlgDefault(); 
        $this->db->set($fields);
        $this->db->where('id',$dmnValorPropiedad->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Atualizar en la base de Datos ValorPropiedadMappr',-1);
        }        
    }
    
    public function delete($domain){
        $this->doDelete($domain);
    }
    protected function doDelete($dmnValorPropiedad){
        $this->db->where('id',$dmnValorPropiedad->getId());
        $res = $this->db->delete($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Borrar en la base de Datos ValorPropiedadMappr',-1);
        }      
    }
}
