<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SysOpcionAplicacionFRM1
 *
 * @author usuario
 */
require_once MAPPERPATH.'SysOpcionAplicacionMapper.php';

class SysOpcionAplicacionFRM1 extends SysOpcionAplicacionMapper {
    //put your code here
    function __construct() {
        parent::__construct();
    }
    public function search($params){        
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->join('sysperfilopcionapp','sysopcionaplicacion.id =    sysperfilopcionapp.SysOpcionAplicacionId');
        $this->db->join('sysperfil','sysperfilopcionapp.sysperfilid = sysperfil.id');
        $this->db->join('sysusuarioperfil','sysperfil.id = sysusuarioperfil.sysperfilid');
        $this->db->where('sysusuarioperfil.sysusuarioid',$params['UsuarioId']);
        $this->db->where('sysopcionaplicacion.flghabilitado',1);
        $this->db->group_by($this->fields);
        $response = $this->db->get();        
        $arrResponse = $this->getMultiResponse($response);              
        return new ResponseModel($arrResponse, count($arrResponse));        
    }
}
