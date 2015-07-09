<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'EstadoMapper.php';
/**
 * Description of EstadoRequerimientoMapper
 *
 * @author usuario
 */
class EstadoRequerimientoMapper extends EstadoMapper{
    //put your code here
     function __construct() {
        //Indicador de tipo de estado es el nro 2 (Estado de Proyectos)
        parent::__construct(3);
    }
}
