<?php

include_once "BaseDatos.php";

class Empresa{

    //Consultar si el nombre de los atributos deben ser igual al nombre de la tabla de la base de datos
    private $idEmpresa;
    private $eNombre;
    private $eDireccion;
    private $colViajes;
    private $mensajeOperacion;


    public function __construct(){

        $this->idEmpresa = " ";
        $this->eNombre = " ";
        $this->eDireccion = " ";
        $this->colViajes= [];
    }

    public function cargar($idEmpresa,$nombre,$direccion){

        $this->setIdEmpresa($idEmpresa);
        $this->setENombre($nombre);
        $this->setEDireccion($direccion);


    }

    public function getIdEmpresa(){
        return $this->idEmpresa;
    }

    public function getENombre(){
        return $this->eNombre;
    }

    public function getEDireccion(){
        return $this->eDireccion;
    }

    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    public function getColViajes(){
        return $this->colViajes;
    }

    public function setIdEmpresa($IdEmpresa){
        $this->idEmpresa = $IdEmpresa;
    }

    public function setENombre($Nombre){
        $this->eNombre = $Nombre;
    }

    public function setEDireccion($direccion){
        $this->eDireccion = $direccion;
    }

    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function setColViajes($colViajes){
        $this->colViajes = $colViajes;
    }




    /**Recupera los datos de una empresa por id Empresa
     * @param int $idEmpresa
     * @return true en caso de encontrar los datos, false en caso contrario
     */

    public function buscar ($idEmpresa){

        $base = new BaseDatos();
        $consultaEmpresa = "SELECT * from empresa WHERE idempresa=".$idEmpresa;
        $resp = false;

        if($base->Iniciar()){
            if($base->Ejecutar($consultaEmpresa)){
                if($row2 = $base->Registro()){
                    $this->setIdEmpresa($idEmpresa);
                    $this->setENombre($row2['enombre']);
                    $this->setEDireccion($row2['edireccion']);

                    $viaje = new Viaje();
                    $viaje->Buscar($row2['idviaje']);
                    $this->setColViajes($viaje);

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

    /**
     * recupera una lista de empresa de la base de datos
     * @param string
     * @return array
     */

    public function listar ($condicion=""){

        $arregloEmpresas = null;
        $base = new BaseDatos();
        $consultaEmpresa = "SELECT * from empresa ";

        if($condicion != ""){
            $consultaEmpresa = $consultaEmpresa.' where '.$condicion;
        }
        
        $consultaEmpresa.= " order by idEmpresa ";
        if($base->Iniciar()){

            if($base->Ejecutar($consultaEmpresa)){

                $arregloEmpresas = array();

                while($row2=$base->Registro()){

                    $IdEmp = $row2['idempresa'];
                    $Enombre = $row2['enombre'];
                    $eDireccion = $row2['edireccion'];

                    $empresa=new Empresa();
                    $empresa->cargar($IdEmp,$Enombre,$eDireccion);
					array_push($arregloEmpresas,$empresa);
                }

            }else{
                $this->setMensajeOperacion($base->getError());
            }

        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $arregloEmpresas;

    }

    /**
     * Inserta el objeto de empresa actual en la base de datos
     * @return boolean
     */
 
     public function insertar(){

        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO empresa (enombre, edireccion)
                            VALUES ('".$this->getENombre()."','".$this->getEDireccion()."')";

        if($base->Iniciar()){

            if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdEmpresa($id);
                $resp = true;

            }else{
                $this->setMensajeOperacion($base->getError());
            }

        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $resp;
    }

    /**
     * modifica la información de la empresa en la base de datos
     * @return boolean
     */

    public function modificar(){

        $resp = false;
        $base = new BaseDatos();
        $consultaModificar = "UPDATE empresa SET enombre='".$this->getENombre()."',edireccion='".$this->getEDireccion()."'WHERE idempresa=".$this->getIdEmpresa();

        if($base->Iniciar()){

            if($base->Ejecutar($consultaModificar)){
                $resp = true;
                
            }else{
                $this->setMensajeOperacion($base->getError());
            }

        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $resp;
    }

    /**
     * elimina el registro de la empresa de la base de datos
     * @return boolean
     */

    public function eliminar (){

        $resp = false;
        $base = new BaseDatos();

        if($base->Iniciar()){
            $consultaEliminar="DELETE FROM empresa WHERE idempresa=".$this->getIdEmpresa();
            if($base->Ejecutar($consultaEliminar)){
                $resp = true;

            }else{
                $this->setMensajeOperacion($base->getError());
            }

        }else{
            $this->setMensajeOperacion($base->getError());
        }

        return $resp; 
    }
    

    /**
     * retorna una coleccion de viajes en una cadena
     * @return string
     */

    public function mostrarViajes(){

        $viajes=$this->getColViajes();
        $cadena="";

        for($i=0; $i<count($viajes);$i++){
            $cadena.="VIAJE N°". $i+1 ."\n".$viajes[$i]."\n \n";
        }

        return $cadena;
    }
    
    public function __toString(){

        return  "ID: ".$this->getIdEmpresa()."\n". 
                "NOMBRE: ". $this->getENombre()."\n". 
                "DIRECCION: ". $this->getEDireccion()."\n". 
                "========== VIAJES ==========\n ". $this->mostrarViajes();
    }

}

?>