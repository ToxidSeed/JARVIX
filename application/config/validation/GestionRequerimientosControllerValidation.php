<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$config['Validation'] = array(
    'add' => array(
        array(
            'field' => 'nombre',
            'label' => 'Nombre',
            'rules' => 'required'
        )
    ),
    'ChangeStatus' => array(
        array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required'
        ),
        array(
            'field' => 'nombre',
            'label' => 'nombre',
            'rules' => 'required'
        ),
        array(
            'field' => 'currentStatus',
            'label' => 'estado',
            'rules' => 'required'
        )
    ),
    'update'=> array(
        array(
            'field' => 'nombre',
            'label' => 'Nombre',
            'rules' => 'required'
        )
    )
);
?>
