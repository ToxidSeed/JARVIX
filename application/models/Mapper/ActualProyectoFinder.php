<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'ProyectoUsuarioMapper.php';
require_once MAPPERPATH.'SysUsuarioMapper.php';

class ActualProyectoFinder extends ProyectoUsuarioMapper{    
    public function Get($UsuarioId){
        $this->load->database();
        $this->db->select($this->fields);        
        $this->db->from($this->tableName);        
        $this->db->where('sysusuarioid',$UsuarioId);
        $this->db->where('flgproyectoactual',1);
        $get = $this->db->get();
        $response = $this->getSingleResponse($get);
        return $response;
    }
    public function GetByEmail($Email){
        $this->load->database();
        
        //Find User
        $mprSysUsuario = new SysUsuarioMapper();
        $mprSysUsuario->addUnique('email', $Email);
        $dmnSysUsuario = $mprSysUsuario->find();
        
        //Find Current Project
        return $this->Get($dmnSysUsuario);                
    }
            
}

?>
