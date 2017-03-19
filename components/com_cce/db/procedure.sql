DELIMITER //

CREATE PROCEDURE proc_dumpstudents(IN oldcid INT, IN startid INT)
BEGIN
        DECLARE b INTEGER;
        DECLARE osid INTEGER(11) UNSIGNED;
        DECLARE sid INTEGER(11) UNSIGNED;
        DECLARE ocid INTEGER(11) UNSIGNED;
        DECLARE cur_p1 CURSOR FOR SELECT id FROM ya_students WHERE id > startid LIMIT 30;
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET b = 1;

        OPEN cur_p1;
        SET b = 0;
        FETCH cur_p1 INTO sid;
        WHILE b <> 1 DO
                INSERT INTO ya_studentclass(studentid,classid) VALUES(sid,oldcid);
                FETCH cur_p1 INTO sid;
        END WHILE;
        CLOSE cur_p1;

END;

//

DELIMITER ;
