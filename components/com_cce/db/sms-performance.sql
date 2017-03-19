CREATE TABLE `ya_sms_sent_q` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `smstext`	VARCHAR(1000) NOT NULL,
  `mobile`	CHAR(20) NOT NULL,
  `stype`	CHAR(1) NOT NULL,
  `cdate`	DATE NOT NULL,
  `ctime`      TIME NOT NULL,
  `sid`		INTEGER (11) UNSIGNED NOT NULL,
  `logid`	INTEGER(11) UNSIGNED NOT NULL,
  `aid`		INTEGER(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE `ya_sms_sent_status_q` (
  `id` int(11) unsigned NOT NULL ,
  `smstext`	VARCHAR(1000) NOT NULL,
  `mobile`	CHAR(20) NOT NULL,
  `stype`	CHAR(1) NOT NULL,
  `cdate`	DATE NOT NULL,
  `ctime`      TIME NOT NULL,
  `sid`		INTEGER (11) UNSIGNED NOT NULL,
  `logid`	INTEGER(11) UNSIGNED NOT NULL,
  `aid`		INTEGER(11) UNSIGNED NOT NULL,
   `errorcode`	CHAR(10),
   `errortext`  VARCHAR(100),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


DELIMITER ;;
CREATE TRIGGER `trig_sms_sent_status_q_insert` AFTER INSERT ON `ya_sms_sent_status_q`
 FOR EACH ROW BEGIN
	DELETE FROM ya_sms_sent_q WHERE id=NEW.id;
END ;;
DELIMITER ;

