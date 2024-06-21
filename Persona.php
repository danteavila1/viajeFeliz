<?php

Class Persona {
    private $nroDoc;
    private $nombre;
    private $apellido;
    private $telefono;
    private $direccion;
    private $mensajeoperacion;

    public function __construct(){
        $this->nroDoc = "";
        $this->nombre = "";
        $this->apellido = "";
        $this->telefono = "";
        $this->direccion = "";
        $this->mensajeoperacion = "";
    }

    public function cargar($pNumDoc,$pNombre, $pApellido, $pTelefono, $pDireccion){
        $this->setNroDoc($pNumDoc);
        $this->setNombre($pNombre);
        $this->setApellido($pApellido);
        $this->setTelefono($pTelefono);
        $this->setDireccion($pDireccion);
    }

    //Metodos GET
    public function getNroDoc(){
        return $this->nroDoc;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getDireccion(){
        return $this->direccion;
    }
    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    //Metodos SET
    public function setNroDoc($pNumDoc){
        $this->nroDoc = $pNumDoc;
    }
    public function setNombre($pNombre){
        $this->nombre = $pNombre;
    }
    public function setApellido($pApellido){
        $this->apellido = $pApellido;
    }
    public function setTelefono($pTelefono){
        $this->telefono = $pTelefono;
    }
    public function setDireccion($pDireccion){
        $this->direccion = $pDireccion;
    }
    public function setMensajeOperacion($mensajeoperacion){
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function Buscar($nroDoc){
        $base = new BaseDatos();
        $consultaPersona = "Select * from persona where nrodoc =" . $nroDoc;
        $resp = false;
        if($base->Iniciar()){
            if($base->Ejecutar($consultaPersona)){
                if($row2= $base->Registro()){
                    $this->setNroDoc($nroDoc);
                    $this->setNombre($row2['nombre']);
                    $this->setApellido($row2['apellido']);
                    $this->setTelefono($row2['telefono']);
                    $this->setDireccion($row2['direccion']);
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        }else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function listar($condicion=""){
        $arregloPersona = null;
        $base = new BaseDatos();
        $consultaPersonas ="Select * from persona ";
        if ($condicion != ""){
            $consultaPersonas = $consultaPersonas. ' where ' . $condicion;
        }
        $consultaPersonas .= " order by apellido";

        if($base->Iniciar()){
            if($base->Ejecutar($consultaPersonas)){
                $arregloPersona = array();
                while($row2 = $base->Registro()){
                    $NroDoc = $row2['nrodoc'];
                    $Nombre = $row2['nombre'];
                    $Apellido=$row2['apellido'];
                    $Telefono = $row2['telefono'];
                    $Direccion = $row2['direccion'];

                    $perso = new Persona();
                    $perso->cargar($NroDoc, $Nombre, $Apellido, $Telefono, $Direccion);
                    array_push($arregloPersona, $perso);
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloPersona;
    }

    public function insertar(){
        $base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO persona(nrodoc,pnombre,papellido, ptelefono, direccion) 
				VALUES (".$this->getNroDoc().",'" . $this->getApellido() . "','" . $this->getNombre() . "','". $this->getTelefono(). ", " . $this->getDireccion() ."')";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
    }

    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE persona SET apellido='".$this->getApellido()."',nombre='".$this->getNombre()."'
                           ,telefono='".$this->getTelefono()."',direccion='".$this->getDireccion()."' WHERE nrodoc=". $this->getNroDoc();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM persona WHERE nrodoc=".$this->getNroDoc();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}

    public function __toString(){
        return "Numero de documento: " . $this->getNroDoc() . "\n Nombre: " . $this->getNombre() . "\n Apellido: " . $this->getApellido() . "\n Telefono: " . $this->getTelefono() . "\n Direccion: " . $this->getDireccion();
	}
}