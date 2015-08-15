<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainPasoFlujo.php';
require_once DOMAINPATH.'DomainProcesoFlujo.php';
require_once DOMAINPATH.'DomainTipoFlujo.php';

class PasoFlujoMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
       'id' ,
        'procesoflujoid',
        'tipoflujoid',
        'numeropaso',
        'descripcion',
        'responsable',
        'numeroflujo',
        'pasoflujoreferenciaid'
    );
    
    protected $uniqueValues = array(
        array('id')
    );
    
    protected $tableName = 'PasoFlujo';
    
    protected function doCreateObject(array $record = null){
        $dmnPasoFlujo = new DomainPasoFlujo($record['ID']);
        $dmnPasoFlujo->setProcesoFlujo(new DomainProcesoFlujo($record['PROCESOFLUJOID']));
        $dmnPasoFlujo->setNumeroPaso($record['NUMEROPASO']);
        $dmnPasoFlujo->setNumeroFlujo($record['NUMEROFLUJO']);                
        $dmnPasoFlujo->setTipoFlujo(new DomainTipoFlujo($record['TIPOFLUJOID']));
        $dmnPasoFlujo->setDescripcion($record['DESCRIPCION']);
        $dmnPasoFlujo->setResponsable($record['RESPONSABLE']);               
        $dmnPasoFlujo->setPasoFlujoReferencia(new DomainPasoFlujo($record['PASOFLUJOREFERENCIAID']));        
        return $dmnPasoFlujo;
    }
    
    public function insert(DomainPasoFlujo $dmnPasoFlujo){
        $this->doInsert($dmnPasoFlujo);
    }
    protected function doInsert(DomainPasoFlujo $dmnPasoFlujo){
        $fields['procesoflujoid'] = $dmnPasoFlujo->getProcesoFlujo()->getId();                
        $fields['numeroflujo'] = $dmnPasoFlujo->getNumeroFlujo();
        $fields['descripcion'] = $dmnPasoFlujo->getDescripcion();
        $fields['tipoflujoid'] = $dmnPasoFlujo->getTipoFlujo()->getId();
        $fields['numeropaso'] = $dmnPasoFlujo->getNumeroPaso();    
        if ( $dmnPasoFlujo->getPasoFlujoReferencia() != null){
            $fields['pasoflujoreferenciaid'] = $dmnPasoFlujo->getPasoFlujoReferencia()->getId();
        }       
        //$fields['responsable'] = $dmnPasoFlujo->getResponsable();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);

        //echo $this->db->last_query();
        
        $dmnPasoFlujo->setId($this->db->insert_id());
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la Base de Datos Detalle Proceso Flujo Mapper',-1);
            
        }
    }
    public function update(DomainPasoFlujo $dmnPasoFlujo){
        $this->doUpdate($dmnPasoFlujo);
    }
    
    protected function doUpdate(DomainPasoFlujo $dmnPasoFlujo){
        $fields['procesoflujoid'] = $dmnPasoFlujo->getProcesoFlujo()->getId();
        $fields['numeroflujo'] = $dmnPasoFlujo->getNumeroFlujo();       
        $fields['numeropaso'] = $dmnPasoFlujo->getNumeroPaso();
        $fields['tipoflujoid'] = $dmnPasoFlujo->getTipoFlujo()->getId();
        $fields['descripcion'] = $dmnPasoFlujo->getDescripcion();
        $fields['responsable'] = $dmnPasoFlujo->getResponsable();
        $this->db->set($fields);
        $this->db->where('id',$dmnPasoFlujo->getId());
        $res = $this->db->update($this->tableName);
        
//        echo $this->db->last_query();
        
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar el Detalle Proceso Flujo',-1);
        }
    }
    
    public function delete(DomainPasoFlujo $dmnPasoFlujo){
        $this->doDelete($dmnPasoFlujo);
    }
    
    protected function doDelete(DomainPasoFlujo $dmnPasoFlujo){
        $this->db->where('id',$dmnPasoFlujo->getId());
        $res = $this->db->delete($this->tableName);
       
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Borrar un registro de la base de datos',-1);
        }
    }
}