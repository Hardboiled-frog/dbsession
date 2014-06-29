DELIMITER $$
CREATE DEFINER=`Przemek`@`%` PROCEDURE `get_session`(
	IN oId VARCHAR(32)
)
BEGIN
	SELECT data FROM sesje WHERE id = oId;
END$$
DELIMITER ;



DELIMITER $$
CREATE DEFINER=`Przemek`@`%` PROCEDURE `mod_session`(
	IN pId VARCHAR(32),
	IN pAccess INT(10),
	IN pData TEXT
)
BEGIN
	DECLARE vId VARCHAR(32);
	DECLARE vAccess INT(10);
	DECLARE vData TEXT;

	IF EXISTS (SELECT * FROM sesje WHERE id = pId) THEN
		IF (pData = "") THEN
			SELECT data INTO vData FROM sesje WHERE id = pId;
			REPLACE INTO sesje VALUES (pId, pAccess, vData);
		ELSE
			REPLACE INTO sesje VALUES (pId, pAccess, pData);
		END IF;

	ELSE
		INSERT INTO sesje VALUES (pId, pAccess, pData);
	END IF;
END$$
DELIMITER ;



DELIMITER $$
CREATE DEFINER=`Przemek`@`%` PROCEDURE `rem_session`(
	IN pId VARCHAR(32)
)
BEGIN
	DELETE FROM sesje WHERE id = pId;
END$$
DELIMITER ;



DELIMITER $$
CREATE DEFINER=`Przemek`@`%` PROCEDURE `rem_sessions`(
	IN pAccess INT(10)
)
BEGIN
	DELETE FROM sesje WHERE access < pAccess;
END$$
DELIMITER ;
