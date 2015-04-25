<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'SysOpcionAplicacionMapper.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class WinPrincipalBO extends BaseBO{
    
    function __construct() {
        parent::__construct();
    }
    protected $sysAplicacion;
    public function setSysAplicacion(DomainSysAplicacion $dmnSysAplicacion){
        $this->sysAplicacion = $dmnSysAplicacion;
    }
            
    
    
}
?>
