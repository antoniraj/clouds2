CREATE TABLE `ya_testportions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `classid` int(11) unsigned NOT NULL,
  `subjectid` int(11) unsigned NOT NULL,
  `subjectcode` CHAR(10) NOT NULL,
  `cdate`	DATE, 
  `testportion` VARCHAR(200) NULL,
  PRIMARY KEY (`id`),
  INDEX (`classid`),
  INDEX (`subjectid`),
  FOREIGN KEY (`classid`) REFERENCES `ya_courses` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`subjectid`) REFERENCES `ya_msubjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
