CREATE TABLE ya_departmentcourses(
  `departmentid` int(11) unsigned NOT NULL,
  `courseid` int(11) unsigned NOT NULL,
  INDEX (`departmentid`),
  INDEX (`courseid`),
  UNIQUE(courseid),
  FOREIGN KEY (`departmentid`) REFERENCES `ya_staffdepartments` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`courseid`) REFERENCES `ya_courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
