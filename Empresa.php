<?php

class Empresa {
    private $id;
    private $nombre;
    private $direccion;


    public function __construct($id, $nombre, $direccion) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

  
    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    
    public function __toString() {
        return "ID Empresa: " . $this->getId() . "\n" .
               "Nombre: " . $this->getNombre() . "\n" .
               "Dirección: " . $this->getDireccion() . "\n";
    }
}