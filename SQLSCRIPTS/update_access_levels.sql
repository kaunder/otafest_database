
set SQL_SAFE_UPDATES=0;
UPDATE Volunteer SET access_level=1 WHERE volunteer_id IN 
	(SELECT DISTINCT supervisor_id FROM Supervises) 
    OR volunteer_id IN 
    (SELECT DISTINCT manager_id FROM Department);
UPDATE Volunteer SET access_level=0 WHERE firstName="Robert" AND lastName="Collier";
set SQL_SAFE_UPDATES=1;

/*set SQL_SAFE_UPDATES = 0;
Update Volunteer set volunteer_id = 100 where firstName="Em";
set SQL_SAFE_UPDATES = 1;*/