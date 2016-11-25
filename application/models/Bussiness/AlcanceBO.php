<?php

require_once BUSSINESSPATH.'BaseBO.php';
require_once MAPPERPATH.'AlcanceMapper.php';
require_once DOMAINPATH.'DomainAlcance.php';

class AlcanceBO extends AlcanceMapper{
  function __construct(){
    parent::__construct();
  }

  private $arrProcesosAlcance = array();

  const __TIPO_PROCESO = 1;

  public function Add(array $arrDmnAlcance = null){
    try{

        $this->load->database();
        $this->db->trans_start();

        foreach($arrDmnAlcance as $key => $dmnAlcance){
            //El Alcance se inserta si es que en alguno de los subprocesos asociados no se encuentra.
            if($dmnAlcance->getTipo()->getId() === self::__TIPO_PROCESO){
                continue;
            }
            //
            $this->InsertarAlcance($dmnAlcance);
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
  private function BuscarProcesoEnAlcance($parProcesoId){
      foreach($this->arrProcesosAlcance as $key => $dmnAlcance){
          if($dmnAlcance->getItem()->getId() == $parProcesoId){
              return $dmnAlcance;
          }
      }
      $dmnAlcance = $this->getAlcance($parProcesoId);
      if($dmnAlcance !== null){
          $this->arrProcesosAlcance[] = $dmnAlcance;
      }
      return $dmnAlcance;
  }

  private function getAlcance($parProcesoId){
        $this->addUnique('tipoid',self::__TIPO_PROCESO);
        $this->addUnique('itemid',$parProcesoId);
        $dmnAlcance = $this->find();
  }

  private function InsertarAlcanceProceso($dmnEntrega,$parProcesoId){
      $dmnAlcance = new DomainAlcance();
      $dmnAlcance->setTipo(new DomainTipoAlcance(self::__TIPO_PROCESO));
      $dmnAlcance->setItem(new DomainProceso($parProcesoId));
      $dmnAlcance->setNroItems(1);
      $this->insert($dmnAlcance);
      return $dmnAlcance;
  }

  private function InsertarAlcance($dmnAlcance){
    $parProcesoId = $dmnAlcance->getProceso()->getId();
    //Encontrar en local
    $dmnAlcanceProceso = $this->BuscarProcesoEnAlcance($parProcesoId);
    //Encontrar En Base de Datos
    if($dmnAlcanceProceso !== null){
        //Insertar Registro de Alcance
        $dmnAlcanceProceso->setNroItems($dmnAlcanceProceso + 1);
        $this->insert($dmnAlcance);
        continue;
    }
    //Si no se encuentra ni en la base de datos ni en el array local, deberia insertarse en la base de datos.
    $dmnAlcanceProceso = $this->InsertarAlcanceProceso($dmnAlcance->getEntrega(),$parProcesoId);
    //$dmnAlcanceProceso->setNroItems($dmnAlcanceProceso + 1);
    $this->arrProcesosAlcance[] = $dmnAlcanceProceso;
    $this->insert($dmnAlcance);
  }

}

 ?>
