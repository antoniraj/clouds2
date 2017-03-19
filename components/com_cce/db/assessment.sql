CREATE TABLE ya_ca_assessmentbook(
	`id`		INTEGER(11) UNSIGNED AUTO_INCREMENT,
	`code`		CHAR(10) NULL,
	`title`		CHAR(50) NOT NULL,
	`gradeupgrade`  INTEGER UNSIGNED NOT NULL,
	`aid`		INTEGER UNSIGNED NOT NULL,
	INDEX(`aid`),
	FOREIGN KEY(`aid`) REFERENCES ya_academicyears(id) ON DELETE CASCADE
	PRIMARY KEY(id),
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE ya_ca_courseassessments(
	`assessmentid` INTEGER UNSIGNED NOT NULL,
	`courseid` INTEGER UNSIGNED NOT NULL,
	INDEX(`assessmentid`),
	INDEX(`courseid`),
	UNIQUE(assessmentid,courseid),
	FOREIGN KEY(`assessmentid`) REFERENCES ya_ca_assessmentbook(id)  ON DELETE CASCADE
	FOREIGN KEY(`courseid`) REFERENCES ya_courses(`id`)  ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE ya_ca_assessmentparts(
	`id`		INTEGER(11) UNSIGNED AUTO_INCREMENT,
	`code`		CHAR(10) NULL,
	`title`		CHAR(50) NOT NULL,
	`assessmentid`	INTEGER UNSIGNED NOT NULL,
	`parentid`	INTEGER UNSIGNED NULL,
	`parttype`	INTEGER UNSIGNED NOT NULL,	
	`cgp`		INTEGER UNSINGED NOT NULL,
	`subjectscategory`	INTEGER UNSINGED NOT NULL,
	INDEX(`assessmentid`),
	INDEX(`parentid`),
	PRIMARY KEY(`id),
	FOREIGN KEY(`assessmentid`) REFERENCES ya_ca_assessmentbook(id)  ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE ya_ca_assessmentparts ADD FOREIGN KEY(parentid) REFERENCES ya_ca_assessmentparts (id) ON DELETE CASCADE;



CREATE TABLE ya_ca_assessmentterms(
	`id`		INTEGER(11) UNSIGNED AUTO_INCREMENT,
	`code`		CHAR(10) NULL,
	`title`		CHAR(50) NOT NULL,
	`fromdate`	DATE NOT NULL,
	`todate`	DATE NOT NULL,
	`partid`	INTEGER UNSIGNED NOT NULL,
	INDEX(partid),
	PRIMARY KEY(id),
	FOREIGN KEY(`partid`) REFERENCES ya_ca_assessmentparts(id)  ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



CREATE TABLE ya_ca_partsubjects(
	`partid`	INTEGER UNSIGNED NOT NULL,
	`subjectid`	INTEGER UNSIGNED NOT NULL,
	`sno`		INTEGER NULL,
	`isadditional`	INTEGER NULL,
	INDEX(partid),
	INDEX(subjectid),
	UNIQUE(partid,subjectid),
	FOREIGN KEY(`partid`) REFERENCES ya_ca_assessmentparts(id)  ON DELETE CASCADE,
	FOREIGN KEY(`subjectid`) REFERENCES ya_msubjects(id)  ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE ya_ca_subjectgradebook(
	`id`		INTEGER(11) UNSIGNED AUTO_INCREMENT,
	`subjectid`	INTEGER UNSIGNED NOT NULL,
	`gradebookid`	INTEGER UNSIGNED NOT NULL,
	`termid`	INTEGER UNSIGNED NOT NULL,
	INDEX(subjectid),
	INDEX(gradebookid),
	FOREIGN KEY(`subjectid`) REFERENCES ya_msubjects(id)  ON DELETE CASCADE,
	FOREIGN KEY(`termid`) REFERENCES ya_ca_assessmentterms(id)  ON DELETE CASCADE,
	FOREIGN KEY(`gradebookid`) REFERENCES ya_ca_gradebooks(id)  ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE ya_ca_gradebooks(
	`id`		INTEGER(11) UNSIGNED AUTO_INCREMENT,
	`title`		CHAR(100) NOT NULL,
	`aid`		INTEGER UNSIGNED NOT NULL,
	INDEX(`aid`),
	FOREIGN KEY(`aid`) REFERENCES ya_academicyears(id) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


CREATE TABLE ya_ca_gradebookdetails(
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;



CREATE TABLE ya_ca_subjectgradings(
	`id`		INTEGER(11) UNSIGNED AUTO_INCREMENT,
	`subjectid`	INTEGER UNSIGNED NOT NULL,
	`termid`	INTEGER UNSIGNED NOT NULL,
	`gradingid`	INTEGER UNSIGNED NOT NULL,
	INDEX(subjectid),
	INDEX(gradingid),
	INDEX(termid),
	FOREIGN KEY(`subjectid`) REFERENCES ya_msubjects(id)  ON DELETE CASCADE,
	FOREIGN KEY(`termid`) REFERENCES ya_ca_assessmentterms(id)  ON DELETE CASCADE,
	FOREIGN KEY(`gradingid`) REFERENCES ya_ca_gradings(id)  ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
