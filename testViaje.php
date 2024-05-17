<?php

include 'Viaje.php';
include 'ResponsableV.php';
include_once 'PasajeroVip.php';
include_once 'PasajeroNecEsp.php';


$pasajero1 = new Pasajero('oscar', 'avila', 1235676, 2994502351, 1, 2);
$pasajero2 = new PasajeroVip('laura', 'laurelio', 32123654, 299123123, 1, 2, 12345, 350);
$pasajero3 = new PasajeroNecEsp('pedro', 'picapiedra', 42123542, 29998452, 1 , 2, false, true, false);

$responsable = new ResponsableV(1, 222, 'daniel', 'flores');

$viaje = new Viaje(1, 'londres', 10, [$pasajero1, $pasajero2, $pasajero3], $responsable, 100, 300);

echo $viaje->__toString();

$pasajero4 = new PasajeroVip('pedro', 'picapiedra', 1111, 29998452, 1 , 2, 1234, 100);

$precioPasaje = $viaje->venderPasaje($pasajero4);
if ($precioPasaje > -1) {
    echo ("el pasajero fue agregado con exito");
}
else{
    echo ("No se pudo agregar pasajero");
}



echo "\n". $viaje->__toString();



