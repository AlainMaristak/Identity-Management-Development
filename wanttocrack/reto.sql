-- MariaDB dump 10.19  Distrib 10.11.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: reto
-- ------------------------------------------------------
-- Server version	10.11.6-MariaDB-0+deb12u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `raspberry_analisis`
--

DROP TABLE IF EXISTS `raspberry_analisis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `raspberry_analisis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `resultado` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`resultado`)),
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `raspberry_analisis`
--

LOCK TABLES `raspberry_analisis` WRITE;
/*!40000 ALTER TABLE `raspberry_analisis` DISABLE KEYS */;
/*!40000 ALTER TABLE `raspberry_analisis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_login`
--

DROP TABLE IF EXISTS `registro_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registro_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contra` varchar(250) NOT NULL,
  `datos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_login`
--

LOCK TABLES `registro_login` WRITE;
/*!40000 ALTER TABLE `registro_login` DISABLE KEYS */;
INSERT INTO `registro_login` VALUES
(1,'10.11.0.50','10.11.0.50','user@user.com','user','{&quot;ip&quot;:&quot;10.11.0.50&quot;,&quot;user_agent&quot;:&quot;Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/131.0.0.0 Safari\\/537.36&quot;,&quot;pagina_actual&quot;:&quot;\\/Identity-Management-Development\\/WEB\\/index.php&quot;,&quot;metodo_http&quot;:&quot;POST&quot;,&quot;referer&quot;:&quot;http:\\/\\/10.11.0.112\\/Identity-Management-Development\\/WEB\\/&quot;,&quot;puerto&quot;:&quot;34082&quot;,&quot;protocolo&quot;:&quot;HTTP\\/1.1&quot;,&quot;idioma&quot;:&quot;es-ES,es;q=0.9,en;q=0.8&quot;,&quot;host&quot;:&quot;10.11.0.50&quot;}'),
(2,'10.11.0.50','10.11.0.50','user@user.com','user','{&quot;ip&quot;:&quot;10.11.0.50&quot;,&quot;user_agent&quot;:&quot;Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/131.0.0.0 Safari\\/537.36&quot;,&quot;pagina_actual&quot;:&quot;\\/Identity-Management-Development\\/WEB\\/index.php&quot;,&quot;metodo_http&quot;:&quot;POST&quot;,&quot;referer&quot;:&quot;http:\\/\\/10.11.0.112\\/Identity-Management-Development\\/WEB\\/&quot;,&quot;puerto&quot;:&quot;34083&quot;,&quot;protocolo&quot;:&quot;HTTP\\/1.1&quot;,&quot;idioma&quot;:&quot;es-ES,es;q=0.9,en;q=0.8&quot;,&quot;host&quot;:&quot;10.11.0.50&quot;}'),
(3,'::1','DUR-Ciber5','alain@maristak.com','132','{&quot;ip&quot;:&quot;::1&quot;,&quot;user_agent&quot;:&quot;Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/131.0.0.0 Safari\\/537.36&quot;,&quot;pagina_actual&quot;:&quot;\\/Identity-Management-Development\\/WEB\\/index.php&quot;,&quot;metodo_http&quot;:&quot;POST&quot;,&quot;referer&quot;:&quot;http:\\/\\/localhost\\/Identity-Management-Development\\/WEB\\/&quot;,&quot;puerto&quot;:&quot;62767&quot;,&quot;protocolo&quot;:&quot;HTTP\\/1.1&quot;,&quot;idioma&quot;:&quot;es-ES,es;q=0.9&quot;,&quot;host&quot;:&quot;DUR-Ciber5&quot;}');
/*!40000 ALTER TABLE `registro_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tarjetas`
--

DROP TABLE IF EXISTS `tarjetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tarjetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(1) NOT NULL COMMENT '1-Débito, 2-Crédito',
  `numero` varchar(16) NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `CVV` varchar(3) NOT NULL,
  `activo` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tarjetas`
--

LOCK TABLES `tarjetas` WRITE;
/*!40000 ALTER TABLE `tarjetas` DISABLE KEYS */;
INSERT INTO `tarjetas` VALUES
(1,1,'1234567890123456','2025-08-21','123',1),
(2,2,'6543210987654321','2025-08-14','321',1),
(3,1,'3213213213213213','2024-12-26','321',1),
(4,2,'6546546546546546','2024-12-26','654',1);
/*!40000 ALTER TABLE `tarjetas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transacciones`
--

DROP TABLE IF EXISTS `transacciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario_tarjeta` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `descripcion` varchar(250) NOT NULL,
  `importe` varchar(9) NOT NULL,
  `ticket` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transacciones`
--

LOCK TABLES `transacciones` WRITE;
/*!40000 ALTER TABLE `transacciones` DISABLE KEYS */;
INSERT INTO `transacciones` VALUES
(1,1,'2024-06-15 10:45:30','Compra en supermercado','120',''),
(2,2,'2024-07-20 14:20:45','Pago de servicios','200',''),
(3,1,'2024-08-05 09:10:50','Compra de ropa','90',''),
(4,2,'2024-09-12 17:30:35','Reserva de hotel','300',''),
(5,1,'2024-10-01 11:50:25','Compra de gadgets electrónicos','150',''),
(6,2,'2024-06-25 08:15:20','Pago de membresía','180',''),
(7,1,'2024-07-10 16:40:30','Cena en restaurante','100',''),
(8,2,'2024-09-30 12:35:15','Reparación de automóvil','220',''),
(9,1,'2024-10-15 09:00:05','Compra de libros','130',''),
(10,2,'2024-11-05 15:25:50','Donación a caridad','175',''),
(11,1,'2024-06-18 12:15:10','Pago de suscripción mensual','50',''),
(12,2,'2024-07-25 19:45:30','Compra de material de oficina','95',''),
(13,1,'2024-08-15 10:30:45','Entrada al cine','40',''),
(14,2,'2024-09-05 08:10:20','Renovación de licencia','120',''),
(15,1,'2024-10-22 14:50:25','Compra en tienda online','220',''),
(16,2,'2024-06-30 17:20:55','Pago de estacionamiento','30',''),
(17,1,'2024-07-18 09:40:35','Recarga de celular','25',''),
(18,2,'2024-09-15 13:00:45','Visita médica','180',''),
(19,1,'2024-10-28 15:35:20','Compra de artículos deportivos','135',''),
(20,2,'2024-11-12 11:15:50','Mantenimiento del hogar','250.69',''),
(21,1,'2024-11-28 09:18:33','sdfghjk','50',''),
(23,1,'2024-11-28 13:21:51','fghjk','3456','./tickets/WannaCrack/6748605f8ade1-Boletin_materias_ALAIN_2024_evaluacion_3.pdf'),
(34,3,'2024-12-01 10:15:00','Compra de producto A','250',''),
(35,3,'2024-12-03 11:30:00','Compra de producto B','300',''),
(36,4,'2024-12-05 14:45:00','Pago de servicio X','500',''),
(37,4,'2024-12-07 09:00:00','Pago de servicio Y','600',''),
(38,4,'2024-12-09 16:20:00','Compra especial Z','800',''),
(39,3,'2024-11-11 13:10:00','Compra menor A1','200',''),
(40,3,'2024-11-13 17:25:00','Compra menor B1','450',''),
(41,4,'2024-11-15 08:50:00','Pago recurrente C1','700',''),
(42,4,'2024-11-16 19:00:00','Pago de deuda D1','750',''),
(43,3,'2024-11-17 12:35:00','Compra menor E1','350',''),
(46,4,'2024-12-18 00:33:49','Salida Madrid','666','./tickets/user12/6762186d13d94-SALIDA_CIBER.pdf');
/*!40000 ALTER TABLE `transacciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_ldap` varchar(250) NOT NULL,
  `tipo` int(1) NOT NULL DEFAULT 2 COMMENT '1=Admin, 2=Usuario',
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `nombre_empresa` varchar(50) NOT NULL,
  `CIF` varchar(10) NOT NULL,
  `ultima_conexion` datetime NOT NULL,
  `fecha_registro` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES
(1,'f0abe836-6b7e-4751-8941-e20aa632538a',2,'user11','alain@maristak.com','WannaCrack','12345678Z','2024-12-18 00:12:53','2024-11-14 11:36:02'),
(2,'5abe1f86-ade9-4cc4-8a81-5166d26e2f0c',2,'user12','user12@email.com','WannaCrack','0','2024-12-18 00:13:05','2024-12-17 21:54:22');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_tarjetas`
--

DROP TABLE IF EXISTS `usuarios_tarjetas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios_tarjetas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_tarjeta` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_tarjetas`
--

LOCK TABLES `usuarios_tarjetas` WRITE;
/*!40000 ALTER TABLE `usuarios_tarjetas` DISABLE KEYS */;
INSERT INTO `usuarios_tarjetas` VALUES
(1,1,1),
(2,1,2),
(3,2,3),
(4,2,4);
/*!40000 ALTER TABLE `usuarios_tarjetas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-17 19:40:25
