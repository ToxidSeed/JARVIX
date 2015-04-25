<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once BASEMODELPATH.'BaseDomain.php';

class DomainFormato extends BaseDomain{
    protected $id;
    protected $tipoDato;
    protected $fechaRegistro;
    protected $fechaUltAct;
    protected $flgPermiteTamano;
    protected $flgPermitePrecision;
    protected $flgPermiteMascara;
    protected $flgPermiteMayusculas;
    protected $flgPermiteMinusculas;
    protected $flgPermiteDetalle;
    
    
    public function __construct($id = null) {
        $this->id = $id;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTipoDato() {
        return $this->tipoDato;
    }

    public function getFechaRegistro() {
        return $this->fechaRegistro;
    }

    public function getFechaUltAct() {
        return $this->fechaUltAct;
    }

  

    public function setId($id) {
        $this->id = $id;
    }

    public function setTipoDato($tipoDato) {
        $this->tipoDato = $tipoDato;
    }

    public function setFechaRegistro($fechaRegistro) {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function setFechaUltAct($fechaUltAct) {
        $this->fechaUltAct = $fechaUltAct;
    }
    public function getFlgPermiteTamano() {
        return $this->flgPermiteTamano;
    }

    public function getFlgPermitePrecision() {
        return $this->flgPermitePrecision;
    }

    public function getFlgPermiteMascara() {
        return $this->flgPermiteMascara;
    }

    public function getFlgPermiteMayusculas() {
        return $this->flgPermiteMayusculas;
    }

    public function getFlgPermiteMinusculas() {
        return $this->flgPermiteMinusculas;
    }

    public function getFlgPermiteDetalle() {
        return $this->flgPermiteDetalle;
    }

    public function setFlgPermiteTamano($flgPermiteTamano) {
        $this->flgPermiteTamano = $flgPermiteTamano;
    }

    public function setFlgPermitePrecision($flgPermitePrecision) {
        $this->flgPermitePrecision = $flgPermitePrecision;
    }

    public function setFlgPermiteMascara($flgPermiteMascara) {
        $this->flgPermiteMascara = $flgPermiteMascara;
    }

    public function setFlgPermiteMayusculas($flgPermiteMayusculas) {
        $this->flgPermiteMayusculas = $flgPermiteMayusculas;
    }

    public function setFlgPermiteMinusculas($flgPermiteMinusculas) {
        $this->flgPermiteMinusculas = $flgPermiteMinusculas;
    }

    public function setFlgPermiteDetalle($flgPermiteDetalle) {
        $this->flgPermiteDetalle = $flgPermiteDetalle;
    }





}
