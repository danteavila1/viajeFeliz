<?php 

include_once 'Pasajero.php';
class PasajeroVip extends Pasajero {
    private $numeroFrecuente;
    private $cantMillas;

    public function __construct($vnombre, $vapellido, $vnumeroDocumento, $vtelefono, $vnumeroAsiento, $vnumeroTicket, $vnumeroFrecuente, $vcantMillas){
        parent::__construct($vnombre, $vapellido, $vnumeroDocumento, $vtelefono, $vnumeroAsiento, $vnumeroTicket);
        $this->numeroFrecuente = $vnumeroFrecuente;
        $this->cantMillas = $vcantMillas;
    }

	public function getNumeroFrecuente() {
		return $this->numeroFrecuente;
	}

	public function setNumeroFrecuente($value) {
		$this->numeroFrecuente = $value;
	}

	public function getCantMillas() {
		return $this->cantMillas;
	}

	public function setCantMillas($value) {
		$this->cantMillas = $value;
	}

    public function __toString(){
        $cadena = parent::__toString();
        $cadena .= $this->getNumeroFrecuente() ."\n". $this->getCantMillas();
        return $cadena;
    }

    public function darPorcentajeIncremento(){
        $incremento=35;
        if($this->getCantMillas() > 300){
            $incremento=30;
        }
        return $incremento;
    }
}