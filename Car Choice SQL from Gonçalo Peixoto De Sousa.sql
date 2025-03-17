-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10-Mar-2025 às 17:56
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `car_choice`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `brands`
--

INSERT INTO `brands` (`id`, `brand`) VALUES
(1, 'Audi'),
(2, 'Mercedes-Benz'),
(3, 'Nissan'),
(4, 'Volvo'),
(5, 'BMW'),
(6, 'Honda');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `registration_year` year(4) NOT NULL,
  `mileage` int(11) NOT NULL,
  `seats` int(11) NOT NULL,
  `fuel_type` enum('Gasolina','Diesel','Elétrico','Híbrido','GPL') NOT NULL,
  `power` int(11) NOT NULL,
  `engine_capacity` float NOT NULL,
  `transmission` enum('Manual','Automática','Semi-Automática') NOT NULL,
  `color` varchar(20) NOT NULL,
  `warranty` int(11) DEFAULT 0,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `registration_year`, `mileage`, `seats`, `fuel_type`, `power`, `engine_capacity`, `transmission`, `color`, `warranty`, `price`, `description`, `created_at`) VALUES
(1, 'Audi', 'A3 1.6 TDI Sport', '2018', 120000, 5, 'Diesel', 110, 1.6, 'Manual', 'Preto', 12, 28600.00, 'Carro desportivo compacto, excelente para cidade e estrada.', '2025-03-10 15:09:18'),
(2, 'BMW', 'Série 3 2.0d M Sport', '2020', 90000, 5, 'Diesel', 190, 2, 'Automática', 'Azul', 24, 45800.00, 'Sedan premium com alto desempenho e conforto.', '2025-03-10 15:09:18'),
(3, 'Mercedes', 'Classe C 2.2 CDI Elegance', '2017', 110000, 5, 'Diesel', 170, 2.2, 'Automática', 'Cinza', 18, 36300.00, 'Luxuoso e confortável, ideal para viagens longas.', '2025-03-10 15:09:18'),
(4, 'Nissan', 'Qashqai 1.5 dCi Tekna', '2021', 30000, 5, 'Diesel', 115, 1.5, 'Manual', 'Branco', 36, 38500.00, 'SUV moderno com tecnologia avançada e baixo consumo.', '2025-03-10 15:09:18'),
(5, 'Volkswagen', 'Golf 1.4 TSI Highline', '2019', 80000, 5, 'Gasolina', 150, 1.4, 'Automática', 'Vermelho', 24, 18900.00, 'Compacto esportivo com excelente desempenho e economia.', '2025-03-10 15:09:18'),
(6, 'aldi', 'trolha 123', '0000', 0, 0, '', 0, 0, '', '', 0, 0.00, NULL, '2025-03-10 15:19:20'),
(7, 'aldi', 'trolha 123', '2000', 1, 1, 'Gasolina', 1, 2, 'Manual', 'red', 2, 21.00, 'tesate', '2025-03-10 15:19:24');

-- --------------------------------------------------------

--
-- Estrutura da tabela `car_categories`
--

CREATE TABLE `car_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `car_images`
--

CREATE TABLE `car_images` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `car_images`
--

INSERT INTO `car_images` (`id`, `car_id`, `image_url`) VALUES
(1, 1, 'assets/images/carros/Audi_A3.jpg'),
(2, 2, 'assets/images/carros/BMW_Serie3.jpg'),
(3, 3, 'assets/images/carros/Mercedes_ClasseC.jpg'),
(4, 4, 'assets/images/carros/Nissan_Qashqai.jpg'),
(5, 5, 'assets/images/carros/VW_Golf.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `models`
--

CREATE TABLE `models` (
  `id` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `model` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `models`
--

INSERT INTO `models` (`id`, `brand`, `model`) VALUES
(1, 2, 'A-Class'),
(2, 2, 'C-Class'),
(3, 2, 'E-Class'),
(4, 2, 'S-Class'),
(5, 2, 'GLC'),
(6, 2, 'GLE'),
(7, 2, 'GLS'),
(8, 2, 'CLA'),
(9, 2, 'G-Class'),
(10, 2, 'EQS'),
(11, 1, 'A1'),
(12, 1, 'A3'),
(13, 1, 'A4'),
(14, 1, 'A6'),
(15, 1, 'Q3'),
(16, 1, 'Q5'),
(17, 1, 'Q7'),
(18, 1, 'Q8'),
(19, 1, 'e-tron'),
(20, 1, 'RS7'),
(21, 6, 'Fit'),
(22, 6, 'Civic'),
(23, 6, 'Accord'),
(24, 6, 'CR-V'),
(25, 6, 'HR-V'),
(26, 6, 'Pilot'),
(27, 6, 'Odyssey'),
(28, 6, 'Ridgeline'),
(29, 6, 'Insight'),
(30, 3, 'Micra'),
(31, 3, 'Altima'),
(32, 3, 'Sentra'),
(33, 3, 'Maxima'),
(34, 3, 'Juke'),
(35, 3, 'Rogue'),
(36, 3, 'Murano'),
(37, 3, 'Pathfinder'),
(38, 3, 'Leaf'),
(39, 3, 'Frontier'),
(40, 5, 'Série 1'),
(41, 5, 'Série 3'),
(42, 5, 'Série 5'),
(43, 5, 'Série 7'),
(44, 5, 'X1'),
(45, 5, 'X3'),
(46, 5, 'X5'),
(47, 5, 'X6'),
(48, 5, 'i4'),
(49, 5, 'Z4'),
(50, 5, 'M3'),
(51, 5, 'M4');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rental_start_date` date NOT NULL,
  `rental_end_date` date NOT NULL,
  `daily_rate` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sale_price` decimal(10,2) NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` enum('admin','client') DEFAULT 'client',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `car_categories`
--
ALTER TABLE `car_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Índices para tabela `car_images`
--
ALTER TABLE `car_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`);

--
-- Índices para tabela `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_models_brands` (`brand`);

--
-- Índices para tabela `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de tabela `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `car_categories`
--
ALTER TABLE `car_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `car_images`
--
ALTER TABLE `car_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `models`
--
ALTER TABLE `models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de tabela `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `car_images`
--
ALTER TABLE `car_images`
  ADD CONSTRAINT `car_images_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);

--
-- Limitadores para a tabela `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `fk_models_brands` FOREIGN KEY (`brand`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `rentals_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
