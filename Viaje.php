<?php

class Viaje {
    private $codigo;
    private $destino;
    private $cantidadMaxPasajeros;
    private $colPasajeros;
    private $objResponsable;

    public function __construct($vcodigo, $vdestino, $vcantidadMaxPasajeros, $vcolPasajeros, $vobjResponsable){
        $this->codigo = $vcodigo;
        $this->destino = $vdestino;
        $this->cantidadMaxPasajeros = $vcantidadMaxPasajeros;
        $this->colPasajeros = $vcolPasajeros;
        $this->objResponsable = $vobjResponsable;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getDestino() {
        return $this->destino;
    }

    public function setDestino($destino) {
        $this->destino = $destino;
    }

    public function getCantidadMaxPasajeros() {
        return $this->cantidadMaxPasajeros;
    }

    public function setCantidadMaxPasajeros($cantidadMaxPasajeros) {
        $this->cantidadMaxPasajeros = $cantidadMaxPasajeros;
    }

    public function getColPasajeros() {
        return $this->colPasajeros;
    }

    public function setColPasajeros($colPasajeros) {
        $this->colPasajeros = $colPasajeros;
    }

    public function getObjResponsable() {
        return $this->objResponsable;
    }

    public function setObjResponsable($objResponsable) {
        $this->objResponsable = $objResponsable;
    }

    public function mostrarCadena($arreglo){
        $cadena = '';
        foreach($arreglo as $pasajero){
            $cadena .= $pasajero->__toString(). "\n";
        }
        return $cadena;
    }

    public function __toString(){
        return $this->getCodigo() ."\n". $this->getDestino() ."\n".
            $this->getCantidadMaxPasajeros() ."\n". 
            $this->mostrarCadena($this->getColPasajeros()) ."\n".
            $this->getObjResponsable();
    }

    public function agregarPasajero($nombre, $apellido, $documento, $telefono){
        $nuevoPasajero = new Pasajero($nombre, $apellido, $documento, $telefono);
        $coleccionPasajerosCopia = $this->getColPasajeros();
        $i=0;
        $existePasajero=false;
        while($i<count($coleccionPasajerosCopia) && $existePasajero==false){
            if($coleccionPasajerosCopia[$i]->getDocumento() == $documento){
                $existePasajero=true;
            }
            $i++;
        }

        if($existePasajero==false){
        $coleccionPasajerosCopia[] = $nuevoPasajero;
        $this->setColPasajeros($coleccionPasajerosCopia);
        }

        return $existePasajero;
    }
    
}