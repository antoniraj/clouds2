
DROP TABLE IF EXISTS ya_ex_studentmarks;
DROP TABLE IF EXISTS ya_ex_gradebookentries;
DROP TABLE IF EXISTS ya_ex_t_subjecttermgradebook;
DROP TABLE IF EXISTS ya_ex_t_subjectgradingsystem;
DROP TABLE IF EXISTS ya_ex_t_subtotals;
DROP TABLE IF EXISTS ya_ex_t_gradebookentries;
DROP TABLE IF EXISTS ya_ex_t_gradebooks;
DROP TABLE IF EXISTS ya_ex_t_gradingsystementries;
DROP TABLE IF EXISTS ya_ex_t_gradingsystems;
DROP TABLE IF EXISTS ya_ex_t_terms;
DROP TABLE IF EXISTS ya_ex_tsubjects;
DROP TABLE IF EXISTS ya_ex_t_parts;
DROP TABLE IF EXISTS ya_ex_t_coursebookcourses ;
DROP TABLE IF EXISTS ya_ex_t_coursebooks;


 CREATE TABLE `ya_ex_t_coursebooks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL,
  `aid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`aid`),
  FOREIGN KEY (`aid`) REFERENCES `ya_academicyears` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


 CREATE TABLE `ya_ex_t_coursebookcourses` (
  `cbid` int(11) unsigned NOT NULL,
  `courseid` int(11) unsigned NOT NULL,
  UNIQUE KEY `courseid` (`courseid`),
  KEY (`cbid`),
  KEY (`courseid`),
  FOREIGN KEY (`cbid`) REFERENCES `ya_ex_t_coursebooks` (`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`courseid`) REFERENCES `ya_courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `ya_ex_t_parts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL,
  `code` char(10) DEFAULT NULL,
  `gpa` int(11) DEFAULT NULL,
  `gs` int(11) DEFAULT NULL,
  `gsno` int(11) DEFAULT NULL,
  `academic` int(11) NOT NULL,
  `cbid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`cbid`),
  FOREIGN KEY (`cbid`) REFERENCES `ya_ex_t_coursebooks` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;




CREATE TABLE `ya_ex_tsubjects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `subjecttitle` char(80) NOT NULL,
  `subjectcode` char(15) NOT NULL,
  `acronym` char(10) NOT NULL,
  `credits` int(11) NOT NULL,
  `passmark` decimal(5,2) NOT NULL,
  `marks` decimal(5,2) NOT NULL,
  `grouptag` char(5) DEFAULT NULL,
  `subjecttype` char(15) NOT NULL DEFAULT 'Theory',
  `sessionduration` int(11) DEFAULT '1',
  `partid` int(11) unsigned NOT NULL,
  `parentid` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY (`partid`),
  KEY (`parentid`),
  FOREIGN KEY (`partid`) REFERENCES `ya_ex_t_parts` (`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`parentid`) REFERENCES `ya_ex_tsubjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



 CREATE TABLE `ya_ex_t_terms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `term` char(9) NOT NULL,
  `months` char(7) NOT NULL,
  `code` char(5) NOT NULL,
  `startdate` date NOT NULL,
  `stopdate` date NOT NULL,
  `partid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`partid`),
  FOREIGN KEY (`partid`) REFERENCES `ya_ex_t_parts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


 CREATE TABLE `ya_ex_t_gradingsystems` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `aid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`aid`),
  FOREIGN KEY (`aid`) REFERENCES `ya_academicyears` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


 
 CREATE TABLE `ya_ex_t_gradingsystementries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from` decimal(4,1) NOT NULL,
  `to` decimal(4,1) NOT NULL,
  `letter` char(5) NOT NULL,
  `points` decimal(3,1) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `gsid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`gsid`),
  FOREIGN KEY (`gsid`) REFERENCES `ya_ex_t_gradingsystems` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ;




