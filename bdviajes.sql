CREATE DATABASE bdviajes; 

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    nrodoc varchar(15),
    rnumeroempleado bigint AUTO_INCREMENT,
    rnumerolicencia bigint,
	PRIMARY KEY (rnumeroempleado),
    FOREIGN KEY (nrodoc) REFERENCES persona (nrodoc)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	vdestino varchar(150),
    vcantmaxpasajeros int,
	idempresa bigint,
    rnumeroempleado bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
	FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado),
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    pdocumento varchar(15),
   	idviaje bigint,
    PRIMARY KEY (pasajero),
	FOREIGN KEY (idviaje) REFERENCES viaje (idviaje),
    FOREIGN KEY (pdocumento) REFERENCES persona (nrodoc)	
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 
 /**Se creo tabla persona y se hicieron modificaciones en las tablas pasajero y responsable*/

CREATE TABLE persona (
    nrodoc varchar(15),
    pnombre varchar(150), 
    papellido varchar(150), 
	ptelefono varchar(150), 
	direccion varchar(150),
    PRIMARY KEY (nrodoc)	
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 
