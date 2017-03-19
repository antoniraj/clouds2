CREATE TABLE `ya_feereceiptcancellation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `studentid` int(11) unsigned NOT NULL,
  `fcid` int(11) unsigned NOT NULL,
  `cid` int(11) unsigned NOT NULL,
  `paiddate` date NOT NULL,
  `paidamount` decimal(7,2) DEFAULT NULL,
  `paymentmode` char(10) DEFAULT NULL,
  `bankname` char(30) DEFAULT NULL,
  `chequeorddno` char(20) DEFAULT NULL,
  `chequeordddate` date DEFAULT NULL,
  `receiptno` char(15) NOT NULL,
  `gid` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

