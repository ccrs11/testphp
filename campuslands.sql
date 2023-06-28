DROP DATABASE campuslands;
CREATE DATABASE campuslands;

USE campuslands;


CREATE TABLE pais( 
  idPais INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
  nombrePais VARCHAR(150) NOT NULL UNIQUE
);

CREATE TABLE departamento( 
  idDep INT NOT NULL PRIMARY KEY , 
  nombreDep VARCHAR(50) NOT NULL UNIQUE, 
  idPais INT NOT NULL, 
  CONSTRAINT fk_idPais 
  FOREIGN KEY(idPais) REFERENCES pais(idPais)
);

CREATE TABLE region( 
  idReg INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
  nombreReg VARCHAR(60) NOT NULL UNIQUE, 
  idDep INT NOT NULL, 
  CONSTRAINT fk_idDep 
  FOREIGN KEY (idDep) REFERENCES departamento(idDep)
);



CREATE TABLE campers( 
  idCamper INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
  nombreCamper VARCHAR(50) NOT NULL, 
  apellidoCamper VARCHAR(50) NOT NULL , 
  fechaNac DATE NOT NULL , 
  idReg INT NOT NULL, 
  CONSTRAINT fk_idReg 
  FOREIGN KEY (idReg) REFERENCES region(idReg)
);


INSERT INTO `pais` (`idPais`, `nombrePais`) VALUES
(1, 'Colombia'),
(2, 'Venezuela'),
(3, 'Brazil'),
(4, 'Peru');

INSERT INTO `departamento` (`idDep`, `nombreDep`, `idPais`) VALUES
(1, 'Santander', 1),
(2, 'Boyacá', 1),
(3, 'Tachira', 2),
(4, 'Merida', 2);

INSERT INTO `region` (`idReg`, `nombreReg`, `idDep`) VALUES
(1, 'Piedecuesta', 1),
(2, 'Duitama', 2),
(3, 'Guaduas', 3),
(4, 'Palamares', 4);


INSERT INTO `campers` (`idCamper`, `nombreCamper`, `apellidoCamper`, `fechaNac`, `idReg`) VALUES
(1, 'Cristian', 'Rojas', '1996-01-04', 2);



