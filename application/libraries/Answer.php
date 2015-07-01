<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Answer {
    protected $errors = array();
    protected $success;
    protected $code;
    protected $message = array();
    protected $extradata = array();
    protected $type;
            
    public function setSuccess($success){
        $this->success = $success;
        return $this;
    }    
    public function setCode($code){
        $this->code = $code;
        return $this;
    }
    public function addMessage($message){
        $this->message[] = $message;
    }
    public function setMessage($message){
        $this->message = $message;
        return $this;
    }
    public function addExtraData($field,$value){
        //$this->extradata[] = array($field => $value);
        $this->extradata[$field] =  $value;
        return $this;
    }
    
  
    
    public function getAsArray(){
        $message = null;
        
        if (is_array($this->message)){
            if(count($this->message) == 1){
                $message = current($this->message);
            }
        }else{
            $message = $this->message;
        }
                           
        $response = array(
                        'success' => $this->success,
                        'code'     => $this->code,
                        'message'  => $message,
                        'extradata' => $this->extradata,
                        'errors'    => $this->errors,
                        'type'      => $this->type
                    );
        
        return $response;
    }
    public function getAsJSON(){
        return json_encode($this->getAsArray());
    }
    public static function setSuccessMessage($message,$code = 0,$JSON = true,$type = 'Informacion',array $extradata = null){
        $response = array(
            'success' => true,
            'message' => $message,
            'code' => $code,
            'type' => $type,
            'extradata' => $extradata
        );
        
        if($JSON == TRUE){
            return json_encode($response);
        }
        return $response;
    }
    public static function setFailedMessage($message,$code = 0,$JSON = true,$type = 'Error'){
        $response = array(
            'success' => false,
            'message' => $message,
            'code' => $code,
            'type' => $type
        );
        
        if($JSON == TRUE){
            return json_encode($response);
        }
        return $response;
    }
    public function addFailMessage($message,$code =-1,$JSON = true,$type = 'Error'){
        $this->addMessage($message);
        $this->code = $code;
        $this->setSuccess(false);
    }
    
    
    public function addFieldError($field,$errorMsg){
        if (isset ($field) && strlen($field) > 0) {
            if (isset ($errorMsg) && strlen($errorMsg) > 0) {
                $this->errors[$field] = $errorMsg; 
            }
        }                    
    }
    public function hasErrors(){
        if(count($this->errors) > 0){
            return true;
        }
        return false;
    }
    public function showSuccessMessage($message,$extradata = null){
        if($this->code == 0){
            $this->message = $message;
            $this->extradata = $extradata;
        }
        
        echo $this->getAsJSON();
    }
    
    public function setAsWarning(){
        $this->type = 'Advertencia';
    }
}


?>
