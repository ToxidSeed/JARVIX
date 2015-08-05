<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'PasoFlujoMapper.php';
/**
 * Description of FinderReferencias
 *
 * @author usuario
 */
class PasoFlujoFRM1 extends PasoFlujoMapper {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    public function Search($filters){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('pasflujoreferenciaid',$filters['PasoFlujoReferenciaId']);
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse,count($arrResponse));
    }
}
