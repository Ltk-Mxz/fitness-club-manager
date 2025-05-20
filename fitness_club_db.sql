-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 07:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitness_club_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `abonnes`
--

CREATE TABLE `abonnes` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `code_postal` varchar(20) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `pays` varchar(100) DEFAULT NULL,
  `date_inscription` date DEFAULT curdate(),
  `date_expiration` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `type_abonnement` enum('mensuel','annuel') DEFAULT 'mensuel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `abonnes`
--

INSERT INTO `abonnes` (`id`, `nom`, `prenom`, `email`, `telephone`, `date_naissance`, `adresse`, `code_postal`, `ville`, `pays`, `date_inscription`, `date_expiration`, `photo`, `type_abonnement`) VALUES
(5, 'Ltk', 'Mxz', 'xupygo@mailinator.com', '+1 (968) 347-6314', '1988-02-18', '2900, Kaban Street', '2900', 'Tokyo', 'Japon', '2025-05-20', NULL, '682cb17e99889.jpg', 'mensuel'),
(6, 'STOLE', 'Fernando', 'hyjoj@mailinator.com', '+1 (283) 831-4315', '2020-05-02', '8933, Dandadan', '90333', 'Berlin', 'Allemagne', '2025-05-20', NULL, '682cb20297b60.jpeg', 'annuel'),
(7, 'Quaerat sint vel se', 'Vero officiis conseq', 'goqix@mailinator.com', '+1 (398) 974-5731', '2011-12-27', 'Fuga Unde dolor ut ', 'Aut quis laudantium', 'Magna ut unde beatae', 'Quo eum sed ut offic', '2025-05-20', NULL, '682cb5301a77c.jpg', 'annuel'),
(8, 'Nulla distinctio Qu', 'Non animi aut persp', 'qeraluzixu@mailinator.com', '+1 (401) 159-5646', '1990-01-02', 'Deleniti qui aliquid', 'Amet accusamus non ', 'Hic qui molestiae do', 'Voluptatem et sed e', '2025-05-20', NULL, '682cb53d39680.jpg', 'mensuel');

-- --------------------------------------------------------

--
-- Table structure for table `coachs`
--

CREATE TABLE `coachs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `specialite` varchar(100) DEFAULT NULL,
  `date_embauche` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coachs`
--

INSERT INTO `coachs` (`id`, `nom`, `prenom`, `email`, `telephone`, `specialite`, `date_embauche`, `photo`) VALUES
(6, 'Krish', 'Lotoko', 'finocil@mailinator.com', '+1 (605) 343-3024', 'BlaBlaBla', '2019-12-24', '682cb47624d0d.jpeg'),
(7, 'Quibusdam ad ut non ', 'Recusandae Sit illu', 'bifulyryvo@mailinator.com', '+1 (973) 342-7877', 'Nihil sit occaecat ', '2009-07-18', '682cb48b20df3.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `coach_affectations`
--

CREATE TABLE `coach_affectations` (
  `id` int(11) NOT NULL,
  `coach_id` int(11) NOT NULL,
  `discipline_id` int(11) NOT NULL,
  `mois` int(11) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disciplines`
--

CREATE TABLE `disciplines` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `disciplines`
--

INSERT INTO `disciplines` (`id`, `nom`, `description`) VALUES
(5, 'Non incidunt eum il', 'Ipsam delectus dolo'),
(6, 'Vero consectetur ad', 'Incidunt ea enim cu');

-- --------------------------------------------------------

--
-- Table structure for table `equipements`
--

CREATE TABLE `equipements` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `etat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipements`
--

INSERT INTO `equipements` (`id`, `nom`, `photo`, `etat`) VALUES
(6, 'Cum aliquid culpa a', '682cb4ae6c5b3.jpg', 'mauvais'),
(7, 'Suscipit aliqua Vel', '682cb4d633b44.jpg', 'moyen'),
(8, 'Modi aliqua Duis si', '682cb4e524f3d.jpg', 'bon'),
(9, 'Molestias numquam qu', '682cb4f266c21.jpg', 'bon');

-- --------------------------------------------------------

--
-- Table structure for table `paiements`
--

CREATE TABLE `paiements` (
  `id` int(11) NOT NULL,
  `abonne_id` int(11) NOT NULL,
  `date_paiement` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `type_abonnement` enum('mensuel','annuel') DEFAULT NULL,
  `mois` int(11) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `statut` enum('paye','impaye') DEFAULT 'impaye'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paiements`
--

INSERT INTO `paiements` (`id`, `abonne_id`, `date_paiement`, `montant`, `type_abonnement`, `mois`, `annee`, `statut`) VALUES
(13, 5, '2025-05-20', 18000.00, 'mensuel', 5, 2025, 'paye'),
(14, 6, '2025-05-20', 78000.00, 'mensuel', 5, 2025, 'paye'),
(15, 7, '2025-05-20', 38000.00, 'mensuel', 5, 2025, 'impaye'),
(16, 8, '2025-05-20', 42000.00, 'mensuel', 5, 2025, 'impaye');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$Z83ejc4v23M0QWYrZnyv2.NXC6LRH9WcMZ0j8f.yHlFtXKIZPokcu', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abonnes`
--
ALTER TABLE `abonnes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coachs`
--
ALTER TABLE `coachs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coach_affectations`
--
ALTER TABLE `coach_affectations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coach_id` (`coach_id`),
  ADD KEY `discipline_id` (`discipline_id`);

--
-- Indexes for table `disciplines`
--
ALTER TABLE `disciplines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipements`
--
ALTER TABLE `equipements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `abonne_id` (`abonne_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abonnes`
--
ALTER TABLE `abonnes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `coachs`
--
ALTER TABLE `coachs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `coach_affectations`
--
ALTER TABLE `coach_affectations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disciplines`
--
ALTER TABLE `disciplines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `equipements`
--
ALTER TABLE `equipements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coach_affectations`
--
ALTER TABLE `coach_affectations`
  ADD CONSTRAINT `coach_affectations_ibfk_1` FOREIGN KEY (`coach_id`) REFERENCES `coachs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coach_affectations_ibfk_2` FOREIGN KEY (`discipline_id`) REFERENCES `disciplines` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `paiements_ibfk_1` FOREIGN KEY (`abonne_id`) REFERENCES `abonnes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
