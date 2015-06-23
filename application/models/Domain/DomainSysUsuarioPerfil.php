<?php
require_once BASEMODELPATH.'BaseDomain.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DomainSysUsuarioPerfil
 *
 * @author usuario
 */
class DomainSysUsuarioPerfil extends BaseDomain{
    //put your code here
    protected $id;
    protected $sysUsuario;
    protected $sysPerfil;
    
    function getId() {
        return $this->id;
    }

    function getSysUsuario() {
        return $this->sysUsuario;
    }

    function getSysPerfil() {
        return $this->sysPerfil;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setSysUsuario($sysUsuario) {
        $this->sysUsuario = $sysUsuario;
    }

    function setSysPerfil($sysPerfil) {
        $this->sysPerfil = $sysPerfil;
    }


}
