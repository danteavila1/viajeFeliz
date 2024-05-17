<?php 

include_once 'Pasajero.php';
class PasajeroNecEsp extends Pasajero {
    private $sillaDeRuedas;
    private $asistencia;
    private $comidaEspecial;

    public function __construct($vnombre, $vapellido, $vnumeroDocumento, $vtelefono, $vnumeroAsiento, $vnumeroTicket, $vsillaDeRuedas, $vasistencia, $vcomidaEspecial){
        parent::__construct($vnombre, $vapellido, $vnumeroDocumento, $vtelefono, $vnumeroAsiento, $vnumeroTicket);
        $this->sillaDeRuedas = $vsillaDeRuedas;
        $this->asistencia = $vasistencia;
        $this->comidaEspecial = $vcomidaEspecial;
    }

	public function getSillaDeRuedas() {
		return $this->sillaDeRuedas;
	}

	public function setSillaDeRuedas($value) {
		$this->sillaDeRuedas = $value;
	}

	public function getAsistencia() {
		return $this->asistencia;
	}

	public function setAsistencia($value) {
		$this->asistencia = $value;
	}

	public function getComidaEspecial() {
		return $this->comidaEspecial;
	}

	public function setComidaEspecial($value) {
		$this->comidaEspecial = $value;
	}

    
    public function __toString(){
        $cadena = parent::__toString();
        $cadena .= "\n". $this->getSillaDeRuedas() ."\n".
        $this->getAsistencia() ."\n". 
        $this->getComidaEspecial() ."\n";
        return $cadena;
    }

    public function darPorcentajeIncremento(){
        $sillaDeRuedas = $this->getSillaDeRuedas();
        $asistencia = $this->getAsistencia();
        $comidaEspecial = $this->getComidaEspecial();
        $incremento = 30;
        if (
            ($sillaDeRuedas && !$asistencia && !$comidaEspecial) ||
            (!$sillaDeRuedas && $asistencia && !$comidaEspecial) ||
            (!$sillaDeRuedas && !$asistencia && $comidaEspecial)
        ) {
            $incremento = 15;
        }
        return $incremento;
    }
}