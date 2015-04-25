<?php
require_once BASEMODELPATH.'BaseMapper.php';
require_once DOMAINPATH.'DomainEstado.php';
require_once DOMAINPATH.'DomainAplicacion.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class AplicacionMapper extends BaseMapper{
    function __construct() {
        parent::__construct();
    }
    protected $fields = array(
        'id',
        'nombre',
        'rutapublicacion',
        'baseDatos',
        'servidor',
        'username',
        'password',
        'fecharegistro',
        'fechamodificacion',
        'estadoid'
    );
    
    protected $uniqueValues = array(
        array('id')
    );
        
    
    
    protected $tableName = 'Aplicacion';
    
    protected function doCreateObject(array $record = null){
        $dmnAplicacion = new DomainAplicacion($record['ID']);
        $dmnAplicacion->setNombre($record['NOMBRE']);
        $dmnAplicacion->setRutaPublicacion($record['RUTAPUBLICACION']);
        $dmnAplicacion->setBaseDatos($record['BASEDATOS']);
        $dmnAplicacion->setServidor($record['SERVIDOR']);
        $dmnAplicacion->setUsername($record['USERNAME']);
        $dmnAplicacion->setPassword($record['PASSWORD']);
        $dmnAplicacion->setEstado(new DomainEstado($record['ESTADOID']));
        $dmnAplicacion->setFechaRegistro($record['FECHAREGISTRO']);
        $dmnAplicacion->setFechaModificacion($record['FECHAMODIFICACION']);
        return $dmnAplicacion;
    }
    public function insert(DomainAplicacion $dmnAplicacion){
        $this->doInsert($dmnAplicacion);
    }
    protected function doInsert(DomainAplicacion $dmnAplicacion){
        $this->load->database();
        $fields['nombre'] = $dmnAplicacion->getNombre();
        $fields['rutapublicacion'] = $dmnAplicacion->getRutaPublicacion();
        $fields['servidor'] = $dmnAplicacion->getServidor();
        $fields['basedatos'] = $dmnAplicacion->getBaseDatos();
        $fields['username'] = $dmnAplicacion->getUsername();
        $fields['password'] = $dmnAplicacion->getPassword();
        $fields['estadoid'] = $dmnAplicacion->getEstado()->getId();
        $fields['fecharegistro'] = $dmnAplicacion->getFechaRegistro();
        $fields['fechamodificacion'] = $dmnAplicacion->getFechaModificacion();
        $this->db->set($fields);
        $res = $this->db->insert($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Insertar en la Base de Datos AplicacionMapper',-1);
        }
    }
    public function update(DomainAplicacion $dmnAplicacion){
        $this->doUpdate($dmnAplicacion);
    }
    protected function doUpdate(DomainAplicacion $dmnAplicacion){
        $this->load->database();
        $fields['nombre'] = $dmnAplicacion->getNombre();
        $fields['rutapublicacion'] = $dmnAplicacion->getRutaPublicacion();
        $fields['servidor'] = $dmnAplicacion->getServidor();
        $fields['basedatos'] = $dmnAplicacion->getBaseDatos();
        $fields['username'] = $dmnAplicacion->getUsername();
        $fields['estadoid'] = $dmnAplicacion->getEstado()->getId();
        $fields['fecharegistro'] = $dmnAplicacion->getFechaRegistro();
        $fields['fechamodificacion'] = $dmnAplicacion->getFechaModificacion();
        $this->db->set($fields);
        $this->db->where('id',$dmnAplicacion->getId());
        $res = $this->db->update($this->tableName);
        if(!$res){
            $this->db->trans_rollback();
            throw new Exception('Error al Actualizar en BD, AplicacionMapper',-1);
        }
    }
    
}
?>
