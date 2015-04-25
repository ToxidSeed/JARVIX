<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once MAPPERPATH.'ProcesoFlujoMapper.php';

class FinderProcesosFlujos extends ProcesoFlujoMapper{  
    const STATUS_REGISTRADO = 0;
    const STATUS_ELIMINADO = -1;
    
    public function getFlujosRegistradosByProceso($procesoId){
        $this->load->database();
        $this->db->select($this->fields);
        $this->db->from($this->tableName);
        $this->db->where('procesoid',$procesoId);
        $this->db->where('estadoprocesoflujoid',self::STATUS_REGISTRADO);
        $response = $this->db->get();
        $arrResponse = $this->getMultiResponse($response);
        return new ResponseModel($arrResponse, count($arrResponse));        
    }
    
    
    
    
}

?>
