CREATE DATABASE /*!32312 IF NOT EXISTS*/`crud_personas`;

USE `crud_personas`;

/*Table structure for table `clientes` */

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `tipo` enum('N','J') DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data example for the table `clientes` */

insert  into `clientes`(`id`,`identificacion`,`nombre`,`telefono`,`celular`,`email`,`tipo`,`direccion`,`created_at`,`updated_at`) values 
(1,'123456','Mark Zuckerberg','6666666','3001234567','mark@facebook.com','N','Edgewood Drive, en Palo Alto, California','2017-09-23 13:29:54','2017-09-23 13:29:57'),
(2,'654321','Tesla, Inc','5555555','3017654321','info@tesla.com','J','3500 Deer Creek Road, en Palo Alto, California','2017-09-23 13:33:26','2017-09-23 13:33:28');
