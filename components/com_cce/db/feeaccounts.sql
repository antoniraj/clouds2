CREATE TABLE `ya_feeaccounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` CHAR(50) NOT NULL,
  `code` CHAR(10) NOT NULL,
  `aid` INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`aid`),
  UNIQUE KEY (`code`,`aid`),
  FOREIGN KEY (`aid`) REFERENCES `ya_academicyears` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
