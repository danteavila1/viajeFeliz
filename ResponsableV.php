<?php
class ResponsableV extends Persona
{
    private $numeroEmpleado;
    private $numeroLicencia;


    public function __construct()
    {
        parent::__construct();
        $this->numeroEmpleado = "";
        $this->numeroLicencia = "";
    }

    public function cargar($nroDoc, $nombre, $apellido, $telefono, $numeroEmpleado=null, $numeroLicencia=null){
        parent::cargar($nroDoc, $nombre, $apellido, $telefono);
		$this->setNumeroEmpleado($numeroEmpleado);
        $this->setNumeroLicencia($numeroLicencia);
    }


    public function getNumeroEmpleado()
    {
        return $this->numeroEmpleado;
    }

    public function setNumeroEmpleado($numeroE)
    {
        $this->numeroEmpleado = $numeroE;
    }

    public function getNumeroLicencia()
    {
        return $this->numeroLicencia;
    }

    public function setNumeroLicencia($numeroL)
    {
        $this->numeroLicencia = $numeroL;
    }
    public function Buscar($numeroEmpleado){
		$base=new BaseDatos();
        $consulta="SELECT * FROM responsable WHERE numeroempleado=".$numeroEmpleado; 
        $resp= false;
        if($base->Iniciar()){
            if($base->Ejecutar($consulta)){
                if($row2=$base->Registro()){    
                    parent::Buscar($row2['numdoc']);
                    $this->setNumeroEmpleado($row2['numeroempleado']);
                    $this->setNumeroLicencia($row2['numerolicencia']);
                    $resp= true;
                }                
            } else {
                $this->setmensajeoperacion($base->getError());
            }
         } else {
                $this->setmensajeoperacion($base->getError());
         }        
         return $resp;
	}	
    

	public function listar($condicion=""){
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="Select * from responsable ";
		if ($condicion!=""){
		    $consulta=$consulta.' where '.$condicion;
		}
		$consulta.=" order by numeroempleado "; /**CONSULTAR */
		//echo $consultaPersonas;
		if($base->Iniciar()){
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new ResponsableV();
					$obj->Buscar($row2['documento']); /**pdocumento o rnumeroempleado */
					array_push($arreglo,$obj);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arreglo;
	}	

		public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		if(parent::insertar()){
		
			$consultaInsertar = "INSERT INTO responsable (numerolicencia, numdoc) 
                     VALUES (" . $this->getNumeroLicencia() . ", " . $this->getNrodoc() . ")";

		    if($base->Iniciar()){

				if($numeroEmpleado = $base->devuelveIDInsercion($consultaInsertar)){
					$this->setNumeroEmpleado($numeroEmpleado);
					$resp=  true;
		        }	else {
		            $this->setmensajeoperacion($base->getError());
		        }
		    } else {
		        $this->setmensajeoperacion($base->getError());
		    }
		 }
		return $resp;
	}
	
	
		public function modificar(){
			$resp =false; 
			$base=new BaseDatos();
			if(parent::modificar()){
				$consultaModifica="UPDATE responsable SET numerolicencia=".$this->getNumeroLicencia()." WHERE numeroempleado=". $this->getNumeroEmpleado(); 
				if($base->Iniciar()){
					if($base->Ejecutar($consultaModifica)){
						$resp=  true;
					}else{
						$this->setmensajeoperacion($base->getError());
						
					}
				}else{
					$this->setmensajeoperacion($base->getError());
					
				}
			}
			
			return $resp;
		}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM responsable WHERE documento=".$this->getNrodoc();
				if($base->Ejecutar($consultaBorra)){
				    if(parent::eliminar()){
				        $resp=  true;
				    }
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
   
    public function __toString()
    {
        $info= parent::__toString();
        $info.= "Empleado: {$this->getNumeroEmpleado()}, Licencia: {$this->getNumeroLicencia()})";
        return $info;
    }
}