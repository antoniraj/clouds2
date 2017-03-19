CREATE TABLE ya_feestructures(
	`id`	INTEGER UNSIGNED AUTO_INCREMENT NOT NULL,
	`title`		VARCHAR(130) NOT NULL,
	`aid`		INTEGER UNSIGNED NOT NULL,
	INDEX(`aid`),
	PRIMARY KEY(`id`),
	FOREIGN KEY (aid) REFERENCES ya_academicyears(`id`) ON DELETE CASCADE
)ENGINE=InnoDB CHARSET=utf8;


CREATE TABLE ya_feecategorystructures(
	`fcid`		INTEGER UNSIGNED NOT NULL,
	`fstid`		INTEGER UNSIGNED NOT NULL,
	INDEX(`fcid`),
	INDEX(`fstid`),
	UNIQUE(`fcid`,`fstid`),
	FOREIGN KEY (fcid) REFERENCES ya_feecategory(`id`) ON DELETE CASCADE,
	FOREIGN KEY (fstid) REFERENCES ya_feestructures(`id`) ON DELETE CASCADE
)ENGINE=InnoDB CHARSET=utf8;
