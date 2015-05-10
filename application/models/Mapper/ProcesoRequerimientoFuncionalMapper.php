<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainProcesoRequerimientoFuncional.php';
require_once DOMAINPATH.'DomainProceso.php';
require_once DOMAINPATH.'DomainProcesoRequerimientoFuncional.php';
require_once DOMAINPATH.'DomainRequerimiento.php';

class ProcesoRequerimientoFuncionalMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
        'procesorequerimientofuncional.id',
        'procesorequerimientofuncional.fecharegistro',
        'procesorequerimientofuncional.procesoid',
        'procesorequerimientofuncional.requerimientofuncionalid'
    );
    
    protected $tableName = 'procesorequerimientofuncional';
    
    protected function doCreateObject(array $record = null){
        $dmnObject = new DomainProcesoRequerimientoFuncional($record['ID']);
        $dmnObject->setProceso(new DomainProceso($record['PROCESOID']));
        $dmnObject->setRequerimientoFuncional(new DomainRequerimiento($record['REQUERIMIENTOFUNCIONALID']));
        return $dmnObject;        
    }
    
    public function insert(DomainProcesoRequerimientoFuncional $dmnObject){
        $this->doInsert($dmnObject);    
    }
    public function update(DomainProcesoRequerimientoFuncional $dmnObject){
        $this->doUpdate($dmnObject);
    }
    
    protected function doInsert(DomainProcesoRequerimientoFuncional $dmnObject){
        $this->load->database();
        $fields['procesoid'] = $dmnObject->getProceso()->getId();
        $fields['requerimientofuncionalid'] = $dmnObject->getRequerimientoFuncional()->getId();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        $dmnObject->setId($this->db->insert_id());
        if(!$res){
            $this->db->trans_rollback();
           throw new Exception('Error al Insertar en '.$this->tableName,-1);
        }        
    }
    protected function doUpdate(DomainProcesoRequerimientoFuncional $dmnObject){
        $this->load->database();
        $fields['procesoid'] = $dmnObject->getProceso()->getId();
        $fields['requerimientofuncionalid'] = $dmnObject->getRequerimientoFuncional()->getId();
        $this->db->set($fields);
        $this->db->where('id',$dmnObject->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar la tabla '.$this->tableName,-1);
        }        
    }
    public function delete(DomainProcesoRequerimientoFuncional $domain){
        $this->doDelete($domain);
    }
    protected function doDelete(DomainProcesoRequerimientoFuncional $domain){
        $this->load->database();
        $this->db->where('id',$domain->getId());
        $res = $this->db->delete($this->tableName);
         if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al borrar registros la tabla '.$this->tableName,-1);
        }     
    }
    
    
}


?>