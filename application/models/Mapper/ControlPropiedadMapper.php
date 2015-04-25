<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
class ControlPropiedadMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'id',      
        'controlid',
        'propiedadid'
    );
    
    protected $uniqueValues = array(
        array('id'),
        array(
            'controlid',
            'propiedadid'
        )
    );
    
    protected $tableName = 'ControlPropiedad';
    
    
    
    public function Insert(DomainControlPropiedad $dmnControlPropiedad){
        $this->doInsert($dmnControlPropiedad);
    }
    
    protected function doInsert(DomainControlPropiedad $dmnControlPropiedad){
        $this->load->database();
        $fields['controlid'] = $dmnControlPropiedad->getControl()->getId();
        $fields['propiedadid'] = $dmnControlPropiedad->getPropiedad()->getId();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error Insertar Control Propiedad',-1);
        }
    }
    
     protected function doCreateObject(array $record = null){
        $dmnControlPropiedad = new DomainControlPropiedad($record['ID']);
        $dmnControlPropiedad->setControl(new DomainTipoControl($record['CONTROLID']));;
        $dmnControlPropiedad->setPropiedad(new DomainPropiedad($record['PROPIEDADID']));        
        return $dmnControlPropiedad;
    }
    
    public function Delete(DomainControlPropiedad $dmnControlPropiedad){
        $this->doDelete($dmnControlPropiedad);
    }
    protected function doDelete(DomainControlPropiedad $dmnControlPropiedad){
        $this->load->database();
        $this->db->where('id',$dmnControlPropiedad->getId());
        $res = $this->db->delete($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error Insertar Control Propiedad',-1);
        }
    }
}
?>
