<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'SysPerfilOpcionAppMapper.php';
/**
 * Description of FinderSysPerfilOpcionAppFRM1
 *
 * @author usuario
 */
class SysPerfilOpcionAppFRM1 extends SysPerfilOpcionAppMapper{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    public function search($params){
        $this->load->database();
        $this->db->distinct($this->fields);
        $this->db->from($this->tableName);
        $this->db->join('sysperfil','sysperfilopcionapp.sysperfilid = sysperfil.id');
        $this->db->join('sysusuarioperfil','sysperfil.id = sysusuarioperfil.sysperfilid');
        $this->db->where('sysusuarioperfil.id',$params['UsuarioId']);
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);              
        return new ResponseModel($arrResponse, count($arrResponse));
    }
}
