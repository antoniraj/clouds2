CREATE TABLE `ya_groupfeeconcession` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `studentid` int(11) unsigned NOT NULL,
  `fcid` int(11) unsigned NOT NULL,
  `gid` int(11) unsigned NOT NULL,
  `amount` decimal(7,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX (`fcid`,`gid`),
  INDEX (`studentid`),
  FOREIGN KEY (`fcid`, `gid`) REFERENCES `ya_groupfeecategory` (`fcid`, `gid`) ON DELETE CASCADE,
  FOREIGN KEY (`studentid`) REFERENCES `ya_students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
