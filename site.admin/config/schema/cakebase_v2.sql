-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Jan 02, 2013 as 01:35 PM
-- Versão do Servidor: 5.5.8
-- Versão do PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `cakebase_v2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_acos`
--

CREATE TABLE IF NOT EXISTS `site_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

--
-- Extraindo dados da tabela `site_acos`
--

INSERT INTO `site_acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 176),
(2, 1, NULL, NULL, 'Pages', 2, 5),
(3, 2, NULL, NULL, 'display', 3, 4),
(4, 1, NULL, NULL, 'Acl', 6, 13),
(5, 4, NULL, NULL, 'set_permission', 7, 8),
(6, 4, NULL, NULL, 'index', 9, 10),
(7, 4, NULL, NULL, 'build_acl', 11, 12),
(8, 1, NULL, NULL, 'Configurations', 14, 25),
(9, 8, NULL, NULL, 'index', 15, 16),
(10, 8, NULL, NULL, 'add', 17, 18),
(11, 8, NULL, NULL, 'edit', 19, 20),
(12, 8, NULL, NULL, 'edit_parcial', 21, 22),
(13, 8, NULL, NULL, 'delete', 23, 24),
(14, 1, NULL, NULL, 'Dashboard', 26, 29),
(15, 14, NULL, NULL, 'index', 27, 28),
(16, 1, NULL, NULL, 'Grupos', 30, 41),
(17, 16, NULL, NULL, 'index', 31, 32),
(18, 16, NULL, NULL, 'add', 33, 34),
(19, 16, NULL, NULL, 'edit', 35, 36),
(20, 16, NULL, NULL, 'edit_parcial', 37, 38),
(21, 16, NULL, NULL, 'delete', 39, 40),
(22, 1, NULL, NULL, 'Logs', 42, 45),
(23, 22, NULL, NULL, 'index', 43, 44),
(24, 1, NULL, NULL, 'Paginas', 46, 55),
(25, 24, NULL, NULL, 'index', 47, 48),
(26, 24, NULL, NULL, 'add', 49, 50),
(27, 24, NULL, NULL, 'edit', 51, 52),
(28, 24, NULL, NULL, 'delete', 53, 54),
(29, 1, NULL, NULL, 'Usuarios', 56, 79),
(30, 29, NULL, NULL, 'login_refresh', 57, 58),
(31, 29, NULL, NULL, 'login', 59, 60),
(32, 29, NULL, NULL, 'logout', 61, 62),
(33, 29, NULL, NULL, 'change_pass', 63, 64),
(34, 29, NULL, NULL, 'recoverpass', 65, 66),
(35, 29, NULL, NULL, 'recoverpass_confirm', 67, 68),
(36, 29, NULL, NULL, 'update_api_key', 69, 70),
(37, 29, NULL, NULL, 'index', 71, 72),
(38, 29, NULL, NULL, 'add', 73, 74),
(39, 29, NULL, NULL, 'edit', 75, 76),
(40, 29, NULL, NULL, 'delete', 77, 78),
(41, 1, NULL, NULL, 'Banners', 80, 89),
(42, 41, NULL, NULL, 'index', 81, 82),
(43, 41, NULL, NULL, 'add', 83, 84),
(44, 41, NULL, NULL, 'edit', 85, 86),
(45, 41, NULL, NULL, 'delete', 87, 88),
(46, 1, NULL, NULL, 'Vitrines', 90, 99),
(47, 46, NULL, NULL, 'index', 91, 92),
(48, 46, NULL, NULL, 'add', 93, 94),
(49, 46, NULL, NULL, 'edit', 95, 96),
(50, 46, NULL, NULL, 'delete', 97, 98),
(51, 1, NULL, NULL, 'Galerias', 100, 117),
(52, 51, NULL, NULL, 'movedown', 101, 102),
(53, 51, NULL, NULL, 'moveup', 103, 104),
(54, 51, NULL, NULL, 'update_parent', 105, 106),
(55, 51, NULL, NULL, 'index', 107, 108),
(56, 51, NULL, NULL, 'add', 109, 110),
(57, 51, NULL, NULL, 'edit', 111, 112),
(58, 51, NULL, NULL, 'delete', 113, 114),
(59, 51, NULL, NULL, 'autocomplete', 115, 116),
(60, 1, NULL, NULL, 'GaleriaArquivos', 118, 135),
(61, 60, NULL, NULL, 'index', 119, 120),
(62, 60, NULL, NULL, 'add', 121, 122),
(63, 60, NULL, NULL, 'edit', 123, 124),
(64, 60, NULL, NULL, 'delete', 125, 126),
(65, 60, NULL, NULL, 'setposition', 127, 128),
(66, 60, NULL, NULL, 'movedown', 129, 130),
(67, 60, NULL, NULL, 'moveup', 131, 132),
(68, 60, NULL, NULL, 'fixposition', 133, 134),
(69, 1, NULL, NULL, 'Sitemaps', 136, 151),
(70, 69, NULL, NULL, 'movedown', 137, 138),
(71, 69, NULL, NULL, 'moveup', 139, 140),
(72, 69, NULL, NULL, 'update_parent', 141, 142),
(73, 69, NULL, NULL, 'index', 143, 144),
(74, 69, NULL, NULL, 'add', 145, 146),
(75, 69, NULL, NULL, 'edit', 147, 148),
(76, 69, NULL, NULL, 'delete', 149, 150),
(90, 1, NULL, NULL, 'Noticias', 152, 163),
(91, 90, NULL, NULL, 'index', 153, 154),
(92, 90, NULL, NULL, 'add', 155, 156),
(93, 90, NULL, NULL, 'edit', 157, 158),
(94, 90, NULL, NULL, 'delete', 159, 160),
(95, 90, NULL, NULL, 'autocomplete', 161, 162),
(96, 1, NULL, NULL, 'Videos', 164, 175),
(97, 96, NULL, NULL, 'index', 165, 166),
(98, 96, NULL, NULL, 'add', 167, 168),
(99, 96, NULL, NULL, 'edit', 169, 170),
(100, 96, NULL, NULL, 'delete', 171, 172),
(101, 96, NULL, NULL, 'autocomplete', 173, 174);

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_aros`
--

CREATE TABLE IF NOT EXISTS `site_aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Extraindo dados da tabela `site_aros`
--

