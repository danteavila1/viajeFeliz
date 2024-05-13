<?php

include 'ResponsableV.php';
include 'Pasajero.php';
include 'Viaje.php';

$pasajero1 = new Pasajero('oscar', 'avila', 1235676, 2994502351);
$pasajero2 = new Pasajero('laura', 'laurelio', 32123654, 299123123);
$pasajero3 = new Pasajero('pedro', 'picapiedra', 42123542, 29998452);

$responsable = new ResponsableV(1, 222, 'daniel', 'flores');

$viaje = new Viaje(1, 'londres', 200, [$pasajero1, $pasajero2, $pasajero3], $responsable);

echo $viaje->__toString();

if($viaje->agregarPasajero('nuevo', 'pasajero', 2312, 222) == false){
    echo ("el pasajero fue agregado con exito");
}
else{
    echo ("ya existe este pasajero");
}



echo "\n". $viaje->__toString();



