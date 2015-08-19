<?php

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainTipoControl.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainTecnologia.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class TipoControlMapper extends BaseMapper{
    function __construct(){
        parent::__construct();
    }
    protected $fields = array(
      'id',
        'nombre',
        'fechaRegistro',
        'fechaUltAct',
        'estadoId'
    );
    protected $uniqueValues = array(
        array('id')
    );
    
    protected $tableName = 'Control';
    
    protected function doCreateObject(array $record = null){
        $dmnTipoControl = new DomainTipoControl($record['ID']);
        $dmnTipoControl->setNombre($record['NOMBRE']);
        $dmnTipoControl->setFechaRegistro($record['FECHAREGISTRO']);
        $dmnTipoControl->setFechaUltAct($record['FECHAULTACT']);
        $dmnTipoControl->setEstado(new DomainEstado($record['ESTADOID']));
        $dmnTipoControl->setTecnologia(new DomainTecnologia('TECNOLOGIAID'));
        return $dmnTipoControl;
    }
    public function insert(DomainTipoControl $dmnTipoControl){
        $this->doInsert($dmnTipoControl);
    }
    protected function doInsert(DomainTipoControl $dmnTipoControl){        
        $this->load->database();
        $fields['nombre'] = $dmnTipoControl->getNombre();
        $fields['fechaRegistro'] = $dmnTipoControl->getFechaRegistro();
        $fields['fechaultact'] = $dmnTipoControl->getFechaUltAct();
        $fields['estadoid'] = $dmnTipoControl->getEstado()->getId();
        $fields['tecnologiaid'] = $dmnTipoControl->getTecnologia()->getId();
        $this->db->set($fields);
        $resInsert = $this->db->insert($this->tableName);
        //Recuperando el ultimo valor
        $dmnTipoControl->setId($this->db->insert_id());
        //
        if(!$resInsert){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la Base de Datos',-1);
        }        
    }
    
    public function update(DomainTipoControl $dmnTipoControl){
        $this->doUpdate($dmnTipoControl);
    }
    
    protected function doUpdate(DomainTipoControl $dmnTipoControl){        
        $fields['nombre'] = $dmnTipoControl->getNombre();
        $fields['fechaultact'] = $dmnTipoControl->getFechaUltAct();
        $fields['estadoid'] = $dmnTipoControl->getEstado()->getId();
        $fields['tecnologiaid'] = $dmnTipoControl->getTecnologia()->getId();
        $this->db->set($fields);
        $this->db->where('id',$dmnTipoControl->getId());
        $resUpdate = $this->db->update($this->tableName);
        if(!$resUpdate){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar en la Base de Datos',-1);
        }        
    }                
}

?>
