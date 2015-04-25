<?php
require_once BASEMODELPATH.'Field.php' ;
require_once BASEMODELPATH.'Like.php' ;
require_once BASEMODELPATH.'Equal.php' ;
require_once BASEMODELPATH.'GreaterTO.php';
require_once BASEMODELPATH.'DateGreaterTO.php';
require_once BASEMODELPATH.'LowerTO.php';
require_once BASEMODELPATH.'DateLowerTO.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Constraints 
{
    protected $db;
    protected $field; //Setea el actual Field al que se esta agregando constraints
    protected $constraints = array();
    
    public function setDB($db){
        $this->db = $db;
    }    
    public function getDB(){
        return $this->db;
    }
    
    public function field($field){
        $myField = new Field($field,$this);
        $this->field = $myField;
        $this->constraints[] = $myField;
        return $this;
    }
    public function eq($value,$searchIfNULL = false){
        if($searchIfNULL == false && (is_null($value) || empty($value) ) ){
            return $this;
        }
        $this->field->addCondition(new Equal($value));
        return $this;
    }        
    public function like($value,$type='both',$searchIfNULL = false){
        if($searchIfNULL == false && (is_null($value)) || empty($value) ){
            return $this;
        }
        $this->field->addCondition(new Like($value, $type));        
        return $this;
    }
    
    public function greaterTO($value,$equal = false,$searchIfNULL = false){
        if($searchIfNULL == false && (is_null($value) || empty($value)) ){
            return $this;
        }        
        $this->field->addCondition(new GreaterTO($value, $equal));        
        return $this;
    }
    public function lowerTO($value,$equal = false,$searchIfNULL = false){
        if($searchIfNULL == false && (is_null($value)) || empty($value) ){
            return $this;
        }        
        $this->field->addCondition(new LowerTO($value, $equal));        
        return $this;
    }
    public function dateGreaterTO($value,$equal = false,$searchIfNULL = false){
        if($searchIfNULL == false && (is_null($value) || empty($value))){
            return $this;
        }
        $this->field->addCondition(new DateGreaterTO($value,$equal));
        return $this;
    }
    public function dateLowerTO($value,$equal = false,$searchIfNULL = false){
        if($searchIfNULL == false && (is_null($value) || empty($value))){
            return $this;
        }
        $this->field->addCondition(new DateLowerTO($value,$equal));
        return $this;
    }
    
    public function generate(){        
        foreach($this->constraints as $field){
            foreach($field->getConditions() as $myCondition){
                $myCondition->execute();
            }
        }
    }    
}
?>
