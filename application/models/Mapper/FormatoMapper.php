<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainFormato.php';

class FormatoMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'id',
        'tipodato',
        'fecharegistro',
        'fechaultact',
        'flgpermitetamano',
        'flgpermiteprecision',
        'flgpermitemascara',        
        'flgpermitemayusculas',
        'flgpermiteminusculas',
        'flgpermitedetalle'
    );
    
    protected $uniqueValues = array(
        array('id')
    );
    
    protected $tableName = 'formato';
    
    protected function doCreateObject(array $record = null){
        $dmnFormato = new DomainFormato($record['ID']);
        $dmnFormato->setTipoDato($record['TIPODATO']);
        $dmnFormato->setFechaRegistro($record['FECHAREGISTRO']);
        $dmnFormato->setFechaUltAct($record['FECHAULTACT']);
        $dmnFormato->setFlgPermiteTamano($record['FLGPERMITETAMANO']);
        $dmnFormato->setFlgPermitePrecision($record['FLGPERMITEPRECISION']);
        $dmnFormato->setFlgPermiteMascara($record['FLGPERMITEMASCARA']);
        $dmnFormato->setFlgPermiteMayusculas($record['FLGPERMITEMAYUSCULAS']);
        $dmnFormato->setFlgPermiteMinusculas($record['FLGPERMITEMINUSCULAS']);
        $dmnFormato->setFlgPermiteDetalle($record['FLGPERMITEDETALLE']);
        return $dmnFormato;
    }
    
    public function insert(DomainFormato $record){
        $this->doInsert($record);
    }
    protected function doInsert(DomainFormato $record){
        $this->load->database();
        $fields['tipodato'] = $record->getTipoDato();
        $fields['flgpermitetamano'] = $record->getFlgPermiteTamano();
        $fields['flgpermiteprecision'] = $record->getFlgPermitePrecision();
        $fields['flgpermitemascara'] = $record->getFlgPermiteMascara();
        $fields['flgpermitemayusculas'] = $record->getFlgPermiteMayusculas();
        $fields['flgpermiteminusculas'] = $record->getFlgPermiteMinusculas();  
        $fields['flgpermitedetalle'] = $record->getFlgPermiteDetalle();
        $fields['fecharegistro'] = $record->getFechaRegistro();
        $fields['fechaultact'] = $record->getFechaUltAct();
                
        $this->db->set($fields);
        $resInsert = $this->db->insert($this->tableName);
        
//        echo $this->db->last_query();
        
        $record->setId($this->db->insert_id());
        
        if(!$resInsert){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la Base de Datos',-1);
        }
        
       
    }
     public function update(DomainFormato $dmnFormato){
            $this->doUpdate($dmnFormato);            
     }
     
     protected function doUpdate(DomainFormato $dmnFormato){
        $fields['tipodato'] = $dmnFormato->getTipoDato();
        $fields['flgpermitetamano'] = $dmnFormato->getFlgPermiteTamano();
        $fields['flgpermiteprecision'] = $dmnFormato->getFlgPermitePrecision();
        $fields['flgpermitemascara'] = $dmnFormato->getFlgPermiteMascara();
        $fields['flgpermitemayusculas'] = $dmnFormato->getFlgPermiteMayusculas();
        $fields['flgpermiteminusculas'] = $dmnFormato->getFlgPermiteMinusculas();  
        $fields['flgpermitedetalle'] = $dmnFormato->getFlgPermiteDetalle();
        $fields['fecharegistro'] = $dmnFormato->getFechaRegistro();
        $fields['fechaultact'] = $dmnFormato->getFechaUltAct();      
         $this->db->set($fields);
         $this->db->where('id',$dmnFormato->getId());
         $resUpdate = $this->db->update($this->tableName);
         if(!$resUpdate){
             $this->db->trans_rollback();
             throw new Exception('Error al Actualizar en la Base de Datos',-1);
         }         
     }
     
     public function search(){
         $this->load->database();
         $this->db->select($this->fields);
         $this->db->from($this->tableName);
         $response = $this->db->get();
         $arrResponse = $this->getMultiResponse($response);
         return new ResponseModel($arrResponse, count($arrResponse));
     }
     
}
