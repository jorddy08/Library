-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 06:58 AM
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
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `middle_initial` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `email`, `created_at`, `first_name`, `last_name`, `middle_initial`) VALUES
(4, 'Jezreel', '$2y$10$NH/bP/uKNbpAUF3xIDA0de4.u4g9jgvnOHLz2NhrX60FFu.vra/b6', 'jezreelvillanueva@gmail.com', '2025-05-22 07:54:10', 'Jezreel', 'Villanueva', ''),
(5, 'Ken', '$2y$10$NhqxD392n6dhmrNKZ2nDleuKh3aZmdaiD76mr.nubGPAIP9aIMHkK', 'kennethventurado@gmail.com', '2025-05-22 07:55:18', 'Kenneth', 'Venturado', ''),
(6, 'Jordan', '$2y$10$BEPpBTnW7Rbd3BO.K3/xjO26KFw688M/vAG8tNsvwZOcDdqL5lIWK', 'jordanherrera@gmail.com', '2025-05-22 07:57:59', 'Jordan', 'Herrera', ''),
(7, 'Lester', '$2y$10$peGnaa7ORI9rhDQLXbK3iuwa6Cct91E74FMMdvmMmoKG1jeOxr8pi', 'lestercustodio@gmail.con', '2025-05-24 02:19:03', 'Lester', 'Custodio', '');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`) VALUES
(10, 'C.S. Lewis'),
(4, 'F. Scott Fitzgerald'),
(2, 'George Orwell'),
(1, 'Harper Lee'),
(5, 'Herman Melville'),
(7, 'J.D. Salinger'),
(8, 'J.R.R. Tolkien'),
(3, 'Jane Austen'),
(6, 'Leo Tolstoy'),
(9, 'Ray Bradbury');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `author`, `location`, `image`, `description`, `category_id`) VALUES
(12, 'To Kill a Mockingbird', 'Harper Lee', 'Shelf A1', '682ebbcaa0daa.jpg', 'A profound novel set in the Deep South that explores themes of racial injustice, moral growth, and compassion through the eyes of young Scout Finch.', 1),
(13, '1984', 'George Orwell', 'Shelf A2', '682ebbe87cc88.jpg', 'A dystopian classic depicting a totalitarian society under constant surveillance, where truth is manipulated and individuality crushed.', 2),
(14, 'Pride and Prejudice', 'Jane Austen', 'Shelf B1', '682ebc30d2876.jpg', 'A timeless romance and social commentary novel focusing on the intelligent and spirited Elizabeth Bennet as she navigates love, society, and family expectations.', 1),
(15, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Shelf B2', '682ebc464762f.jpg', 'An evocative portrayal of the Jazz Age, wealth, and the American Dream through the tragic story of Jay Gatsby and his unrequited love for Daisy Buchanan.', 1),
(16, 'Moby Dick', 'Herman Melville', 'Shelf C1', '682ebc60d41cf.png', 'An epic and symbolic adventure chronicling Captain Ahab’s obsessive quest for revenge against the elusive white whale, exploring themes of fate, nature, and madness.', 1),
(17, 'War and Peace', 'Leo Tolstoy', 'Shelf C2', '682ebc8020b31.jpg', 'A sweeping historical novel intertwining the lives of aristocratic families against the backdrop of the Napoleonic Wars, reflecting on war, peace, and human nature.', 4),
(18, 'The Catcher in the Rye', 'J.D. Salinger', 'Shelf D1', '682ebc9590c29.jpg', 'A compelling coming-of-age story revealing the struggles of adolescent Holden Caulfield as he deals with alienation, identity, and loss in post-war America.', 1),
(19, 'The Hobbit', 'J.R.R. Tolkien', 'Shelf D2', '682ebcb819fa0.jpg', 'A richly imagined fantasy tale following Bilbo Baggins on a daring adventure filled with dragons, dwarves, and unexpected heroism in Middle-earth.', 3),
(20, 'Fahrenheit 451', 'Ray Bradbury', 'Shelf E1', '682ebcd2f1de4.jpg', 'A powerful dystopian narrative warning against censorship and the suppression of ideas, centered on a future society where books are banned and burned.', 2),
(21, 'The Chronicles of Narnia', 'C.S. Lewis', 'Shelf E2', '682ebce712e5c.jpg', 'A beloved fantasy series exploring themes of bravery, faith, and imagination through the magical adventures of children in the enchanted land of Narnia.', 3),
(23, 'The Smile', 'Ray Bradbury', 'Shelf D2', '682f1562aff1f.jpg', 'The Smile is a thought-provoking short story by Ray Bradbury that explores the power of art and beauty in a dystopian future. Set in a post-apocalyptic world where knowledge and culture have been largely destroyed, the story centers around a man who discovers a famous painting, Mona Lisa, preserved beneath the rubble.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Classic Fiction'),
(2, 'Science Fiction / Dystopian'),
(3, 'Fantasy'),
(4, 'Historical Fiction');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
