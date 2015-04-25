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
    'update' => array(
                    array(
                        'field' => 'nombre',
                        'label' => 'Nombre',
                        'rules' => 'required'
                    )
    ),
    'inactivate' => array(
                    array(
                        'field' => 'nombre',
                        'label' => 'Nombre',
                        'rules' => 'required'
                    )
    )
);
?>
