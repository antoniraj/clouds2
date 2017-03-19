DROP TABLE ya_sms_timetablecourses;
DROP TABLE ya_sms_timetable;
DROP TABLE ya_sms_timetablelist;

CREATE TABLE ya_sms_timetablelist(
        `id` 	        INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        `title`       	VARCHAR(255) NOT NULL,
	`examid`	INTEGER UNSIGNED NOT NULL,
	INDEX(`examid`),
        FOREIGN KEY(`examid`) REFERENCES ya_tngradebook(`id`) ON DELETE CASCADE,
	PRIMARY KEY(`id`)
) Engine="InnoDB" CHARSET=utf8;


CREATE TABLE ya_sms_timetablecourses(
        `ttid` 	        INTEGER UNSIGNED NOT NULL,
	`courseid`	INTEGER UNSIGNED NOT NULL,
	INDEX(`ttid`),
        FOREIGN KEY(`ttid`) REFERENCES ya_sms_timetablelist(`id`) ON DELETE CASCADE,
	INDEX(`courseid`),
        FOREIGN KEY(`courseid`) REFERENCES ya_courses(`id`) ON DELETE CASCADE,
	PRIMARY KEY(`ttid`,`courseid`)
) Engine="InnoDB" CHARSET=utf8;


CREATE TABLE ya_sms_timetable(
        `id` 	        INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        `sno` 	        INTEGER UNSIGNED NOT NULL,
        `fdate`       	DATE NOT NULL,
	`fn`		VARCHAR(255) NULL,
	`an`		VARCHAR(255) NULL,
	`ttid`		INTEGER UNSIGNED NOT NULL,
	INDEX(`ttid`),
        FOREIGN KEY(`ttid`) REFERENCES ya_sms_timetablelist(`id`) ON DELETE CASCADE,
	PRIMARY KEY(`id`)
) Engine="InnoDB" CHARSET=utf8;

	
