<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DomainSysPerfilOpcionApp
 *
 * @author usuario
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainSysPerfilOpcionApp  extends BaseDomain{
    //put your code here
    protected $id;
    protected $sysPerfil;
    protected $sysOpcionAplicacion;
    
    function getId() {
        return $this->id;
    }

    function getSysPerfil() {
        return $this->sysPerfil;
    }

    function getSysOpcionAplicacion() {
        return $this->sysOpcionAplicacion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setSysPerfil($sysPerfil) {
        $this->sysPerfil = $sysPerfil;
    }

    function setSysOpcionAplicacion($sysOpcionAplicacion) {
        $this->sysOpcionAplicacion = $sysOpcionAplicacion;
    }


    
}
