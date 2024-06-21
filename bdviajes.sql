CREATE DATABASE bdviajes; 

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    nombre varchar(150),
    direccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    numeroempleado bigint AUTO_INCREMENT,
    numerolicencia bigint,
	nombre varchar(150), 
    apellido  varchar(150), 
    PRIMARY KEY (numeroempleado)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	destino varchar(150),
    cantmaxpasajeros int,
	idempresa bigint,
    numeroempleado bigint,
    importe float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
	FOREIGN KEY (numeroempleado) REFERENCES responsable (numeroempleado)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    documento varchar(15),
    nombre varchar(150), 
    apellido varchar(150), 
	telefono int, 
	idviaje bigint,
    PRIMARY KEY (pasajero),
	FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)	
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 
  
