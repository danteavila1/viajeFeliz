<?php

Class Pasajero {
    private $nombre;
    private $apellido;
    private $documento;
    private $telefono;

    public function __construct($vnombre, $vapellido, $vdocumento, $vtelefono){
        $this->nombre = $vnombre;
        $this->apellido = $vapellido;
        $this->documento = $vdocumento;
        $this->telefono = $vtelefono;
    }

    public function setNombre ($nombre){
        $this->nombre = $nombre;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function setApellido($apellido){
        $this->apellido=$apellido;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function setDocumento($documento){
        $this->documento=$documento;
    }
    public function getDocumento(){
        return $this->documento;
    }

    public function setTelefono ($telefono){
        $this->telefono = $telefono;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function __toString(){
        return $this->getNombre() ."\n". $this->getApellido() 
        ."\n". $this->getDocumento() ."\n". $this->getTelefono()."\n";
    }
}