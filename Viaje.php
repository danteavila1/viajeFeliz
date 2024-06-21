<?php

class Viaje {

    private $idViaje;
    private $destino; 
    private $cantidadMaxPasajeros;
    private $colPasajeros;
    private $objResponsable;
    private $costo;
    private $sumaCostos;
    private $objEmpresa;

    public function __construct($vidViaje, $vdestino, $vcantidadMaxPasajeros, $vcolPasajeros, $vobjResponsable, $vcosto, $vsumaCostos, $vobjEmpresa){
        $this->idViaje = $vidViaje;
        $this->destino = $vdestino;
        $this->cantidadMaxPasajeros = $vcantidadMaxPasajeros;
        $this->colPasajeros = $vcolPasajeros;
        $this->objResponsable = $vobjResponsable;
        $this->costo = $vcosto;
        $this->sumaCostos = $vsumaCostos;
        $this->objEmpresa = $vobjEmpresa;
    }

    public function cargar($idViaje, $destino, $cantidadMaxPasajeros,$colPasajeros, $objEmpresa, $objResponsable, $costo){
        $this->setIdViaje($idViaje);
        $this->setDestino($destino);
        $this->setCantidadMaxPasajeros($cantidadMaxPasajeros);
        $this->setColPasajeros($colPasajeros);
        $this->setObjResponsable($objResponsable);
        $this->setCosto($costo);
        $this->setObjEmpresa($objEmpresa);
    }


    public function getIdViaje() {
        return $this->idViaje;
    }

    public function setIdViaje($idViaje) {
        $this->idViaje = $idViaje;
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

	public function setCosto($costo) {
		$this->costo = $costo;
	}

    public function getObjEmpresa() {
		return $this->objEmpresa;
	}

	public function setObjEmpresa($value) {
		$this->objEmpresa = $value;
	}

    public function mostrarCadena($arreglo){
        $cadena = '';
        foreach($arreglo as $pasajero){
            $cadena .= $pasajero->__toString(). "\n";
        }
        return $cadena;
    }

    public function __toString(){
        return $this->getIdViaje() ."\n". $this->getDestino() ."\n".
            $this->getCantidadMaxPasajeros() ."\n". 
            $this->mostrarCadena($this->getColPasajeros()) ."\n".
            $this->getObjResponsable()."\n".$this->getObjEmpresa()."\n";
    }

    public function Buscar($idViaje){

        $base = new BaseDatos();
        $consultaBuscarViaje = "SELECT * FROM viaje WHERE idviaje=".$idViaje; 
        $resp = false;

        if($base->Iniciar()){
            if($base->Ejecutar($consultaBuscarViaje)){
                if($row2 =$base->Registro()){
                    $this->setIdViaje($idViaje);
                    $this->setDestino($row2["destino"]);
                    $this->setCantidadMaxPasajeros($row2["cantidadMaxPasajeros"]);


                    $objResponsable  = new ResponsableV();
                    $objResponsable->Buscar($row2["numEmpleado"]);
                    $this->setObjResponsable($objResponsable);
                    $this->setCosto($row2["costo"]);

                    $objEmpresa = new Empresa();
                    $objEmpresa->Buscar($row2["idEmpresa"]);
                    $this->setObjEmpresa($objEmpresa);

                    $resp = true;
                }

            }else{
                    $this->setMensajeOperacion($base->getError());
            } 

        }else{
                $this->setMensajeOperacion($base->getError());
            }
        

        return $resp;

    }

    public function listar($condicion=""){

        $arregloViajes = null;
        $base = new BaseDatos();
        $consultaViajes = "SELECT * from viaje";

        if($condicion != ""){
        
            $consultaViajes = $consultaViajes.' where '. $condicion;
        }

        $consultaViajes .= " order by idviaje ";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaViajes)){
                $arregloViajes = array();

                while ($row2 = $base->Registro()){

                    $idViaje = $row2['idviaje'];
                    $objViaje = new Viaje();
                    $objViaje->Buscar($idViaje);
                    array_push($arregloViajes, $objViaje);
                
                }
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }
        
        return $arregloViajes;

    }

    public function insertar()
    {
		$base = new BaseDatos();
		$resp = false;

		$consultaInsertar = "INSERT INTO viaje(destino, cantmaxpasajeros, idempresa, numeroempleado, costo) VALUES ('" . $this->getDestino() . "', " . $this->getCantidadMaxPasajeros() . ", " . $this->getObjEmpresa()->getIdEmpresa() . ", ". $this->getObjResponsable()->getNumEmpleado() . ", " . $this->getCosto() . ")";

		if ($base->Iniciar()) { 

			if ($idViaje = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdviaje($idViaje);
			    $resp = true;
			} 
            else {
				$this->setMensajeOperacion($base->getError());					
			}
		} 
        else {
			$this->setMensajeOperacion($base->getError());			
		}

		return $resp;
    }
	
    public function modificar() { 
	    $resp = false; 
	    $base = new BaseDatos();
		
        $consultaModifica = "UPDATE viaje SET destino = '" . $this->getDestino() . "', cantmaxpasajeros = " . $this->getCantidadMaxPasajeros() . ", idempresa = " . $this->getObjEmpresa()->getIdempresa() . ", numeroempleado = " . $this->getObjResponsable()->getNumempleado() . ", vimporte = " . $this->getCosto() . " WHERE idviaje = " . $this->getIdviaje();

        if ($base->Iniciar()) {

			if ($base->Ejecutar($consultaModifica)) {
			    $resp=  true;
			} 
            else {
				$this->setMensajeOperacion($base->getError());				
			}
		} 
        else {
			$this->setMensajeOperacion($base->getError());			
		}

		return $resp;
	}


    public function eliminar() {
		$base = new BaseDatos();
		$resp = false;

		if ($base->Iniciar()) {
				$consultaBorra = "DELETE FROM viaje WHERE idviaje = " . $this->getIdViaje();
				if ($base->Ejecutar($consultaBorra)) {
				    $resp=  true;
				} 
                else{
					$this->setMensajeOperacion($base->getError());					
				}
		} 
        else {
			$this->setMensajeOperacion($base->getError());			
		}
		
        return $resp; 
	}

    // Otros metodos

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