-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 20-12-2017 a las 04:46:32
-- Versión del servidor: 10.1.29-MariaDB
-- Versión de PHP: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id413979_yewellers`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `areaId` int(11) NOT NULL,
  `areaName` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`areaId`, `areaName`) VALUES
(11, 'Cardenal Quintero'),
(10, 'Los Curos'),
(9, 'Glenfall'),
(7, 'Glentilt'),
(6, 'Upcot Div'),
(5, 'Gartmore Div'),
(3, 'area 3'),
(2, 'area 2'),
(1, 'area 1'),
(12, 'Bronx'),
(13, 'Centro'),
(14, 'Browere'),
(15, 'Brownlow'),
(16, 'Bagro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE `articles` (
  `articleId` int(11) NOT NULL,
  `articleName` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`articleId`, `articleName`) VALUES
(6, 'Grenada Rope Chain'),
(5, 'Indian Rope Chain'),
(4, 'Pendant '),
(3, 'Singapore Rope Chain'),
(2, 'new article'),
(7, 'Chennai Rope Chain'),
(8, 'Outum Ring');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `configId` int(11) NOT NULL,
  `webEmail` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `timezone` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`configId`, `webEmail`, `password`, `timezone`) VALUES
(1, 'email@mail.com', '1234', 'Asia/Calcutta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `customerId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `idCard` varchar(100) DEFAULT NULL,
  `area` varchar(200) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `customers`
--

