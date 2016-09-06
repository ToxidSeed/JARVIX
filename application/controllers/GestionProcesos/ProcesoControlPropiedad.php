<?php
require_once BASECONTROLLERPATH.'BaseController.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ProcesoControlPropiedad extends BaseController{
    function __construct() {
        parent::__construct();
    }

    const CONST_TIPO_PROPIEDAD = 1;

    public function updValorPropiedad(){
        try{
            $this->load->model('Bussiness/ProcesoFlujoBO/ProcesoControlPropiedadBO','ProcesoControlPropiedadBO');
            $this->ProcesoControlPropiedadBO->updValorPropiedad(
                        $this->getField('id'),
                        $this->getField('valor')
                    );
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Actualizado Correctamente');
            $this->getAnswer()->setCode(0);
            echo $this->getAnswer()->getAsJSON();
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
              }
        }
    }
    public function wrtComentario(){
        try{
            $this->load->model('Bussiness/ComentarioBO','ComentarioBO');
            $dmnComentario = new DomainComentario($this->getField('id'));
            $dmnComentario->setTipo(self::CONST_TIPO_PROPIEDAD);
            $dmnComentario->setIdReferencia($this->getField('idReferencia'));
            $dmnComentario->setTexto($this->getField('texto'));
            $this->ComentarioBO->setDomain($dmnComentario);
            $this->ComentarioBO->wrt();
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Actualizado Correctamente');
            $this->getAnswer()->setCode(0);
            echo $this->getAnswer()->getAsJSON();
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }

    public function delComentario(){
        try{
            $this->load->model('Bussiness/ComentarioBO','ComentarioBO');
            $this->ComentarioBO->del($this->getField('id'));
            $this->getAnswer()->setSuccess(true);
            $this->getAnswer()->setMessage('Borrado Correctamente');
            $this->getAnswer()->setCode(0);
            echo $this->getAnswer()->getAsJSON();
        } catch (Exception $ex) {
            if($ex->getCode() == FORM_VALIDATION_ERRORS_CODE){
                echo $this->getAnswer()->getAsJSON();
            }else{
                echo Answer::setFailedMessage($ex->getMessage(),$ex->getCode());
            }
        }
    }

    public function listComentarios(){
            $this->load->model('Mapper/Finders/Comentario/ComentarioFRM1','ComentarioFRM1');
            $response = $this->ComentarioFRM1->search(
                        array(
                            'Tipo' => self::CONST_TIPO_PROPIEDAD,
                            'ProcesoControlPropiedadId' => $this->getField('ProcesoControlPropiedadId')
                        )
                    );
            echo json_encode(Response::asResults($response));
    }
}
