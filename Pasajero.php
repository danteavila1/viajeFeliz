<?php

Class Pasajero {
    private $nombre;
    private $apellido;
    private $numeroDocumento;
    private $telefono;
    // private $numeroAsiento;
    // private $numeroTicket;

    public function __construct($vnombre, $vapellido, $vnumeroDocumento, $vtelefono){
        $this->nombre = $vnombre;
        $this->apellido = $vapellido;
        $this->numeroDocumento = $vnumeroDocumento;
        $this->telefono = $vtelefono;
        // $this->numeroAsiento = $vnumeroAsiento;
        // $this->numeroTicket = $vnumeroTicket;
    }

    public function setNombre ($nombre){
        $this->nombre = $nombre;
    }
    public function getNombre(){
        return $this->nombre;
    }
    // public function setNumeroAsiento($numeroAsiento){
    //     $this->numeroAsiento=$numeroAsiento;
    // }
    // public function getNumeroAsiento(){
    //     return $this->numeroAsiento;
    // }

    // public function setNumeroTicket ($numeroTicket){
    //     $this->numeroTicket = $numeroTicket;
    // }
    // public function getNumeroTicket(){
    //     return $this->numeroTicket;
    // }

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

    public function __toString(){
        return $this->getNombre() ."\n". $this->getApellido() ."\n".
        $this->getTelefono() ."\n". $this->getNumeroDocumento() ."\n";
    }

    public function darPorcentajeIncremento(){
        $incremento = 10;
        return $incremento;
    }

}