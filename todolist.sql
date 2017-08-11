-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11-Ago-2017 às 03:02
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todolist`
--
CREATE DATABASE IF NOT EXISTS `todolist` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `todolist`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo`
--

CREATE TABLE `grupo` (
  `id` int(11) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `tarefa_id` int(11) DEFAULT NULL,
  `observacao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `grupo`
--

INSERT INTO `grupo` (`id`, `descricao`, `tarefa_id`, `observacao`) VALUES
(1, 'Tarefa 13', NULL, 'Teste de incluir tarefas'),
(2, 'Tarefa 2', NULL, 'Teste de incluir tarefa 3');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefa`
--

CREATE TABLE `tarefa` (
  `id` int(11) NOT NULL,
  `datatarefa` date NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `id_grupo` int(11) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tarefa`
--

INSERT INTO `tarefa` (`id`, `datatarefa`, `descricao`, `id_grupo`, `usuario_id`) VALUES
(1, '2017-08-07', 'Fazer To Do List PHP2', 1, 0),
(2, '2017-08-07', 'Fazer Deploy 1', 2, 0),
(3, '2017-08-08', 'Ordenar campos da datagrid', 1, 0),
(5, '2017-08-09', 'Converter data PT-BR en EN-EN', 1, 0),
(6, '2017-08-10', 'Encerrar tarefas', 1, 0),
(7, '2017-08-10', 'Encerrar tarefas', 1, 0),
(8, '2017-08-10', 'Encerrar tarefas', 1, 0),
(9, '2017-08-10', 'Encerrar tarefas', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password_hash` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `user_name`, `user_email`, `user_password_hash`) VALUES
(1, 'Admin', 'teste1@10host.top', '$2y$10$BatdFhJNJLrVmFs1q1/9r.caJsc3qa7el1ys/T1VE6xV5Dad7hw3y'),
(2, 'andremarinho', 'andrdemelomarinho@gmail.com', '$2y$10$MaioZX6IPvHe/sRo/EaYveASZhB9aLWbIYCGE3wX5F482Jl4.QAUa'),
(3, 'andremarinho2', 'andrdemelomarinho2@gmail.com', '$2y$10$Nf43Iar5FNlSyppxfNMiKuwR1QOadA1v.4XM3mWgjygolERw1dq1y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarefa`
--
ALTER TABLE `tarefa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
