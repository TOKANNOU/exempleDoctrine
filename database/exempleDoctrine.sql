-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           10.5.8-MariaDB - mariadb.org binary distribution
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour exempledoctrine
CREATE DATABASE IF NOT EXISTS `exempledoctrine` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `exempledoctrine`;

-- Listage de la structure de la table exempledoctrine. products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `quantity_per_unit` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` decimal(10,4) DEFAULT NULL,
  `units_in_stock` smallint(6) DEFAULT NULL,
  `units_on_order` smallint(6) DEFAULT NULL,
  `reorder_level` smallint(6) DEFAULT NULL,
  `discontinued` tinyint(1) NOT NULL,
  `supplier_id_id` int(11) DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B3BA5A5AA65F9C7D` (`supplier_id_id`),
  CONSTRAINT `FK_B3BA5A5AA65F9C7D` FOREIGN KEY (`supplier_id_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table exempledoctrine.products : ~14 rows (environ)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `product_name`, `category_id`, `quantity_per_unit`, `unit_price`, `units_in_stock`, `units_on_order`, `reorder_level`, `discontinued`, `supplier_id_id`, `picture`) VALUES
	(1, 'Guitare classique EM-08', 1, 'ererez', 18.5000, 2, 3, 1, 1, 3, '1.png'),
	(2, 'Batterie ER-6', 2, 'ezrzer', 25.0000, 2, 3, 3, 1, 5, '2.png'),
	(3, 'Piano EM-58', 2, 'zeezrfez', 789.0000, 2, 1, 1, 0, 3, '3.png'),
	(4, 'Câble CY-85', 1, 'zerez', 89.0000, 1, 1, 0, 1, 4, '4.png'),
	(6, 'Guitare classique GR-8', 3, 'ezrzerr', 89.5000, 6, 3, 1, 0, 5, '6.png'),
	(7, 'Guitare classique GC-2', 1, 'erre', 19.5000, 1, 1, 1, 0, 4, '7.png'),
	(8, 'Sono Alter Royal IMx', 1, 'zerf', 25.0000, 1, 1, 1, 1, 3, '8.png'),
	(9, 'Sono R-7', 1, 'ezraff', 89.0000, 1, 1, 1, 0, 5, '9.png'),
	(10, 'Micr SF DRGi', 1, 'zaGEZEHTR', 36.0000, 1, 2, 2, 0, 3, '10.png'),
	(11, 'Accessoires électroniques', 1, 'HFYGJ', 89.0000, 1, 1, 0, 0, 5, '11.png'),
	(12, 'Saxophone IM-03G', 1, 'rtehht', 48.0000, 1, 1, 1, 0, 4, '12.png'),
	(13, 'TAR-SOUL DG12', 1, 'fqzeev', 15.0000, 1, 1, 1, 0, 4, '13.png'),
	(14, 'Caisson Full HR pi64', 1, 'ezfezf', 85.0000, 1, 1, 1, 0, 3, '14.png'),
	(16, 'Guitare classique IM-30', 1, 'rer ezre', 58.9900, 7, 1, 1, 0, 5, '16.png');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Listage de la structure de la table exempledoctrine. suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_title` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_page` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table exempledoctrine.suppliers : ~4 rows (environ)
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` (`id`, `company_name`, `contact_name`, `contact_title`, `address`, `city`, `region`, `postal_code`, `country`, `phone`, `fax`, `home_page`) VALUES
	(3, 'Amazon', 'John Marc', 'Pourchasing Manager', '25 rue Porc-épic', 'Amiens', 'Picardie', '80000', 'France', '0785694896', '+(33)0785694896', 'Lorem ipsum'),
	(4, 'AliExpress', 'Jean Dupont', 'Pourchasing Manager', '59 avenue du paradis', 'Paris', 'Îles-de-France', '70010', 'France', '+(33)798685278', '+(33)798685278', 'Lorem ipsum'),
	(5, 'Cdiscount', 'Marie Dupont', 'Pourchasing Manager', '36 avenue du Général Régis', 'Paris', 'Îles-de-France', '70018', 'France', '+(33)728686270', '+(33)728686270', 'Lorem ipsum');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
