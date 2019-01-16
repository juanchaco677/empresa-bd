-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-01-2019 a las 03:32:52
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.1.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `candidato_aux`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `codigo` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `consulta` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`codigo`, `consulta`, `created_at`, `updated_at`) VALUES
('00010REPORTEGENERAL', 'SELECT.c*.c*concat_ws(\'.c*\',users.NAME,users.NAME2,users.LASTNAME,users.LASTNAME2).c*as.c*usuario,localizaciones.direccion,mesas_votacions.numero,puntos_votacions.nombre,users.nit.c*FROM.c*departamentos.c*INNER.c*JOIN.c*ciudades.c*ON.c*departamentos.ID=ciudades.id_departamento.c*INNER.c*JOIN.c*localizaciones.c*on.c*ciudades.id=localizaciones.id_ciudad.c*INNER.c*JOIN.c*puntos_votacions.c*ON.c*localizaciones.id=puntos_votacions.id_localizacion.c*.c*INNER.c*JOIN.c*mesas_votacions.c*ON.c*puntos_votacions.ID=mesas_votacions.id_punto.c*.c*INNER.c*JOIN.c*users.c*ON.c*.c*mesas_votacions.id=users.id_mesa.c*WHERE.c*departamentos.id=\'s$departamento$s\'.c*and.c*ciudades.id=\'s$ciudad$s\'', '2019-01-16 03:21:59', '2019-01-16 03:21:59'),
('0001MESAGENERAL', 'SELECT.c*.c*.c*DEPARTAMENTOS.NOMBRE.c*AS.c*DEPARTAMENTO,.c*.c*.c*CIUDADES.NOMBRE.c*.c*.c*.c*.c*.c*AS.c*CIUDAD,.c*.c*.c*LOCALIZACIONES.DIRECCION,.c*.c*.c*MESAS_VOTACIONS.NUMERO,.c*.c*.c*MESAS_VOTACIONS.ID,.c*.c*.c*USERS.NAME||\'.c*\'||.c*.c*.c*USERS.NAME2||\'.c*\'||.c*.c*.c*USERS.LASTNAME||\'.c*\'||.c*.c*.c*.c*USERS.LASTNAME2.c*NOMBRECOMPLETO.c*FROM.c*.c*.c*DEPARTAMENTOS.c*INNER.c*JOIN.c*CIUDADES.c*ON.c*.c*.c*DEPARTAMENTOS.ID=CIUDADES.ID_DEPARTAMENTO.c*INNER.c*JOIN.c*LOCALIZACIONES.c*ON.c*CIUDADES.ID=LOCALIZACIONES.ID_CIUDAD.c*INNER.c*JOIN.c*PUNTOS_VOTACIONS.c*ON.c*.c*.c*LOCALIZACIONES.ID=PUNTOS_VOTACIONS.ID_LOCALIZACION.c*INNER.c*JOIN.c*MESAS_VOTACIONS.c*ON.c*.c*.c*PUNTOS_VOTACIONS.ID=MESAS_VOTACIONS.ID_PUNTO.c*INNER.c*JOIN.c*USERS.c*ON.c*.c*.c*MESAS_VOTACIONS.ID=USERS.ID_MESA.c*WHERE.c*.c*.c*MESAS_VOTACIONS.NUMERO.c*LIKE.c*\'%s$buscar$s%\'.c*OR.c*LOCALIZACIONES.DIRECCION.c*LIKE.c*\'%s$buscar$s%\'.c*OR.c*CIUDADES.NOMBRE.c*LIKE.c*\'%s$buscar$s%\'.c*OR.c*DEPARTAMENTOS.NOMBRE.c*LIKE.c*\'%s$buscar$s%\'.c*ORDER.c*BY.c*.c*.c*MESAS_VOTACIONS.ID', '2019-01-16 01:35:51', '2019-01-16 01:35:51'),
('0003DEPARTAMENTOS', 'SELECT.c*.c*.c*ID,.c*.c*.c*NOMBRE.c*FROM.c*.c*.c*DEPARTAMENTOS.c*WHERE.c*.c*.c*NOMBRE.c*LIKE.c*\'%s$buscar$s%\'', '2018-01-05 09:42:23', '2018-01-05 09:42:23'),
('0004CIUDADES', 'SELECT.c*.c*.c*CIUDADES.ID,.c*.c*.c*CIUDADES.NOMBRE.c*.c*.c*.c*.c*.c*AS.c*CIUDAD,.c*.c*.c*DEPARTAMENTOS.NOMBRE.c*AS.c*DEPARTAMENTO.c*FROM.c*.c*.c*DEPARTAMENTOS.c*INNER.c*JOIN.c*CIUDADES.c*ON.c*.c*.c*DEPARTAMENTOS.ID.c*=.c*CIUDADES.ID_DEPARTAMENTO.c*WHERE.c*.c*.c*CIUDADES.NOMBRE.c*LIKE.c*\'%s$buscar$s%\'.c*OR.c*DEPARTAMENTOS.NOMBRE.c*LIKE.c*\'%s$buscar$s%\'', '2018-01-05 09:46:57', '2018-01-05 09:46:57'),
('0006ADMINISTRADOR', 'SELECT.c*.c*.c*ID,.c*.c*.c*CASE.c*.c*.c*.c*.c*WHEN.c*TYPE=\'A\'.c*.c*.c*.c*.c*THEN.c*\'ADMINISTRADOR\'.c*.c*.c*.c*.c*ELSE.c*\'VOTANTE\'.c*.c*.c*END.c*TYPE,.c*.c*.c*EMAIL.c*AS.c*CORREO,.c*.c*.c*concat_ws(\'.c*\',NAME,NAME2,LASTNAME,LASTNAME2).c*AS.c*NOMBRES.c*FROM.c*.c*.c*USERS.c*WHERE.c*.c*.c*(.c*.c*.c*.c*.c*NAME.c*LIKE.c*\'%s$buscar$s%\'.c*.c*.c*OR.c*NAME2.c*LIKE.c*\'%s$buscar$s%\'.c*.c*.c*OR.c*LASTNAME.c*LIKE.c*\'%s$buscar$s%\'.c*.c*.c*OR.c*LASTNAME2.c*LIKE.c*\'%s$buscar$s%\'.c*.c*.c*).c*AND.c*TYPE.c*=.c*\'A\'', '2018-01-05 10:13:07', '2018-01-05 10:13:07'),
('0007VOTANTE', 'SELECT.c*.c*.c*NIT,.c*.c*.c*CASE.c*.c*.c*.c*.c*WHEN.c*TYPE=\'A\'.c*.c*.c*.c*.c*THEN.c*\'ADMINISTRADOR\'.c*.c*.c*.c*.c*ELSE.c*\'VOTANTE\'.c*.c*.c*END.c*TYPE,.c*.c*.c*IFNULL(EMAIL,\'SIN-ASIGNAR\').c*AS.c*CORREO,.c*.c*.c*concat_ws(\'.c*\',NAME,NAME2,LASTNAME,LASTNAME2).c*AS.c*NOMBRES.c*FROM.c*.c*.c*USERS.c*WHERE.c*.c*.c*(.c*.c*.c*.c*.c*NAME.c*LIKE.c*\'%s$buscar$s%\'.c*.c*.c*OR.c*NAME2.c*LIKE.c*\'%s$buscar$s%\'.c*.c*.c*OR.c*LASTNAME.c*LIKE.c*\'%s$buscar$s%\'.c*.c*.c*OR.c*LASTNAME2.c*LIKE.c*\'%s$buscar$s%\'.c*.c*.c*).c*AND.c*TYPE.c*=.c*\'E\'', '2019-01-16 01:46:50', '2019-01-16 01:46:50'),
('0009REPORTEMESAPUNTO', 'SELECT.c*departamentos.nombre.c*as.c*departamentos,ciudades.nombre.c*as.c*ciudad,.c*concat_ws(\'.c*\',users.NAME,users.NAME2,users.LASTNAME,users.LASTNAME2).c*as.c*usuario,localizaciones.direccion,mesas_votacions.numero.c*FROM.c*departamentos.c*INNER.c*JOIN.c*ciudades.c*ON.c*departamentos.ID=ciudades.id_departamento.c*INNER.c*JOIN.c*localizaciones.c*on.c*ciudades.id=localizaciones.id_ciudad.c*inner.c*join.c*puntos_votacions.c*ON.c*localizaciones.id=puntos_votacions.id_localizacion.c*.c*INNER.c*JOIN.c*mesas_votacions.c*ON.c*puntos_votacions.ID=mesas_votacions.id_punto.c*.c*INNER.c*JOIN.c*users.c*ON.c*.c*mesas_votacions.id=users.id_mesa.c*WHERE.c*departamentos.id=\'s$departamento$s\'.c*and.c*ciudades.id=\'s$ciudad$s\'.c*and.c*puntos_votacions.id=\'s$punto$s\'.c*order.c*by.c*users.id', '2019-01-16 03:01:38', '2019-01-16 03:01:38'),
('002PUNTOSVOTACION', 'SELECT.c*.c*.c*LOCALIZACIONES.DIRECCION,.c*.c*.c*PUNTOS_VOTACIONS.ID,.c*.c*.c*IFNULL(PUNTOS_VOTACIONS.NOMBRE,\'\').c*NOMBRE,.c*.c*.c*IFNULL(CIUDADES.NOMBRE,\'\').c*AS.c*CIUDAD.c*FROM.c*.c*.c*CIUDADES.c*INNER.c*JOIN.c*LOCALIZACIONES.c*ON.c*CIUDADES.ID=LOCALIZACIONES.ID_CIUDAD.c*INNER.c*JOIN.c*.c*PUNTOS_VOTACIONS.c*ON.c*.c*.c*LOCALIZACIONES.ID.c*=.c*PUNTOS_VOTACIONS.ID_LOCALIZACION.c*WHERE.c*.c*.c*PUNTOS_VOTACIONS.NOMBRE.c*LIKE.c*\'%s$buscar$s%\'.c*OR.c*LOCALIZACIONES.DIRECCION.c*LIKE.c*\'%s$buscar$s%\'.c*OR.c*CIUDADES.NOMBRE.c*LIKE.c*\'%s$buscar$s%\'', '2019-01-16 01:40:38', '2019-01-16 01:40:38');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
