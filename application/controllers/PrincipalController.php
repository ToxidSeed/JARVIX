<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once BASEMODELPATH.'Constraints.php';

class PrincipalController extends BaseController{
    function index(){
        $this->load->library('session');
     
        
        
        if($this->session->userdata('id')!= false){
            $data = array(
                'id' => $this->session->userdata('id'),
                'email' => $this->session->userdata('email')
            );            
            $this->load->view('Principal',$data);
        }else{
            $this->load->view('login');
        }                
    }
    
    
    public function getSysOpcionesAplicacion(){
        try{            
            $this->load->model('Mapper/Finders/SysOpcionAplicacion/SysOpcionAplicacionFRM1','SysOpcionAplicacionFRM1');
            
            $myResponseModel = $this->SysOpcionAplicacionFRM1->search(
                        array('UsuarioId' => $this->getField('UsuarioId'))
                    );
                                                           
            $results = array();            
            foreach($myResponseModel->getResults() as $myDmnOpcionAplicacion){                                
                $results[] = array(
                    'name' => $myDmnOpcionAplicacion->getNombre(),
                    'id'  => $myDmnOpcionAplicacion->getId(),
                    'parentId' => $myDmnOpcionAplicacion->getParent()->getId()
                    );
            }
            
            $this->load->library('TreeGenerator',$results);
            //print_r($this->treegenerator->response());
            echo json_encode($this->treegenerator->response());
            
            
        }catch(Exception $ex){
            echo Answer::setFailedMessage($ex->getMessage());
        }        
    }
    public function find(){
        try{
            $this->load->model('Mapper/SysOpcionAplicacionMapper','SysOpcionAplicacionMapper');
            $myDomainSysOpcionApp = $this->SysOpcionAplicacionMapper->find($this->getField('id'));
            echo json_encode(Response::asSingleObject($myDomainSysOpcionApp));
        }catch(Exception $ex){
            echo Answer::setFailedMessage($ex->getMessage(),$e->getCode());
        }
    }
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
