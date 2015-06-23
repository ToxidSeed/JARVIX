<?php
require_once LIBATH.'Answer.php';
require_once MESSAGESPATH.'Message.php';
require_once BASEMODELPATH.'Constraints.php';
require_once LIBATH.'Response/Response.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class BaseController extends CI_Controller{
    
    private $answer;
    
    function __construct(){
        parent::__construct();
        date_default_timezone_set('America/Lima');
        $this->load->helper('url');
        $this->answer = new Answer();
    }   
    
    public function index(){
        
    }
    
    public function getAnswer(){
        return $this->answer;
    }
    
    
    private function createFieldErrorAnswer(Answer $myAnswer,array $flderrs) {
        
        $field = null;
        // On validation error returns the error messages with the fields invloved and his error messages
        $count = count($flderrs);        
        for($i=0; $i < $count; $i++) {  
        // get  the field  name
            $field = $flderrs[$i]['field'];
            $myAnswer->addFieldError($field,$this->form_validation->error($field));
            // Get the error message for the field           
            //$field = NULL;
        }
        $flderrs = NULL;
    }        
    
    function formValidation($Archivo,$Seccion,$type)
    {                                
        if($Seccion == ''){
            $Seccion = 'Validation';
        }
        $this->load->library('form_validation');
        $this->load->config(FOLDERVALIDATION.$Archivo.'Validation');
        $rules = $this->config->item($Seccion);
        $this->form_validation->set_error_delimiters('','');
        $this->form_validation->set_rules($rules[$type]);
        if ($this->form_validation->run() == false)
        {
            $myAnswer = new Answer();
            $myAnswer->setSuccess(false);
            $myAnswer->setCode(FORM_VALIDATION_ERRORS_CODE);            
            $myAnswer->setAsWarning();
            $this->answer = $myAnswer;
            $this->createFieldErrorAnswer($myAnswer, $rules[($type)]);
            throw new Exception(FORM_VALIDATION_ERRORS_MSG,FORM_VALIDATION_ERRORS_CODE);                
        }	                        
    }
    
    public function getField($field){
       $value = $this->input->get_post($field);       
       if($value === false){
           throw new Exception('El Valor enviado: '.$field.' al que se esta intentando acceder no existe',ERROR_GENERAL_CODE);
       }
       return $value;
    }
//    public function getDateField($field){
//        $value = $this->input->get_post($field);
//        if($value === false){
//           throw new Exception('El Valor enviado: '.$field.' al que se esta intentando acceder no existe',ERROR_GENERAL_CODE);
//        }
//        $this->load->library('DateConvert');
//        $formatedDate = $this->dateconvert->convert($value);
//        return $formatedDate;
//    }
      
         
}
?>
