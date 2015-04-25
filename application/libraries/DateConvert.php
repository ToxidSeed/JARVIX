<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class DateConvert {
    private $date;
    private $arrDateParsed;
    private $formatedDate;
    
    public function convert($value){    
        //Setting the Values        
        $this->date = $value;                
        $this->arrDateParsed = date_parse($this->date);
        
        //Initializing Values
        $this->formatedDate = null;
        
        //Create Date
        $this->createDate();
        return $this->formatedDate;
    }
    private function createDate(){
        $splitFormat = str_split(APPDATEFORMAT); 
        $this->addToFormatDate($splitFormat);
    }
    private function addToFormatDate($splitFormat){
        foreach($splitFormat as $character){
            $this->setEquivalent($character);
        }
    }
    private function setEquivalent($character){
        switch ($character){
            case 'd': 
                $this->formatedDate .= $this->arrDateParsed['day'];
                break;
            case 'm':
                $this->formatedDate .= $this->arrDateParsed['month'];
                break;
            case 'Y':
                $this->formatedDate .= $this->arrDateParsed['year'];
                break;
            case '/':
                $this->formatedDate .= $character;
                break;
        }
    }
}
?>
