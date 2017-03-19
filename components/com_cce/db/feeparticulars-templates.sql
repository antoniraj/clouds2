CREATE TABLE `ya_feecategory_t` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `aid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`aid`),
  FOREIGN KEY (`aid`) REFERENCES `ya_academicyears` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE `ya_feeparticulars_t` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` char(10) NOT NULL,
  `amount` decimal(7,2) NOT NULL,
  `fcid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  INDEX(`fcid`),
  FOREIGN KEY (`fcid`) REFERENCES `ya_feecategory_t` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;
