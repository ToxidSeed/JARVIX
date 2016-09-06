<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainComentario.php';

class ComentarioMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'id',        
        'texto'
    );
    
    protected $uniqueValues = array(
            array('id')
    );
    
    protected $tableName = 'Comentario';
    
    protected function doCreateObject(array $record = null){
        $dmnComentario = new DomainComentario($record['ID']);
        $dmnComentario->setTexto($record['TEXTO']);
        return $dmnComentario;
    }
    
    public function insert(DomainComentario $dmnComentario){
        $this->doInsert($dmnComentario);
    }
    
    protected function doInsert(DomainComentario $dmnComentario ){
        $field['texto'] = $dmnComentario->getTexto();
        $field['tipo'] = $dmnComentario->getTipo();
        $field['idreferencia'] = $dmnComentario->getIdReferencia();
        $this->db->set($field);
        $res = $this->db->insert($this->tableName);
        $dmnComentario->setId($this->db->insert_id());
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar comentario',-1);
        }        
    }
    
    public function update(DomainComentario $dmnComentario){
        $this->doUpdate($dmnComentario);
    }
    
    protected function doUpdate(DomainComentario $dmnComentario){
        $field['texto'] = $dmnComentario->getTexto();
        $this->db->set($field);
        $this->db->where('id',$dmnComentario->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al actualizar comentario',-1);
        }
    }
    
    public function delete($id){
        $this->doDelete($id);
    }
    
    protected function doDelete($id){
        $this->db->where('id',$dmnComentario->getId());
        $this->db->delete($this->tableName);
    }
}
