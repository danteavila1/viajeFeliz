<?php

include_once 'Viaje.php';
include_once 'ResponsableV.php';
include_once 'Pasajero.php';
include_once 'Empresa.php';
include_once 'BaseDatos.php';


// $pasajero1 = new Pasajero('oscar', 'avila', 1235676, 2994502351, 1, 2);
// $pasajero2 = new PasajeroVip('laura', 'laurelio', 32123654, 299123123, 1, 2, 12345, 350);
// $pasajero3 = new PasajeroNecEsp('pedro', 'picapiedra', 42123542, 29998452, 1 , 2, false, true, false);

// $responsable = new ResponsableV(1, 222, 'daniel', 'flores');

// $viaje = new Viaje(1, 'londres', 10, [$pasajero1, $pasajero2, $pasajero3], $responsable, 100, 300);

// echo $viaje->__toString();

// $pasajero4 = new PasajeroVip('pedro', 'picapiedra', 1111, 29998452, 1 , 2, 1234, 100);

// $precioPasaje = $viaje->venderPasaje($pasajero4);
// if ($precioPasaje > -1) {
//     echo ("el pasajero fue agregado con exito");
// }
// else{
//     echo ("No se pudo agregar pasajero");
// }



// echo "\n". $viaje->__toString();


echo "<<<<<<<<<<<<< Bienvenido >>>>>>>>>>>>> 
\n [Ingrese una opcion] \n ";

do {
    echo "1- Ver informacion del viaje \n";
    echo "2- Vender pasaje \n";
    echo "3- Ingresar viaje \n";
    echo "4- Ver viajes de la empresa \n";
    echo "5- Modificar un viaje o pasajero \n";
    echo "6- Eliminar un viaje o pasajero \n";
    echo "7- Ingresar datos \n";
    echo "8- Salir";
    $valor=trim(fgets(STDIN));

    // VER INFORMACION DEL VIAJE

    if ($valor == 1){
        $objViaje = new Viaje();
        echo "Ingrese el ID del viaje";
        $idViaje = trim(fgets(STDIN));
        $objViaje->buscar($idViaje);
        echo $objViaje;
    }

    // VENDER PASAJE

    if($valor == 2){
        echo "Ingrese el destino: \n";
        $destino = trim(fgets(STDIN));
        $objViaje = new Viaje();
        $colViajes = $objViaje->listar("destino = " . " '$destino'"); 
        if ($colViajes != null){
            $i = 1;
            foreach ($colViajes as $viaje){
                echo "|N° ". $i . "|[" . $viaje . "]\n";
                $i = $i + 1;
            }
            echo "ingrese el id de viaje que desea comprar:  \n";
            $id=trim(fgets(STDIN));  
            if($objViaje->Buscar($id)){
                $objPasajero=new Pasajero();
                $colObjPasajero=$objPasajero->listar();
                if (count($colObjPasajero)<$objViaje->getcantidadMaxPasajeros()) {
                    $asientosDisponibles=$objViaje->getcantidadMaxPasajeros()-count($colObjPasajero);
                    echo "los asientos disponibles son:".$asientosDisponibles."\n";
                    echo "Ingrese el Nombre: \n";
                    $nombre=trim(fgets(STDIN));
                    echo "Ingrese el apellido: \n";
                    $apellido=trim(fgets(STDIN));
                    echo "ingrese el DNI del pasajero: \n";
                    $documento=trim(fgets(STDIN));
                    echo "ingrese el numero de telefono: \n";
                    $telefono=trim(fgets(STDIN));

                    $objPasajero=new Pasajero();
                    $objPasajero->cargar($documento,$nombre,$apellido,$telefono,$objViaje);
                    $objPasajero->insertar();
                    echo "\n ***Se vendio el pasaje con exito*** :v \n";
                }
            } else {
                echo "error al ingresar el codigo \n";
            }
        } else {
            echo "No hay lugares disponibles";
        }
    }

    // INGRESAR VIAJE

    if ($valor == 3){
        mostrarEmpresa();
        echo "Ingrese el id de la empresa \n";
        $idEmpresa = trim(fgets(STDIN));

        if($objEmpresa->Buscar($idEmpresa)){
            $objViaje = new Viaje();
            echo "Ingrese el destino: \n";
            $destino = trim(fgets(STDIN));
            echo "Ingrese la cantidad maxima de pasajeros: \n";
            $cantMax = trim(fgets(STDIN));
            $objViaje->cargar(10, $destino, $cantMax,[], $objEmpresa, null, 7);
            mostrarResponsables();
            if (agregarResponsable($objViaje)){
                $objViaje->insertar();
                echo "El viaje se ha cargado con exito \n";
            }
        } else {
            echo "No se registra el ID de empresa: " . $idEmpresa;
        }
    }

}while($valor==1 || $valor==2 ||$valor==3 ||$valor==4||$valor==5||$valor==6 ||$valor==7);

function mostrarEmpresa(){
    $objEmpresa = new Empresa();
    $colEmpresa = $objEmpresa->listar();
    $i = 1;

    foreach ($colEmpresa as $empresa){
        $i = 1;
        echo "|N°".$i."|[".$empresa."]\n";
        $i+=1;
    }
}

function mostrarResponsables(){
    $objResponsable=new ResponsableV();
    $colResponsable=$objResponsable->listar();
    $i=1;
    foreach ($colResponsable as $responsable) {
        echo "|N°".$i."|[".$responsable."]\n";
        $i+=1;
    }
}

function agregarResponsable($objViaje){
    $exito=false;
    $objResponsable=new ResponsableV();
    echo "¿el responsable esta cargado en la lista? (s para si/n para no) \n";
    $resResponsable=trim(fgets(STDIN));
    if ($resResponsable=="s") {
        echo "ingrese el Número de empleado del responsable \n";
        $idEmpleado=trim(fgets(STDIN));
        if ($objResponsable->Buscar($idEmpleado)) {
            $exito=true;
        }
        else {
            echo "no se encontro al empleado con el id: ".$idEmpleado;
        }
                
    }
    else{
        echo "ingrese Nombre del responsable del viaje \n";
        $nombre=trim(fgets(STDIN));
        echo "ingrese el apellido del responsable \n";
        $apellido=trim(fgets(STDIN));
        echo "ingrese el numero de licencia del responsable \n";
        $numLicencia=trim(fgets(STDIN));
        echo "ingrese el numero de empleado del responsable \n";
        $numEmpleado=trim(fgets(STDIN));
        $objResponsable->cargar($numEmpleado,$numLicencia,$nombre,$apellido);
        $objResponsable->insertar();
        $objViaje->setObjResponsable($objResponsable);
        $exito=true;
        }
    return $exito;
}


