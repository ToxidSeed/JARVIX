<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'TipoFlujoMapper.php';

class FinderTipoFlujoDefault extends TipoFlujoMapper{
    public function search(){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('flgdefault',1);
        $response = $this->db->get();
        
        return $this->getSingleResponse($response);                     
    }
}

