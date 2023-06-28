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
(3, 'argentina'),
(1, 'colombia'),
(2, 'mexico');

INSERT INTO `departamento` (`idDep`, `nombreDep`, `idPais`) VALUES
(1, 'santander', 1),
(2, 'ANTIOQUIA', 1),
(3, 'CMDX', 2),
(4, 'CANCUN', 2),
(5, 'Rio plata', 3);

INSERT INTO `region` (`idReg`, `nombreReg`, `idDep`) VALUES
(1, 'Bucaramanga', 1),
(2, 'Medellin', 2),
(3, 'Ciudad de mexico', 3),
(4, 'CANCUN', 4),
(5, 'Buenos aires', 5);


INSERT INTO `campers` (`idCamper`, `nombreCamper`, `apellidoCamper`, `fechaNac`, `idReg`) VALUES
(1, 'daniel', 'manosalva', '2002-03-13', 5);



