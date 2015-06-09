<?php
require_once BASECONTROLLERPATH.'BaseController.php';
require_once BASEMODELPATH.'Constraints.php';

class PrincipalController extends BaseController{
    function index(){
        $this->load->view('Principal');
    }
    public function getSysOpcionesAplicacion(){
        try{            
            $this->load->model('Mapper/SysOpcionAplicacionMapper','SysOpcionAplicacionMapper');
            $myResponseModel = $this->SysOpcionAplicacionMapper->search(new Constraints());
                        
                                   
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
