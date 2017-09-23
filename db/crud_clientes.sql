CREATE DATABASE /*!32312 IF NOT EXISTS*/`crud_clientes`;

USE `crud_clientes`;

/*Table structure for table `clientes` */

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `identificacion` VARCHAR(20) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `telefono` VARCHAR(20) DEFAULT NULL,
  `celular` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(60) DEFAULT NULL,
  `tipo` ENUM('Natural','Juridico') DEFAULT NULL,
  `direccion` VARCHAR(200) DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data example for the table `clientes` */

INSERT  INTO `clientes`(`id`,`identificacion`,`nombre`,`telefono`,`celular`,`email`,`tipo`,`direccion`,`created_at`,`updated_at`) VALUES 
(1,'123456','Mark Zuckerberg','6666666','3001234567','mark@facebook.com','Natural','Edgewood Drive, en Palo Alto, California','2017-09-23 13:29:54','2017-09-23 13:29:57'),
(2,'654321','Tesla, Inc','5555555','3017654321','info@tesla.com','Juridico','3500 Deer Creek Road, en Palo Alto, California','2017-09-23 13:33:26','2017-09-23 13:33:28');
