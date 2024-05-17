<?php

class Viaje {
    private $codigo;
    private $destino;
    private $cantidadMaxPasajeros;
    private $colPasajeros;
    private $objResponsable;
    private $costo;
    private $sumaCostos;

    public function __construct($vcodigo, $vdestino, $vcantidadMaxPasajeros, $vcolPasajeros, $vobjResponsable, $vcosto, $vsumaCostos){
        $this->codigo = $vcodigo;
        $this->destino = $vdestino;
        $this->cantidadMaxPasajeros = $vcantidadMaxPasajeros;
        $this->colPasajeros = $vcolPasajeros;
        $this->objResponsable = $vobjResponsable;
        $this->costo = $vcosto;
        $this->sumaCostos = $vsumaCostos;
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

    public function getCosto() {
		return $this->costo;
	}

	public function setCosto($value) {
		$this->costo = $value;
	}

	public function getSumaCostos() {
		return $this->sumaCostos;
	}

	public function setSumaCostos($value) {
		$this->sumaCostos = $value;
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

    public function buscarPasajero($numDocumento){
        $pasajero = null;
        $pasajeros = $this->getColPasajeros();
        for ($i=0; $i < count($pasajeros); $i++) { 
            if ($pasajeros[$i]->getNumeroDocumento() == $numDocumento){
                $pasajero = $pasajeros[$i];
            }
        }
        return $pasajero;
    }

    public function agregarPasajero(Pasajero $nuevoPasajero){
        $agregado = false;
        $doc = $nuevoPasajero->getNumeroDocumento();
        $cantPasajeros = count($this->getColPasajeros());
        $cantMaxima = $this->getCantidadMaxPasajeros();
        if ($cantPasajeros < $cantMaxima && $this->buscarPasajero($doc) == null){
            $pasajeros = $this->getColPasajeros();
            array_push($pasajeros, $nuevoPasajero);
            $this->setColPasajeros($pasajeros);
            $agregado = true;
        }
        return $agregado;
    }

    public function venderPasaje($objPasajero){
        $agregado = $this->agregarPasajero($objPasajero);
        if($agregado==true) {
            $incremento = $objPasajero->darPorcentajeIncremento();
            $costoFinal = $this->getCosto() * (1 + $incremento / 100);
            $costosAbonados = $this->getSumaCostos() + $costoFinal;
            $this->setSumaCostos($costosAbonados);
        } else {
            $costoFinal = -1;
        }
        return $costoFinal;
    }

    public function hayPasajesDisponible(){
        $hayPasajes = false;
        $cantPasajeros = count($this->getColPasajeros());
        $cantMaxima = $this->getCantidadMaxPasajeros();
        if ($cantPasajeros < $cantMaxima){
            $hayPasajes = true;
        }
        return $hayPasajes;
    }
    

}