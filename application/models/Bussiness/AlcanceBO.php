<?php

require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'AlcanceMapper.php';

class AlcanceBO extends BaseBO{
  function __construct(){
    parent::__construct();
  }

  public function Add(array $arrDmnAlcance = null){
    try{

        /*print_r($arrDmnAlcance);
        exit();*/

        $this->load->database();
        $this->db->trans_start();

        $mprAlcance = new AlcanceMapper();

        foreach($arrDmnAlcance as $key => $dmnAlcance){
            $mprAlcance->insert($dmnAlcance);
        }

        $this->db->trans_commit();
      } catch (Exception $ex) {
          $this->db->trans_rollback();
          throw new Exception($ex->getMessage(),$ex->getCode());
      }

  }
}

 ?>
