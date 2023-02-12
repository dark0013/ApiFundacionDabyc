CREATE DATABASE `bdabyc`;

CREATE TABLE `tbl_contactos` (
  `id_contacto` int NOT NULL,
  `indentication_card` varchar(50) NOT NULL,
  `full_name` varchar(250) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` char(100) NOT NULL,
  `address` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` char(5) NOT NULL,
  `user_sesion` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `usur_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_update` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

CREATE TABLE `tbl_detalle_donacion` (
  `id_detalle` int NOT NULL,
  `id_donacion` int NOT NULL,
  `id_producto` int NOT NULL,
  `id_user` int NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `status` char(5) NOT NULL,
  PRIMARY KEY (`id_detalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;


CREATE TABLE `tbl_donaciones` (
  `id_donacion` int NOT NULL,
  `type_products` varchar(250) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` char(5) NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_donacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;


CREATE TABLE `tbl_informacion_visual` (
  `id_information` int NOT NULL,
  `local_storage` varchar(250) NOT NULL,
  `rol_user` varchar(100) NOT NULL,
  `status` char(5) NOT NULL,
  PRIMARY KEY (`id_information`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;

CREATE TABLE `tbl_productos` (
  `id_product` int NOT NULL,
  `name` varchar(250) NOT NULL,
  `quantity` varchar(300) NOT NULL,
  `tipe_products` varchar(250) NOT NULL,
  `status` char(5) NOT NULL,
  `description` varchar(250) NOT NULL,
  `user_sesion` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `usur_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_update` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;


CREATE TABLE `tbl_proyectos` (
  `id_project` int NOT NULL,
  `title` varchar(250) NOT NULL,
  `url_image` varchar(250) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` char(5) NOT NULL,
  `rol_user` varchar(100) NOT NULL,
  `estado` char(5) NOT NULL,
  `user_sesion` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `usur_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_update` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_project`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;


CREATE TABLE `tbl_roles` (
  `id_rol` int NOT NULL,
  `rol_user` varchar(100) NOT NULL,
  `status` char(5) NOT NULL,
  `user_sesion` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `usur_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_update` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;


CREATE TABLE `tbl_usuario` (
  `id_user` int NOT NULL,
  `id_rol` varchar(100) NOT NULL,
  `identification_card` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `status` char(5) NOT NULL,
  `user_sesion` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `usur_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_update` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ;