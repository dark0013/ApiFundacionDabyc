CREATE DATABASE `istghknj_key_passwords`;
USE `istghknj_key_passwords`;
CREATE TABLE `users` (
  `iduser` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `name` varchar(50) NOT NULL,
  `cellphone` char(100) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `imagen` char(5) NOT NULL,
  `activo` varchar(100) NOT NULL,
  `delete` datetime DEFAULT CURRENT_TIMESTAMP(),
  `date_registro` varchar(100) NOT NULL,
  `date_update` datetime DEFAULT CURRENT_TIMESTAMP(),
  `date_delete` varchar(100) NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

CREATE TABLE `passwords` (
  `idpasswords` int NOT NULL AUTO_INCREMENT,
  `iduser` varchar(50) NOT NULL,
  `namepassword` varchar(250) NOT NULL,
  `password` varchar(50) NOT NULL,
  `activo` char(100) NOT NULL,
  `delete` varchar(250) NOT NULL,
  `date_registro` varchar(250) NOT NULL,
  `date_update` char(5) NOT NULL,
  `date_delete` varchar(100) NOT NULL,
  PRIMARY KEY (`idpasswords`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;