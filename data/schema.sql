CREATE TABLE `ecommerce_vouchers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL,
  `uses_left` int(11) DEFAULT '1' COMMENT 'never allow infinite uses',
  `expires` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
