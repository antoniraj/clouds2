DELIMITER ;;
CREATE TRIGGER trig_groupfeecategory_ins AFTER INSERT ON ya_groupfeecategory
FOR EACH ROW
BEGIN
	DECLARE ssid INT;
	DECLARE b INT;
	DECLARE gfcat CURSOR FOR SELECT sid FROM ya_groupmembers WHERE gid = NEW.gid;
	DECLARE CONTINUE HANDLER FOR NOT FOUND 
		SET b = 0;
	SET b = 1;
	OPEN gfcat;
	FETCH gfcat INTO ssid;
	WHILE b = 1 DO
	insert into ya_loggg VALUES(getstudentclass(ssid));
		INSERT INTO ya_feecollectionmaster(fcid,cid,gid,studentid,paidamount,paiddate,fine,status) VALUES(NEW.fcid,getstudentclass(ssid),NEW.gid,ssid,0.0,current_date,0,0);	
		FETCH gfcat INTO ssid;
	END WHILE;	
	CLOSE gfcat;
END;;
DELIMITER ;
