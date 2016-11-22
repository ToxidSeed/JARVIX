<?php

require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'AlcanceMapper.php';

class AlcanceBO extends AlcanceMapper{
  function __construct(){
    parent::__construct();
  }

  public function Add(array $arrDmnAlcance = null){
    try{

        $this->load->database();
        $this->db->trans_start();

        $mprAlcance = new AlcanceMapper();

        foreach($arrDmnAlcance as $key => $dmnAlcance){
            $mprAlcance->insert($dmnAlcance);
        }

        $this->db->trans_commit();
      }catch (Exception $ex){
          $this->db->trans_rollback();
          throw new Exception($ex->getMessage(),$ex->getCode());
      }
  }
  public function Quitar(array $arrDmnAlcance = null){
      try{
          $this->load->database();
          $this->db->trans_start();
          foreach($arrDmnAlcance as $key => $row){
              $this->delete($row);
          }
          $this->db->trans_commit();
      } catch (Exception $ex) {
          $this->db->trans_rollback();
          throw new Exception($ex->getMessage(),$ex->getCode());
      }
  }
}

 ?>
