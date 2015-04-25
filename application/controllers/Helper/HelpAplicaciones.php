<?php
require_once BASECONTROLLERPATH.'BaseController.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class HelpAplicaciones extends BaseController{
    function __construct() {
        parent::__construct();
    }
    public function search(){        
        $this->load->model('Mapper/HelpAplicacionFinder','HelpAplicacionFinder');
        $this->HelpAplicacionFinder->setParamNombre($this->getField('nombre'));
        $response = $this->HelpAplicacionFinder->getList();
        echo json_encode(Response::asResults($response));                                   
    }
}
?>
