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

/*
*Return all shifts with associate department
*/
function SQLgetShifts(){
$sql=<<<SQL
	SELECT W.dept_name, W.shift_start, W.shift_end
	FROM Volunteer V, VolunteerWorks W
	WHERE V.volunteer_id=:userid AND W.volunteer_id=V.volunteer_id AND W.convention_name=:convoyr

SQL;

return $sql;
}

/*
*Return all scholarship winners with year and amount won
*/
function SQLgetSchoWinners(){
$sql=<<<SQL
	SELECT scholarship_name, convention_name, amount, firstName, lastName
	FROM Volunteer V, Scholarship S
	WHERE S.scholarship_winner=V.volunteer_id
SQL;

return $sql;
}

/*
*Return lal contests run in a given convention year
*/
function SQLgetContests(){
$sql=<<<SQL
	SELECT * FROM Contest
	WHERE convention_name=:convoyr;
SQL;

return $sql;
}

/*
*Insert a new Contest into the database
*/
function SQLcreateNewContest(){
$sql=<<<SQL
	INSERT INTO Contest VALUES(:newname, :newtype, :newconvo)
SQL;

return $sql;
}

/*
*Insert a new Scholarship winner into the database
*/
function SQLcreateNewScholWinner(){
$sql=<<<SQL
	INSERT INTO Scholarship VALUES(:scholname, :convoyr, :amount, :wfname, :wlname)
SQL;
return $sql;
}

/*
*Get all volunteers ordered alphabetically by last name
*(for use in a drop-down menu)
*/
function SQLgetVolunteersForDropdown(){
$sql=<<<SQL
 SELECT lastName, firstName FROM volunteerDatabase.Volunteer ORDER BY lastName ASC

SQL;

return $sql;
}