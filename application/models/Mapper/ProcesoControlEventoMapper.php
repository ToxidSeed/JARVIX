<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainProcesoControlEvento.php';
require_once DOMAINPATH.'DomainProcesoControl.php';
require_once DOMAINPATH.'DomainControlEvento.php';
require_once DOMAINPATH.'DomainEvento.php';

class ProcesoControlEventoMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'procesocontrolevento.id',
        'procesocontrolevento.procesocontrolid',
        'procesocontrolevento.valor',
        'procesocontrolevento.controleventoid',
        'procesocontrolevento.eventoid'
    );
    
    protected $uniqueValues = array(
        array('id'),
        array(
            'procesocontrolid',
            'controlpropiedadid'
        )
    );
    
    protected $tableName = 'procesocontrolevento';
    
    protected function doCreateObject(array $record = null){        
        $dmnProcesoControlEvento = new DomainProcesoControlEvento($record['ID']);
        $dmnProcesoControlEvento->setProcesoControl(new DomainProcesoControl($record['PROCESOCONTROLID']));
        $dmnProcesoControlEvento->setControlEvento(new DomainControlEvento($record['CONTROLEVENTOID']));
        $dmnProcesoControlEvento->setEvento( new DomainEvento($record['EVENTOID']));
        $dmnProcesoControlEvento->setValor($record['VALOR']);                
        return $dmnProcesoControlEvento;
    }
    
    public function insert(DomainProcesoControlEvento $dmnProcesoControlEvento){
        $this->doInsert($dmnProcesoControlEvento);
    }
   protected function doInsert(DomainProcesoControlEvento $dmnProcesoControlEvento){
       $this->load->database();
       $fields['procesocontrolid'] = $dmnProcesoControlEvento->getProcesoControl()->getId();
       $fields['valor'] = $dmnProcesoControlEvento->getValor();
       $fields['eventoid'] = $dmnProcesoControlEvento->getEvento()->getId();
       $fields['controleventoid'] = $dmnProcesoControlEvento->getControlEvento()->getId();
       $this->db->set($fields);
       $res = $this->db->insert($this->tableName);
    //   echo $this->db->last_query();
       $dmnProcesoControlEvento->setId($this->db->insert_id());
       if(!$res){
           $this->db->trans_rollback();
           throw new Exception('Error al Insertar en '.$this->tableName,-1);
       }
           
   }
    public function update(DomainProcesoControlEvento $dmnProcesoControlEvento){
        $this->doUpdate($dmnProcesoControlEvento);
    }
   protected function doUpdate(DomainProcesoControlEvento $dmnProcesoControlEvento){                     
       $this->load->database();
        $fields['id'] = $dmnProcesoControlEvento->getId();
        $fields['valor'] = $dmnProcesoControlEvento->getValor();
        //$fields['controleventoid'] = $dmnProcesoControlEvento->getControlEvento()->getId();
        $this->db->set($fields);
        $this->db->where('id',$dmnProcesoControlEvento->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar la tabla '.$this->tableName,-1);
        }
   }
}