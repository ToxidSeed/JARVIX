<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once BASECONTROLLERPATH.'BaseController.php';
class Alcance extends BaseController{
    function __construct() {
        parent::__construct();
    }
    function search(){
        $this->load->model('Mapper/Finders/Alcance/AlcanceFRM1','AlcanceFRM1');
        $results = $this->AlcanceFRM1->search(array(
            'ProyectoId' => 4
        ));

        //echo json_encode($results);

      /*  echo json_encode(array(array(
          'nombre' => 'xxx'
        )));*/

        //print_r($results);
        echo json_encode($this->makeTree($results));
    }

    private function makeTree($ArrayTreeData){
        $JSONTreeData = array(
          'text' => ".",
          'children' => array()
        );

        foreach($ArrayTreeData as $key => $row){
          $JSONTreeData['children'][] = array(
            "id" =>  $row['id'],
            "nombre" => $row['nombre'],
            "children" => array(
                  array(
                    "nombre" => "Flujos",
                    "children" => $this->makeNodeFlujos($row["Flujos"])
                  ),
                  array(
                    "nombre" => "Controles",
                    "children" => $this->makeNodeControles($row["Controles"])
                  )
            )
          );
        }
        return $JSONTreeData;
    }

    private function makeNodeFlujos($ArrayNode){
        $JSONNode = array();
        foreach($ArrayNode as $key => $row){
          //print_r($row);
            $JSONNode[] = array(
                "nombre" => $row["procesoflujo_nombre"],
                "leaf"  => "true"
            );
        }
        return $JSONNode;
    }

    private function makeNodeControles($ArrayNode){
       $JSONNode = array();
       foreach($ArrayNode as $key => $row){
         //print_r($row);
           $JSONNode[] = array(
               "nombre" => $row["procesocontrol_nombre"],
               "leaf"  => "true"
           );
       }
       return $JSONNode;   }
}
