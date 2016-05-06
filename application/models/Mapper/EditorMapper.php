<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EditorMapper
 *
 * @author usuario
 */
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainEditor.php';

class EditorMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    
    protected $fields = array(
        'id',
        'constante'
    );
    
    protected $tableName = 'editor';
    
    public function doCreateObject(array $record = null){
        $dmnEditor = new DomainEditor($record['ID']);
        $dmnEditor->setConstante($record['CONSTANTE']);
        return $dmnEditor;
    }
}
