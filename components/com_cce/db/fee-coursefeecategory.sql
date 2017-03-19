DELIMITER;;

CREATE TRIGGER trig_coursefeecategory_ins AFTER INSERT ON ya_coursefeecategory
FOR EACH ROW BEGIN
	DECLARE sid INT;
	DECLARE b INT;
	DECLARE cfcat CURSOR FOR SELECT studentid FROM ya_studentclass WHERE classid = NEW.cid;
	DECLARE CONTINUE HANDLER FOR NOT FOUND 
		SET b = 0;
	SET b = 1;
	OPEN cfcat;
	FETCH cfcat INTO sid;
	WHILE b = 1 DO
		INSERT INTO ya_feecollectionmaster(fcid,cid,studentid,paidamount,paiddate,fine,status) VALUES(NEW.fcid,NEW.cid,sid,0.0,current_date,0,0);	
		FETCH cfcat INTO sid;
	END WHILE;	
	CLOSE cfcat;
END;;
                   
DELIMITER;

