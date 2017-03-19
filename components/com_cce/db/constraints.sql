
CREATE TABLE ya_staff_pref_slots(
	`staffid`		INTEGER UNSIGNED NOT NULL,
	`daycode`	CHAR(10) NOT NULL,
	`sessioncode`	CHAR(10) NOT NULL,
	UNIQUE(`staffid`,`daycode`,`sessioncode`),
	FOREIGN KEY(`staffid`) REFERENCES ya_staffs(`id`) ON DELETE CASCADE
) Engine="InnoDB" CHARSET=utf8;

CREATE TABLE ya_staff_not_available_slots(
	`staffid`		INTEGER UNSIGNED NOT NULL,
	`daycode`	CHAR(10) NOT NULL,
	`sessioncode`	CHAR(10) NOT NULL,
	UNIQUE(`staffid`,`daycode`,`sessioncode`),
	FOREIGN KEY(`staffid`) REFERENCES ya_staffs(`id`) ON DELETE CASCADE
) Engine="InnoDB" CHARSET=utf8;

CREATE TABLE ya_class_not_available_slots(
	`classid`		INTEGER UNSIGNED NOT NULL,
	`daycode`	CHAR(10) NOT NULL,
	`sessioncode`	CHAR(10) NOT NULL,
	UNIQUE(`classid`,`daycode`,`sessioncode`),
	FOREIGN KEY(`classid`) REFERENCES ya_courses(`id`) ON DELETE CASCADE
) Engine="InnoDB" CHARSET=utf8;
CREATE TABLE ya_activity_pref_slots(
	`actid`		INTEGER UNSIGNED NOT NULL,
	`daycode`	CHAR(10) NOT NULL,
	`sessioncode`	CHAR(10) NOT NULL,
	UNIQUE(`actid`,`daycode`,`sessioncode`),
	FOREIGN KEY(`actid`) REFERENCES ya_tt_activities(`id`) ON DELETE CASCADE
) Engine="InnoDB" CHARSET=utf8;
