<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$config['Validation'] = array(
    'Add' => array(
                    array(
                        'field' => 'Nombre',
                        'label' => 'Nombre',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'Descripcion',
                        'label' => 'Descripcion',
                        'rules' => 'required'
                    ),
    )
);
?>
