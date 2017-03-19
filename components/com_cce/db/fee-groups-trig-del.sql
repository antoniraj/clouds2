DELIMITER ;;
CREATE TRIGGER trig_groupfeecategory_del BEFORE DELETE  ON ya_groupfeecategory
FOR EACH ROW
BEGIN
	DELETE FROM ya_feecollectionmaster WHERE gid=OLD.gid AND fcid=OLD.fcid;
END;;
DELIMITER ;
