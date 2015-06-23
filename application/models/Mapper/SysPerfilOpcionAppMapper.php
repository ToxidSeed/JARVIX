<?php
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainSySPerfil.php';
require_once DOMAINPATH.'DomainSysOpcionAplicacion.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SysPerfilOpcionApp
 *
 * @author usuario
 */
class SysPerfilOpcionAppMapper extends BaseMapper{
    //put your code here
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'sysperfilopcionapp.id',
        'sysperfilopcionapp.sysperfilid',
        'sysperfilopcionapp.sysopcionaplicacionid'
    );
    
    protected $tableName = 'sysperfilopcionapp';
    
    protected $uniqueValues = array(
        array('id'),
        array('sysperfilid','sysopcionaplicacionid')
    );
    
    protected function doCreateObject(array $record = null){
        $dmnSysPerfilOpcionApp = new DomainSysPerfilOpcionApp();
        $dmnSysPerfilOpcionApp->setId($record['ID']);
        $dmnSysPerfilOpcionApp->setPerfil(new DomainSysPerfil($record['SYSPERFILID']));
        $dmnSysPerfilOpcionApp->setSysOpcionAplicacion(new DomainSysOpcionAplicacion($record['SYSOPCIONAPLICACIONID']));
        return $dmnSysPerfilOpcionApp;        
    }
}
