DELIMITER ;;
CREATE TRIGGER `trig_fee_receipt` AFTER INSERT ON `ya_feereceipt`
 FOR EACH ROW BEGIN
	UPDATE ya_feecollectionmaster SET receiptno=NEW.id WHERE fcid=NEW.fcid AND studentid=NEW.studentid and cid=NEW.courseid;
END ;;
DELIMITER ;