INSERT INTO `customers` (`customerId`, `name`, `lastname`, `email`, `address`, `idCard`, `area`, `telephone`) VALUES
(1, 'Edward', 'Norton', 'edwardnorton@hotmail.com', 'New York', '123456', 'Browere', '123456'),
(19, 'Peter', 'Pan', 'peterpan@gmail.com', 'Quinta avenida con calle 25', '123456321C', 'Centro', '123456'),
(20, 'Michael', 'Jackson', '', '', '85689569v', 'Brownlow', ''),
(21, 'Irston', 'Antao', '', '', '910208080v', 'Bagro', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory`
--

CREATE TABLE `inventory` (
  `articleId` int(11) NOT NULL,
  `goldStatus` int(1) NOT NULL,
  `onSale` int(1) NOT NULL,
  `articleName` varchar(200) NOT NULL,
  `articleWeight` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inventory`
--

INSERT INTO `inventory` (`articleId`, `goldStatus`, `onSale`, `articleName`, `articleWeight`) VALUES
(1, 0, 0, 'Newlin Ring', 0),
(2, 0, 0, 'Crafted necklace with esmerald', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL,
  `orderDeliveryDate` datetime NOT NULL,
  `orderFinished` datetime DEFAULT NULL,
  `orderFirstName` varchar(100) NOT NULL,
  `orderLastName` varchar(200) NOT NULL,
  `orderAddress` varchar(1000) NOT NULL,
  `orderTelephone` varchar(50) NOT NULL,
  `orderCustomDetail` varchar(2000) NOT NULL,
  `orderDesignDetail` varchar(2000) NOT NULL,
  `orderCost` float NOT NULL,
  `orderAdvance` float NOT NULL,
  `orderBillNo` int(11) NOT NULL,
  `orderPending` tinyint(1) DEFAULT NULL,
  `orderArea` varchar(200) DEFAULT NULL,
  `orderWeight` float NOT NULL,
  `orderQuality` float NOT NULL,
  `orderWeightMili` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`orderId`, `orderDeliveryDate`, `orderFinished`, `orderFirstName`, `orderLastName`, `orderAddress`, `orderTelephone`, `orderCustomDetail`, `orderDesignDetail`, `orderCost`, `orderAdvance`, `orderBillNo`, `orderPending`, `orderArea`, `orderWeight`, `orderQuality`, `orderWeightMili`) VALUES
(9, '2017-08-06 07:01:09', '2017-08-06 00:00:00', 'Edward', 'Norton', 'New York', '123456', '', 'Threaded bareel asdo', 78000, 24000, 426351, 1, 'Bronx', 12, 0, 0),
(10, '2017-08-06 07:10:27', NULL, 'Edward', 'Norton', 'New York', '123456', '', 'Refurbishing a gold ring', 74000, 20000, 154236, 0, 'Bronx', 75, 0, 5),
(11, '2017-08-06 07:10:27', NULL, 'Edward', 'Norton', 'New York', '123456', '', 'Refurbishing other gold ring', 45000, 14000, 142234, 0, 'Bronx', 65, 0, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pawningextras`
--

CREATE TABLE `pawningextras` (
  `extraId` int(11) NOT NULL,
  `pawnId` int(10) NOT NULL,
  `extraValue` float NOT NULL,
  `extraConcept` varchar(100) NOT NULL,
  `pawnBillNo` int(10) NOT NULL,
  `extraDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pawningextras`
--

INSERT INTO `pawningextras` (`extraId`, `pawnId`, `extraValue`, `extraConcept`, `pawnBillNo`, `extraDate`) VALUES
(31, 46, 5500, 'debit', 30000, '2017-08-03 04:29:43'),
(32, 46, 2500, 'credit', 30000, '2017-08-03 04:31:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pawnings`
--

CREATE TABLE `pawnings` (
  `pawnId` int(10) NOT NULL,
  `pawnDateTime` datetime NOT NULL,
  `pawnFirstName` varchar(100) NOT NULL,
  `pawnLastName` varchar(200) NOT NULL,
  `pawnAge` int(11) NOT NULL,
  `pawnAreaName` varchar(200) NOT NULL,
  `pawnAddress` varchar(1000) NOT NULL,
  `pawnIdcard` varchar(100) NOT NULL,
  `pawnArticleType` varchar(100) NOT NULL,
  `pawnNetWeight` float DEFAULT NULL,
  `pawnGrossWeight` float DEFAULT NULL,
  `pawnAuthorized` varchar(200) NOT NULL,
  `pawnBillNo` int(10) NOT NULL,
  `forPawn` int(1) DEFAULT '1',
  `warning` int(4) NOT NULL DEFAULT '0',
  `pawnIdcardAuthorized` varchar(100) DEFAULT NULL,
  `pawnNetWeightMili` float DEFAULT NULL,
  `pawnGrossWeightMili` float DEFAULT NULL,
  `pawnOwed` float DEFAULT NULL,
  `pawnPaid` float DEFAULT NULL,
  `pawnAmount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pawnings`
--

INSERT INTO `pawnings` (`pawnId`, `pawnDateTime`, `pawnFirstName`, `pawnLastName`, `pawnAge`, `pawnAreaName`, `pawnAddress`, `pawnIdcard`, `pawnArticleType`, `pawnNetWeight`, `pawnGrossWeight`, `pawnAuthorized`, `pawnBillNo`, `forPawn`, `warning`, `pawnIdcardAuthorized`, `pawnNetWeightMili`, `pawnGrossWeightMili`, `pawnOwed`, `pawnPaid`, `pawnAmount`) VALUES
(46, '2017-08-04 16:23:21', 'Edward', 'Norton', 30, 'Bronx', '4th Av. 34 St.', '52161452c', 'Gold Necklace', 65, 45, 'James Lee', 30000, 2, 1, '531962562c', 524, 255, 5500, 2500, 5245.23),
(47, '2016-07-05 03:49:03', 'Edward', 'Norton', 35, 'Upcot Div', 'New York', '123456', 'Macedonian Ring', 10, 11, 'Erica de la Vega', 30001, 0, 0, '131332622c', 65, 55, NULL, NULL, 5500),
(48, '2017-08-08 14:16:49', 'Edward', 'Norton', 25, 'Bronx', 'New York', '123456', 'Eutectic Ring', 12, 13, 'Lupe', 30002, 1, 0, '123456789C', 25, 47, NULL, NULL, 45000),
(49, '2016-07-08 14:25:49', 'Edward', 'Norton', 25, 'Bronx', 'New York', '123456', 'some article', 15, 16, 'Some person', 30003, 1, 0, '123456789C', 25, 26, NULL, NULL, 45000),
(50, '2017-08-25 20:54:59', 'Michael', 'Jackson', 29, 'Brownlow', '2/3 Anna Salai', '85689569v', 'Pendant and broken chain', 9, 9, 'Janet', 30004, 0, 0, '85689569v', 25, 95, NULL, NULL, 85000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salebills`
--

CREATE TABLE `salebills` (
  `sbillId` int(10) NOT NULL,
  `saleBillNo` varchar(100) NOT NULL,
  `sbillFirstName` varchar(100) NOT NULL,
  `sbillLastName` varchar(100) NOT NULL,
  `sbillFinalPrice` decimal(18,3) DEFAULT NULL,
  `sbillDate` datetime NOT NULL,
  `sbillExchange` decimal(18,3) DEFAULT NULL,
  `sbillExchArticle` varchar(200) DEFAULT NULL,
  `sbillExchWeight` float DEFAULT NULL,
  `sbillExchWeightMili` float DEFAULT NULL,
  `sbillActive` int(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `salebills`
--

INSERT INTO `salebills` (`sbillId`, `saleBillNo`, `sbillFirstName`, `sbillLastName`, `sbillFinalPrice`, `sbillDate`, `sbillExchange`, `sbillExchArticle`, `sbillExchWeight`, `sbillExchWeightMili`, `sbillActive`) VALUES
(5, '3000', 'Edward', 'Norton', 94817.359, '2017-08-02 03:38:46', 25.560, 'Some Exchange Article Edited', 7, 51, 1),
(6, '3001', 'Edward', 'Norton', 5200.000, '2016-09-07 15:03:50', 2000.000, 'Exchange Item', 20, 45, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `saleId` int(10) NOT NULL,
  `saleArticleName` varchar(200) NOT NULL,
  `saleAddress` varchar(1000) DEFAULT NULL,
  `saleArticleCode` varchar(200) NOT NULL,
  `saleArea` varchar(100) DEFAULT NULL,
  `saleBillNo` varchar(100) DEFAULT NULL,
  `saleWeight` float NOT NULL,
  `saleWeightMili` float NOT NULL,
  `saleLabor` decimal(18,3) DEFAULT NULL,
  `saleLossGold` decimal(18,3) DEFAULT NULL,
  `saleGoldValue` decimal(18,3) DEFAULT NULL,
  `saleFinalPrice` decimal(18,3) DEFAULT NULL,
  `forsale` int(1) NOT NULL DEFAULT '1',
  `saleDetail` varchar(1000) DEFAULT NULL,
  `goldStatus` tinyint(1) NOT NULL DEFAULT '1',
  `saleQty` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sales`
--

INSERT INTO `sales` (`saleId`, `saleArticleName`, `saleAddress`, `saleArticleCode`, `saleArea`, `saleBillNo`, `saleWeight`, `saleWeightMili`, `saleLabor`, `saleLossGold`, `saleGoldValue`, `saleFinalPrice`, `forsale`, `saleDetail`, `goldStatus`, `saleQty`) VALUES
(10, 'Grenada Rope Chain Edit', 'New York', 'rsDU7538', 'Glenfall', '3000', 1, 2, 5000.000, 4000.000, 46256.123, 55256.121, 0, 'This will have enough details to show that this field is worth having for some reason', 1, NULL),
(11, 'Chennai Rope Chain Edit', 'New York', 'iNLt7353', 'Glenfall', '3000', 6, 7, 4000.000, 3000.000, 32561.234, 39561.234, 0, 'This will have enough details to show that this field is worth having for some reason', 1, NULL),
(12, 'Pendant ', 'New York', 'ulGt3637', 'Bronx', '3001', 14, 53, 50.000, 150.000, 5000.000, 5200.000, 0, 'This will have enough details to show that this field is worth having for some reason', 1, NULL),
(13, 'Newlin Ring', NULL, 'CcGn8066', NULL, NULL, 5, 45, 500.850, 1500.650, 6500.450, 8501.950, 1, NULL, 1, NULL),
(14, 'Crafted necklace with esmerald', NULL, 'Qeff5807', NULL, NULL, 100, 45, 25600.000, 5000.000, 45000.000, 75600.000, 1, NULL, 1, NULL),
(15, 'Heart Pendant', NULL, 'OCSu5715', NULL, NULL, 5, 25, 5000.000, 7500.000, 25000.000, 37500.000, 1, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(200) NOT NULL,
  `privileges` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`userId`, `name`, `username`, `password`, `email`, `privileges`) VALUES
(7, 'Andres3', 'Skarz0r', '$2y$10$N8F6.SfkSxbkZylGhlEXK.M6x.qjmDHaG7yN..rB/C9Ss0XtVSUT.', 'mail@mail.com', 2),
(18, 'test', 'test', '$2y$10$FnGPJ415Xf6jNn2sYPvoruX8cFz6yelz7.rnI/PksgzwIqT8sxFGC', 'test@gmail.com', 2),
(19, 'Pradeep', 'Pradeep', '$2y$10$YiwxtPTa/saMbC8Og5C9I.o7fpfYu08/mO5Y9J9SaSdiVi2TDLH6m', 'pradeep.jeevaratnam@gmail.com', 2),
(20, 'Prad', 'PJ', '$2y$10$4OMO5poSBj78Y0GAbRXOXOpnk5Mj6j23GsxuRQWO7twFnC044T4Qi', 'PJ@gmail.com', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`areaId`),
  ADD UNIQUE KEY `areaName` (`areaName`);

--
-- Indices de la tabla `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`articleId`);

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`configId`);

--
-- Indices de la tabla `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerId`);

--
-- Indices de la tabla `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`articleId`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD UNIQUE KEY `orderBillNo` (`orderBillNo`);

--
-- Indices de la tabla `pawningextras`
--
ALTER TABLE `pawningextras`
  ADD PRIMARY KEY (`extraId`),
  ADD KEY `constraint_2` (`pawnId`);

--
-- Indices de la tabla `pawnings`
--
ALTER TABLE `pawnings`
  ADD PRIMARY KEY (`pawnId`),
  ADD KEY `pawnBillNo` (`pawnBillNo`);

--
-- Indices de la tabla `salebills`
--
ALTER TABLE `salebills`
  ADD PRIMARY KEY (`sbillId`),
  ADD UNIQUE KEY `idx_saleBillNo` (`saleBillNo`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`saleId`),
  ADD KEY `idx_child_saleBillNo` (`saleBillNo`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `areaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `articleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
  MODIFY `configId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `customerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `inventory`
--
ALTER TABLE `inventory`
  MODIFY `articleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pawningextras`
--
ALTER TABLE `pawningextras`
  MODIFY `extraId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `pawnings`
--
ALTER TABLE `pawnings`
  MODIFY `pawnId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `salebills`
--
ALTER TABLE `salebills`
  MODIFY `sbillId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `saleId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pawningextras`
--
ALTER TABLE `pawningextras`
  ADD CONSTRAINT `constraint_2` FOREIGN KEY (`pawnId`) REFERENCES `pawnings` (`pawnId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
