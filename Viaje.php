<?php

class Viaje {

    private $idViaje;
    private $destino;
    private $cantidadMaxPasajeros;
    private $colPasajeros;
    private $objResponsable;
    private $costo;
    private $objEmpresa;
    private $mensajeOperacion;

    public function __construct(){
        $this->idViaje = 0;
        $this->destino = "";
        $this->cantidadMaxPasajeros = 0;
        $this->colPasajeros = [];
        $this->objResponsable = null;
        $this->costo = 0;
        $this->objEmpresa = null;
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

	public function setObjEmpresa($objEmpresa) {
		$this->objEmpresa = $objEmpresa;
	}

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function cargar($idViaje,$Nom,$Dir){

        $this->setIdViaje($idViaje);
        $this->setDestino($destino);
        $this->setCantidadMaxPasajeros($cantidadMaxPasajeros);
        $this->setColPasajeros($colPasajeros);
        $this->setObjResponsable($objResponsable);
        $this->setCosto($costo);
        $this->setObjEmpresa($objEmpresa);

    }

    public function buscar($idViaje){

        $base = new BaseDatos();
        $consultaBuscarViaje = "SELECT * FROM viaje WHERE idviaje=".$idViaje; 
        $resp = false;

        if($base->Iniciar()){
            if($base->Ejecutar($consultaBuscarViaje)){
                if($row2 =$base->Registro()){
                    $resp = new ResponsableV();
                    $resp->buscar($row2['rnumeroempleado']);
                    $emp = new Empresa();
                    $emp->buscar($row2['idempresa']);
                    $this->cargar($idviaje,$row2['vdestino'],$row2['vcantmaxpasajeros'],$resp,$row2['vimporte'],$emp);
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
                    $destino = $row2['vdestino'];
                    $cantidadMaxPasajeros = $row2['vcantmaxpasajeros'];
                    $costo = $row2['vimporte'];

                    $resp = new ResponsableV();
                    $resp->buscar($row2['rnumeroempleado']);
                    $emp = new Empresa();
                    $emp->buscar($row2['idempresa']);

                    $viaje = new Viaje($idViaje,$destino,$cantidadMaxPasajeros,$resp,$costo,$emp);
                    $viaje->cargar();
                    array_push($arregloViajes,$viaje);
                
                }
            }else{
                $this->setMensajeOperacion($base->getError());
            }
        }else{
            $this->setMensajeOperacion($base->getError());
        }
        
        return $arregloViajes;

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