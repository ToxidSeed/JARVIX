<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'PasoFlujoMapper.php';

class FinderFlujos extends PasoFlujoMapper{
	public function __construct(){
		parent::__construct();
	}

    protected $fields = array(
            'procesoflujoid',
            'tipoflujoid',
            'numeroflujo',
            'pasoflujoreferenciaid'
    );

    public function Search($procesoFlujoId,$type,$pasoReferenciaId = null){   
        $this->load->database();    
        $this->db->select($this->fields);
        $this->db->from($this->tableName);        
        $this->db->where('procesoflujoid',$procesoFlujoId);
        $this->db->where('tipoflujoid',$type);
        if($pasoReferenciaId != null){
            $this->db->where('pasoflujoreferenciaid',$pasoReferenciaId);
        }
        $this->db->group_by($this->fields);
        $this->db->order_by('pasoflujoreferenciaid','asc');
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));          
    }    

    protected function doCreateObject(array $record = null){
        $dmnPasoFlujo = new DomainPasoFlujo();
        $dmnPasoFlujo->setProcesoFlujo(new DomainProcesoFlujo($record['PROCESOFLUJOID']));
        $dmnPasoFlujo->setTipoFlujo(new domainTipoFlujo($record['TIPOFLUJOID']));
        $dmnPasoFlujo->setNumeroFlujo($record['NUMEROFLUJO']);
        $dmnPasoFlujo->setPasoFlujoReferencia(new DomainPasoFlujo($record['PASOFLUJOREFERENCIAID']));
        return $dmnPasoFlujo;
    }
}

?>
