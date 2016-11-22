<?php

/*


 */
require_once BASEMODELPATH.'BaseMapper.php';

class AlcanceFRM2 extends BaseMapper{

    const __TIPO_PROCESO = 1;
    const __TIPO_PROCESO_FLUJO = 2;
    const __TIPO_PROCESO_CONTROL = 3;

    public function __construct() {
        parent::__construct();
    }
    protected $fields = array(
        'proceso.id',
        'proceso.nombre',
        'alcance.id as alcance_id'
    );

    private $Procesos = array();
    private $ProcesoFlujos = array();
    private $ProcesoControl = array();

    public function getProcesos(){
        return $this->Procesos;
    }
    public function getFlujos(){
        return $this->ProcesoFlujos;
    }
    public function getControles(){
        return $this->ProcesoControl;
    }

    function search($filters){
         $this->load->database();

         $this->SearchProcesos($filters['parEntregaId']);
         $this->SearchFlujos($filters['parEntregaId']);
         $this->SearchControles($filters['parEntregaId']);
    }

    private function SearchProcesos($parEntregaId){
        $this->db->select($this->fields);
        $this->db->from('proceso');
        $this->db->join('alcance','proceso.id = alcance.itemid');
        $this->db->where('alcance.tipoid',self::__TIPO_PROCESO);
        $this->db->where('alcance.entregaid',$parEntregaId);
        $res = $this->db->get();
        $this->Procesos = $res->result_array();
    }

    private function  SearchFlujos($parEntregaId){
        $fields = array(
            'alcance.id as alcance_id',
            'procesoflujo.procesoid as proceso_id',
            'procesoflujo.id as procesoflujo_id',
            'procesoflujo.nombre as procesoflujo_nombre'
        );

        $this->db->select($fields);
        $this->db->from('procesoflujo');
        $this->db->join('alcance','procesoflujo.id = Alcance.itemid');
        $this->db->where('alcance.tipoid',self::__TIPO_PROCESO_FLUJO);
        $this->db->where('alcance.entregaid',$parEntregaId);

        $res = $this->db->get();
        //print_r($this->db->last_query());
        $this->ProcesoFlujos = $res->result_array();
    }

    private function SearchControles($parEntregaId){
        $fields = array(
            'alcance.id as alcance_id',
            'procesocontrol.procesoid as proceso_id',
            'procesocontrol.id as procesocontrol_id',
            'procesocontrol.nombre as procesocontrol_nombre'
        );

        $this->db->select($fields);
        $this->db->from('procesocontrol');
        $this->db->join('alcance','procesocontrol.id = alcance.itemid');
        $this->db->where('alcance.tipoid',self::__TIPO_PROCESO_CONTROL);
        $this->db->where('alcance.entregaid',$parEntregaId);

        $res = $this->db->get();
        $this->ProcesoControl = $res->result_array();
    }

    private function armarDependencia(){
        //print_r($this->Proceso);
       foreach($this->Procesos as $key => $row){
           $this->Procesos[$key]['Flujos'] = $this->getFlujoPorProceso($row['id']);
           $this->Procesos[$key]['Controles'] = $this->getControlPorProceso($row['id']);
       }
    }

    private function getFlujoPorProceso($ProcesoId){
        $flujos = array();

        foreach($this->ProcesoFlujos as $key => $row){
            if($this->ProcesoFlujos[$key]['proceso_id'] === $ProcesoId  ){
                $flujos[] = $row;
            }
        }
        return $flujos;
    }

    private function getControlPorProceso($ProcesoId){
        $controles = array();

        foreach($this->ProcesoControls as $key => $row){
            if($this->ProcesoControls[$key]['proceso_id'] === $ProcesoId){
                $controles[] = $row;
            }
        }

        return $controles;
    }
}
