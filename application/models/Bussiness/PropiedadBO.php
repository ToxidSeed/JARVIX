<?php
require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'PropiedadMapper.php';
require_once MAPPERPATH.'ValorPropiedadMapper.php';
require_once DOMAINPATH.'DomainValorPropiedad.php';


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class PropiedadBO extends BaseBO{
    function __construct() {
        parent::__construct();
        $this->valorPropiedadMapper = new ValorPropiedadMapper();
    }
    protected $dmnPropiedad;
    protected $valores;
    protected $valorPropiedadMapper;
    
    function setDmnPropiedad(DomainPropiedad $dmnPropiedad){
        $this->dmnPropiedad = $dmnPropiedad;
    }
    function getDmnPropiedad(){
        return $this->dmnPropiedad;
    }
    
    function setValores(array $parValores = null){
        foreach($parValores as $row){
            $dmnValores = new DomainValorPropiedad();
            $dmnValores->setValor($row['valor']);
            $dmnValores->setPropiedad($this->getDomain());
            $this->valores[]  = $dmnValores;
        }        
    }
    
    function add(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $this->checkObject();
            
            //Por cada valor insertar un registro en valor propiedad
            
            $mprPropiedad = new PropiedadMapper();
            $mprPropiedad->insert($this->getDomain());
            
            foreach($this->valores as $dmnValores){
                $this->valorPropiedadMapper->insert($dmnValores);
            }
            
            $this->db->trans_commit();
        }catch(Exception $e){
            $this->db->trans_rollback();
            throw new Exception($e->getMessage(),$e->getCode());
        }
    }
    
    function update(){
        try{
            $this->load->database();
            $this->db->trans_start();
            
            $this->checkObject();
            
            $mprPropiedad = new PropiedadMapper();
            
            $dmnCurrentPropiedad = $mprPropiedad->find($this->domain->getId());
            $dmnCurrentPropiedad->setNombre($this->domain->getNombre());            
            $mprPropiedad->update($dmnCurrentPropiedad);            
            $this->db->trans_commit();
        }catch(Exception $ex){
            $this->db->trans_rollback();
            throw new Exception($ex->getMessage(),$ex->getCode());
        }
    }
     
    
}
?>