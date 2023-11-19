CREATE TABLE `no_index` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `code1` varchar(8) NOT NULL,
  `code2` varchar(8) NOT NULL,
  `code3` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `index_1` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `code1` varchar(8) NOT NULL,
  `code2` varchar(8) NOT NULL,
  `code3` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code1` (`code1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `index_2` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `code1` varchar(8) NOT NULL,
  `code2` varchar(8) NOT NULL,
  `code3` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code1` (`code1`),
  KEY `code2` (`code2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `index_3` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `code1` varchar(8) NOT NULL,
  `code2` varchar(8) NOT NULL,
  `code3` varchar(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code1` (`code1`),
  KEY `code2` (`code2`),
  KEY `code3` (`code3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;