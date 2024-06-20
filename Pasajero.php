<?php

Class Pasajero extends Persona {

	private $idPasajero;
    private $numeroAsiento;
    private $numeroTicket;
	private $objViaje;
    private $mensajeOperacion;

    public function __construct (){
        parent::__construct();
		$this->idPasajero = "";
        $this->numeroAsiento = "";
        $this->numeroTicket = "";
		$this->objViaje = [];
	}

    public function cargar($nroDoc, $nombre, $apellido, $telefono, $direccion, $idPasajero = null, $numAsiento = null, $numTicket = null, $objetoViaje = null) {
        parent::cargar($nroDoc, $nombre, $apellido, $telefono, $direccion);
        if ($idPasajero !== null) $this->setIdPasajero($idPasajero);
        if ($numAsiento !== null) $this->setNumeroAsiento($numAsiento);
        if ($numTicket !== null) $this->setNumeroTicket($numTicket);
        if ($objetoViaje !== null) $this->setObjViaje($objetoViaje);
    }

    public function setNumeroAsiento($numeroAsiento){
    	$this->numeroAsiento=$numeroAsiento;
    	}
    public function getNumeroAsiento(){
    	return $this->numeroAsiento;
    }

    public function setNumeroTicket ($numeroTicket){
    	$this->numeroTicket = $numeroTicket;
    }

    public function getNumeroTicket(){
    	return $this->numeroTicket;
    }

    public function getObjViaje(){
        return $this->objViaje;
    }

    public function setObjViaje($objViaje){
        $this->objViaje = $objViaje;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensaje)
    {
        $this->mensajeOperacion = $mensaje;
    }

	public function getIdPasajero() {
		return $this->idPasajero;
	}

	public function setIdPasajero($value) {
		$this->idPasajero = $value;
	}

    public function __toString(){
        $cadena = parent::__toString();
        $cadena.= "Id Pasajero:{$this->getIdPasajero()}\nNumero de asiento:{$this->getNumeroAsiento()}\nNumero de ticket:{$this->getNumeroTicket()} \n";
        return $cadena;
    }

    // public function darPorcentajeIncremento(){
    //     $incremento = 10;
    //     return $incremento;
    // }

    public function Buscar($dni) { 
		$base = new BaseDatos();  
		$consulta = "Select * from pasajero where documento = '" . $dni . "'";
		$resp = false; 
		if ($base->Iniciar()) { 
			if ($base->Ejecutar($consulta)) {
				if ($row2 = $base->Registro()) {					 
				    $this->setNroDoc($dni);
					$this->setNombre($row2["nombre"]);
					$this->setApellido($row2["apellido"]);
					$this->setTelefono($row2["telefono"]);
                    $idviaje = ($row2["idviaje"]);
					$objViaje = new Viaje();
					$objViaje->Buscar($idviaje);
					$this->setObjViaje($objViaje);
                    $resp = true;
				}				
			
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

    public function listar($condicion = ""){
	    $colPasajeros = null;
		$base = new BaseDatos(); 
		$consulta = "Select * from pasajero";
		if ($condicion != ""){
		    $consulta = $consulta .' where '. $condicion;
		}
		$consulta .= " order by papellido ";

		if ($base->Iniciar()) {
			if ($base->Ejecutar($consulta)) {				
				$colPasajeros = [];

				while($row2 = $base->Registro()) {
					$documento = $row2['documento'];
					$objPasajero = new Pasajero();
                    $objPasajero->Buscar($documento);
					array_push($colPasajeros, $objPasajero);
				}
		 	}	
            else {
		 		$this->setMensajeOperacion($base->getError());	
			}
		}	
        else {
		 	$this->setMensajeOperacion($base->getError());
		}	
		
        return $colPasajeros;
	}

    public function insertar() {
		$base = new BaseDatos();
		$resp = false;
        $consultaInsertar = "INSERT INTO pasajero(documento, nombre, apellido, telefono, idviaje) VALUES ('" . $this->getNroDoc() . "', '" . $this->getNombre() . "', '" . $this->getApellido() . "', '" . $this->getTelefono() . "', " . $this->getObjViaje()->getIdviaje() . ")";
	
		if ($base->Iniciar()) { 
			if ($base->Ejecutar($consultaInsertar)) {
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

    public function modificar() {
	    $resp = false; 
	    $base = new BaseDatos();
		$consultaModifica = "UPDATE pasajero SET nombre = '" . $this->getNombre() . "', apellido = '" . $this->getApellido() . "', telefono = '" . $this->getTelefono() . "', idviaje = " . $this->getObjViaje()->getIdviaje() . " WHERE pdocumento = " . $this->getNroDoc();
		if($base->Iniciar()){
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
				$consultaBorra = "DELETE FROM pasajero WHERE documento = " . $this->getNroDoc();
				if ($base->Ejecutar($consultaBorra)) {
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

}