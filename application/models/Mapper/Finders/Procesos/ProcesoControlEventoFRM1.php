<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'EventoMapper.php';
/**
 * Description of ProcesoControlEventoFRM1
 *
 * @author usuario
 */
class ProcesoControlEventoFRM1 extends EventoMapper{
    //put your code here
     public function __construct() {
        parent::__construct();
    }
    
    public function search(array $filters = null){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->join('procesocontrolevento',
                'evento.controlid = procesocontrolevento.controlid '
                . 'and evento.id = procesocontrolevento.eventoid '
                . 'and procesocontrolevento.procesocontrolid = '.$filters['ProcesoControlId'],'left');        
        $this->db->where('evento.controlid',$filters['ControlId']);
        $this->db->where('procesocontrolevento.id is null');
        if(isset($filters['NombreEvento']) && Trim($filters['NombreEvento']) != '' ){
            $this->db->where('evento.nombre',$filters['NombreEvento']);
        }
        $response = $this->db->get();
        //echo $this->db->last_query();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse,count($arrResponse));
    }
}
