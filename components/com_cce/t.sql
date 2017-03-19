DELIMITER ;;
CREATE TRIGGER trig_coursefeecategory_del BEFORE DELETE  ON ya_coursefeecategory
FOR EACH ROW
BEGIN
        DELETE FROM ya_feecollectionmaster WHERE cid=OLD.cid AND fcid=OLD.fcid;
        DELETE FROM ya_feecollectiontransaction WHERE cid=OLD.cid AND fcid=OLD.fcid;
END ;;
DELIMITER ;

