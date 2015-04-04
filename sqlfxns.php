<?php 
//This file contains the SQL queries required for all functions
//in otafunctions.php


function SQLgetVolInfo(){

$sql=<<<SQL
	SELECT V.volunteer_id, V.firstName, V.lastName, V.nickName, V.phoneNumber, V.date_of_birth, W.dept_name, E.contact_name, E.phone_num, E.relationship
	FROM Volunteer V LEFT OUTER JOIN EmergencyContact E ON V.volunteer_id=E.volunteer_id LEFT OUTER JOIN VolunteerWorks W ON V.volunteer_id=W.volunteer_id
	WHERE V.volunteer_id=:userid 

SQL;

return $sql;

}