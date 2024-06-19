<?php

Class Pasajero {
    private $nombre;
    private $apellido;
    private $numeroDocumento;
    private $telefono;
    private $objViaje;
    private $mensajeOperacion;



    public function __construct()
    {
        $this->numeroDocumento = "";
        $this->nombre = "";
        $this->apellido = "";
        $this->telefono = "";
    }

    public function cargar ($documento, $nombre, $apellido, $telefono, $objViaje){
        $this->setNumeroDocumento($documento);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
        $this->setTelefono($telefono);
        $this->setObjViaje($objViaje);
    }

    public function setNombre ($nombre){
        $this->nombre = $nombre;
    }
    public function getNombre(){
        return $this->nombre;
    }

	public function getApellido() {
		return $this->apellido;
	}

	public function setApellido($apellido) {
		$this->apellido = $apellido;
	}

	public function getNumeroDocumento() {
		return $this->numeroDocumento;
    }

	public function setNumeroDocumento($documento) {
		$this->numeroDocumento = $documento;
	}

	public function getTelefono() {
		return $this->telefono;
	}

	public function setTelefono($telefono) {
		$this->telefono = $telefono;
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

    public function __toString(){
        return $this->getNombre() ."\n". $this->getApellido() ."\n".
        $this->getTelefono() ."\n". $this->getNumeroDocumento() ."\n" . 
        $this->getObjViaje()->getIdViaje();
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
				    $this->setNumeroDocumento($dni);
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
        $consultaInsertar = "INSERT INTO pasajero(documento, nombre, apellido, telefono, idviaje) VALUES ('" . $this->getNumeroDocumento() . "', '" . $this->getNombre() . "', '" . $this->getApellido() . "', '" . $this->getTelefono() . "', " . $this->getObjViaje()->getIdviaje() . ")";
	
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
		$consultaModifica = "UPDATE pasajero SET nombre = '" . $this->getNombre() . "', apellido = '" . $this->getApellido() . "', telefono = '" . $this->getTelefono() . "', idviaje = " . $this->getObjViaje()->getIdviaje() . " WHERE pdocumento = " . $this->getNumeroDocumento();
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
				$consultaBorra = "DELETE FROM pasajero WHERE documento = " . $this->getNumeroDocumento();
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