CREATE DATABASE bdviajes; 
USE bdviajes;
CREATE TABLE persona(
    numdoc bigint PRIMARY KEY,
    nombre varchar(150),
    apellido varchar(150),
    telefono bigint
)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    nombre varchar(150),
    direccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    numeroempleado bigint AUTO_INCREMENT,
    numerolicencia bigint,
    numdoc bigint,
    PRIMARY KEY (numeroempleado),
    FOREIGN KEY (numdoc) REFERENCES persona(numdoc)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, 
	destino varchar(150),
    maxpasajeros bigint,
	idempresa bigint,
    numeroempleado bigint,
    importe float, 
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (numeroempleado) REFERENCES responsable (numeroempleado)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
    CREATE TABLE pasajero ( 
    idpasajero bigint AUTO_INCREMENT, 
    documento bigint,
    numasiento bigint,
    numticket bigint,
    idviaje bigint, 
    PRIMARY KEY (idpasajero), 
    FOREIGN KEY (documento) REFERENCES persona (numdoc)  ON UPDATE CASCADE
    ON DELETE RESTRICT,
    FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)  ON UPDATE CASCADE
    ON DELETE RESTRICT
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;


    