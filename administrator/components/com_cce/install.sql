DROP TABLE IF EXISTS `#__reminders`;
DROP TABLE IF EXISTS `#__feediscounts`;
DROP TABLE IF EXISTS `#__coursefeecategory`;
DROP TABLE IF EXISTS `#__feeparticulars`;
DROP TABLE IF EXISTS `#__feecategory`;
DROP TABLE IF EXISTS `#__timetable`;
DROP TABLE IF EXISTS `#__officedesk`;
DROP TABLE IF EXISTS `#__days`;
DROP TABLE IF EXISTS `#__daycourses`;
DROP TABLE IF EXISTS `#__daycategory`;
DROP TABLE IF EXISTS `#__sessiontimings`;
DROP TABLE IF EXISTS `#__coursesessions`;
DROP TABLE IF EXISTS `#__timetableterms`;
DROP TABLE IF EXISTS `#__sessiontypes`;
DROP TABLE IF EXISTS `#__studentsphoto`;
DROP TABLE IF EXISTS `#__staffphoto`;
DROP TABLE IF EXISTS `#__staffleave`;
DROP TABLE IF EXISTS `#__staffattendance`;
DROP TABLE IF EXISTS `#__classattendance`;
DROP TABLE IF EXISTS `#__nmarks`;
DROP TABLE IF EXISTS `#__classleave`;
DROP TABLE IF EXISTS `#__lsmarks`;
DROP TABLE IF EXISTS `#__avmarks`;
DROP TABLE IF EXISTS `#__cosamarks`;
DROP TABLE IF EXISTS `#__cosbmarks`;
DROP TABLE IF EXISTS `#__coscholasticamarksmarks`;
DROP TABLE IF EXISTS `#__coscholasticbmarksmarks`;
DROP TABLE IF EXISTS `#__attitudeandvaluesmarks`;
DROP TABLE IF EXISTS `#__studentsmsstatuslog`;
DROP TABLE IF EXISTS `#__staffsmsstatuslog`;
DROP TABLE IF EXISTS `#__studentsmslog`;
DROP TABLE IF EXISTS `#__staffsmslog`;
DROP TABLE IF EXISTS `#__scholasticbgrades`;
DROP TABLE IF EXISTS `#__scholasticamarks`;
DROP TABLE IF EXISTS `#__scholasticagrades`;
DROP TABLE IF EXISTS `#__sagrades`;
DROP TABLE IF EXISTS `#__fagrades`;
DROP TABLE IF EXISTS `#__normalgrades`;
DROP TABLE IF EXISTS `#__coscholasticbactivities`;
DROP TABLE IF EXISTS `#__coscholasticaactivities`;
DROP TABLE IF EXISTS `#__attitudesandvalues`;
DROP TABLE IF EXISTS `#__lsactivities`;
DROP TABLE IF EXISTS `#__faactivities`;
DROP TABLE IF EXISTS `#__classteachers`;
DROP TABLE IF EXISTS `#__staffpositions`;
DROP TABLE IF EXISTS `#__staffgrades`;
DROP TABLE IF EXISTS `#__staffcategories`;
DROP TABLE IF EXISTS `#__staffdepartments`;
DROP TABLE IF EXISTS `#__studentclass`;
DROP TABLE IF EXISTS `#__groupmembers`;
DROP TABLE IF EXISTS `#__studentgroups`;
DROP TABLE IF EXISTS `#__tgradebookentries`;
DROP TABLE IF EXISTS `#__tgradebook`;
DROP TABLE IF EXISTS `#__tngradebook`;
DROP TABLE IF EXISTS `#__ngradebook`;
DROP TABLE IF EXISTS `#__scholasticacategorydetails`;
DROP TABLE IF EXISTS `#__students`;
DROP TABLE IF EXISTS `#__studentcategories`;
DROP TABLE IF EXISTS `#__scholasticacategories`;
DROP TABLE IF EXISTS `#__countries`;
DROP TABLE IF EXISTS `#__subjectteachers`;
DROP TABLE IF EXISTS `#__coursesubjects`;
DROP TABLE IF EXISTS `#__subjects`;
DROP TABLE IF EXISTS `#__msubjects`;
DROP TABLE IF EXISTS `#__courses`;
DROP TABLE IF EXISTS `#__terms`;
DROP TABLE IF EXISTS `#__academicyears`;

DROP TABLE IF EXISTS `#__schooltopnews`;
DROP TABLE IF EXISTS `#__schoolsidebarnews`;
DROP TABLE IF EXISTS `#__schoolcal`;


-- INSERT INTO #__viewlevels(id,title) VALUES(100,'Principal');
-- INSERT INTO #__viewlevels(id,title) VALUES(101,'Teacher');
-- INSERT INTO #__viewlevels(id,title) VALUES(102,'Office');
-- INSERT INTO #__viewlevels(id,title) VALUES(103,'Student');

-- INSERT INTO #__usergroups(id,parent_id,lft,rgt,title) VALUES(100,2,19,20,'Principal');
-- INSERT INTO #__usergroups(id,parent_id,lft,rgt,title) VALUES(101,2,23,24,'Teacher');
-- INSERT INTO #__usergroups(id,parent_id,lft,rgt,title) VALUES(102,2,21,22,'Student');
-- INSERT INTO #__usergroups(id,parent_id,lft,rgt,title) VALUES(103,2,17,18,'Office');

-- INSERT INTO #__users (id,name,username,email,password,usertype,activation) VALUES(500,'Principal','principal','principal@gmail.com','ea810a8f6584edb13d4787bc7f620caa:JwjtVWsvLFVPI7VMoignWDgADPqDz6ia','','{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}');
-- INSERT INTO #__users (id,name,username,email,password,usertype,activation) VALUES(501,'Teacher','teacher','teacher@gmail.com','ea810a8f6584edb13d4787bc7f620caa:JwjtVWsvLFVPI7VMoignWDgADPqDz6ia','','{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}');
-- INSERT INTO #__users (id,name,username,email,password,usertype,activation) VALUES(502,'Student','Student','student@gmail.com','ea810a8f6584edb13d4787bc7f620caa:JwjtVWsvLFVPI7VMoignWDgADPqDz6ia','','{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}');
-- INSERT INTO #__users (id,name,username,email,password,usertype,activation) VALUES(503,'Office','office','office@gmail.com','ea810a8f6584edb13d4787bc7f620caa:JwjtVWsvLFVPI7VMoignWDgADPqDz6ia','','{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}');

-- INSERT INTO #__user_usergroup_map(user_id,group_id) VALUES(500,100);
-- INSERT INTO #__user_usergroup_map(user_id,group_id) VALUES(501,101);
-- INSERT INTO #__user_usergroup_map(user_id,group_id) VALUES(502,102);
-- INSERT INTO #__user_usergroup_map(user_id,group_id) VALUES(503,103);



