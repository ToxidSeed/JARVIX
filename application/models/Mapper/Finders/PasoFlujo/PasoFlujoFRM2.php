<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'PasoFlujoMapper.php';
/**
 * Description of PasoFlujoFRM2
 *
 * @author usuario
 */
class PasoFlujoFRM2 extends PasoFlujoMapper{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    protected $fields = array(
         'id',
        'pasoflujoreferenciaid',
        'tipoflujoid',
        'numeroflujo',
        'numeropaso'
        
        );
    public function search(array $filters = null){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('procesoflujoid',$filters['ProcesoFlujoId']);
        $this->db->order_by('tipoflujoid,numeroflujo,numeropaso');
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse,count($arrResponse));
    }
    
    protected function doCreateObject(array $record = null){
        $dmnPasoFlujo = new DomainPasoFlujo($record['ID']);
        $dmnPasoFlujo->setTipoFlujo(new DomainTipoFlujo($record['TIPOFLUJOID']));
        $dmnPasoFlujo->setPasoFlujoReferencia(new DomainPasoFlujo($record['PASOFLUJOREFERENCIAID']));
        $dmnPasoFlujo->setNumeroFlujo($record['NUMEROFLUJO']);
        $dmnPasoFlujo->setNumeroPaso($record['NUMEROPASO']);
        return $dmnPasoFlujo;
    }
}
