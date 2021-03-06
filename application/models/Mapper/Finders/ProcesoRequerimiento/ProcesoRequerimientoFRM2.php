<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProcesoRequerimientoFRM2
 *
 * @author usuario
 */
require_once MAPPERPATH.'ProcesoRequerimientoFuncionalMapper.php';

class ProcesoRequerimientoFRM2 extends ProcesoRequerimientoFuncionalMapper {
    //put your code here
    
    protected $fields = array('procesorequerimientofuncional.id',
        'procesorequerimientofuncional.fecharegistro',
        'procesorequerimientofuncional.procesoid',
        'requerimientofuncional.id as requerimientofuncionalid');
    
    public function search($params){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $join = $this->tableName.'.requerimientofuncionalid = requerimientofuncional.id and IFNULL(procesorequerimientofuncional.procesoid,0) = '.$params['parProcesoId'];
        $this->db->join('requerimientofuncional',$join,'right');        
        //$this->db->where('IFNULL(requerimientofuncional.id,0) <>',0);
        $response = $this->db->get();
//        echo $this->db->last_query();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse,count($arrResponse));
    }
}
