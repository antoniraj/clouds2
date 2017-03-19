CREATE TABLE `ya_groupfeecategory` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fcid` int(11) unsigned NOT NULL,
  `gid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`fcid`,`gid`),
  INDEX(`fcid`),
  INDEX (`gid`),
  FOREIGN KEY (`fcid`) REFERENCES `ya_feecategory` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`gid`) REFERENCES `ya_studentgroups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
