<?php

class ResponsableV {
    private $numEmpleado;
    private $numLicencia;
    private $nombre;
    private $apellido;
    private $mensajeOperacion;

    public function __construct(){
        $this->numEmpleado = 0;
        $this->numLicencia = "";
        $this->nombre = "";
        $this->apellido = "";
    }

    public function cargar($numLicencia, $nombre, $apellido){
        $this->setNumLicencia($numLicencia);
        $this->setnombre($nombre);
        $this->setApellido($apellido);
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

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function __toString(){
        return $this->getNumEmpleado() ."\n". $this->getNumLicencia()
        ."\n". $this->getNombre() ."\n". $this->getApellido()."\n";
    }

    public function Buscar($numEmpleado){
        $base = new BaseDatos();
        $consulta = "Select * from responsableV where numEmpleado = " . $numEmpleado;
        $resp = false;

        if ($base->Iniciar()){
            if($base->Ejecutar($consulta)){
                if ($row2 = $base->Registro()){
                    $this->setNumEmpleado($numEmpleado);
                    $this->setNumLicencia($row2["numLicencia"]);
                    $this->setNombre($row2["nombre"]);
                    $this->setApellido($row2["apellido"]);
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function listar($condicion = ""){
        $colResponsables = null;
        $base = new BaseDatos();
        $consultaResponsables = "Select * from responsable";

        if ($condicion = ""){
            $consultaResponsables .= 'where' . $condicion;
        }
        $consultaResponsables .= "order by apellido";

        if($base->Iniciar()) {
			if ($base->Ejecutar($consultaResponsables)) {				
				$colResponsables = [];
				while ($row2 = $base->Registro()) {
					$numEmpleado = $row2['numEmpleado'];
					$responsable = new ResponsableV();
					$responsable->Buscar($numEmpleado);
					array_push($colResponsables, $responsable);
				}
		 	}	
            else {
		 		$this->setMensajeOperacion($base->getError());
			}
		}	
        else {
		 	$this->setMensajeOperacion($base->getError());
		}	
		 
        return $colResponsables;
    }

    public function insertar(){
		$base = new BaseDatos();
		$resp = false;

        $consultaInsertar = "INSERT INTO responsableV (numLicencia, nombre, apellido) VALUES (" . $this->getNumLicencia() . ", '" . $this->getNombre() . "', '" . $this->getApellido() . "')";
		
        if ($base->Iniciar()) { 
            if ($numEmpleado = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setNumEmpleado($numEmpleado);
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

    public function modificar(){
	    $resp = false; 
	    $base = new BaseDatos();

        $consultaModifica = "UPDATE responsableV SET nombre = '" . $this->getNombre() . "', apellido = '" . $this->getApellido() . "', numLicencia = " . $this->getNumLicencia() . " WHERE numEmpleado = " . $this->getNumEmpleado();
        
        if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaModifica)) {
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

    public function eliminar(){
		$base = new BaseDatos();
		$resp = false;
		if ($base->Iniciar()) {
				$consultaBorra = "DELETE FROM responsableV WHERE numEmpleado = " . $this->getNumEmpleado();
				if ($base->Ejecutar($consultaBorra)) {
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

}