<?php //you don't close this block because the whole block is php

//This file contains all of the php functions that will be called from the main
//html files. 

//Turn on error reporting
error_reporting(E_ALL);


//Include SQL functions file
include_once "sqlfxns.php";

/*
*Get volunteer's first name
*(For site personalization)
*/
//function getname()


/*
*List volunteer names
*/
function listvolunteers(){

//$_GET is a superglobal - defines current runtime env
	 if(isset($_GET['maxid'])){
		$maxid=$_GET['maxid'];
	 }else{
		$maxid=10;
	 }	 

	 //store a string into the variable $sql
	 $sql = <<<SQL
	      	SELECT Volunteer.firstName, Volunteer.lastName
		FROM Volunteer
		WHERE volunteer_id<:maxid
SQL;
	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 //prepared statements are the things that allow you to user placeholders
	 $stmt = $con->prepare($sql);
	 
	 //bind to parameter maxid the value 10, which is of type INT
	 $stmt->bindParam(':maxid',$maxid,PDO::PARAM_INT);
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$vols=$stmt->execute();

	//html unordered list
	$temp="<ul class='vols'>";

	if($vols){
	//fetch returns one row of the statement as an assosiative array
	//so indexed by keys=column names requested in SELECT
		while($vol=$stmt->fetch()){
			$temp.="<li>".$vol['firstName']." ".$vol['lastName']."</li>";
		}
		
	}
	$temp.="</ul>";
	
	 return $temp;
}



/*
*Return all info for a given volunteer
*/
function getVolInfo($username){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLgetVolInfo();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //bind to parameter maxid the value 10, which is of type INT
	 //this prevents little billy tables
	 $stmt->bindParam(':userid',$username,PDO::PARAM_INT);
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$vols=$stmt->execute();

	$temp="<ul class='vols'>";
	if($vols){
	$vol=$stmt->fetch();
		//Build the formatted string to be returned
		//Replace any null values with "none"
		$temp=$temp."<li> Full Name: ".$vol['firstName']." ".$vol['lastName']."</li>";
		if(!is_null($vol['nickName'])){
			$temp.="<li> Nickname: ".$vol['nickName']."</li>";
		}else{
			$temp.="<li> Nickname: (none)</li>";
		}
		$temp.="<li> Phone Number: ".$vol['phoneNumber']."</li>";
		$temp.="<li>Date Of Birth: ".$vol['date_of_birth']."</li>";
		if(!is_null($vol['contact_name'])){
			$temp.="<li>Emergency Contact: ".$vol['contact_name']."</li>";
			$temp.="<li>Emergency Contact Relationship: ".$vol['relationship']."</li>";
			$temp.="<li>Emergency Contact Phone Number: ".$vol['phone_num']."</li>";
		}else{
			$temp.="<li>Emergency Contact: (none)</li>";
		}
		$temp.="</ul>";

	 	return $temp;
		}
}

/*
*Return all departments worked by a volunteer for a given convention year
*/
function getVolDeptsByYear($username, $convoyear){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLgetVolDeptsByYear();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //bind to parameter maxid the value 10, which is of type INT
	 //this prevents little billy tables
	 $stmt->bindParam(':userid',$username,PDO::PARAM_INT);
	 $stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$vols=$stmt->execute();

	$temp="<ul class=vols>";
	//$temp.="<h4>Departments Worked During $convoyear:</h4>";
	if($vols){
	while($dept=$stmt->fetch()){
		//Build the formatted string to be returned
		$deptname=$dept['dept_name'];
		$temp.="<li> $deptname</li>";
		}
	}
		$temp.="</ul>";
		return $temp;
}


/*
*Return all departments worked by a volunteer for a given convention year with dept manager
*/
function getVolDeptsByYearWMgr($username, $convoyear){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLgetVolDeptsByYearWMgr();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //bind to parameter maxid the value 10, which is of type INT
	 //this prevents little billy tables
	 $stmt->bindParam(':userid',$username,PDO::PARAM_INT);
	 $stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$vols=$stmt->execute();

	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Department</th><th>Manager</th><th>Manager's Phone Number</th></tr>";

	//$temp.="<h4>Departments Worked During $convoyear:</h4>";
	if($vols){
	while($dept=$stmt->fetch()){
		//Build the formatted string to be returned
		$deptname=$dept['dept_name'];
		$mgrfname=$dept['firstName'];
		$mgrlname=$dept['lastName'];
		$mgrphone=$dept['phoneNumber'];
		$temp.="<tr><td> $deptname</td><td>$mgrfname $mgrlname</td><td>$mgrphone</td></tr>";
		}
	}
		$temp.="</table>";
		return $temp;
}


/*
*Return all convention years (used for drop-down menus with list of convo years)
*/
function getConvoYears($dest){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLgetConvoYears();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$years=$stmt->execute();

	$temp="";

	if($years){
		//Build the formatted string to be returned
		while($row=$stmt->fetch()){
			$yr=$row['convention_name'];
			$temp.="<li><a href=\"$dest?convoyear=$yr\">$yr</a></li>";
		}
	}

return $temp;
}


