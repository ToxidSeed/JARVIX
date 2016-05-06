<?php
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainEvento.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainTipoControl.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class EventoMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
      'evento.id',
       'evento.nombre',
        'evento.fecharegistro',
        'evento.fechaultact',
//        'estadoid',
        'evento.controlid'
    );
    protected $uniqueValues = array(
        array('id')
    );
    
    protected $tableName = 'Evento';
    
    protected function doCreateObject(array $record = null){
        $dmnEvento = new DomainEvento($record['ID']);
        $dmnEvento->setNombre($record['NOMBRE']);
        $dmnEvento->setFechaRegistro($record['FECHAREGISTRO']);
        $dmnEvento->setFechaUltAct($record['FECHAULTACT']);
//        $dmnEvento->setEstado(new DomainEstado($record['ESTADOID']));
        $dmnEvento->setControl(new DomainTipoControl('CONTROLID'));
        return $dmnEvento;
    }
    
    public function insert(DomainEvento $dmnEvento){
        $this->doInsert($dmnEvento);
    }
    
    protected function doInsert(DomainEvento $dmnEvento){
        $this->load->database();
        $fields['nombre'] = $dmnEvento->getNombre();
        $fields['fecharegistro'] = $dmnEvento->getFechaRegistro();
        $fields['fechaultact'] = $dmnEvento->getFechaUltAct();
        //$fields['estadoid'] = $dmnEvento->getEstado()->getId();
        $fields['controlid'] = $dmnEvento->getControl()->getId();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        if(!$res){                        
            $this->db->trans_rollback();            
            throw new Exception('Error al Insertar en la Base de Datos EventoMapper',-1);
        }
    }
    
    public function update(DomainEvento $dmnEvento){
        $this->doUpdate($dmnEvento);
    }
    protected function doUpdate(DomainEvento $dmnEvento){
        $this->load->database();
        $fields['nombre'] = $dmnEvento->getNombre();
        $fields['fecharegistro'] = $dmnEvento->getFechaRegistro();
        $fields['fechaultact'] = $dmnEvento->getFechaUltAct();
        $fields['estadoid'] = $dmnEvento->getEstado()->getId();
        $fields['controlid'] = $dmnEvento->getControl()->getId();
        $this->db->set($fields);
        $this->db->where('id',$dmnEvento->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar la Base de Datos',-1);
        }
        
    }
}
?>
