<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainTipoControl.php';
require_once DOMAINPATH.'DomainEvento.php';
require_once DOMAINPATH.'DomainControlEvento.php';

class ControlEventoMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'id',
        'controlid',
        'eventoid'
    );
    
    protected $uniqueValues = array(
        array('id'),
        array(
            'controlid',
            'eventoid'
        )
    );
    
    protected $tableName = 'ControlEvento';
    
    public function Insert(DomainControlEvento $dmnControlEvento){
        $this->doInsert($dmnControlEvento);
    }
    
    protected function doInsert(DomainControlEvento $dmnControlEvento){
        $this->load->database();
        $fields['controlid'] = $dmnControlEvento->getControl()->getId();
        $fields['eventoid'] = $dmnControlEvento->getEvento()->getId();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error Insertar Control Evento',-1);
        }
    }
    
    public function doCreateObject(array $record = null){        
        $dmnControlEvento = new DomainControlEvento($record['ID']);
        $dmnControlEvento->setControl(new DomainTipoControl($record['CONTROLID']));
        $dmnControlEvento->setEvento(new DomainEvento($record['EVENTOID']));
        return $dmnControlEvento;
    }
    
    public function Delete(DomainControlEvento $dmnControlEvento){
        $this->doDelete($dmnControlEvento);
    }
    
    protected function doDelete(DomainControlEvento $dmnControlEvento){
        $this->load->database();
        $this->db->where('id',$dmnControlEvento->getId());
        $res = $this->db->delete($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error Insertar Control Propiedad',-1);
        }
    }
    
}
?>
