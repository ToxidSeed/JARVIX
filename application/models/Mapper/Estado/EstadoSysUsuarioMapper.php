<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'EstadoMapper.php';
/**
 * Description of EstadoSysUsuario
 *
 * @author usuario
 */
class EstadoSysUsuarioMapper extends EstadoMapper{
    //put your code here
    function __construct() {
        //Indicador de tipo de estado para Usuarios es el nro 1
        parent::__construct(1);
    }
}
