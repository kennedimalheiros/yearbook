-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 28-Abr-2015 às 19:07
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `daw_yearbook`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades`
--

CREATE TABLE IF NOT EXISTS `cidades` (
  `idCidade` int(11) NOT NULL AUTO_INCREMENT,
  `idEstado` int(11) NOT NULL,
  `nomeCidade` varchar(70) NOT NULL,
  PRIMARY KEY (`idCidade`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Extraindo dados da tabela `cidades`
--

INSERT INTO `cidades` (`idCidade`, `idEstado`, `nomeCidade`) VALUES
(1, 1, 'Belo Horizonte'),
(2, 1, 'Betim'),
(3, 1, 'Contagem'),
(4, 1, 'Arcos'),
(5, 1, 'Poços de Caldas'),
(6, 1, 'Guanhães'),
(7, 2, 'Porto Alegre'),
(8, 2, 'São Leopoldo'),
(9, 2, 'Nova Petrópolis'),
(10, 2, 'Gramado'),
(11, 3, 'Rio de Janeiro'),
(12, 3, 'Rezende'),
(13, 3, 'Macaé'),
(14, 3, 'Niterói'),
(15, 4, 'São Paulo'),
(16, 4, 'São Carlos'),
(17, 4, 'Santos'),
(18, 4, 'Campinas'),
(19, 4, 'Caraguatatuba'),
(20, 5, 'Fortaleza'),
(21, 5, 'Sobral'),
(22, 5, 'Juazeiro do Norte'),
(23, 5, 'Ubajara'),
(24, 1, 'Montes Claros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estados`
--

CREATE TABLE IF NOT EXISTS `estados` (
  `idEstado` int(11) NOT NULL AUTO_INCREMENT,
  `sigaEstado` char(2) NOT NULL,
  `nomeEstado` varchar(50) NOT NULL,
  PRIMARY KEY (`idEstado`),
  UNIQUE KEY `sigaEstado` (`sigaEstado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `estados`
--

INSERT INTO `estados` (`idEstado`, `sigaEstado`, `nomeEstado`) VALUES
(1, 'MG', 'Minas Gerais'),
(2, 'RS', 'Rio Grande do Sul'),
(3, 'RJ', 'Rio de Janeiro'),
(4, 'SP', 'São Paulo'),
(5, 'CE', 'Ceará');

-- --------------------------------------------------------

--
-- Estrutura da tabela `galeria`
--

CREATE TABLE IF NOT EXISTS `galeria` (
  `login` varchar(100) NOT NULL,
  `arquivoFoto` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `participantes`
--

CREATE TABLE IF NOT EXISTS `participantes` (
  `login` varchar(20) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `nomeCompleto` varchar(50) NOT NULL,
  `arquivoFoto` varchar(250) NOT NULL,
  `cidade` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `descricao` varchar(5000) NOT NULL,
  PRIMARY KEY (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
