<?php 
//This file contains the SQL queries required for all functions
//in otafunctions.php

//Return all info for the selected volunteer
function SQLgetVolInfo(){

$sql=<<<SQL
	SELECT V.volunteer_id, V.firstName, V.lastName, V.nickName, V.phoneNumber, V.date_of_birth, E.contact_name, E.phone_num, E.relationship
	FROM Volunteer V LEFT OUTER JOIN EmergencyContact E ON V.volunteer_id=E.volunteer_id LEFT OUTER JOIN VolunteerWorks W ON V.volunteer_id=W.volunteer_id 
	WHERE V.volunteer_id=:userid 

SQL;

return $sql;

}

//Return all depts worked by a selected volunteer for a selected year
function SQLgetVolDeptsByYear(){
$sql=<<<SQL
	SELECT DISTINCT W.dept_name
	FROM Volunteer V LEFT OUTER JOIN VolunteerWorks W ON V.volunteer_id=W.volunteer_id 
	WHERE V.volunteer_id=:userid AND W.convention_name=:convoyr
SQL;

return $sql;
}

//Return all depts worked by a selected volunteer for a selected year with associated dept manager
function SQLgetVolDeptsByYearWMgr(){
$sql=<<<SQL
	SELECT W.convention_name, W.dept_name, M.firstName, M.lastName, M.phoneNumber
	FROM Volunteer U JOIN VolunteerWorks W ON U.volunteer_id=W.volunteer_id JOIN Department D ON W.dept_name=D.dept_name AND W.convention_name=D.convention_name JOIN Volunteer M ON D.manager_id= M.volunteer_id
	WHERE U.volunteer_id=:userid AND W.convention_name=:convoyr
SQL;

return $sql;
}

//Return all convention names (years)
function SQLgetConvoYears(){
$sql=<<<SQL
	SELECT convention_name FROM volunteerDatabase.Convention; 
SQL;

return $sql;
}

//Return volunteer nickname, firstname (used for personalization)
function SQLgetVolName(){
$sql=<<<SQL
	SELECT V.firstName, V.nickname
    	FROM Volunteer V
    	Where V.volunteer_id=:userid
SQL;

return $sql;
}

