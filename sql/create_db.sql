-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         11.5.2-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para comercio_electronico
CREATE DATABASE IF NOT EXISTS `comercio_electronico` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `comercio_electronico`;

-- Volcando estructura para tabla comercio_electronico.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla comercio_electronico.productos: ~2 rows (aproximadamente)
INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `precio`, `imagen`, `stock`) VALUES
	(1, 'Iphone 15 Pro 256Gb Natural Titanium Reacondicionado', 'Tamaño de pantalla\r\n6.1 pulgadas\r\nSistema operativo\r\niOS\r\nAltavoz\r\nSi\r\nCapacidad de almacenamiento\r\n256 GB\r\nVelocidad del procesador\r\n3,78\r\nRadio\r\nNo\r\nProcesador\r\nA17 PRO\r\nDual Sim\r\nNo\r\nVer todo\r\nIphone 15 Pro 256GB 5G Natural Titanium E Sim Reacondicionado\r\nBatería entre el 85% al 100% de condición\r\n\r\n¿Que incluye?\r\nCable USB-C a USB-C (Genérico de magnifica calidad).\r\n\r\n¿NO incluye?\r\nNo incluye cargador, no incluye caja, no incluye instrucciones de uso\r\n\r\n¿Qué debes tener en cuenta?\r\nEstás adquiriendo un celular R E A C O N D I C I O N A D O es decir, un dispositivo móvil que ha sido diagnosticado, (proceso de limpieza, inspección y restauración de 0), ha sido probado para funcionar como uno nuevo, pero NO es nuevo. excelente estado físico y funcional, libre de iCloud, libre para registrar en cualquier operador a nivel nacional e internacional; puede contener marcas leves en pantalla y cuerpo.', 3199000.00, 'iphone-15-pro-max-256gb-titanio-natural-esim.jog.webp', 10),
	(2, 'Iphone 16 Pro 256Gb Negro', 'El iPhone 16 Pro Max lleva la experiencia al siguiente nivel con un diseño de titanio ligero y resistente, acompañado del potente chip A18 Pro que redefine el rendimiento y la eficiencia. Su espectacular pantalla Super Retina XDR de 6.1 pulgadas con ProMotion ofrece imágenes fluidas y realistas en cada desplazamiento.', 3999000.00, 'iphone-16-pro-max-256gb-negro-titanio-.jpg', 10);

-- Volcando estructura para tabla comercio_electronico.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla comercio_electronico.usuarios: ~1 rows (aproximadamente)
INSERT INTO `usuarios` (`id_usuario`, `usuario`, `password`) VALUES
	(1, 'admin', '$2y$10$6PFrbEjmO/e/XkjTtzO/.ejqzI4VGhKiR/U61caBKK3BtfqL6xKdi'); 
/* admin, 12345 */;
/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
