DELIMITER ;;
CREATE FUNCTION getstudentclass(ssid INTEGER) RETURNS INTEGER
BEGIN
	DECLARE clid INTEGER;
	SELECT id INTO clid FROM ya_courses WHERE aid IN (SELECT id FROM ya_academicyears WHERE status='Y') AND  id IN (SELECT classid FROM ya_studentclass WHERE studentid=ssid);
	RETURN clid;

END;;
DELIMITER ;
