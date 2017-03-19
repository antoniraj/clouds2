DELIMITER ;;
CREATE TRIGGER `trig_feemaster_ins` AFTER INSERT ON `ya_feecollectiontransaction`
FOR EACH ROW BEGIN
        IF NEW.gid > 0 THEN
                UPDATE ya_feecollectionmaster SET paidamount = paidamount+NEW.paidamount, paiddate=current_date WHERE fcid=NEW.fcid AND cid=NEW.cid AND studentid=NEW.studentid AND gid=NEW.gid;
        ELSE
                UPDATE ya_feecollectionmaster SET paidamount = paidamount+NEW.paidamount, paiddate=current_date WHERE fcid=NEW.fcid AND cid=NEW.cid AND studentid=NEW.studentid;
        END IF;
        INSERT INTO ya_feereceipt (fcid,courseid,studentid,cdate,gid) VALUES(NEW.fcid,NEW.cid,NEW.studentid,CURRENT_DATE,NEW.gid);
END ;;
DELIMITER ;