CREATE TABLE `ya_ex_t_gradebooks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL,
  `aid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`aid`),
  FOREIGN KEY (`aid`) REFERENCES `ya_academicyears` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


 CREATE TABLE `ya_ex_t_gradebookentries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL,
  `code` char(10) NOT NULL,
  `weightage` int(11) NOT NULL,
  `bestof` int(11) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `grouptag` char(5) NOT NULL,
  `gsno` int(11) NOT NULL,
  `duedate` date DEFAULT NULL,
  `required` INT(11) unsigned NOT NULL DEFAULT 1,
  `parentid` int(11) unsigned DEFAULT NULL,
  `gid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY (`gid`),
  KEY (`parentid`),
  FOREIGN KEY (`gid`) REFERENCES `ya_ex_t_gradebooks` (`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`parentid`) REFERENCES `ya_ex_t_gradebookentries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



CREATE TABLE `ya_ex_t_subjecttermgradebook` (
  `subjectid` int(11) unsigned NOT NULL,
  `termid`   int(11) unsigned NOT NULL,
  `gbid`    int(11) unsigned NOT NULL,
  PRIMARY KEY(`subjectid`,`termid`),
  INDEX(`gbid`), 
  FOREIGN KEY (`subjectid`) REFERENCES `ya_ex_tsubjects` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`termid`) REFERENCES `ya_ex_t_terms` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`gbid`) REFERENCES `ya_ex_t_gradebooks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



CREATE TABLE `ya_ex_t_subjectgradingsystem` (
  `subjectid` int(11) unsigned NOT NULL,
  `gsid`    int(11) unsigned NOT NULL,
  INDEX(`subjectid`),
  INDEX(`gsid`),
  UNIQUE(`subjectid`),
  FOREIGN KEY (`subjectid`) REFERENCES `ya_ex_tsubjects` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`gsid`) REFERENCES `ya_ex_t_gradingsystems` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;







 CREATE TABLE `ya_ex_gradebookentries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(80) NOT NULL,
  `code` char(10) NOT NULL,
  `weightage` int(11) NOT NULL,
  `bestof` int(11) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `grouptag` char(5) NOT NULL,
  `gsno` int(11) NOT NULL,
  `duedate` date DEFAULT NULL,
  `parentid` int(11) unsigned DEFAULT NULL,
  `required` INT(11) unsigned NOT NULL DEFAULT 1,
  `classid` int(11) unsigned NOT NULL,
  `subjectid` int(11) unsigned NOT NULL,
  `termid` int(11) unsigned NOT NULL,
  `tgradebookid` int(11) unsigned NULL,
   UNIQUE(classid,subjectid,termid,tgradebookid),
  PRIMARY KEY (`id`),
  KEY (`parentid`),
  KEY (`classid`),
  INDEX (`subjectid`,`termid`),
  KEY (`tgradebookid`),
  FOREIGN KEY (`classid`) REFERENCES `ya_courses` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`subjectid`,`termid`) REFERENCES `ya_ex_t_subjecttermgradebook` (`subjectid`,`termid`) ON DELETE CASCADE,
  FOREIGN KEY (`parentid`) REFERENCES `ya_ex_gradebookentries` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tgradebookid`) REFERENCES `ya_ex_t_gradebookentries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



 CREATE TABLE `ya_ex_studentmarks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gbid` int(11) unsigned NOT NULL,
  `studentid` int(11) unsigned NOT NULL,
  `marks` decimal(5,2) NOT NULL,
  `comments` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  UNIQUE(gbid,studentid),
  KEY (`gbid`),
  KEY (`studentid`),
  FOREIGN KEY (`gbid`) REFERENCES `ya_ex_gradebookentries` (`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`studentid`) REFERENCES `ya_students` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


 CREATE TABLE `ya_ex_t_subtotals` (
  `gbid` int(11) unsigned NOT NULL,
  `sgbid` int(11) unsigned NOT NULL,
  KEY `gbid` (`gbid`),
  KEY `sgbid` (`sgbid`),
  FOREIGN KEY (`gbid`) REFERENCES `ya_ex_t_gradebookentries` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`sgbid`) REFERENCES `ya_ex_t_gradebookentries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


 CREATE TABLE `ya_ex_t_summary` (
  `id` 		int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title`	CHAR(80) NOT NULL,
  `code`	CHAR(10) NOT NULL,
  `summarytype`	INT(1) NOT NULL,
  `subjectid` int(11) unsigned NOT NULL,
   PRIMARY KEY (`id`),
  FOREIGN KEY (`subjectid`) REFERENCES `ya_ex_tsubjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `ya_ex_t_summarycols`(
	`summaryid`	INT(11) UNSIGNED NOT NULL,
	`gbeid`		INT(11) UNSIGNED NOT NULL,
  	FOREIGN KEY (`gbeid`) REFERENCES `ya_ex_t_gradebookentries` (`id`) ON DELETE CASCADE,
  	FOREIGN KEY (`summaryid`) REFERENCES `ya_ex_t_summary` (`id`) ON DELETE CASCADE,
	UNIQUE(`summaryid`,`gbeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
	
