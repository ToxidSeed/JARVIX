<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'PropiedadMapper.php';
require_once DOMAINPATH.'DomainPropiedad.php';

class FinderActivePropiedades extends PropiedadMapper{
    public $nombre;
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
      'id'  ,
      'nombre'        
    );    
    protected $tableName = 'propiedad';
    
    protected function doCreateObject(array $record = null){
        $dmnPropiedad = new DomainPropiedad($record['ID']);
        $dmnPropiedad->setNombre($record['NOMBRE']);
        return $dmnPropiedad;
    }
    
    
    public function Search(){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        //$this->db->where('estadoid',1);//Aplicaciones Activas, agregar el campo estadoid en la tabla propiedad
        if($this->nombre != ''){
            $this->db->like('nombre',$this->nombre,'both');
        }        
        $response = $this->db->get(); 
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse,count($arrResponse));
    }
    
    

}
?>
