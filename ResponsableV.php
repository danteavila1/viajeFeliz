<?php

class ResponsableV {
    private $numEmpleado;
    private $numLicencia;
    private $nombre;
    private $apellido;

    public function __construct($vnumEmpleado, $vnumLicencia, $vnombre, $vapellido){
        $this->numEmpleado = $vnumEmpleado;
        $this->numLicencia = $vnumLicencia;
        $this->nombre = $vnombre;
        $this->apellido = $vapellido;
    }

    public function setNumEmpleado($numEmpleado){
        $this->numEmpleado = $numEmpleado;
    }

    public function getNumEmpleado(){
        return $this->numEmpleado;
    }

    public function setNumLicencia($numLicencia){
        $this->numLicencia = $numLicencia;
    }

    public function getNumLicencia(){
        return $this->numLicencia;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    public function getApellido(){
        return $this->apellido;
    }

    public function __toString(){
        return $this->getNumEmpleado() ."\n". $this->getNumLicencia()
        ."\n". $this->getNombre() ."\n". $this->getApellido()."\n";
    }

}