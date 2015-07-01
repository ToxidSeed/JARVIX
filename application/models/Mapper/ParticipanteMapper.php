<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainParticipante.php';
require_once DOMAINPATH.'DomainProyecto.php';
require_once DOMAINPATH.'DomainSysUsuario.php';

class ParticipanteMapper extends BaseMapper{
    function __construct(){
        parent::__construct();
    }
    protected $fields = array(
        'id',
        'proyectoid',
        'sysusuarioid',
        'flgproyectodefault'
    );
    
    protected $uniqueValues = array(
        array('id'),
        array('proyectoid','sysusuarioid')        
    );
    
    protected $tableName = 'Participante';
    
    protected function doCreateObject(array $record = null){
        $dmnParticipante = new DomainParticipante($record['ID']);
        $dmnParticipante->setProyecto(new DomainProyecto($record['PROYECTOID']));
        $dmnParticipante->setSysUsuario(new DomainSysUsuario($record['SYSUSUARIOID']));
        $dmnParticipante->setFlgProyectoDefault($record['FLGPROYECTODEFAULT']);
        return $dmnParticipante;        
    }
    
    public function Insert(DomainParticipante $dmnParticipante){
        $this->doInsert($dmnParticipante);
    }
    public function Delete(DomainParticipante $dmnParticipante){
        $this->doDelete($dmnParticipante);
    }    
    public function Update(DomainParticipante $dmnParticipante){
        $this->doUpdate($dmnParticipante);
    }
    
    protected function doInsert(DomainParticipante $dmnParticipante){
           $this->load->database();
           $fields['proyectoid']            = $dmnParticipante->getProyecto()->getId();
           $fields['sysusuarioid']          = $dmnParticipante->getSysUsuario()->getId();
           $fields['flgproyectodefault']    = $dmnParticipante->getFlgProyectoDefault();
           $this->db->set($fields);
            $res = $this->db->insert($this->tableName);
            
            $dmnParticipante->setId($this->db->insert_id());
            if(!$res){
                $this->db->trans_rollback();
                throw new Exception('Error al Insertar en la BD '.__CLASS__,-1);                
            }
    }
    protected function doDelete(DomainParticipante $dmnParticipante){
        $this->load->database();
        $this->db->where('id',$dmnParticipante->getId());
        $res = $this->db->delete($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la BD '.__CLASS__,-1);                
        }
    }
    
    protected function doUpdate(DomainParticipante $dmnParticipante){
        $this->load->database();
        $fields['proyectoid'] = $dmnParticipante->getProyecto()->getId();
        $fields['sysusuarioid'] =  $dmnParticipante->getSysUsuario()->getId();
        $fields['flgproyectodefault'] = $dmnParticipante->getFlgProyectoDefault();
        $this->db->set($fields);
        $this->db->where('id',$dmnParticipante->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la BD '.__CLASS__,-1);                
        }
    }
}

?>