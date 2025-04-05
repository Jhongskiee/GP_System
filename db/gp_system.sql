-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 09:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gp_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipsched`
--

CREATE TABLE `equipsched` (
  `id` int(224) NOT NULL,
  `equipdate` date NOT NULL,
  `equipoperator` varchar(224) DEFAULT NULL,
  `equipplate` varchar(255) DEFAULT NULL,
  `equiptype` varchar(255) DEFAULT NULL,
  `equipbrand` varchar(255) DEFAULT NULL,
  `equiparea` varchar(255) DEFAULT NULL,
  `equipnature` varchar(255) DEFAULT NULL,
  `distance` float DEFAULT NULL,
  `hours` float DEFAULT NULL,
  `fuelLiters` float DEFAULT NULL,
  `fuelCost` float DEFAULT NULL,
  `odoMeasure` float DEFAULT NULL,
  `smrMeasure` float DEFAULT NULL,
  `print_status` enum('Not Printed','Printed') DEFAULT 'Not Printed',
  `equipcategory` enum('odometer','smr') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipsched`
--

INSERT INTO `equipsched` (`id`, `equipdate`, `equipoperator`, `equipplate`, `equiptype`, `equipbrand`, `equiparea`, `equipnature`, `distance`, `hours`, `fuelLiters`, `fuelCost`, `odoMeasure`, `smrMeasure`, `print_status`, `equipcategory`) VALUES
(3, '2025-03-28', 'CHRISTIAN', 'SGL 988', 'NISSAN DT-6WHEELERS', 'MITSHUBISHI', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 'Printed', 'odometer'),
(4, '2025-04-03', 'ALTHEA GALORIO JAYVEE', 'SGL 988', 'NISSAN DT-6WHEELERS', 'MITSHUBISHI', 'MOTOR POOL', 'MAIN CITY HALL', 480, 0, 40, 200, NULL, NULL, 'Printed', 'odometer'),
(5, '2025-04-03', 'CHRISTIAN MELENDREZ', 'SGL 988', 'NISSAN DT-6WHEELERS', 'MITSHUBISHI', 'LGU PANABO', 'MOTOR POOL', 0, 3.5, 30, 65, NULL, NULL, 'Printed', 'odometer'),
(6, '2025-04-01', 'JANE GRACE PACOMIIOS', 'SGL 988', 'NISSAN DT-6WHEELERS', 'MITSHUBISHI', 'GSO-INVENTORY', 'MOTOR POOL MAIN', 50, 0, 37.3, 65, 0, 0, 'Printed', 'odometer'),
(7, '2025-04-03', 'BERNA', 'SGL 988', 'NISSAN DT-6WHEELERS', 'MITSHUBISHI', 'WOW', 'EWO', 0, 37.3, 330, 0, 20, 10, 'Printed', 'smr'),
(8, '2025-04-02', 'CHERVIN RELAMPAGOS', 'SGL 988', 'NISSAN DT-6WHEELERS', 'MITSHUBISHI', 'GSO - MOTOR POOL', 'CITY LEGAL OFFICE', 0, 0, 35, 42, 0, 105, 'Not Printed', 'odometer'),
(9, '2025-01-02', 'MARCOS LANTICSE', '1017-8081250', 'WATER TRUCK', 'HYUNDAI', 'SUPPLY WATER', 'BRGY. JP LAUREL/ PANABO CITY HALL', 0, 0, 30, 1, 37625, 0, 'Not Printed', 'odometer'),
(10, '2025-01-03', 'MARCOS LANTICSE', '1017-8081250', 'WATER TRUCK', 'HYUNDAI', 'SUPPLY WATER', 'BRGY. JP LAUREL/ PANABO CITY HALL', 0, 0, 30, 1, 37730, 0, 'Not Printed', 'odometer'),
(11, '2025-01-06', 'MARCOS LANTICSE', '1017-8081250', 'WATER TRUCK', 'HYUNDAI', 'SUPPLY WATER', 'BRGY. JP LAUREL/ PANABO CITY HALL', 0, 0, 30, 1735.5, 37835, 0, 'Not Printed', 'odometer'),
(12, '2025-01-07', 'MARCOS LANTICSE', '1017-8081250', 'WATER TRUCK', 'HYUNDAI', 'SUPPLY WATER', 'BRGY. JP LAUREL/ PANABO CITY HALL', 0, 0, 0, 0, 0, 0, 'Not Printed', 'odometer'),
(13, '2025-01-08', 'MARCOS LANTICSE', '1017-8081250', 'WATER TRUCK', 'HYUNDAI', 'SUPPLY WATER', 'BRGY. JP LAUREL/ PANABO CITY HALL', 0, 0, 30, 1735.5, 37940, 0, 'Not Printed', 'odometer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(224) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `minitial` varchar(255) DEFAULT NULL,
  `lname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fname`, `minitial`, `lname`) VALUES
(1, 'christian1', '$2y$10$CuxU1r4rn24H8AKzw3Uswe4Rpgx71xWWpF/eb3VTp0/tXvRtcGrWO', 'Christian', '', 'Melendrez'),
(2, 'Althea_Jayvee', '$2y$10$Ykx5lj3zjj1L/bic6n8nputuHBpQNOPx8cebZhj5DGw35gfPR.iRS', 'Althea', 'Bantilan', 'Galorio');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(224) NOT NULL,
  `vehitype` varchar(224) NOT NULL,
  `vehibrand` varchar(255) DEFAULT NULL,
  `vehicle` varchar(224) NOT NULL,
  `vehiplate` varchar(255) NOT NULL,
  `vehicate` varchar(244) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `vehitype`, `vehibrand`, `vehicle`, `vehiplate`, `vehicate`) VALUES
(1, 'NISSAN DT-6WHEELERS', 'MITSHUBISHI', 'DT # 3', 'SGL 988', 'HEAVY'),
(2, 'WATER TRUCK', 'HYUNDAI', 'BIG YELLOW WATER TANKER', '1017-8081250', 'LIGHT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipsched`
--
ALTER TABLE `equipsched`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipsched`
--
ALTER TABLE `equipsched`
  MODIFY `id` int(224) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(224) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(224) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
