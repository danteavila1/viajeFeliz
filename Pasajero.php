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
		$this->objViaje = null;
	}

    public function cargar($nroDoc, $nombre, $apellido, $telefono, $idPasajero = null, $numAsiento = null, $numTicket = null, $objetoViaje = null) {
        parent::cargar($nroDoc, $nombre, $apellido, $telefono);
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

    public function Buscar($dni) { 
		$base = new BaseDatos();  
		$consulta = "Select * from pasajero where documento = '" . $dni . "'";
		$resp = false; 
		if ($base->Iniciar()) { 
			if ($base->Ejecutar($consulta)) {
				if ($row2 = $base->Registro()) {		
					parent :: Buscar($dni);			 
					$this->setIdPasajero($row2['idpasajero']);
					$this->setNumeroAsiento($row2['numasiento']);
					$this->setNumeroTicket($row2['numticket']);
//cargar
					$objViaje = new Viaje();
					$objViaje->Buscar($row2['idviaje']);
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
		$consulta .= " order by apellido ";

		if ($base->Iniciar()) {
			if ($base->Ejecutar($consulta)) {				
				$colPasajeros = [];

				while($row2 = $base->Registro()) {
					$obj=new Pasajero();
					$obj->Buscar($row2['documento']);
					array_push($colPasajeros,$obj);
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


	//revisar
    public function insertar() {
		$base = new BaseDatos();
		$resp = false;
	
		if (parent::insertar()) {
			$objViaje = $this->getObjViaje();
			
			if ($objViaje !== null) {
				// Asume que idPasajero es auto increment y no lo incluimos en la consulta.
				$nroDoc = $this->getNrodoc();
				$numAsiento = $this->getNumeroAsiento();
				$numTicket = $this->getNumeroTicket();
				$idViaje = $objViaje->getCodigo();
				
				$consultaInsertar = "INSERT INTO pasajero(documento, numasiento, numticket, idviaje)
					VALUES ($nroDoc, $numAsiento, $numTicket, $idViaje)";

				if ($base->Iniciar()) {
					if ($base->Ejecutar($consultaInsertar)) {
						$resp = true;
					} else {
						$this->setmensajeoperacion($base->getError());
					}
				} else {
					$this->setmensajeoperacion($base->getError());
				}
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		}
	
		return $resp;
	}

	public function modificar(){
		$resp = false; 
		$base = new BaseDatos();
		if (parent::modificar()) {
			$objViaje = $this->getObjViaje();
			if ($objViaje !== null) {
				$idViaje = $objViaje->getCodigo();
			} else {
				$idViaje = "NULL"; // Asume que es nullable en la base de datos
			}
			$consultaModifica = "UPDATE pasajero SET 
				numasiento = " . $this->getNumeroAsiento() . ", 
				numticket = " . $this->getNumeroTicket() . ", 
				idviaje = " . $idViaje . " 
				WHERE documento = " . $this->getNrodoc();
	
			if ($base->Iniciar()) {
				if ($base->Ejecutar($consultaModifica)) {
					$resp = true;
				} else {
					$this->setMensajeOperacion($base->getError());
				}
			} else {
				$this->setMensajeOperacion($base->getError());
			}
		}
	
		return $resp;
	}

	// primero hay que eliminar pasajero y luego recien persona. Porque hay una referencia. Si elimino primero la persona, el pasajero me va a quedar ahciendo referencia a un id que ya no existe.
    public function eliminar() {
		$base = new BaseDatos();
		$resp = false;
		if ($base->Iniciar()) {
				$consultaBorra = "DELETE FROM pasajero WHERE documento = " . $this->getNroDoc();
				if ($base->Ejecutar($consultaBorra)) {
					//consultar por el delete restric, que no me restrige cuando quiero borrar un pasajero
					//if(parent::eliminar()){
						$resp=  true;
					//}
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