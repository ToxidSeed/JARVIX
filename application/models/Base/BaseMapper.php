<?php
require_once BASEMODELPATH.'ResponseModel.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class BaseMapper extends CI_Model{    
    
    
    protected $uniqueValues = array();
    
    protected $unique = array();
    
    protected $fields;
    
    protected $tableName;        
    
    function __construct(){
        parent::__construct();       
    }
    
    public function addUnique($field,$value){
        //Check exist field
        $this->unique[$field] = $value;
        return $this;
    }
    
    public function find($id = null){
        $this->load->database();
        $response = null;
        
        if($id == null && count($this->unique)== 0){
            throw new Exception('No se han ingresado criterios de Busqueda');            
        }
        
        if($id != null){
            $this->db->select($this->fields);
            $this->db->from($this->tableName);
            $this->db->where('id',$id);
            $res = $this->db->get();
            $response = $this->getSingleResponse($res);
        }                
        
        if(count($this->unique)>0){              
            if($this->checkExistUnique() == false){
                throw new Exception('No se ha encontrado clave unica declarada');
            }
            $res = $this->findByUnique();   
            
            $response = $res;
        }
        
        return $response;
        
    }
            
    public function findByUnique(){
        $this->load->database();
        
        $this->db->select($this->fields);
        $this->db->from($this->tableName);                
        foreach($this->unique as $field => $value){            
            $this->db->where($field,$value);
        }
        $res = $this->db->get();
        
        return $this->getSingleResponse($res);
    }                            
    
    private function checkExistUnique(){
        //print_r($this->unique);
        //print_r($this->uniqueValues);
        
        $arrUniqueValidEstructure = null;                
        $arrUniqueToValidateEstructure = array_keys($this->unique);
        
        $ctdFieldsUnique = count($this->unique);        
        foreach($this->uniqueValues as $uniqueValue){                        
            $arrUniqueValidEstructure = array_values($uniqueValue);            
            
            //print_r($arrUniqueValidEstructure);
            //print_r($arrUniqueToValidateEstructure);
            if($ctdFieldsUnique == count(array_intersect($arrUniqueValidEstructure, $arrUniqueToValidateEstructure))){
                return true;
            }
        }
        return false;
    }
    
    protected function getMultiResponse($response){
        
        $coll = array();
        if($response->num_rows() > 0){
            foreach($response->result_array() as $record){
                $record = array_change_key_case($record,CASE_UPPER);
                $coll[] = $this->doCreateObject($record);
            }
        }
        return $coll;
    }
    
    protected function getSingleResponse($response){
        $record = null;
        if($response->num_rows() > 1){
            throw new Exception('Mas de un registro devuelto');
        }
        if($response->num_rows() == 1){
            $res = array_change_key_case($response->row_array(),CASE_UPPER);
            $record = $this->doCreateObject($res);
        }
        
        return $record;
    }
    
    public function finder(Constraints $myConstraints,$begin,$end){
        $this->load->database();
        $myConstraints->setDB($this->db);
        $this->db->select($this->fields);
        $this->db->from($this->tableName);  
        //Solo si se envia el tamaño de la pagina se realiza el limite
        if($end > 0){
            $this->db->limit($end,$begin);
        }                
        $myConstraints->generate();
        $response = $this->db->get();         
//        echo $this->db->last_query();
        return $this->getMultiResponse($response);
    }
    
    public function count(Constraints $myConstraints){
        $this->load->database();
        $myConstraints->setDB($this->db);
        $this->db->select('count(1) as rowcount');        
        $this->db->from($this->tableName);                                
        $myConstraints->generate();
        $response = $this->db->get();        
        return $response->row()->rowcount;
    }
    
    /*
     * Funcion que devuelve el resultado de una consulta por construir
     */
    public function search($myConstraints,$begin = 0,$end = 0){        
        $results = $this->finder($myConstraints,$begin,$end);
        $count = $this->count($myConstraints);
        
        return new ResponseModel($results, $count);
    }            
    
}
?>
