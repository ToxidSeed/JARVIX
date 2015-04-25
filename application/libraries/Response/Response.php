<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Response{
    static function asResults(ResponseModel $myResponseModel){                
        
        $results = array();
        
        foreach($myResponseModel->getResults() as $myObject){
            $results[] = Response::searchObject($myObject);
        }
        
        $data = array(
            'results' => $results,
            'total' => $myResponseModel->getCount(),
            'success' => true
        );
        return $data;
    }
    private static function searchObject($myObject){
        $myObjectValues = $myObject->getValues();
        if(count($myObjectValues) > 0){
            foreach($myObjectValues as $key => $value){                
                
                if(is_object($value)){
                    
                   $myObjectValues[$key] =  Response::searchObject($value);
                }
            }
        }
        return $myObjectValues;
    }
    static function asSingleObject($object){
        $data = array(
            'success' => true,
            'data' => Response::searchObject($object)
        );
        return $data;
    }
}
?>
