<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TreeGenerator {
    /*La Estructura de Records
     * @id
     * @parentId
     * @text
     * @name
    */
    private $records = array();
    private $treeFormRecords = array();
    
    
    public function __construct(array $records = null){
       foreach($records as $row){
           //print_r($row);
           $this->addRecord($row);           
       }
       //Creando los Objetos
       $this->myTreeForm();
    }  
    
    private function addRecord(array $row){
        $myRecord = new Tree();
        $myRecord->setId($row['id']);
        $myRecord->setParentId($row['parentId']);
        $myRecord->setName($row['name']);
        $this->records[] = $myRecord;
        
    }
    
    private function myTreeForm(){                
        while(count($this->records) > 0){            
            foreach($this->records as $key =>  $myObject){                                
                if($myObject->getParentId() == null){
                    $this->treeFormRecords[] = $myObject;
                    unset($this->records[$key]);
                }else{                    
                    $success = $this->addChild($this->treeFormRecords, $myObject);
                        if($success === true){
                            unset($this->records[$key]);
                        }
                }
            }
        }
    }
    
    private function addChild(array $toFind,Tree $myObject){
        foreach($toFind as $key => $myTreeObject ){
            if($myTreeObject->getId() === $myObject->getParentId()){
                $myTreeObject->addChild($myObject);
                return true;
            }
            if(count($myTreeObject->getChilds()) > 0){
                return $this->addChild($myTreeObject->getChilds(), $myObject);                                    
            }
        }
        return false;        
    }
    
    public function response(){
        foreach($this->treeFormRecords as $key => $root){
            $this->treeFormRecords[$key] = $this->toArray($root);
        }
        $children = array(
            'children' => $this->treeFormRecords
        );
        return $children;
    }
    
    
    private function toArray(Tree $node){
        $arrNode = array(
            'id' => $node->getId(),
            'text' => $node->getName()            
        );
        
        if(count($node->getChilds())>0){
            foreach($node->getChilds() as $dmnNode){
                $arrNode['children'][] = $this->toArray($dmnNode);
            }
        }else{
            $arrNode['leaf'] = true;
        }
        return $arrNode;
    }
}
//Clase que guardara la estructura del arbol

class Tree{
    protected $id;
    protected $parentId;
    protected $name;
    protected $childs = array();
    
    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
    public function setParentId($parentId){
        $this->parentId = $parentId;
    }
    public function getParentId(){
        return $this->parentId;
    }
    public function setChilds(array $childs = null){
        $this->childs = $childs;
    }
    public function getChilds(){
        return $this->childs;
    }
    public function addChild(Tree $tree = null){
        $this->childs[] = $tree;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }
}

?>