INSERT INTO `site_aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Grupo', 1, NULL, 1, 4),
(12, 1, 'Usuario', 9, NULL, 2, 3),
(13, NULL, 'Grupo', 2, NULL, 5, 6);

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_aros_acos`
--

CREATE TABLE IF NOT EXISTS `site_aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `site_aros_acos`
--

INSERT INTO `site_aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(2, 1, 12, '-1', '-1', '-1', '-1'),
(4, 13, 1, '1', '1', '1', '1'),
(5, 13, 4, '-1', '-1', '-1', '-1'),
(6, 13, 8, '-1', '-1', '-1', '-1'),
(7, 13, 16, '-1', '-1', '-1', '-1'),
(8, 13, 22, '-1', '-1', '-1', '-1'),
(9, 13, 29, '-1', '-1', '-1', '-1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_banners`
--

CREATE TABLE IF NOT EXISTS `site_banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area` varchar(16) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `peso` decimal(2,0) unsigned NOT NULL DEFAULT '1',
  `data_inicio` datetime DEFAULT NULL,
  `data_fim` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `area` (`area`),
  KEY `data` (`data_inicio`,`data_fim`),
  KEY `data_inicio` (`data_inicio`),
  KEY `data_fim` (`data_fim`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_banners`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `site_configurations`
--

CREATE TABLE IF NOT EXISTS `site_configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config` varchar(255) DEFAULT NULL,
  `value` text,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config` (`config`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Extraindo dados da tabela `site_configurations`
--

INSERT INTO `site_configurations` (`id`, `config`, `value`, `description`) VALUES
(1, 'site.title', '%install%', 'Título do site'),
(2, 'site.keywords', '%install%', '5 a 10 palavras separadas por vírgula'),
(3, 'site.description', '%install%', 'Descrição do site com até 160 caracteres'),
(4, 'smtp.port', '587', 'Porta do servidor SMTP'),
(5, 'smtp.host', '%install%', 'Endereço do servidor de SMTP'),
(6, 'smtp.username', '%install%', 'Nome de usuário para envio de emails'),
(7, 'smtp.password', '%install%', 'Senha para envio de e-mails'),
(8, 'Admin.name', 'Webjump Admin', 'Admin - codename'),
(9, 'Admin.version', '2.0', 'Versão do Admin'),
(10, 'from.nome', '%install%', 'Nome do remetente de e-mail'),
(11, 'from.email', '%install%', 'Endereço do remetente de e-mail'),
(12, 'Admin.Usuario.senha_expiracao', '', 'Quantidade de dias para expiração da senha'),
(13, 'Admin.Usuario.remember_me', '1', 'Ativar recurso remember-me no login'),
(14, 'Admin.loginRedirect', '/paginas', 'Página padrão após login');

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_galerias`
--

CREATE TABLE IF NOT EXISTS `site_galerias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `friendly_url` varchar(255) DEFAULT NULL,
  `descricao` text,
  `imagem_capa` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_friendly_url` (`parent_id`,`friendly_url`),
  KEY `parent_id` (`parent_id`),
  KEY `friendly_url` (`friendly_url`),
  KEY `lft` (`lft`),
  KEY `rght` (`rght`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_galerias`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `site_galeria_arquivos`
--

CREATE TABLE IF NOT EXISTS `site_galeria_arquivos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `galeria_id` int(10) unsigned DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `friendly_url` varchar(255) DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `legenda` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `embed` varchar(255) DEFAULT NULL,
  `order` int(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `friendly_url` (`friendly_url`),
  KEY `titulo` (`titulo`),
  KEY `galeria_id` (`galeria_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_galeria_arquivos`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `site_grupos`
--

CREATE TABLE IF NOT EXISTS `site_grupos` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `site_grupos`
--

INSERT INTO `site_grupos` (`id`, `nome`, `created`, `modified`) VALUES
(1, 'Administrador', '2011-02-18 08:31:01', '2011-02-18 08:31:01'),
(2, 'Webmaster', '2012-12-11 17:17:00', '2012-12-11 17:17:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_logs`
--

CREATE TABLE IF NOT EXISTS `site_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `description` text,
  `model` varchar(40) DEFAULT NULL,
  `model_id` int(10) unsigned DEFAULT NULL,
  `action` varchar(25) DEFAULT NULL,
  `usuario_id` int(10) unsigned DEFAULT NULL,
  `change` text,
  `changes` tinyint(3) unsigned DEFAULT NULL,
  `ip` char(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `model` (`model`),
  KEY `model_id` (`model_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

--
-- Extraindo dados da tabela `site_logs`
--

INSERT INTO `site_logs` (`id`, `title`, `created`, `description`, `model`, `model_id`, `action`, `usuario_id`, `change`, `changes`, `ip`) VALUES
(1, 'Aco (41)', '2012-12-12 10:06:19', 'Aco (41) incluído pelo Usuario "Webjump" (9).', 'Aco', 41, 'add', 9, 'parent_id () => (1), alias () => (Banners)', 2, '127.0.0.1'),
(2, 'Aco (42)', '2012-12-12 10:06:20', 'Aco (42) incluído pelo Usuario "Webjump" (9).', 'Aco', 42, 'add', 9, 'parent_id () => (41), alias () => (index)', 2, '127.0.0.1'),
(3, 'Aco (43)', '2012-12-12 10:40:25', 'Aco (43) incluído pelo Usuario "Webjump" (9).', 'Aco', 43, 'add', 9, 'parent_id () => (41), alias () => (add)', 2, '127.0.0.1'),
(4, 'Aco (44)', '2012-12-12 10:40:26', 'Aco (44) incluído pelo Usuario "Webjump" (9).', 'Aco', 44, 'add', 9, 'parent_id () => (41), alias () => (edit)', 2, '127.0.0.1'),
(5, 'Aco (45)', '2012-12-12 10:40:26', 'Aco (45) incluído pelo Usuario "Webjump" (9).', 'Aco', 45, 'add', 9, 'parent_id () => (41), alias () => (delete)', 2, '127.0.0.1'),
(6, 'teste', '2012-12-12 10:42:12', 'Banner "teste" (49) incluído pelo Usuario "Webjump" (9).', 'Banner', 49, 'add', 9, 'peso () => (1), area () => (parceiros), titulo () => (teste), url () => (http://www.google.com), data_inicio () => (2012-12-12 00:00), data_fim () => (2012-12-16 00:00), imagem () => (img/upload/banners/201212/50c87ba4-f6fc-4935-905c-0754d182e9d6/imagem.png)', 7, '127.0.0.1'),
(7, 'teste', '2012-12-12 10:44:05', 'Banner "teste" (49) atualizado pelo Usuario "Webjump" (9).', 'Banner', 49, 'edit', 9, 'imagem (img/upload/banners/201212/50c87ba4-f6fc-4935-905c-0754d182e9d6/imagem.png) => (img/upload/banners/201212/50c87c15-09d8-4610-b90f-0754d182e9d6/imagem.jpg), data_inicio (2012-12-12 00:00:00) => (2012-12-12 00:00), data_fim (2012-12-16 00:00:00) => (2012-12-16 00:00)', 3, '127.0.0.1'),
(8, 'teste', '2012-12-12 14:29:59', 'Banner "teste" (49) removido pelo Usuario "Webjump" (9).', 'Banner', 49, 'delete', 9, NULL, NULL, '127.0.0.1'),
(9, 'banner teste', '2012-12-14 08:39:12', 'Banner "banner teste" (50) incluído pelo Usuario "Webjump" (9).', 'Banner', 50, 'add', 9, 'peso () => (1), area () => (parceiros), titulo () => (banner teste), url () => (http://www.google.com), data_inicio () => (2012-12-15 00:00), data_fim () => (2012-12-16 00:00), imagem () => (img/upload/banners/201212/50cb01d0-44a8-4af2-aef0-0bd4d182e9d6/imagem.jpg)', 7, '127.0.0.1'),
(10, 'banner teste', '2012-12-14 08:45:31', 'Banner "banner teste" (50) atualizado pelo Usuario "Webjump" (9).', 'Banner', 50, 'edit', 9, 'imagem (img/upload/banners/201212/50cb01d0-44a8-4af2-aef0-0bd4d182e9d6/imagem.jpg) => (img/upload/banners/201212/50cb034b-6f3c-40f7-92f7-0bd4d182e9d6/imagem.jpg), data_inicio (2012-12-15 00:00:00) => (2012-12-15 00:00), data_fim (2012-12-16 00:00:00) => (2012-12-16 00:00)', 3, '127.0.0.1'),
(11, 'banner teste', '2012-12-14 08:48:30', 'Banner "banner teste" (50) atualizado pelo Usuario "Webjump" (9).', 'Banner', 50, 'edit', 9, 'imagem (img/upload/banners/201212/50cb034b-6f3c-40f7-92f7-0bd4d182e9d6/imagem.jpg) => (img/upload/banners/201212/50cb03fe-9b68-4c3b-8e28-0bd4d182e9d6/imagem.jpg), data_inicio (2012-12-15 00:00:00) => (2012-12-15 00:00), data_fim (2012-12-16 00:00:00) => (2012-12-16 00:00)', 3, '127.0.0.1'),
(12, 'banner teste', '2012-12-14 08:50:17', 'Banner "banner teste" (50) removido pelo Usuario "Webjump" (9).', 'Banner', 50, 'delete', 9, NULL, NULL, '127.0.0.1'),
(13, 'teste', '2012-12-14 08:51:36', 'Banner "teste" (51) incluído pelo Usuario "Webjump" (9).', 'Banner', 51, 'add', 9, 'peso () => (4), area () => (parceiros), titulo () => (teste), url () => (http://www.google.com), data_inicio () => (2012-12-15 00:00), data_fim () => (2012-12-16 00:00), imagem () => (img/upload/banners/201212/50cb04b8-42ac-4b1c-8e49-0bd4d182e9d6/imagem.jpg)', 7, '127.0.0.1'),
(14, 'teste', '2012-12-14 09:13:32', 'Banner "teste" (51) atualizado pelo Usuario "Webjump" (9).', 'Banner', 51, 'edit', 9, 'imagem (img/upload/banners/201212/50cb04b8-42ac-4b1c-8e49-0bd4d182e9d6/imagem.jpg) => (img/upload/banners/201212/50cb09dc-bef0-4e97-b5ff-0bd4d182e9d6/imagem.jpg), data_inicio (2012-12-15 00:00:00) => (2012-12-15 00:00), data_fim (2012-12-16 00:00:00) => (2012-12-16 00:00)', 3, '127.0.0.1'),
(15, 'teste', '2012-12-14 09:14:07', 'Banner "teste" (51) atualizado pelo Usuario "Webjump" (9).', 'Banner', 51, 'edit', 9, 'imagem (img/upload/banners/201212/50cb09dc-bef0-4e97-b5ff-0bd4d182e9d6/imagem.jpg) => (img/upload/banners/201212/50cb09ff-fe7c-48e4-a955-0bd4d182e9d6/imagem.png), data_inicio (2012-12-15 00:00:00) => (2012-12-15 00:00), data_fim (2012-12-16 00:00:00) => (2012-12-16 00:00)', 3, '127.0.0.1'),
(16, 'teste 2', '2012-12-14 09:15:48', 'Banner "teste 2" (52) incluído pelo Usuario "Webjump" (9).', 'Banner', 52, 'add', 9, 'peso () => (2), area () => (atualidades), titulo () => (teste 2), url () => (http://www.google.com), imagem () => (img/upload/banners/201212/50cb0a64-7984-489c-bee4-0bd4d182e9d6/imagem.jpg)', 5, '127.0.0.1'),
(17, 'teste 2', '2012-12-14 09:30:17', 'Banner "teste 2" (52) atualizado pelo Usuario "Webjump" (9).', 'Banner', 52, 'edit', 9, 'imagem (img/upload/banners/201212/50cb0a64-7984-489c-bee4-0bd4d182e9d6/imagem.jpg) => (img/upload/banners/201212/50cb0dc9-4c44-4689-b5b2-0bd4d182e9d6/imagem.jpg)', 1, '127.0.0.1'),
(18, 'teste 2', '2012-12-14 09:32:00', 'Banner "teste 2" (52) atualizado pelo Usuario "Webjump" (9).', 'Banner', 52, 'edit', 9, 'imagem (img/upload/banners/201212/50cb0dc9-4c44-4689-b5b2-0bd4d182e9d6/imagem.jpg) => (img/upload/banners/201212/50cb0e30-f320-480e-ae4a-0bd4d182e9d6/imagem.jpg)', 1, '127.0.0.1'),
(19, 'Aco (46)', '2012-12-14 15:14:30', 'Aco (46) incluído pelo Usuario "Webjump" (9).', 'Aco', 46, 'add', 9, 'parent_id () => (1), alias () => (Vitrines)', 2, '127.0.0.1'),
(20, 'Aco (47)', '2012-12-14 15:14:30', 'Aco (47) incluído pelo Usuario "Webjump" (9).', 'Aco', 47, 'add', 9, 'parent_id () => (46), alias () => (index)', 2, '127.0.0.1'),
(21, 'Aco (48)', '2012-12-14 15:14:31', 'Aco (48) incluído pelo Usuario "Webjump" (9).', 'Aco', 48, 'add', 9, 'parent_id () => (46), alias () => (add)', 2, '127.0.0.1'),
(22, 'Aco (49)', '2012-12-14 15:14:31', 'Aco (49) incluído pelo Usuario "Webjump" (9).', 'Aco', 49, 'add', 9, 'parent_id () => (46), alias () => (edit)', 2, '127.0.0.1'),
(23, 'Aco (50)', '2012-12-14 15:14:32', 'Aco (50) incluído pelo Usuario "Webjump" (9).', 'Aco', 50, 'add', 9, 'parent_id () => (46), alias () => (delete)', 2, '127.0.0.1'),
(24, 'teste', '2012-12-14 15:20:05', 'Vitrine "teste" (6) incluído pelo Usuario "Webjump" (9).', 'Vitrine', 6, 'add', 9, 'peso () => (1), titulo () => (teste), chamada () => (teste), url () => (http://www.google.com), imagem () => (img/upload/vitrines/201212/50cb5fc5-5b44-4754-bf10-0bd4d182e9d6/imagem.png)', 5, '127.0.0.1'),
(25, 'Aco (51)', '2012-12-14 15:43:34', 'Aco (51) incluído pelo Usuario "Webjump" (9).', 'Aco', 51, 'add', 9, 'parent_id () => (1), alias () => (Galerias)', 2, '127.0.0.1'),
(26, 'Aco (52)', '2012-12-14 15:43:35', 'Aco (52) incluído pelo Usuario "Webjump" (9).', 'Aco', 52, 'add', 9, 'parent_id () => (51), alias () => (movedown)', 2, '127.0.0.1'),
(27, 'Aco (53)', '2012-12-14 15:43:36', 'Aco (53) incluído pelo Usuario "Webjump" (9).', 'Aco', 53, 'add', 9, 'parent_id () => (51), alias () => (moveup)', 2, '127.0.0.1'),
(28, 'Aco (54)', '2012-12-14 15:43:36', 'Aco (54) incluído pelo Usuario "Webjump" (9).', 'Aco', 54, 'add', 9, 'parent_id () => (51), alias () => (update_parent)', 2, '127.0.0.1'),
(29, 'Aco (55)', '2012-12-14 15:43:37', 'Aco (55) incluído pelo Usuario "Webjump" (9).', 'Aco', 55, 'add', 9, 'parent_id () => (51), alias () => (index)', 2, '127.0.0.1'),
(30, 'Aco (56)', '2012-12-14 15:43:37', 'Aco (56) incluído pelo Usuario "Webjump" (9).', 'Aco', 56, 'add', 9, 'parent_id () => (51), alias () => (add)', 2, '127.0.0.1'),
(31, 'Aco (57)', '2012-12-14 15:43:37', 'Aco (57) incluído pelo Usuario "Webjump" (9).', 'Aco', 57, 'add', 9, 'parent_id () => (51), alias () => (edit)', 2, '127.0.0.1'),
(32, 'Aco (58)', '2012-12-14 15:43:38', 'Aco (58) incluído pelo Usuario "Webjump" (9).', 'Aco', 58, 'add', 9, 'parent_id () => (51), alias () => (delete)', 2, '127.0.0.1'),
(33, 'Aco (59)', '2012-12-14 15:43:38', 'Aco (59) incluído pelo Usuario "Webjump" (9).', 'Aco', 59, 'add', 9, 'parent_id () => (51), alias () => (autocomplete)', 2, '127.0.0.1'),
(34, 'Aco (60)', '2012-12-14 15:43:39', 'Aco (60) incluído pelo Usuario "Webjump" (9).', 'Aco', 60, 'add', 9, 'parent_id () => (1), alias () => (GaleriaArquivos)', 2, '127.0.0.1'),
(35, 'Aco (61)', '2012-12-14 15:43:39', 'Aco (61) incluído pelo Usuario "Webjump" (9).', 'Aco', 61, 'add', 9, 'parent_id () => (60), alias () => (index)', 2, '127.0.0.1'),
(36, 'Aco (62)', '2012-12-14 15:43:40', 'Aco (62) incluído pelo Usuario "Webjump" (9).', 'Aco', 62, 'add', 9, 'parent_id () => (60), alias () => (add)', 2, '127.0.0.1'),
(37, 'Aco (63)', '2012-12-14 15:43:40', 'Aco (63) incluído pelo Usuario "Webjump" (9).', 'Aco', 63, 'add', 9, 'parent_id () => (60), alias () => (edit)', 2, '127.0.0.1'),
(38, 'Aco (64)', '2012-12-14 15:43:41', 'Aco (64) incluído pelo Usuario "Webjump" (9).', 'Aco', 64, 'add', 9, 'parent_id () => (60), alias () => (delete)', 2, '127.0.0.1'),
(39, 'Aco (65)', '2012-12-14 15:43:41', 'Aco (65) incluído pelo Usuario "Webjump" (9).', 'Aco', 65, 'add', 9, 'parent_id () => (60), alias () => (setposition)', 2, '127.0.0.1'),
(40, 'Aco (66)', '2012-12-14 15:43:41', 'Aco (66) incluído pelo Usuario "Webjump" (9).', 'Aco', 66, 'add', 9, 'parent_id () => (60), alias () => (movedown)', 2, '127.0.0.1'),
(41, 'Aco (67)', '2012-12-14 15:43:42', 'Aco (67) incluído pelo Usuario "Webjump" (9).', 'Aco', 67, 'add', 9, 'parent_id () => (60), alias () => (moveup)', 2, '127.0.0.1'),
(42, 'Aco (68)', '2012-12-14 15:43:43', 'Aco (68) incluído pelo Usuario "Webjump" (9).', 'Aco', 68, 'add', 9, 'parent_id () => (60), alias () => (fixposition)', 2, '127.0.0.1'),
(43, 'Aco (69)', '2012-12-19 14:16:24', 'Aco (69) incluído pelo Usuario "Webjump" (9).', 'Aco', 69, 'add', 9, 'parent_id () => (1), alias () => (Sitemaps)', 2, '127.0.0.1'),
(44, 'Aco (70)', '2012-12-19 14:16:24', 'Aco (70) incluído pelo Usuario "Webjump" (9).', 'Aco', 70, 'add', 9, 'parent_id () => (69), alias () => (movedown)', 2, '127.0.0.1'),
(45, 'Aco (71)', '2012-12-19 14:16:25', 'Aco (71) incluído pelo Usuario "Webjump" (9).', 'Aco', 71, 'add', 9, 'parent_id () => (69), alias () => (moveup)', 2, '127.0.0.1'),
(46, 'Aco (72)', '2012-12-19 14:16:25', 'Aco (72) incluído pelo Usuario "Webjump" (9).', 'Aco', 72, 'add', 9, 'parent_id () => (69), alias () => (update_parent)', 2, '127.0.0.1'),
(47, 'Aco (73)', '2012-12-19 14:16:26', 'Aco (73) incluído pelo Usuario "Webjump" (9).', 'Aco', 73, 'add', 9, 'parent_id () => (69), alias () => (index)', 2, '127.0.0.1'),
(48, 'Aco (74)', '2012-12-19 14:16:26', 'Aco (74) incluído pelo Usuario "Webjump" (9).', 'Aco', 74, 'add', 9, 'parent_id () => (69), alias () => (add)', 2, '127.0.0.1'),
(49, 'Aco (75)', '2012-12-19 14:16:26', 'Aco (75) incluído pelo Usuario "Webjump" (9).', 'Aco', 75, 'add', 9, 'parent_id () => (69), alias () => (edit)', 2, '127.0.0.1'),
(50, 'Aco (76)', '2012-12-19 14:16:27', 'Aco (76) incluído pelo Usuario "Webjump" (9).', 'Aco', 76, 'add', 9, 'parent_id () => (69), alias () => (delete)', 2, '127.0.0.1'),
(51, 'Aco (77)', '2012-12-19 16:38:28', 'Aco (77) incluído pelo Usuario "Webjump" (9).', 'Aco', 77, 'add', 9, 'parent_id () => (1), alias () => (Produtos)', 2, '127.0.0.1'),
(52, 'Aco (78)', '2012-12-19 16:38:28', 'Aco (78) incluído pelo Usuario "Webjump" (9).', 'Aco', 78, 'add', 9, 'parent_id () => (77), alias () => (index)', 2, '127.0.0.1'),
(53, 'Aco (79)', '2012-12-19 16:38:29', 'Aco (79) incluído pelo Usuario "Webjump" (9).', 'Aco', 79, 'add', 9, 'parent_id () => (77), alias () => (add)', 2, '127.0.0.1'),
(54, 'Aco (80)', '2012-12-19 16:38:29', 'Aco (80) incluído pelo Usuario "Webjump" (9).', 'Aco', 80, 'add', 9, 'parent_id () => (77), alias () => (edit)', 2, '127.0.0.1'),
(55, 'Aco (81)', '2012-12-19 16:38:29', 'Aco (81) incluído pelo Usuario "Webjump" (9).', 'Aco', 81, 'add', 9, 'parent_id () => (77), alias () => (delete)', 2, '127.0.0.1'),
(56, 'Aco (82)', '2012-12-19 16:38:30', 'Aco (82) incluído pelo Usuario "Webjump" (9).', 'Aco', 82, 'add', 9, 'parent_id () => (1), alias () => (ProdutoCategorias)', 2, '127.0.0.1'),
(57, 'Aco (83)', '2012-12-19 16:38:30', 'Aco (83) incluído pelo Usuario "Webjump" (9).', 'Aco', 83, 'add', 9, 'parent_id () => (82), alias () => (movedown)', 2, '127.0.0.1'),
(58, 'Aco (84)', '2012-12-19 16:38:31', 'Aco (84) incluído pelo Usuario "Webjump" (9).', 'Aco', 84, 'add', 9, 'parent_id () => (82), alias () => (moveup)', 2, '127.0.0.1'),
(59, 'Aco (85)', '2012-12-19 16:38:31', 'Aco (85) incluído pelo Usuario "Webjump" (9).', 'Aco', 85, 'add', 9, 'parent_id () => (82), alias () => (update_parent)', 2, '127.0.0.1'),
(60, 'Aco (86)', '2012-12-19 16:38:32', 'Aco (86) incluído pelo Usuario "Webjump" (9).', 'Aco', 86, 'add', 9, 'parent_id () => (82), alias () => (index)', 2, '127.0.0.1'),
(61, 'Aco (87)', '2012-12-19 16:38:32', 'Aco (87) incluído pelo Usuario "Webjump" (9).', 'Aco', 87, 'add', 9, 'parent_id () => (82), alias () => (add)', 2, '127.0.0.1'),
(62, 'Aco (88)', '2012-12-19 16:38:32', 'Aco (88) incluído pelo Usuario "Webjump" (9).', 'Aco', 88, 'add', 9, 'parent_id () => (82), alias () => (edit)', 2, '127.0.0.1'),
(63, 'Aco (89)', '2012-12-19 16:38:33', 'Aco (89) incluído pelo Usuario "Webjump" (9).', 'Aco', 89, 'add', 9, 'parent_id () => (82), alias () => (delete)', 2, '127.0.0.1'),
(64, 'teste', '2012-12-20 09:25:16', 'Produto "teste" (4) incluído pelo Usuario "Webjump" (9).', 'Produto', 4, 'add', 9, 'status () => (ativo), nome () => (teste), descricao () => (teste), imagem_1 () => (img/upload/produtos/201212/50d2f59c-1274-439e-aac2-0810d182e9d6/imagem_1.jpg), friendly_url () => (teste)', 5, '127.0.0.1'),
(65, 'Aco (77)', '2012-12-20 11:17:05', 'Aco (77) removido pelo Sistema.', 'Aco', 77, 'delete', NULL, NULL, NULL, NULL),
(66, 'Aco (82)', '2012-12-20 11:17:05', 'Aco (82) removido pelo Sistema.', 'Aco', 82, 'delete', NULL, NULL, NULL, NULL),
(67, 'Aco (90)', '2012-12-20 11:32:35', 'Aco (90) incluído pelo Usuario "Webjump" (9).', 'Aco', 90, 'add', 9, 'parent_id () => (1), alias () => (Noticias)', 2, '127.0.0.1'),
(68, 'Aco (91)', '2012-12-20 11:32:36', 'Aco (91) incluído pelo Usuario "Webjump" (9).', 'Aco', 91, 'add', 9, 'parent_id () => (90), alias () => (index)', 2, '127.0.0.1'),
(69, 'Aco (92)', '2012-12-20 11:32:36', 'Aco (92) incluído pelo Usuario "Webjump" (9).', 'Aco', 92, 'add', 9, 'parent_id () => (90), alias () => (add)', 2, '127.0.0.1'),
(70, 'Aco (93)', '2012-12-20 11:32:37', 'Aco (93) incluído pelo Usuario "Webjump" (9).', 'Aco', 93, 'add', 9, 'parent_id () => (90), alias () => (edit)', 2, '127.0.0.1'),
(71, 'Aco (94)', '2012-12-20 11:32:37', 'Aco (94) incluído pelo Usuario "Webjump" (9).', 'Aco', 94, 'add', 9, 'parent_id () => (90), alias () => (delete)', 2, '127.0.0.1'),
(72, 'Aco (95)', '2012-12-20 11:32:38', 'Aco (95) incluído pelo Usuario "Webjump" (9).', 'Aco', 95, 'add', 9, 'parent_id () => (90), alias () => (autocomplete)', 2, '127.0.0.1'),
(73, 'Aco (96)', '2012-12-20 12:04:46', 'Aco (96) incluído pelo Usuario "Webjump" (9).', 'Aco', 96, 'add', 9, 'parent_id () => (1), alias () => (Videos)', 2, '127.0.0.1'),
(74, 'Aco (97)', '2012-12-20 12:04:46', 'Aco (97) incluído pelo Usuario "Webjump" (9).', 'Aco', 97, 'add', 9, 'parent_id () => (96), alias () => (index)', 2, '127.0.0.1'),
(75, 'Aco (98)', '2012-12-20 12:04:47', 'Aco (98) incluído pelo Usuario "Webjump" (9).', 'Aco', 98, 'add', 9, 'parent_id () => (96), alias () => (add)', 2, '127.0.0.1'),
(76, 'Aco (99)', '2012-12-20 12:04:47', 'Aco (99) incluído pelo Usuario "Webjump" (9).', 'Aco', 99, 'add', 9, 'parent_id () => (96), alias () => (edit)', 2, '127.0.0.1'),
(77, 'Aco (100)', '2012-12-20 12:04:48', 'Aco (100) incluído pelo Usuario "Webjump" (9).', 'Aco', 100, 'add', 9, 'parent_id () => (96), alias () => (delete)', 2, '127.0.0.1'),
(78, 'Aco (101)', '2012-12-20 12:04:48', 'Aco (101) incluído pelo Usuario "Webjump" (9).', 'Aco', 101, 'add', 9, 'parent_id () => (96), alias () => (autocomplete)', 2, '127.0.0.1'),
(79, 'titulo', '2012-12-20 13:31:44', 'Noticia "titulo" (1) incluído pelo Usuario "Webjump" (9).', 'Noticia', 1, 'add', 9, 'tipo () => (noticia), data_noticia () => (2012-12-20 13:30), status () => (rascunho), usuario_id () => (9), categoria () => (noticia), titulo () => (titulo), olho () => (olho), image_align () => (left), image_legenda () => (legenda), conteudo_preview () => (preview), conteudo () => (noticia), image () => (img/upload/noticias/201212/50d32f60-28ac-4477-b3ce-0810d182e9d6/image.jpg), friendly_url () => (titulo), created () => (2012-12-20 13:31:44)', 14, '127.0.0.1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_noticias`
--

CREATE TABLE IF NOT EXISTS `site_noticias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `friendly_url` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `data_noticia` datetime DEFAULT NULL,
  `tipo` varchar(16) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `olho` text,
  `conteudo_preview` text,
  `conteudo` text,
  `usuario_id` int(10) unsigned DEFAULT NULL,
  `status` enum('rascunho','em_aprovacao','aprovada') DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_align` enum('left','center','right') DEFAULT NULL,
  `image_legenda` varchar(100) DEFAULT NULL,
  `categoria` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `fk_noticias_usuario` (`usuario_id`),
  KEY `friendly_url` (`friendly_url`),
  KEY `tipo` (`tipo`(1))
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_noticias`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `site_noticias_galerias`
--

CREATE TABLE IF NOT EXISTS `site_noticias_galerias` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `galeria_id` int(10) DEFAULT NULL,
  `noticia_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `galeria_id` (`galeria_id`),
  UNIQUE KEY `noticia_id` (`noticia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_noticias_galerias`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `site_noticias_noticias`
--

CREATE TABLE IF NOT EXISTS `site_noticias_noticias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `noticia_id` int(10) unsigned DEFAULT NULL,
  `related_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `noticia_id` (`noticia_id`),
  KEY `related_id` (`related_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_noticias_noticias`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `site_noticias_videos`
--

CREATE TABLE IF NOT EXISTS `site_noticias_videos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `video_id` int(10) DEFAULT NULL,
  `noticia_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `video_id` (`video_id`),
  UNIQUE KEY `noticias_id` (`noticia_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_noticias_videos`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `site_paginas`
--

CREATE TABLE IF NOT EXISTS `site_paginas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `friendly_url` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `texto_aspas` text,
  `conteudo` text,
  `image` varchar(255) DEFAULT NULL,
  `image_align` enum('left','center','right') DEFAULT NULL,
  `image_legenda` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `friendly_url` (`friendly_url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_paginas`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `site_sitemaps`
--

CREATE TABLE IF NOT EXISTS `site_sitemaps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `friendly_url` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `show_header` tinyint(1) NOT NULL,
  `show_footer` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_friendly_url` (`parent_id`,`friendly_url`),
  KEY `parent_id` (`parent_id`),
  KEY `friendly_url` (`friendly_url`),
  KEY `lft` (`lft`),
  KEY `rght` (`rght`),
  KEY `show_footer` (`show_footer`),
  KEY `route` (`route`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `site_sitemaps`
--

INSERT INTO `site_sitemaps` (`id`, `parent_id`, `lft`, `rght`, `label`, `friendly_url`, `route`, `show_header`, `show_footer`, `status`) VALUES
(1, NULL, 1, 2, 'quem somos', 'quem-somos', '', 1, 0, 1),
(2, NULL, 13, 14, 'como funciona', 'como-funciona', 'pages/como-funciona', 1, 0, 1),
(3, NULL, 3, 4, 'como participar', 'como-participar', 'pages/como-participar', 1, 0, 1),
(4, NULL, 9, 10, 'dúvidas', 'duvidas', 'duvidas', 1, 1, 1),
(5, NULL, 7, 8, 'localização', 'localizacao', 'pages/localizacao', 1, 0, 1),
(6, NULL, 15, 16, 'contato', 'contato', 'form_contatos', 1, 1, 1),
(7, NULL, 5, 6, 'POLÍTICA DE PRIVACIDADE', 'politica-de-privacidade', '', 0, 1, 1),
(8, NULL, 11, 12, 'TERMOS DE USO', 'termos-de-uso', '', 0, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_usuarios`
--

CREATE TABLE IF NOT EXISTS `site_usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `senha` char(32) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `apelido` varchar(45) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `grupo_id` tinyint(2) unsigned DEFAULT NULL,
  `api_key` char(36) DEFAULT NULL,
  `uid` char(32) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `password_create` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `api_key` (`api_key`),
  KEY `senha` (`senha`),
  KEY `status` (`status`),
  KEY `fk_usuario_grupo` (`grupo_id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `site_usuarios`
--

INSERT INTO `site_usuarios` (`id`, `email`, `senha`, `nome`, `apelido`, `status`, `grupo_id`, `api_key`, `uid`, `created`, `modified`, `password_create`) VALUES
(9, 'desenvolvimento@webjump.com.br', '72e649e5be1d6526cab9d1cfb571f072', 'Webjump Informática', 'Webjump', '1', 1, '50815f12-f388-4fe2-8d70-3e98d182e9d6', NULL, '2012-10-19 11:09:22', '2012-12-11 17:16:26', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_videos`
--

CREATE TABLE IF NOT EXISTS `site_videos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `hora` varchar(16) DEFAULT NULL,
  `tipo` set('promocoes') DEFAULT NULL,
  `friendly_url` varchar(255) NOT NULL DEFAULT '',
  `destaque` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `feriado` tinyint(1) unsigned DEFAULT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descricao_preview` text,
  `descricao` text,
  `imagens_edicao` text NOT NULL,
  `trilha` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_legenda` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `embed` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `tipo` (`tipo`),
  KEY `data` (`data`),
  KEY `data_fim` (`data_fim`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_videos`
--


-- --------------------------------------------------------

--
-- Estrutura da tabela `site_vitrines`
--

CREATE TABLE IF NOT EXISTS `site_vitrines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) DEFAULT NULL,
  `chamada` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `peso` decimal(2,0) unsigned DEFAULT NULL,
  `data_inicio` datetime DEFAULT NULL,
  `data_fim` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `data` (`data_inicio`,`data_fim`),
  KEY `data_inicio` (`data_inicio`),
  KEY `data_fim` (`data_fim`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Extraindo dados da tabela `site_vitrines`
--


--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `site_usuarios`
--
ALTER TABLE `site_usuarios`
  ADD CONSTRAINT `fk_usuario_grupo` FOREIGN KEY (`grupo_id`) REFERENCES `site_grupos` (`id`) ON UPDATE CASCADE;