/*
*Return all convention years - when you need two indep convo years drop downs
*on the same page (pass in existing year to preserve orig button value)
*/
function getConvoYearsAdd($dest, $exyr){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLgetConvoYears();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$years=$stmt->execute();

	$temp="";

	if($years){
		//Build the formatted string to be returned
		while($row=$stmt->fetch()){
			$yr=$row['convention_name'];
			$temp.="<li><a href=\"$dest?convoyearadd=$yr&convoyear=$exyr\">$yr</a></li>";
		}
	}

return $temp;
}

/*
*Connect to Volsunteer Database
*/
function connectToDB(){
	 $dsn = 'mysql:host=localhost; dbname=volunteerDatabase;';
	 $username = 'webtest';
	 $password = 'robertcollier';
	 return new PDO($dsn, $username, $password);
}

/*
*Return volunteer nickname (if exists) or first name (otherwise)
*(For website personalization only)
*/
function getVolName($username){

 	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLgetVolName();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //bind userid to $username
	 $stmt->bindParam(':userid',$username,PDO::PARAM_INT);

	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull

	$temp="";

	if($stmt->execute()){
		//Build the formatted string to be returned
		$name=$stmt->fetch();
		
		//If user has a nickname, return that
		if(!is_null($name['nickname'])){
			$temp=$name['nickname'];
		}else{
			//Otherwise, return the user's first name
			$temp=$name['firstName'];		
		}
	}
	return $temp;
}

/*
*Return all shifts for all departments in a given convention year
*/
function getShifts($username, $convoyear){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLgetShifts();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //bind to parameter maxid the value 10, which is of type INT
	 //this prevents little billy tables
	 $stmt->bindParam(':userid',$username,PDO::PARAM_INT);
	 $stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$shifts=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Department</th><th>Shift Start</th><th>Shift End</th></tr>";

	if($shifts){
	while($shift=$stmt->fetch()){
		//Build the formatted string to be returned
		$deptname=$shift['dept_name'];
		$shiftstart=$shift['shift_start'];
		$shiftend=$shift['shift_end'];
		$temp.="<tr><td> $deptname</td><td>$shiftstart</td><td>$shiftend</td></tr>";
		}
	}
		$temp.="</table>";
return $temp;

}

/*
*Return all past scholarship winners in table format
*/
function getSchoWinners(){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLgetSchoWinners();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$schols=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Winner</th><th>Convention</th><th>Scholarship Amount</th></tr>";

	if($schols){
	while($schol=$stmt->fetch()){
		//Build the formatted string to be returned
		$winnerfirst=$schol['firstName'];
		$winnerlast=$schol['lastName'];
		$convo=$schol['convention_name'];
		$amt=$schol['amount'];
		$temp.="<tr><td> $winnerfirst $winnerlast</td><td>$convo</td><td>$amt</td></tr>";
		}
	}
		$temp.="</table>";
return $temp;

}




/*
*Return all Contests run in a given convention year
*/
function getContests($convoyear){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLgetContests();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //bind to parameter maxid the value 10, which is of type INT
	 //this prevents little billy tables
	 $stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$contests=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Contest Name</th><th>Contest Type</th></tr>";

	if($contests){
	while($contest=$stmt->fetch()){
		//Build the formatted string to be returned
		$name=$contest['contest_name'];
		$type=$contest['contest_type'];
		$temp.="<tr><td> $name</td><td>$type</td></tr>";
		}
	}
		$temp.="</table>";
return $temp;

}

/*
*Insert a new Contest in the database
*/
function createNewContest($newname, $newtype, $newconvo){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLcreateNewContest();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //bind to parameter maxid the value 10, which is of type INT
	 //this prevents little billy tables
	 $stmt->bindParam(':newname',$newname,PDO::PARAM_STR);
	 $stmt->bindParam(':newtype',$newtype,PDO::PARAM_STR);
	 $stmt->bindParam(':newconvo',$newconvo,PDO::PARAM_STR);
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$contests=$stmt->execute();

return $contests;
}

/*
*Insert a new Scholarship winner in the database
*/
function createNewScholWinner($scholname, $convoyearadd, $wfname, $wlname, $amount){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLcreateNewScholWinner();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //bind to parameter maxid the value 10, which is of type INT
	 //this prevents little billy tables
	 $stmt->bindParam(':scholname',$scholname,PDO::PARAM_STR);
	 $stmt->bindParam(':convoyr',$convoyearadd,PDO::PARAM_STR);
	 $stmt->bindParam(':wfname',$wfname,PDO::PARAM_STR);
	 $stmt->bindParam(':wlname',$wlname,PDO::PARAM_STR);
	 $stmt->bindParam(':amount',$amount,PDO::PARAM_STR);
	 

	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$contests=$stmt->execute();

return $contests;
}



/*
*Return names of all volunteers, formatted for use in a drop-down list
*/
function getVolunteersForDropdown($dest){

	 //call SQL fxn to perform the query, store returned string
	 $sql = SQLgetVolunteersForDropdown();

	//Conncet to database
 	 $con = connectToDB();
	 
	 //On the open connection, create a prepared statement from $sql
	 $stmt = $con->prepare($sql);
	 
	 //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	$vols=$stmt->execute();

	$temp="";

	if($vols){
		//Build the formatted string to be returned
		while($vol=$stmt->fetch()){
			$fname=$vol['firstName'];
			$lname=$vol['lastName'];
			$temp.="<li><a href=\"$dest?fname=$fname&lname=$lname\">$lname, $fname</a></li>";
		}
	}

return $temp;
}