CREATE TABLE `#__academicyears` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `academicyear` char(9) NOT NULL,
  `startdate` DATE NULL,
  `stopdate` DATE NULL,
  `status` CHAR(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
 

INSERT INTO `#__academicyears` (`academicyear`,`status`) VALUES ('2012-2013','Y'), ('2011-2012','N'), ('2010-2011','N');

CREATE TABLE `#__studentsmslog` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `smstext` varchar(161) NOT NULL,
  `smstype` varchar(30) NOT NULL,
  `smsdate` DATE NOT NULL,
  `smstime` CHAR(8) NOT NULL,
  `sentby` varchar(50) NOT NULL,
  `sentto` CHAR(30) NULL,
  `sids` TEXT NULL,
  `status` CHAR(1) NOT NULL, 
  `aid`	 INT(11) unsigned NOT NULL,
  INDEX `aid_ind`(`aid`),
  FOREIGN KEY (`aid`) REFERENCES `#__academicyears`(`id`) ON DELETE CASCADE,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__staffsmslog` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `smstext` varchar(161) NOT NULL,
  `smstype` varchar(30) NOT NULL,
  `smsdate` DATE NOT NULL,
  `smstime` CHAR(8) NOT NULL,
  `sentby` varchar(50) NOT NULL,
  `sentto` varchar(2000) NULL,
  `status` CHAR(1) NOT NULL,
  `aid`	 INT(11) unsigned NOT NULL,
  INDEX `aid_ind`(`aid`),
  FOREIGN KEY (`aid`) REFERENCES `#__academicyears`(`id`) ON DELETE CASCADE,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__schooltopnews` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `newstext` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
 
CREATE TABLE `#__schoolsidebarnews` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `newstext1` varchar(255) NOT NULL,
  `newstext2` varchar(255) NOT NULL,
  `newstext3` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;




 
CREATE TABLE `#__terms` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `term` char(9) NOT NULL,
  `months` CHAR(7) Not null,
  `code` CHAR(5) NOT NULL,
  `startdate` DATE NOT NULL,
  `stopdate` DATE NOT NULL,
  PRIMARY KEY  (`id`),
  `aid`	 INT(11) unsigned NOT NULL,
  INDEX `aid_ind`(`aid`),
  FOREIGN KEY (`aid`) REFERENCES `#__academicyears`(`id`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
 
INSERT INTO `#__terms` (`term`,`months`,`code`,`startdate`,`stopdate`,`aid`) VALUES ('Term-1','JUN-AUG','T1','2012-01-01','2012-08-01',1), ('Term-2','SEP-NOV','T2','2012-09-01','2012-11-30',1), ('Term-3','JAN-MAR','T3','2013-01-01','2013-03-31',1);


CREATE TABLE `#__courses`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `coursename` char(30) NOT NULL,
  `sectionname` CHAR(10) Not null,
  `code` CHAR(10) NOT NULL,
  `assessmenttype` CHAR(10) NOT NULL,
  `filename` CHAR(30) NULL,
  PRIMARY KEY  (`id`),
  `aid`	 INT(11) unsigned NOT NULL,
  INDEX `courses_aid_ind`(`aid`),
  FOREIGN KEY(`aid`)  REFERENCES `#__academicyears`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__courses` (`coursename`,`sectionname`,`code`,`assessmenttype`,`aid`) VALUES ('I Standard','A','I STD','Normal',1);
INSERT INTO `#__courses` (`coursename`,`sectionname`,`code`,`assessmenttype`,`aid`) VALUES ('II Standard','A','II STD','CCE',1);

CREATE TABLE `#__subjects`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `subjectname` char(30) NOT NULL,
  `subjectcode` CHAR(15) Not null,
  `hoursperweek` INT(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__subjects` (`subjectcode`,`subjectname`,`hoursperweek`) VALUES ('BCS061','TCP/IP Programming',5);
INSERT INTO `#__subjects` (`subjectcode`,`subjectname`,`hoursperweek`) VALUES ('CS68','Computer Networks',4);
INSERT INTO `#__subjects` (`subjectcode`,`subjectname`,`hoursperweek`) VALUES ('CS70','Software Engineering',4);

CREATE TABLE `#__msubjects`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `subjecttitle` char(30) NOT NULL,
  `subjectcode` CHAR(15) Not null,
  `acronym` CHAR(10) Not null,
  `credits` INT(11) NOT NULL,
  `passmark` NUMERIC(5,2) NOT NULL,
  `marks` NUMERIC(5,2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__msubjects` (`subjectcode`,`subjecttitle`,`acronym`,`credits`,`passmark`,`marks`) VALUES ('BCS061','TCP/IP Programming','TCP',5,35,100);
INSERT INTO `#__msubjects` (`subjectcode`,`subjecttitle`,`acronym`,`credits`,`passmark`,`marks`) VALUES ('BCS041','C Programming','CP',5,75,200);
INSERT INTO `#__msubjects` (`subjectcode`,`subjecttitle`,`acronym`,`credits`,`passmark`,`marks`) VALUES ('BCS051','JAVA Programming','JA',5,100,200);

CREATE TABLE `#__coursesubjects`(
  `sid`  INT(11) unsigned NOT NULL,
   INDEX `sid_ind`(`sid`),
   FOREIGN KEY (`sid`)  REFERENCES `#__msubjects`(`id`) ON DELETE CASCADE,
  `cid`  INT(11) unsigned NOT NULL,
   UNIQUE(`cid`,`sid`),
   INDEX `cid_ind`(`cid`),
   FOREIGN KEY (`cid`)  REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
   PRIMARY KEY(`sid`,`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__coursesubjects` (`cid`,`sid`) VALUES(1,1);
INSERT INTO `#__coursesubjects` (`cid`,`sid`) VALUES(1,2);
INSERT INTO `#__coursesubjects` (`cid`,`sid`) VALUES(1,3);



DROP TABLE IF EXISTS `#__staffs`;

CREATE TABLE `#__staffs`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `hprefix` CHAR(10) NULL,
  `staffcode` char(10) NOT NULL UNIQUE,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NULL,
  `lastname` varchar(50) NULL,
  `doj` DATE NULL,
  `department` INTEGER NULL,
  `category` INTEGER NULL,
  `position` INTEGER NULL,
  `grade` INTEGER NULL,
  `jobtitle` varchar(30) NULL,
  `qualification` varchar(30) NULL,
  `experienceinfo` VARCHAR(1000) NULL,
  `totalexperience` NUMERIC(5,2) NULL,
  `status`  CHAR(10) NULL,
  `maritalstatus`  CHAR(10) NULL,
  `gender` char(6) NULL,
  `dob` DATE NULL,
  `bloodgroup` char(10) NULL,
  `mothername` varchar(30) NULL,
  `fathername` varchar(30) NULL,
  `nationality`  INTEGER, 
  `addressline1` varchar(50) NULL,
  `addressline2` varchar(50) NULL,
  `city` varchar(30) NULL,
  `state` varchar(30) NULL,
  `pincode` char(15) NULL,
  `country`  integer,
  `phone` varchar(30) NULL,
  `mobile` varchar(30) NULL,
  `email` varchar(50) NULL,
  PRIMARY KEY  (`id`)

) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__staffs`(`staffcode`,`firstname`) VALUES('F0201','Sundaram M');
INSERT INTO `#__staffs`(`staffcode`,`firstname`) VALUES('F0202','Julias Ceasor');
INSERT INTO `#__staffs`(`staffcode`,`firstname`) VALUES('F0203','Ceasor');


CREATE TABLE `#__subjectteachers`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `courseid`  INT(11) unsigned NOT NULL,
  `subjectid` INT(11) unsigned NOT NULL,
  `staffid`  INT(11) unsigned NOT NULL,
  PRIMARY KEY(`id`),
  UNIQUE(`staffid`,`courseid`,`subjectid`),
  INDEX (`courseid`),
  INDEX (`subjectid`),
  INDEX (`staffid`),
  FOREIGN KEY (`courseid`)  REFERENCES `#__courses`(`id`) ON DELETE  CASCADE,
  FOREIGN KEY (`subjectid`) REFERENCES `#__msubjects`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`staffid`)   REFERENCES `#__staffs`(`id`) ON DELETE   CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__countries`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `countryname` char(30) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__countries`(`countryname`) VALUES('Albania');
INSERT INTO `#__countries`(`countryname`) VALUES('Algeria');
INSERT INTO `#__countries`(`countryname`) VALUES('Andorra');
INSERT INTO `#__countries`(`countryname`) VALUES('Angola');
INSERT INTO `#__countries`(`countryname`) VALUES('Antigua Deps');
INSERT INTO `#__countries`(`countryname`) VALUES('Argentina');
INSERT INTO `#__countries`(`countryname`) VALUES('Armenia');
INSERT INTO `#__countries`(`countryname`) VALUES('Australia');

INSERT INTO `#__countries`(`countryname`) VALUES('Austria');
INSERT INTO `#__countries`(`countryname`) VALUES('Azerbaijan');
INSERT INTO `#__countries`(`countryname`) VALUES('Bahamas');
INSERT INTO `#__countries`(`countryname`) VALUES('Bahrain');
INSERT INTO `#__countries`(`countryname`) VALUES('Bangladesh');
INSERT INTO `#__countries`(`countryname`) VALUES('Barbados');
INSERT INTO `#__countries`(`countryname`) VALUES('Belarus');
INSERT INTO `#__countries`(`countryname`) VALUES('Belgium');
INSERT INTO `#__countries`(`countryname`) VALUES('Belize');

INSERT INTO `#__countries`(`countryname`) VALUES('Benin');
INSERT INTO `#__countries`(`countryname`) VALUES('Bhutan');
INSERT INTO `#__countries`(`countryname`) VALUES('Bolivia');
INSERT INTO `#__countries`(`countryname`) VALUES('Bosnia Herzegovina');
INSERT INTO `#__countries`(`countryname`) VALUES('Botswana');
INSERT INTO `#__countries`(`countryname`) VALUES('Brazil');
INSERT INTO `#__countries`(`countryname`) VALUES('Brunei');
INSERT INTO `#__countries`(`countryname`) VALUES('Bulgaria');
INSERT INTO `#__countries`(`countryname`) VALUES('Burkina');

INSERT INTO `#__countries`(`countryname`) VALUES('Burundi');
INSERT INTO `#__countries`(`countryname`) VALUES('Cambodia');
INSERT INTO `#__countries`(`countryname`) VALUES('Cameroon');
INSERT INTO `#__countries`(`countryname`) VALUES('Canada');
INSERT INTO `#__countries`(`countryname`) VALUES('Cape Verde');
INSERT INTO `#__countries`(`countryname`) VALUES('Central African Rep');
INSERT INTO `#__countries`(`countryname`) VALUES('Chad');
INSERT INTO `#__countries`(`countryname`) VALUES('Chile');
INSERT INTO `#__countries`(`countryname`) VALUES('China');

INSERT INTO `#__countries`(`countryname`) VALUES('Colombia');
INSERT INTO `#__countries`(`countryname`) VALUES('Comoros');
INSERT INTO `#__countries`(`countryname`) VALUES('Congo');
INSERT INTO `#__countries`(`countryname`) VALUES('Congo {Democratic Rep}');
INSERT INTO `#__countries`(`countryname`) VALUES('Costa Rica');
INSERT INTO `#__countries`(`countryname`) VALUES('Croatia');
INSERT INTO `#__countries`(`countryname`) VALUES('Cuba');
INSERT INTO `#__countries`(`countryname`) VALUES('Cyprus');
INSERT INTO `#__countries`(`countryname`) VALUES('Czech Republic');

INSERT INTO `#__countries`(`countryname`) VALUES('Denmark');
INSERT INTO `#__countries`(`countryname`) VALUES('Djibouti');
INSERT INTO `#__countries`(`countryname`) VALUES('Dominica');
INSERT INTO `#__countries`(`countryname`) VALUES('Dominican Republic');
INSERT INTO `#__countries`(`countryname`) VALUES('East Timor');
INSERT INTO `#__countries`(`countryname`) VALUES('Ecuador');
INSERT INTO `#__countries`(`countryname`) VALUES('Egypt');
INSERT INTO `#__countries`(`countryname`) VALUES('El Salvador');
INSERT INTO `#__countries`(`countryname`) VALUES('Equatorial Guinea');

INSERT INTO `#__countries`(`countryname`) VALUES('Eritrea');
INSERT INTO `#__countries`(`countryname`) VALUES('Estonia');
INSERT INTO `#__countries`(`countryname`) VALUES('Ethiopia');
INSERT INTO `#__countries`(`countryname`) VALUES('Fiji');
INSERT INTO `#__countries`(`countryname`) VALUES('Finland');
INSERT INTO `#__countries`(`countryname`) VALUES('France');
INSERT INTO `#__countries`(`countryname`) VALUES('Gabon');
INSERT INTO `#__countries`(`countryname`) VALUES('Gambia');
INSERT INTO `#__countries`(`countryname`) VALUES('Georgia');

INSERT INTO `#__countries`(`countryname`) VALUES('Germany');
INSERT INTO `#__countries`(`countryname`) VALUES('Ghana');
INSERT INTO `#__countries`(`countryname`) VALUES('Greece');
INSERT INTO `#__countries`(`countryname`) VALUES('Grenada');
INSERT INTO `#__countries`(`countryname`) VALUES('Guatemala');
INSERT INTO `#__countries`(`countryname`) VALUES('Guinea');
INSERT INTO `#__countries`(`countryname`) VALUES('Guinea-Bissau');
INSERT INTO `#__countries`(`countryname`) VALUES('Guyana');
INSERT INTO `#__countries`(`countryname`) VALUES('Haiti');

INSERT INTO `#__countries`(`countryname`) VALUES('Honduras');
INSERT INTO `#__countries`(`countryname`) VALUES('Hungary');
INSERT INTO `#__countries`(`countryname`) VALUES('Iceland');
INSERT INTO `#__countries`(`countryname`) VALUES('India');
INSERT INTO `#__countries`(`countryname`) VALUES('Indonesia');
INSERT INTO `#__countries`(`countryname`) VALUES('Iran');
INSERT INTO `#__countries`(`countryname`) VALUES('Iraq');
INSERT INTO `#__countries`(`countryname`) VALUES('Ireland {Republic}');
INSERT INTO `#__countries`(`countryname`) VALUES('Israel');

INSERT INTO `#__countries`(`countryname`) VALUES('Italy');
INSERT INTO `#__countries`(`countryname`) VALUES('Ivory Coast');
INSERT INTO `#__countries`(`countryname`) VALUES('Jamaica');
INSERT INTO `#__countries`(`countryname`) VALUES('Japan');
INSERT INTO `#__countries`(`countryname`) VALUES('Jordan');
INSERT INTO `#__countries`(`countryname`) VALUES('Kazakhstan');
INSERT INTO `#__countries`(`countryname`) VALUES('Kenya');
INSERT INTO `#__countries`(`countryname`) VALUES('Kiribati');
INSERT INTO `#__countries`(`countryname`) VALUES('Korea North');

INSERT INTO `#__countries`(`countryname`) VALUES('Korea South');
INSERT INTO `#__countries`(`countryname`) VALUES('Kosovo');
INSERT INTO `#__countries`(`countryname`) VALUES('Kuwait');
INSERT INTO `#__countries`(`countryname`) VALUES('Kyrgyzstan');
INSERT INTO `#__countries`(`countryname`) VALUES('Laos');
INSERT INTO `#__countries`(`countryname`) VALUES('Latvia');
INSERT INTO `#__countries`(`countryname`) VALUES('Lebanon');
INSERT INTO `#__countries`(`countryname`) VALUES('Lesotho');
INSERT INTO `#__countries`(`countryname`) VALUES('Liberia');

INSERT INTO `#__countries`(`countryname`) VALUES('Libya');
INSERT INTO `#__countries`(`countryname`) VALUES('Liechtenstein');
INSERT INTO `#__countries`(`countryname`) VALUES('Lithuania');
INSERT INTO `#__countries`(`countryname`) VALUES('Luxembourg');
INSERT INTO `#__countries`(`countryname`) VALUES('Macedonia');
INSERT INTO `#__countries`(`countryname`) VALUES('Madagascar');
INSERT INTO `#__countries`(`countryname`) VALUES('Malawi');
INSERT INTO `#__countries`(`countryname`) VALUES('Malaysia');
INSERT INTO `#__countries`(`countryname`) VALUES('Maldives');

INSERT INTO `#__countries`(`countryname`) VALUES('Mali');
INSERT INTO `#__countries`(`countryname`) VALUES('Malta');
INSERT INTO `#__countries`(`countryname`) VALUES('Montenegro');
INSERT INTO `#__countries`(`countryname`) VALUES('Marshall Islands');
INSERT INTO `#__countries`(`countryname`) VALUES('Mauritania');
INSERT INTO `#__countries`(`countryname`) VALUES('Mauritius');
INSERT INTO `#__countries`(`countryname`) VALUES('Mexico');
INSERT INTO `#__countries`(`countryname`) VALUES('Micronesia');
INSERT INTO `#__countries`(`countryname`) VALUES('Moldova');

INSERT INTO `#__countries`(`countryname`) VALUES('Monaco');
INSERT INTO `#__countries`(`countryname`) VALUES('Mongolia');
INSERT INTO `#__countries`(`countryname`) VALUES('Morocco');
INSERT INTO `#__countries`(`countryname`) VALUES('Mozambique');
INSERT INTO `#__countries`(`countryname`) VALUES('Myanmar, {Burma}');
INSERT INTO `#__countries`(`countryname`) VALUES('Namibia');
INSERT INTO `#__countries`(`countryname`) VALUES('Nauru');
INSERT INTO `#__countries`(`countryname`) VALUES('Nepal');
INSERT INTO `#__countries`(`countryname`) VALUES('Netherlands');

INSERT INTO `#__countries`(`countryname`) VALUES('New Zealand');
INSERT INTO `#__countries`(`countryname`) VALUES('Nicaragua');
INSERT INTO `#__countries`(`countryname`) VALUES('Niger');
INSERT INTO `#__countries`(`countryname`) VALUES('Nigeria');
INSERT INTO `#__countries`(`countryname`) VALUES('Norway');
INSERT INTO `#__countries`(`countryname`) VALUES('Oman');
INSERT INTO `#__countries`(`countryname`) VALUES('Pakistan');
INSERT INTO `#__countries`(`countryname`) VALUES('Palau');
INSERT INTO `#__countries`(`countryname`) VALUES('Panama');

INSERT INTO `#__countries`(`countryname`) VALUES('Papua New Guinea');
INSERT INTO `#__countries`(`countryname`) VALUES('Paraguay');
INSERT INTO `#__countries`(`countryname`) VALUES('Peru');
INSERT INTO `#__countries`(`countryname`) VALUES('Philippines');
INSERT INTO `#__countries`(`countryname`) VALUES('Poland');
INSERT INTO `#__countries`(`countryname`) VALUES('Portugal');
INSERT INTO `#__countries`(`countryname`) VALUES('Qatar');
INSERT INTO `#__countries`(`countryname`) VALUES('Romania');
INSERT INTO `#__countries`(`countryname`) VALUES('Russian Federation');

INSERT INTO `#__countries`(`countryname`) VALUES('Rwanda');
INSERT INTO `#__countries`(`countryname`) VALUES('St Kitts &amp; Nevis');
INSERT INTO `#__countries`(`countryname`) VALUES('St Lucia');
INSERT INTO `#__countries`(`countryname`) VALUES('Saint Vincent &amp; the Grenadines');
INSERT INTO `#__countries`(`countryname`) VALUES('Samoa');
INSERT INTO `#__countries`(`countryname`) VALUES('San Marino');
INSERT INTO `#__countries`(`countryname`) VALUES('Sao Tome &amp; Principe');

INSERT INTO `#__countries`(`countryname`) VALUES('Saudi Arabia');
INSERT INTO `#__countries`(`countryname`) VALUES('Senegal');
INSERT INTO `#__countries`(`countryname`) VALUES('Serbia');
INSERT INTO `#__countries`(`countryname`) VALUES('Seychelles');
INSERT INTO `#__countries`(`countryname`) VALUES('Sierra Leone');
INSERT INTO `#__countries`(`countryname`) VALUES('Singapore');
INSERT INTO `#__countries`(`countryname`) VALUES('Slovakia');
INSERT INTO `#__countries`(`countryname`) VALUES('Slovenia');
INSERT INTO `#__countries`(`countryname`) VALUES('Solomon Islands');

INSERT INTO `#__countries`(`countryname`) VALUES('Somalia');
INSERT INTO `#__countries`(`countryname`) VALUES('South Africa');
INSERT INTO `#__countries`(`countryname`) VALUES('Spain');
INSERT INTO `#__countries`(`countryname`) VALUES('Sri Lanka');
INSERT INTO `#__countries`(`countryname`) VALUES('Sudan');
INSERT INTO `#__countries`(`countryname`) VALUES('Suriname');
INSERT INTO `#__countries`(`countryname`) VALUES('Swaziland');
INSERT INTO `#__countries`(`countryname`) VALUES('Sweden');
INSERT INTO `#__countries`(`countryname`) VALUES('Switzerland');

INSERT INTO `#__countries`(`countryname`) VALUES('Syria');
INSERT INTO `#__countries`(`countryname`) VALUES('Taiwan');
INSERT INTO `#__countries`(`countryname`) VALUES('Tajikistan');
INSERT INTO `#__countries`(`countryname`) VALUES('Tanzania');
INSERT INTO `#__countries`(`countryname`) VALUES('Thailand');
INSERT INTO `#__countries`(`countryname`) VALUES('Togo');
INSERT INTO `#__countries`(`countryname`) VALUES('Tonga');
INSERT INTO `#__countries`(`countryname`) VALUES('Trinidad &amp; Tobago');

INSERT INTO `#__countries`(`countryname`) VALUES('Tunisia');
INSERT INTO `#__countries`(`countryname`) VALUES('Turkey');
INSERT INTO `#__countries`(`countryname`) VALUES('Turkmenistan');
INSERT INTO `#__countries`(`countryname`) VALUES('Tuvalu');
INSERT INTO `#__countries`(`countryname`) VALUES('Uganda');
INSERT INTO `#__countries`(`countryname`) VALUES('Ukraine');
INSERT INTO `#__countries`(`countryname`) VALUES('United Arab Emirates');
INSERT INTO `#__countries`(`countryname`) VALUES('United Kingdom');
INSERT INTO `#__countries`(`countryname`) VALUES('United States');

INSERT INTO `#__countries`(`countryname`) VALUES('Uruguay');
INSERT INTO `#__countries`(`countryname`) VALUES('Uzbekistan');
INSERT INTO `#__countries`(`countryname`) VALUES('Vanuatu');
INSERT INTO `#__countries`(`countryname`) VALUES('Vatican City');
INSERT INTO `#__countries`(`countryname`) VALUES('Venezuea');
INSERT INTO `#__countries`(`countryname`) VALUES('Vietnam');
INSERT INTO `#__countries`(`countryname`) VALUES('Yemen');
INSERT INTO `#__countries`(`countryname`) VALUES('Zambia');
INSERT INTO `#__countries`(`countryname`) VALUES('Zimbabwe');




CREATE TABLE `#__studentcategories`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `categoryname` char(25) NOT NULL,
  `categorycode` char(10) NOT NULL,
   PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__studentcategories`(`id`,`categoryname`,`categorycode`) VALUES(0,'General','GEN');

CREATE TABLE `#__students`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `registerno` char(15) NOT NULL UNIQUE,
  `ano` char(15) NULL,
  `adate` DATE NULL,
  `firstname` char(50) NOT NULL,
  `middlename` char(50) NULL,
  `lastname` char(50) NULL,
  `dob` DATE NULL,
  `gender` char(6) NULL,
  `bloodgroup` char(10) NULL,
  `birthplace` char(30) NULL,
  `nationality`  INTeger,
  `mothertongue` char(30) NULL,
  `caste` char(50) NULL,
  `religion` char(30) NULL,
  `addressline1` char(50) NULL,
  `addressline2` char(50) NULL,
  `city` char(30) NULL,
  `state` char(30) NULL,
  `pincode` char(15) NULL,
  `country`  INTeger,
  `pfathername` char(50) NOT NULL,
  `phone` char(30) NULL,
  `mobile` char(30) NULL,
  `email` char(50) NULL,
  `mothername` char(50) NOT NULL,
  `mphone` char(30) NULL,
  `mmobile` char(30) NULL,
  `memail` char(30) NULL,
  `categoryid` INT(11) unsigned NOT NULL,
  INDEX (`categoryid`),
  FOREIGN KEY(`categoryid`) REFERENCES `#__studentcategories`(`id`) ON DELETE NO ACTION,
  `joinedclassid` INT(11) unsigned NOT NULL,
  INDEX (`joinedclassid`),
  FOREIGN KEY(`joinedclassid`) REFERENCES `#__courses`(`id`) ON DELETE NO ACTION,
  `joinedacademicyearid` INT(11) unsigned NOT NULL,
  INDEX (`joinedacademicyearid`),
  FOREIGN KEY(`joinedacademicyearid`) REFERENCES `#__academicyears`(`id`) ON DELETE NO ACTION,
  PRIMARY KEY  (`id`)
  
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;



CREATE TABLE `#__studentclass`(
	`studentid` int(11) unsigned NOT NULL,
        INDEX (`studentid`),
        FOREIGN KEY(`studentid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE,
	`classid` INT(11) unsigned NOT null,
        INDEX(`classid`),
        FOREIGN KEY(`classid`)  REFERENCES `#__courses`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;





CREATE TABLE `#__staffdepartments`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `departmentname` char(25) NOT NULL,
  `departmentcode` char(10) NOT NULL,
   PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__staffcategories`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `categoryname` char(25) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__staffcategories` VALUES(1,'Teaching');
INSERT INTO `#__staffcategories` VALUES(2,'Non-Teaching');

CREATE TABLE `#__staffgrades`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `gradename` char(25) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__staffpositions`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `positionname` char(25) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;



CREATE TABLE `#__classteachers`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `staffid` int(11) unsigned NOT NULL,
   INDEX(`staffid`),
   FOREIGN KEY (`staffid`) REFERENCES `#__staffs`(`id`) ON DELETE CASCADE,
  `classid` int(11) unsigned NOT NULL,
   INDEX (`classid`),
   FOREIGN KEY (`classid`)  REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
   UNIQUE(`staffid`,`classid`),
   PRIMARY KEY(`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__classteachers`(`staffid`,`classid`) VALUES(1,1); 
INSERT INTO `#__classteachers`(`staffid`,`classid`) VALUES(2,1); 
INSERT INTO `#__classteachers`(`staffid`,`classid`) VALUES(2,2); 


CREATE TABLE `#__faactivities`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `activityname` char(30) NOT NULL,
  `activitycode` char(10) NOT NULL,
  `description` varchar(250) NULL,
  PRIMARY KEY(`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__faactivities`(`activityname`,`activitycode`) VALUES('Telling Stories','TES');
INSERT INTO `#__faactivities`(`activityname`,`activitycode`) VALUES('Dictation','DIC');
INSERT INTO `#__faactivities`(`activityname`,`activitycode`) VALUES('Singing','SIN');
INSERT INTO `#__faactivities`(`activityname`,`activitycode`) VALUES('Memory Activity','MEA');


CREATE TABLE `#__lsactivities`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `activityname` char(30) NOT NULL,
  `activitycode` char(10) NOT NULL,
  `description` VARCHAR(250) NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__lsactivities`(`activityname`,`activitycode`) VALUES('Thinking Skills','THS');
INSERT INTO `#__lsactivities`(`activityname`,`activitycode`) VALUES('Emotional Skills','EMS');


CREATE TABLE `#__attitudesandvalues`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `activityname` char(30) NOT NULL,
  `activitycode` char(10) NOT NULL,
  `description` VARCHAR(250) NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__attitudesandvalues`(`activityname`,`activitycode`) VALUES('Attitude towards teachers','ATT');
INSERT INTO `#__attitudesandvalues`(`activityname`,`activitycode`) VALUES('Attitude towards School-Mates','ATS');
INSERT INTO `#__attitudesandvalues`(`activityname`,`activitycode`) VALUES('Value System','VS');


CREATE TABLE `#__coscholasticaactivities`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `activityname` char(30) NOT NULL,
  `activitycode` char(10) NOT NULL,
  `description` VARCHAR(250) NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__coscholasticaactivities`(`activityname`,`activitycode`) VALUES('Games','GS');
INSERT INTO `#__coscholasticaactivities`(`activityname`,`activitycode`) VALUES('Sports','SS');


CREATE TABLE `#__coscholasticbactivities`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `activityname` char(30) NOT NULL,
  `activitycode` char(10) NOT NULL,
  `description` VARCHAR(250) NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__coscholasticbactivities`(`activityname`,`activitycode`) VALUES('Games','GS');
INSERT INTO `#__coscholasticbactivities`(`activityname`,`activitycode`) VALUES('Sports','SS');


CREATE TABLE `#__fagrades`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `from` integer  NOT NULL,
  `to` integer NOT NULL,
  `letter` CHAR(5) NOT NULL,
  `points` INTEGER NULL,
  `description` VARCHAR(50) NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__fagrades`(`from`,`to`,`letter`,`points`) VALUES('91','100','A1',10);
INSERT INTO `#__fagrades`(`from`,`to`,`letter`,`points`) VALUES('81','90','A2',9);
INSERT INTO `#__fagrades`(`from`,`to`,`letter`,`points`) VALUES('71','80','B1',8);
INSERT INTO `#__fagrades`(`from`,`to`,`letter`,`points`) VALUES('61','70','B2',7);
INSERT INTO `#__fagrades`(`from`,`to`,`letter`,`points`) VALUES('51','60','C1',6);
INSERT INTO `#__fagrades`(`from`,`to`,`letter`,`points`) VALUES('41','50','C2',5);
INSERT INTO `#__fagrades`(`from`,`to`,`letter`,`points`) VALUES('33','40','D',4);
INSERT INTO `#__fagrades`(`from`,`to`,`letter`,`points`) VALUES('21','32','E1',3);
INSERT INTO `#__fagrades`(`from`,`to`,`letter`,`points`) VALUES('0','20','E2',2);


CREATE TABLE `#__normalgrades`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `from` integer  NOT NULL,
  `to` integer NOT NULL,
  `letter` CHAR(5) NOT NULL,
  `points` INTEGER NULL,
  `description` VARCHAR(50) NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__normalgrades`(`from`,`to`,`letter`,`points`) VALUES('91','100','A1',10);
INSERT INTO `#__normalgrades`(`from`,`to`,`letter`,`points`) VALUES('81','90','A2',9);
INSERT INTO `#__normalgrades`(`from`,`to`,`letter`,`points`) VALUES('71','80','B1',8);
INSERT INTO `#__normalgrades`(`from`,`to`,`letter`,`points`) VALUES('61','70','B2',7);
INSERT INTO `#__normalgrades`(`from`,`to`,`letter`,`points`) VALUES('51','60','C1',6);
INSERT INTO `#__normalgrades`(`from`,`to`,`letter`,`points`) VALUES('41','50','C2',5);
INSERT INTO `#__normalgrades`(`from`,`to`,`letter`,`points`) VALUES('33','40','D',4);
INSERT INTO `#__normalgrades`(`from`,`to`,`letter`,`points`) VALUES('21','32','E1',3);
INSERT INTO `#__normalgrades`(`from`,`to`,`letter`,`points`) VALUES('0','20','E2',2);


CREATE TABLE `#__sagrades`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `from` integer  NOT NULL,
  `to` integer NOT NULL,
  `letter` CHAR(5) NOT NULL,
  `points` INTEGER NULL,
  `description` VARCHAR(50) NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__sagrades`(`from`,`to`,`letter`,`points`) VALUES('91','100','A+',10);
INSERT INTO `#__sagrades`(`from`,`to`,`letter`,`points`) VALUES('81','90','A',9);


CREATE TABLE `#__scholasticagrades`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `from` integer  NOT NULL,
  `to` integer NOT NULL,
  `letter` CHAR(5) NOT NULL,
  `points` INTEGER NULL,
  `description` VARCHAR(50) NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__scholasticagrades`(`from`,`to`,`letter`,`points`) VALUES('91','100','A+',10);


CREATE TABLE `#__scholasticbgrades`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `letter` CHAR(5) NOT NULL,
  `points` integer NOT NULL,
  `title` CHAR(30) NULL,
  `description` VARCHAR(50) NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__scholasticbgrades`(`title`,`points`,`letter`) VALUES('Excellent','5','A');
INSERT INTO `#__scholasticbgrades`(`title`,`points`,`letter`) VALUES('Very Good','4','B');
INSERT INTO `#__scholasticbgrades`(`title`,`points`,`letter`) VALUES('Good','3','C');
INSERT INTO `#__scholasticbgrades`(`title`,`points`,`letter`) VALUES('Ok','2','D');


CREATE TABLE `#__tgradebook`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` CHAR(30) not null,
  `code` CHAR(10) NOT NULL,
  `weightage` INTEGER NOT NULL,
  `bestof` INTEGER NOT NULL,
  `description` VARCHAR(250) NULL,
  `grouptag`	CHAR(5) NOT NULL,
  `gsno`	INTEGER NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
INSERT INTO `#__tgradebook`(`id`,`title`,`code`,`weightage`,`bestof`,`grouptag`,`gsno`) VALUES(1,'Formative Assessment - Part A','FA(a)',20,4,'A',1);
INSERT INTO `#__tgradebook`(`id`,`title`,`code`,`weightage`,`bestof`,`grouptag`,`gsno`) VALUES(2,'Formative Assessment - Part B','FA(b)',20,4,'A',2);
INSERT INTO `#__tgradebook`(`id`,`title`,`code`,`weightage`,`bestof`,`grouptag`,`gsno`) VALUES(3,'Summative Assessment','SA',60,1,'B',1);


CREATE TABLE `#__tgradebookentries`(
  `id` int(11) unsigned NOT NULL auto_increment ,
  `title` CHAR(30) not null,
  `code` CHAR(10) NOT NULL,
  `marks` INTEGER NOT NULL,
  `duedate` DATE NULL,
  `description` VARCHAR(250) NULL,
  PRIMARY KEY(`id`),
  `categoryid` INT(11) unsigned,
  INDEX (`categoryid`),
  FOREIGN KEY (`categoryid`) REFERENCES `#__tgradebook`(id) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-1','A1',5,1);
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-2','A2',5,1);
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-3','A3',5,1);
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-4','A4',5,1);
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-5','A5',5,1);
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-6','A6',5,1);


INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-1','T1',5,2);
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-2','T2',5,2);
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-3','T3',5,2);
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-4','T4',5,2);
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-5','T5',5,2);
INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-6','T6',5,2);

INSERT INTO `#__tgradebookentries`(`title`,`code`,`marks`,`categoryid`) VALUES('Term End Exam','TEE',100,3);


CREATE TABLE `#__scholasticacategories`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` CHAR(30) not null,
  `code` CHAR(10) NOT NULL,
  `weightage` INTEGER NOT NULL,
  `bestof` INTEGER NOT NULL,
  `description` VARCHAR(250) NULL,
  PRIMARY KEY(`id`),
  `subjectid` INT(11) unsigned NOT NULL,
  `courseid` INT(11) unsigned NOT NULL,
  `termid` INT(11) unsigned NOT NULL,
  `grouptag`	CHAR(5) NOT NULL,
  `gsno`	INTEGER NOT NULL,
  INDEX(`termid`),
  FOREIGN KEY(`termid`) REFERENCES `#__terms`(id) ON DELETE CASCADE,
  INDEX(`subjectid`,`courseid`),
  FOREIGN KEY(`subjectid`,`courseid`) REFERENCES `#__coursesubjects`(`sid`,`cid`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__scholasticacategories`(`id`,`title`,`code`,`weightage`,`bestof`,`subjectid`,`courseid`,`termid`,`grouptag`,`gsno`) VALUES(1,'Formative Assessment - Part A','FA(a)',20,4,1,1,1,'A',1);
INSERT INTO `#__scholasticacategories`(`id`,`title`,`code`,`weightage`,`bestof`,`subjectid`,`courseid`,`termid`,`grouptag`,`gsno`) VALUES(2,'Formative Assessment - Part B','FA(b)',20,4,1,1,1,'A',2);
INSERT INTO `#__scholasticacategories`(`id`,`title`,`code`,`weightage`,`bestof`,`subjectid`,`courseid`,`termid`,`grouptag`,`gsno`) VALUES(3,'Summative Assessment','SA',60,1,1,1,1,'B',1);


CREATE TABLE `#__scholasticacategorydetails`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` CHAR(30) not null,
  `code` CHAR(10) NOT NULL,
  `marks` INTEGER NOT NULL,
  `duedate` DATE NULL,
  `description` VARCHAR(250) NULL,
  `categoryid` INT(11) unsigned NOT NULL,
  INDEX(`categoryid`),
  FOREIGN KEY(`categoryid`)  REFERENCES `#__scholasticacategories`(id) ON DELETE CASCADE,
  PRIMARY KEY(`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-1','A1',5,1);
INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-2','A2',5,1);
INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-3','A3',5,1);
INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-4','A4',5,1);
INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-5','A5',5,1);
INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Activity-6','A6',5,1);


INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-1','T1',5,2);
INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-2','T2',5,2);
INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-3','T3',5,2);
INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-4','T4',5,2);
INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-5','T5',5,2);
INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Slip Test-6','T6',5,2);

INSERT INTO `#__scholasticacategorydetails`(`title`,`code`,`marks`,`categoryid`) VALUES('Term End Exam','TEE',100,3);


CREATE TABLE `#__scholasticamarks`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `description` VARCHAR(150) NULL,
  `marks` NUMERIC(5,2) not NULL,
  `comments` VARCHAR(150) NULL,
  `studentid` int(11) unsigned NOT NULL,
   INDEX (`studentid`),
   FOREIGN KEY(`studentid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE,
  `sacdid` INT(11) unsigned NOT NULL,
  INDEX(`sacdid`),
  FOREIGN KEY(`sacdid`) REFERENCES `#__scholasticacategorydetails`(`id`) ON DELETE CASCADE,
  PRIMARY KEY(`id`),
  UNIQUE(`studentid`,`sacdid`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__studentsmsstatuslog` (
  `smslogid` int(11) unsigned NOT NULL,
  `sid` INT(11) unsigned NOT NULL,
  `status` CHAR(5) NOT NULL,
  INDEX `sid_ind`(`sid`),
  FOREIGN KEY (`sid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE,
  INDEX `smslogid_ind`(`smslogid`),
  FOREIGN KEY (`smslogid`) REFERENCES `#__studentsmslog`(`id`) ON DELETE CASCADE,
  UNIQUE(`smslogid`,`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__staffsmsstatuslog` (
  `smslogid` int(11) unsigned NOT NULL,
  `sid` INT(11) unsigned NOT NULL,
  INDEX `sid_ind`(`sid`),
  FOREIGN KEY (`sid`) REFERENCES `#__staffs`(`id`) ON DELETE CASCADE,
  INDEX `smslogid_ind`(`smslogid`),
  FOREIGN KEY (`smslogid`) REFERENCES `#__staffsmslog`(`id`) ON DELETE CASCADE,
  UNIQUE(`smslogid`,`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__studentgroups`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `groupname` CHAR(100) NOT NULL,
  `groupcode` CHAR(10) NOT NULL,
  `purpose`   VARCHAR(1000) NULL,
  `description` VARCHAR(1500) NULL,
  `aid`	 INT(11) unsigned NOT NULL,
  INDEX `aid_ind`(`aid`),
  FOREIGN KEY (`aid`) REFERENCES `#__academicyears`(`id`) ON DELETE CASCADE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__groupmembers`(
  `gid`	INT(11) unsigned NOT NULL,
  `sid` INT(11) unsigned NOT NULL,
   UNIQUE(`gid`,`sid`),
   INDEX ind_gid(`gid`),
   FOREIGN KEY (`gid`) REFERENCES `#__studentgroups`(`id`) ON DELETE CASCADE,
   INDEX ind_sid(`sid`),
   FOREIGN KEY(`sid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__lsmarks`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `studentid` int(11) unsigned NOT NULL,
  `activityid` int(11) unsigned NOT NULL,
  `classid`   int(11) unsigned NOT NULL,
  `termid`   int(11) unsigned not null,
  `marks`     NUMERIC(4,1) NOT NULL,
  `indicators` VARCHAR(1000) NULL,
  PRIMARY KEY(`id`),
  INDEX (`studentid`),
  FOREIGN KEY(`studentid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE,
  INDEX(`classid`),
  FOREIGN KEY(`classid`)  REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
  INDEX(`activityid`),
  FOREIGN KEY(`activityid`)  REFERENCES `#__lsactivities`(`id`) ON DELETE CASCADE,
  INDEX(`termid`),
  FOREIGN KEY(`termid`)  REFERENCES `#__terms`(`id`) ON DELETE CASCADE,
  UNIQUE INDEX(`studentid`,`activityid`,`classid`,`marks`,`termid`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__avmarks`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `studentid` int(11) unsigned NOT NULL,
  `activityid` int(11) unsigned NOT NULL,
  `classid`   int(11) unsigned NOT NULL,
  `termid`   int(11) unsigned not null,
  `marks`     NUMERIC(4,1) NOT NULL,
  `indicators` VARCHAR(1000) NULL,
  PRIMARY KEY(`id`),
  INDEX (`studentid`),
  FOREIGN KEY(`studentid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE,
  INDEX(`classid`),
  FOREIGN KEY(`classid`)  REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
  INDEX(`activityid`),
  FOREIGN KEY(`activityid`)  REFERENCES `#__attitudesandvalues`(`id`) ON DELETE CASCADE,
  INDEX(`termid`),
  FOREIGN KEY(`termid`)  REFERENCES `#__terms`(`id`) ON DELETE CASCADE,
  UNIQUE INDEX(`studentid`,`activityid`,`classid`,`marks`,`termid`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__cosamarks`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `studentid` int(11) unsigned NOT NULL,
  `activityid` int(11) unsigned NOT NULL,
  `classid`   int(11) unsigned NOT NULL,
  `termid`   int(11) unsigned not null,
  `marks`     NUMERIC(4,1) NOT NULL,
  `indicators` VARCHAR(1000) NULL,
  PRIMARY KEY(`id`),
  INDEX (`studentid`),
  FOREIGN KEY(`studentid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE,
  INDEX(`classid`),
  FOREIGN KEY(`classid`)  REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
  INDEX(`activityid`),
  FOREIGN KEY(`activityid`)  REFERENCES `#__coscholasticaactivities`(`id`) ON DELETE CASCADE,
  INDEX(`termid`),
  FOREIGN KEY(`termid`)  REFERENCES `#__terms`(`id`) ON DELETE CASCADE,
  UNIQUE  INDEX(`studentid`,`activityid`,`classid`,`marks`,`termid`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;




CREATE TABLE `#__cosbmarks`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `studentid` int(11) unsigned NOT NULL,
  `activityid` int(11) unsigned NOT NULL,
  `classid`   int(11) unsigned NOT NULL,
  `termid`   int(11) unsigned not null,
  `marks`     NUMERIC(4,1) NOT NULL,
  `indicators` VARCHAR(1000) NULL,
  PRIMARY KEY(`id`),
  INDEX (`studentid`),
  FOREIGN KEY(`studentid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE,
  INDEX(`classid`),
  FOREIGN KEY(`classid`)  REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
  INDEX(`activityid`),
  FOREIGN KEY(`activityid`)  REFERENCES `#__coscholasticbactivities`(`id`) ON DELETE CASCADE,
  INDEX(`termid`),
  FOREIGN KEY(`termid`)  REFERENCES `#__terms`(`id`) ON DELETE CASCADE,
  UNIQUE INDEX(`studentid`,`activityid`,`classid`,`marks`,`termid`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__schoolcal`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `cdate` DATE NOT NULL,
  `description` VARCHAR(500) NULL,
  `daytype` CHAR(5) NOT NULL,
  `dayorder` INT(11) unsigned NOT NULL, 
  PRIMARY KEY(`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__classattendance`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `classid`   int(11) unsigned NOT NULL,
  `studentid` int(11) unsigned NOT NULL,
  `sessiontype` CHAR(1) NOT NULL,
  `cdate` DATE NOT NULL,
   UNIQUE INDEX(`classid`,`studentid`,`cdate`,`sessiontype`),
  PRIMARY KEY(`id`),
  INDEX (`studentid`),
  FOREIGN KEY(`studentid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE,
  INDEX(`classid`),
  FOREIGN KEY(`classid`)  REFERENCES `#__courses`(`id`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__classleave`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `classid`   int(11) unsigned NOT NULL,
  `studentid` int(11) unsigned NOT NULL,
  `sessiontype` CHAR(1) NOT NULL,
  `cdate` DATE NOT NULL,
  `reason` VARCHAR(1000) NULL,
   UNIQUE INDEX(`classid`,`studentid`,`cdate`,`sessiontype`),
  PRIMARY KEY(`id`),
  INDEX (`studentid`),
  FOREIGN KEY(`studentid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE,
  INDEX(`classid`),
  FOREIGN KEY(`classid`)  REFERENCES `#__courses`(`id`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;



CREATE TABLE `#__tngradebook`(
  `id` int(11) unsigned NOT NULL auto_increment ,
  `title` CHAR(30) not null,
  `code` CHAR(10) NOT NULL,
  `marks` INTEGER NOT NULL,
  `duedate` DATE NULL,
  `description` VARCHAR(250) NULL,
  PRIMARY KEY(`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__ngradebook`(
  `id` int(11) unsigned NOT NULL auto_increment ,
  `title` CHAR(30) not null,
  `code` CHAR(10) NOT NULL,
  `marks` INTEGER NOT NULL,
  `duedate` DATE NULL,
  `description` VARCHAR(250) NULL,
  `subjectid` INT(11) unsigned NOT NULL,
  `courseid` INT(11) unsigned NOT NULL,
   PRIMARY KEY (`id`),
  INDEX(`subjectid`,`courseid`),
  FOREIGN KEY(`subjectid`,`courseid`) REFERENCES `#__coursesubjects`(`sid`,`cid`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__nmarks`(
  `id` int(11) unsigned NOT NULL auto_increment ,
  `marks`     NUMERIC(4,1) NOT NULL,
  `comments` VARCHAR(150) NULL,
  `examid`    INT(11) unsigned NOT NULL, 
  `studentid` int(11) unsigned NOT NULL,
  `subjectid` INT(11) unsigned NOT NULL,
  `courseid` INT(11) unsigned NOT NULL,
  INDEX(`subjectid`,`courseid`),
  FOREIGN KEY(`subjectid`,`courseid`) REFERENCES `#__coursesubjects`(`sid`,`cid`) ON DELETE CASCADE,
  INDEX (`studentid`),
  FOREIGN KEY(`studentid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE,
  INDEX(`examid`),
  FOREIGN KEY(`examid`) REFERENCES `#__tngradebook`(`id`) ON DELETE CASCADE,
  PRIMARY KEY(`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__studentsphoto`(
  `id` int(11) unsigned NOT NULL auto_increment ,
  `imagedata` longblob NOT NULL,
  `sid` int(11) unsigned NOT NULL,
  PRIMARY KEY(`id`),
  INDEX (`sid`),
  FOREIGN KEY(`sid`) REFERENCES `#__students`(`id`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__staffphoto`(
  `id` int(11) unsigned NOT NULL auto_increment ,
  `imagedata` longblob NOT NULL,
  `sid` int(11) unsigned NOT NULL,
  PRIMARY KEY(`id`),
  INDEX (`sid`),
  FOREIGN KEY(`sid`) REFERENCES `#__staffs`(`id`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__staffattendance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `staffid` int(11) unsigned NOT NULL,
  `sessiontype` char(1) NOT NULL,
  `cdate` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE (`staffid`,`cdate`,`sessiontype`),
  KEY (`staffid`),
  FOREIGN KEY (`staffid`) REFERENCES `#__staffs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

CREATE TABLE `#__staffleave`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `staffid` int(11) unsigned NOT NULL,
  `sessiontype` CHAR(1) NOT NULL,
  `cdate` DATE NOT NULL,
  `reason` VARCHAR(1000) NULL,
  UNIQUE INDEX(`staffid`,`cdate`,`sessiontype`),
  PRIMARY KEY(`id`),
  INDEX (`staffid`),
  FOREIGN KEY(`staffid`) REFERENCES `#__staffs`(`id`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;



CREATE TABLE `#__sessiontypes`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `description` VARCHAR(100) NOT NULL,
  `aid`	 INT(11) unsigned NOT NULL,
  INDEX `aid_ind`(`aid`),
  FOREIGN KEY (`aid`) REFERENCES `#__academicyears`(`id`) ON DELETE CASCADE,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__sessiontimings`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` VARCHAR(100) NOT NULL,
  `code` CHAR(10) NOT NULL,
  `start` TIME NOT NULL,
  `stop` TIME NOT NULL,
  `sid` INT(11) unsigned NOT NULL,
  INDEX (`sid`),
  FOREIGN KEY (`sid`) REFERENCES `#__sessiontypes`(`id`) ON DELETE CASCADE,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;



CREATE TABLE `#__daycategory`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `description` VARCHAR(100) NOT NULL,
  `aid`  INT(11) unsigned NOT NULL,
  INDEX `aid_ind`(`aid`),
  FOREIGN KEY (`aid`) REFERENCES `#__academicyears`(`id`) ON DELETE CASCADE,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__days`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` VARCHAR(100) NOT NULL,
  `code` CHAR(10) NOT NULL,
  `active` INTEGER(1) NULL,
  `dcid` INT(11) unsigned NOT NULL,
  INDEX (`dcid`),
  FOREIGN KEY (`dcid`) REFERENCES `#__daycategory`(`id`) ON DELETE CASCADE,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;




CREATE TABLE `#__timetableterms` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `term` char(9) NOT NULL,
  `months` CHAR(7) Not null,
  `code` CHAR(5) NOT NULL,
  `startdate` DATE NOT NULL,
  `stopdate` DATE NOT NULL,
  PRIMARY KEY  (`id`),
  `aid`  INT(11) unsigned NOT NULL,
  INDEX `aid_ind`(`aid`),
  FOREIGN KEY (`aid`) REFERENCES `#__academicyears`(`id`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__timetable` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `termid` INT(11) unsigned NOT NULL,
  `courseid` INT(11) unsigned NOT NULL,
  `dayid` INT(11) unsigned NOT NULL,
  `sessionid` INT(11) unsigned NOT NULL,
  `subjectid` INT(11) unsigned NOT NULL,
  `staffid` INT(11) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE(termid,dayid,sessionid,staffid),
  INDEX (`termid`),
  FOREIGN KEY (`termid`) REFERENCES `#__timetableterms`(`id`) ON DELETE CASCADE,
  INDEX (`courseid`),
  FOREIGN KEY (`courseid`) REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
  INDEX (`dayid`),
  FOREIGN KEY (`dayid`) REFERENCES `#__days`(`id`) ON DELETE CASCADE,
  INDEX (`sessionid`),
  FOREIGN KEY (`sessionid`) REFERENCES `#__sessiontimings`(`id`) ON DELETE CASCADE,
  INDEX (`subjectid`),
  FOREIGN KEY (`subjectid`) REFERENCES `#__msubjects`(`id`) ON DELETE CASCADE,
  INDEX (`staffid`),
  FOREIGN KEY (`staffid`)   REFERENCES `#__staffs`(`id`) ON DELETE   CASCADE
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__coursesessions`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `sid` INT(11) unsigned NOT NULL,
  `cid` INT(11) unsigned NOT NULL,
  `termid` INT(11) unsigned NOT NULL,
  INDEX (`termid`),
  FOREIGN KEY (`termid`) REFERENCES `#__timetableterms`(`id`) ON DELETE CASCADE,
  INDEX (`sid`),
  FOREIGN KEY (`sid`) REFERENCES `#__sessiontypes`(`id`) ON DELETE CASCADE,
  INDEX (`cid`),
  FOREIGN KEY (`cid`) REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
  UNIQUE(`termid`,`cid`),
  PRIMARY KEY  (`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__daycourses`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `dcid` INT(11) unsigned NOT NULL,
  `cid` INT(11) unsigned NOT NULL,
  `termid` INT(11) unsigned NOT NULL,
  INDEX (`termid`),
  FOREIGN KEY (`termid`) REFERENCES `#__timetableterms`(`id`) ON DELETE CASCADE,
  INDEX (`dcid`),
  FOREIGN KEY (`dcid`) REFERENCES `#__daycategory`(`id`) ON DELETE CASCADE,
  INDEX (`cid`),
  FOREIGN KEY (`cid`) REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
  UNIQUE(`termid`,`cid`),
  PRIMARY KEY  (`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__officedesk` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `message` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__reminders`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `cdate` DATE NOT NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY(`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__feecategory`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` VARCHAR(30) NOT NULL,
  `description` VARCHAR(100) NOT NULL,
  `aid`	 INT(11) unsigned NOT NULL,
  INDEX `aid_ind`(`aid`),
  FOREIGN KEY (`aid`) REFERENCES `#__academicyears`(`id`) ON DELETE CASCADE,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__feeparticulars`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` VARCHAR(100) NOT NULL,
  `description` CHAR(10) NOT NULL,
  `amount` NUMERIC(7,2) NOT NULL,
  `fcid` INT(11) unsigned NOT NULL,
  INDEX (`fcid`),
  FOREIGN KEY (`fcid`) REFERENCES `#__feecategory`(`id`) ON DELETE CASCADE,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


CREATE TABLE `#__coursefeecategory`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `fcid` INT(11) unsigned NOT NULL,
  `cid` INT(11) unsigned NOT NULL,
  INDEX (`fcid`),
  FOREIGN KEY (`fcid`) REFERENCES `#__feecategory`(`id`) ON DELETE CASCADE,
  INDEX (`cid`),
  FOREIGN KEY (`cid`) REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
  UNIQUE(`fcid`,`cid`),
  PRIMARY KEY  (`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

CREATE TABLE `#__feediscounts`(
  `id` int(11) unsigned NOT NULL auto_increment,
  `fcid` INT(11) unsigned NOT NULL,
  `cid` INT(11) unsigned NOT NULL,
  `scid` INT(11) unsigned NOT NULL,
  INDEX (`fcid`),
  FOREIGN KEY (`fcid`) REFERENCES `#__feecategory`(`id`) ON DELETE CASCADE,
  INDEX (`cid`),
  FOREIGN KEY (`cid`) REFERENCES `#__courses`(`id`) ON DELETE CASCADE,
  INDEX (`scid`),
  FOREIGN KEY (`scid`) REFERENCES `#__studentcategories`(`id`) ON DELETE CASCADE,
  UNIQUE(`fcid`,`cid`,`scid`),
  PRIMARY KEY  (`id`)
) ENGINE=INNODB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

