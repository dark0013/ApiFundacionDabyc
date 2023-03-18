CREATE DATABASE `bdabyc`;
USE `bdabyc`;

CREATE TABLE `tbl_contactos` (
  `id_contacto` int NOT NULL AUTO_INCREMENT,
  `indentication` varchar(50) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` char(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` char(5) DEFAULT 'S' NOT NULL,
  `user_sesion` datetime NOT NULL,
  `date_creation` datetime NOT NULL,
  `user_creation` varchar(100) NOT NULL,
  `user_update` varchar(100) NOT NULL,
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

CREATE TABLE `tbl_detalle_donacion` (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `id_donacion` int NOT NULL,
  `id_producto` int NOT NULL,
  `id_user` int NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `status` char(5) DEFAULT 'S' NOT NULL,
  PRIMARY KEY (`id_detalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;


CREATE TABLE `tbl_donaciones` (
  `id_donacion` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `dni` varchar(15) NOT NULL,
  `email` text NOT NULL,
  `cellPhone` varchar(15) NOT NULL,
  `type_products` varchar(250) NOT NULL,
  `donaciones` varchar(250) NOT NULL,
  `user` varchar(10) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` char(5) DEFAULT 'S' NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id_donacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

/*PS*/
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_DONACIONES`(
    iv_name VARCHAR(200),
    iv_dni VARCHAR(20),
    iv_email VARCHAR(200),
    iv_cellPhone VARCHAR(17),
    iv_type_products VARCHAR(20),
    iv_donaciones VARCHAR(5000),
    iv_user VARCHAR(100),
    OUT COD_RESPONSE VARCHAR(100),
    OUT MENSAJE_RESPONSE VARCHAR(1000)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET COD_RESPONSE = 'No se pudo insertar el nuevo usuario, ocurrió un error en la base de datos.';
        SET MENSAJE_RESPONSE = '99';
        ROLLBACK;
    END;

    START TRANSACTION;

    INSERT INTO `tbl_donador`(`name`, `dni`, `email`, `cellPhone`)
    VALUES(iv_name, iv_dni, iv_email, iv_cellPhone);

-- Parsear JSON y guardar los datos en tbl_donaciones
 INSERT INTO tbl_donaciones (type_products,id_cabecera,description, quantity)
    VALUES (
        iv_type_products,
        (SELECT LAST_INSERT_ID() AS ultimo_id FROM tbl_donador),
        JSON_EXTRACT(iv_donaciones, '$.description'), JSON_EXTRACT(iv_donaciones, '$.quantity')
    );
    
COMMIT;

SET COD_RESPONSE = 'TRANSACCIÓN OK.';
SET MENSAJE_RESPONSE = '00';
END$$
DELIMITER ;
/*TERMINA PS*/

CREATE TABLE `tbl_informacion_visual` (
  `id_information` int NOT NULL AUTO_INCREMENT,
  `local_storage` varchar(250) NOT NULL,
  `rol_user` varchar(100) NOT NULL,
  `status` char(5) DEFAULT 'S' NOT NULL,
  PRIMARY KEY (`id_information`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

CREATE TABLE `tbl_productos` (
  `id_product` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `quantity` varchar(300) NOT NULL,
  `tipe_products` varchar(250) NOT NULL,
  `status` char(5) DEFAULT 'S' NOT NULL,
  `description` varchar(250) NOT NULL,
  `user_sesion` datetime NOT NULL,
  `date_creation` datetime NOT NULL,
  `user_creation` varchar(100) NOT NULL,
  `user_update` varchar(100) NOT NULL,
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;


CREATE TABLE `tbl_proyectos` (
  `id_project` int NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `url_image` varchar(250) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL,
  `rol_user` varchar(100) NOT NULL,
  `status` char(5) DEFAULT 'S' NOT NULL,
  `user_sesion` datetime NOT NULL,
  `date_creation` datetime NOT NULL,
  `user_creation` varchar(100) NOT NULL,
  `user_update` varchar(100) NOT NULL,
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;


CREATE TABLE `tbl_roles` (
  `id_rol` int NOT NULL AUTO_INCREMENT,
  `rol_user` varchar(100) NOT NULL,
  `cod_rol` varchar(5) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `status` char(5) DEFAULT 'S' NOT NULL,
  `user_sesion` datetime NOT NULL,
  `date_creation` datetime NOT NULL,
  `user_creation` varchar(100) NOT NULL,
  `user_update` varchar(100) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;


CREATE TABLE `tbl_usuario` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `name_users` varchar(200) NOT NULL,
  `id_rol` varchar(100) NOT NULL,
  `identification_card` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `status` char(5) DEFAULT 'S' NOT NULL,
  `user_sesion` datetime NOT NULL,
  `date_creation` datetime NOT NULL,
  `user_creation` varchar(100) NOT NULL,
  `user_update` varchar(100) NOT NULL,
    PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
