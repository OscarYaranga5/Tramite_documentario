-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 04, 2025 at 05:25 PM
-- Server version: 8.0.41
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemacolegio`
--

-- --------------------------------------------------------

--
-- Table structure for table `tramites`
--

CREATE TABLE `tramites` (
  `id` int NOT NULL,
  `codigo_tramite` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `Remitente` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `documento_identidad` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_envio` datetime NOT NULL,
  `fecha_recepcion` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Estado` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `mensaje` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tramites`
--

INSERT INTO `tramites` (`id`, `codigo_tramite`, `Remitente`, `email`, `documento_identidad`, `telefono`, `fecha_envio`, `fecha_recepcion`, `archivo`, `Estado`, `mensaje`) VALUES
(1, '20250611234955', 'asdas', 'asdasd@fff.com', '1111', '111', '2025-06-11 23:49:55', '2025-06-11 19:03:30', '../pdf/20250611234955.pdf', 'Aceptado', ''),
(2, '20250611235027', 'neo', 'oscoac@gmail.com', '70782026', '965338170', '2025-06-11 23:50:27', '2025-06-13 15:06:21', '../pdf/20250611235027.pdf', 'Subsanar', 'subsanar tal cositas'),
(3, '20250613213537', 'OSCAR YARANGA', 'AFNASF@GMIL.COM', '70787426', '965338170', '2025-06-13 21:35:37', '2025-06-13 16:36:21', '../pdf/20250613213537.pdf', 'Subsanar', 'LE FALTA FOTO\n'),
(4, '20250613214741', 'ALEXIS YAYA', 'AFAS@GMAIL.COM', '70707070', '965338170', '2025-06-13 21:47:41', '2025-06-13 16:48:57', '../pdf/20250613214741.pdf', 'Aceptado', 'aceptado correctamente\n'),
(5, '20250625041042', 'Daniel perez', 'aa@gmail.com', 'qwd', 'aa', '2025-06-25 04:10:42', '2025-06-24 23:12:18', '../pdf/20250625041042.pdf', 'Aceptado', 's'),
(6, '20250625041438', 'as', 'dd@g.com', 'a', 'ass', '2025-06-25 04:14:38', '2025-06-24 23:15:14', '../pdf/20250625041438.pdf', 'Eliminado', 'as'),
(7, '20250625065115', 'asas', 'asas@ddd.cc', 'asas', 'asas', '2025-06-25 06:51:15', '2025-06-25 01:51:31', '../pdf/20250625065115.pdf', 'Eliminado', ''),
(8, '20250627214050', 'Prueba', 'asd@f.c', '70707075', '5555', '2025-06-27 21:40:50', '2025-06-27 16:43:43', '../pdf/20250627214050.pdf', 'Subsanar', 'dsfsdf'),
(9, '20250627222434', 'asdasd', 'asdad@aasdasd.c', 'asdasd', 'asdasd', '2025-06-27 22:24:34', 'Sin recepcionar', '../pdf/20250627222434.pdf', 'Enviado', 'Trámite enviado');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `contraseña` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rol` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `correo`, `contraseña`, `rol`) VALUES
(1, 'Admin', 'a@gmail.com', 'a1', 'usuario');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tramites`
--
ALTER TABLE `tramites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_tramite` (`codigo_tramite`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tramites`
--
ALTER TABLE `tramites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
