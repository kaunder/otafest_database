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

	$deptname;

	if($vols){
		while($dept=$stmt->fetch()){
			//Build the formatted string to be returned
			$deptname=$dept['dept_name'];
			$temp.="<li> $deptname</li>";
		}
	}
	$temp.="</ul>";

	//If query returns zero rows, return message instead
	if(is_null($deptname)){
		$temp="(You didn't work in any departments during $convoyear)";
	}


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

	//Initialize $deptname in this scope
	$deptname=null;

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


	//If volunteer did not work in any depts during the given convo,
	//return a message instead of a blank table
	if(is_null($deptname)){
		$temp="(You didn't work in any departments during $convoyear)";
	}



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

	if(is_null($exyr)){
		$preserveyear="";
	}else{
		$preserveyear="convoyear=$exyr";
	}
	if($years){
		//Build the formatted string to be returned
		while($row=$stmt->fetch()){
			$yr=$row['convention_name'];
			$temp.="<li><a href=\"$dest?convoyearadd=$yr&$preserveyear\">$yr</a></li>";
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

	//Initialize deptname in this scope
	$deptname=null;

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

	//If volunteer did not work any shifts in the specified year,
	//return a message instead of a blank table
	if(is_null($deptname)){
		$temp="(You're not working any shifts during $convoyear)";
	}



	return $temp;

}

/*
*Return all shifts applied for for a given volunteer, convention
*/
function getShiftsApplied($username, $convoyear){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetShiftsApplied();

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

	//Initialize deptname in this scope
	$deptname=null;

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

	//If volunteer did not apply for any shifts in the specified year,
	//return a message instead of a blank table
	if(is_null($deptname)){
		$temp="(You didn't apply for any shifts during $convoyear)";
	}

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
	$temp.="<tr><th>Winner</th><th>Convention</th><th>Scholarship Name</th><th>Scholarship Amount</th></tr>";

	if($schols){
		while($schol=$stmt->fetch()){
			//Build the formatted string to be returned
			$winnerfirst=$schol['firstName'];
			$winnerlast=$schol['lastName'];
			$convo=$schol['convention_name'];
			$amt=$schol['amount'];
			$name=$schol['scholarship_name'];
			$temp.="<tr><td> $winnerfirst $winnerlast</td><td>$convo</td><td>$name</td><td>$amt</td></tr>";
		}
	}
	$temp.="</table>";
	return $temp;

}




/*
*Return all Contests run in a given convention year
*/
function getContests($convoyear, $accesslev){

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

	//Volunteers do not get to see judge names
	if($accesslev<2){
		$temp.="<tr><th>Contest Name</th><th>Contest Type</th><th>Contest Judge(s)</th></tr>";
	}else{
		$temp.="<tr><th>Contest Name</th><th>Contest Type</th></tr>";
	}

	if($contests){
		while($contest=$stmt->fetch()){
			//Build the formatted string to be returned
			$name=$contest['contest_name'];
			$type=$contest['contest_type'];

			//Managers and execs also get to see judges
			if($accesslev<2){
				$judges=$contest['judges'];
				//May exist multiple judges, explode them
				$judgearray=explode(';',$judges);
				//Format result
				$temp.="<tr><td> $name</td><td>$type</td><td>$judgearray[0]";
				for($i=1;$i<count($judgearray);$i++){
					$temp.="<br>$judgearray[$i]";
				}
				$temp.="</td></tr>";
			}else{
				$temp.="<tr><td> $name</td><td>$type</td></tr>";
			}
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
function createNewScholWinner($scholname, $convoyearadd, $winnername, $amount){

	//Split $winnername string on ',' to recover fname, lname
	$names=explode (', ' ,$winnername);
	$wlname=$names[0];
	//only set $wfname if there exists second element
	if(isset($names[1])){
		$wfname=$names[1];
	}

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
	$stmt->bindParam(':amount',$amount,PDO::PARAM_INT);


	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$schols=$stmt->execute();
	//echo "$sql<br>";
	//echo "$scholname<br>";
	//echo "$convoyearadd<br>";
	//echo "$wlname<br>";
	//echo "$wfname<br>";
	//echo "$amount<br>";

	return $schols;
}



/*
*Return names of all volunteers, formatted for use in a drop-down list
*$tag is appended to the end of returned variables and defaults to the empty string
*(this allows multiple uses of this function on the same page without overwriting variables)
*/
function getVolunteersForDropdown($dest, $exyr,$tag=""){

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
			$volid=$vol['volunteer_id'];
			$volname=$lname.", ".$fname;
			$prev=$volname;
			//Display volunteer name, but store volunteer id for easy queries
			$temp.="<li><a href=\"$dest?volname$tag=$volname&volid$tag=$volid&convoyearadd$tag=$exyr\">$lname, $fname</a></li>";
			//Note: need to pass in existing year to preserve value of Convention Year drop down when pg refreshed (if two drop-downs are being used in same page)
		}
	}

	return $temp;
}

/*
*Return names of ONLY volunteers, formatted for use in a drop-down list
*(Managers and executives not included in result)
*/
function getVolunteersForDropdownNoMgr($dest, $exyr){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetVolunteersForDropdownNoMgr();

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
			$volid=$vol['volunteer_id'];
			$volname=$lname.", ".$fname;
			$prev=$volname;
			//Display volunteer name, but store volunteer id for easy queries
			$temp.="<li><a href=\"$dest?volname=$volname&volid=$volid&convoyearadd=$exyr\">$lname, $fname</a></li>";
			//Note: need to pass in existing year to preserve value of Convention Year drop down when pg refreshed (if two drop-downs are being used in same page)
		}
	}

	return $temp;
}



/*
*Return all departments with manager info for a given year
*/
function getDepts($convoyear){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetDepts();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter maxid the value 10, which is of type INT
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$depts=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Department</th><th>Manager</th><th>Manager Phone Number</th></tr>";

	if($depts){
		while($dept=$stmt->fetch()){
			//Build the formatted string to be returned
			$depname=$dept['dept_name'];
			$mgrfname=$dept['firstName'];
			$mgrlname=$dept['lastName'];
			$mgrphone=$dept['phoneNumber'];
			$temp.="<tr><td> $depname</td><td>$mgrfname $mgrlname</td><td>$mgrphone</td></tr>";
		}
	}
	$temp.="</table>";


	return $temp;
}


/*
* Helper function to get ID number(s) associated with volunteer fname, lname
*/
function getVolIDFromName($volname){

	//Split $volname string on ',' to recover fname, lname
	$names=explode (', ' ,$volname);
	$lname=$names[0];
	$fname=$names[1];

	//Call helper SQL fxn to recover volunteer id from fname, lname
	$sql=SQLgetIDFromName();

	//Connect to DB
	$con=connectTODB();

	//On the open connection, create prepared statement
	$stmt = $con->prepare($sql);

	//bind variables
	$stmt->bindParam(':fname',$fname,PDO::PARAM_STR);
	$stmt->bindParam(':lname',$lname,PDO::PARAM_STR);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$namebool=$stmt->execute();

	//Declare counter
	$i=0;

	//If query was succesfull, fetch resulting volunteer_id
	if($namebool){
		while($ids=$stmt->fetch()){
			$id[$i]=$ids['volunteer_id'];
			$i++;
		}
	}

	//return array containing id number(s)
	return $id;

}


/*
*Display all info for given volunteer, with comments (for managers)
*/
function getVolInfoWithComments($volid){

	//Call helper function to get vol id from names
	//$id=getVolIDFromName($volname);


	/*Handle the "George Foreman" case - check whether there is more than
	* one unique ID associated with the input name
	* If ID is not unique - present user with choice of how to proceed
	*/

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetVolInfoWithComments();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind values to parameters
	//this prevents little billy tables
	$stmt->bindParam(':volid',$volid,PDO::PARAM_INT);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$vols=$stmt->execute();

	//Result is returned in table format
	$headerinfo="<h4><b>Personal Info</b></h4><table class='table table-condensed'>";
	$datainfo="<tr><th>ID #</th><th>First Name</th><th>Last Name</th><th>Nickname</th><th>Phone Number</th><th>Date of Birth</th></tr>";

	$headeremerg="<h4><b>Emergency Contact</b></h4><table class='table table-condensed'>";
	$dataemerg="<tr><th>Name</th><th>Phone Number</th><th>Relationship</th></tr>";

	$headercmnts="<h4><b>Comments</b></h4><table class='table table-condensed'>";
	$datacmnts="";

	if($vols){
		while($vol=$stmt->fetch()){
			//Build the formatted strings to be returned

			$id=$vol['volunteer_id'];
			$fname=$vol['firstName'];
			$lname=$vol['lastName'];

			//If volunteer has no nickname, set to "none"
			if(is_null($vol['nickName'])){
				$nkname="(none)";
			}else{
				$nkname=$vol['nickName'];
			}

			$volphone=$vol['phoneNumber'];
			$dob=$vol['date_of_birth'];

			//If volunteer has no emergency contact, set values to "none" or "n/a"
			if(is_null($vol['contact_name'])){
				$emerg="(none)";
				$ephone="n/a";
				$rel="n/a";
			}else{
				$emerg=$vol['contact_name'];
				$ephone=$vol['phone_num'];
				$rel=$vol['relationship'];
			}


			//If comment is null, set value to "none"
			if(is_null($vol['comments'])){
				$cmnt="(no comments on file)";
				$datacmnts.="<tr><td><li>$cmnt</li></td></tr>";
			}else{
				$cmnt=$vol['comments'];
				//Comment may consist of several strings, separate them
				$comments=explode (';' ,$cmnt);


				//Format comments
				for($i=0;$i<count($comments);$i++){
					$datacmnts.="<tr><td><li>$comments[$i]</li></td></tr>";
				}
			}

			$datainfo.="<tr><td>$id</td><td> $fname</td><td>$lname</td><td>$nkname</td><td>$volphone</td><td>$dob</td></tr>";
			$dataemerg.="<tr><td>$emerg</td><td>$ephone</td><td>$rel</td></tr>";
		}
	}


	$datainfo.="</table>";
	$dataemerg.="</table>";
	$datacmnts.="</table>";

	//Concat table parts to get final result
	$result=$headerinfo.$datainfo.$headeremerg.$dataemerg.$headercmnts.$datacmnts;

	return $result;
}

/*
*Helper function to return max current volunteer ID
*/
function getMaxID(){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetMaxID();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);


	//Execute statement
	$nums=$stmt->execute();

	//extract maximum id number currently in use
	if($nums){
		$num=$stmt->fetch();
		$maxID=$num['max'];
	}

	return $maxID;
}

/*
*Insert a new Volunteer
*/
function insertNewVolunteer($fname, $lname, $nname, $num, $dob){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLinsertNewVolunteer();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//Get next unused volunteer id
	$newid=getMaxID()+1;

	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':newid',$newid,PDO::PARAM_INT);
	$stmt->bindParam(':fname',$fname,PDO::PARAM_STR);
	$stmt->bindParam(':lname',$lname,PDO::PARAM_STR);
	$stmt->bindParam(':nname',$nname,PDO::PARAM_STR);
	$stmt->bindParam(':num',$num,PDO::PARAM_STR);
	$stmt->bindParam(':dob',$dob,PDO::PARAM_STR);


	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$vol=$stmt->execute();

	return $vol;
}

/*
*Insert a new comment
*/
function insertNewComment($volid, $comment){


	//call SQL fxn to perform the query, store returned string
	$sql = SQLinsertNewComment();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);


	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':volid',$volid,PDO::PARAM_INT);
	$stmt->bindParam(':comment',$comment,PDO::PARAM_STR);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$cmnt=$stmt->execute();

	if(!$cmnt){
		echo "\nPDO::errorInfo():\n";
		print_r($con->errorInfo());
	}

	return $cmnt;
}


/*
*Display all blacklisted volunteers
*/
function getBlacklist(){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetBlacklist();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$blist=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Name</th><th>Comments</th></tr>";

	if($blist){
		while($bl=$stmt->fetch()){
			//Build the formatted string to be returned
			$fname=$bl['firstName'];
			$lname=$bl['lastName'];
			$comment=$bl['vol_comment'];
			$temp.="<tr><td>$fname $lname</td><td>$comment</td></tr>";
		}
	}
	$temp.="</table>";


	return $temp;
}

/*
*Helper function to return specific emergency contact info
*Used to preserve existing emergency contact info when part of the table is being updated
*/
function getEmergInfo($info, $volid){

	/* $info= 0 -->return name
	*	 = 1 -->return phone number
	*       = 2 -->return relationship
	*/

	//call appropriate SQL fxn to perform the query, store returned string
	if($info==0){
		$sql = SQLgetEmergContactName();
	}else if($info==1){
		$sql = SQLgetEmergPhone();
	}else if($info==2){
		$sql = SQLgetEmergRel();
	}else{
		//No other input values supported - return
		return;
	}


	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':volid',$volid,PDO::PARAM_INT);


	//Execute statement
	$emerg=$stmt->execute();

	//extract result
	if($emerg){
		$em=$stmt->fetch();
		if($info==0){
			$result=$em['contact_name'];
		}else if($info==1){
			$result=$em['phone_num'];
		}else{
			$result=$em['relationship'];
		}
	}

	return $result;
}

/*
*Update/Modify Emergency Contact
*/
function modifyEmergContact($volid, $emergname, $emergphone, $emergrel){


	//Check whether volunteer has existing emergency contact
	$sql0=SQLgetEmergExists();
	$con0=connectToDB();
	$stmt0=$con0->prepare($sql0);
	$stmt0->bindParam(':volid',$volid,PDO::PARAM_INT);
	if($stmt0->execute()){
		$contact=$stmt0->fetch();
		//if volunteer ID is not in the table, record does not exist
		if(is_null($contact['volunteer_id'])){
			$hascontact=False;
		}else{
			$hascontact=True;
		}
	}

	//If volunteer has an existing emerg contact, call the Update function
	//Else, call the Insert function
	if($hascontact==False){
		$sql=SQLinsertEmerg();
	}else{
		$sql=SQLupdateEmerg();
	}


	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);


	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':volid',$volid,PDO::PARAM_INT);
	$stmt->bindParam(':emergname',$emergname,PDO::PARAM_STR);
	$stmt->bindParam(':emergphone',$emergphone,PDO::PARAM_STR);
	$stmt->bindParam(':emergrel',$emergrel,PDO::PARAM_STR);



	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$emergc=$stmt->execute();

	if(!$emergc){
		echo "\nPDO::errorInfo():\n";
		print_r($con->errorInfo());
	}

	return $emergc;
}

/*
*Return department info for a given manager and convo year
*(Manager's view)
*/
function displayDeptInfo($convoyear, $userid){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLdisplayDeptInfo();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);
	$stmt->bindParam(':userid',$userid,PDO::PARAM_INT);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$depts=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Department</th><th>Number of Volunteers Required</th></tr>";

	//delcare variables so they can be user outside the while
	$depname=null;
	$num=null;

	if($depts){
		while($dept=$stmt->fetch()){
			//Build the formatted string to be returned
			$depname=$dept['dept_name'];
			$num=$dept['num_volunteers_req'];
			$temp.="<tr><td> $depname</td><td>$num</td></tr>";
		}
	}
	//If no results returned for the selected convention year,
	//display a message:
	if(is_null($depname)&&is_null($num)){
		$temp="(You didn't manage any departments during $convoyear)";
	}

	$temp.="</table>";


	return $temp;
}

/*
*Return all volunteers who work in a selected dept for a selected convo
*(Manager's view)
*/
function displayDeptVols($convoyear, $userid){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLdisplayDeptVols();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);
	$stmt->bindParam(':userid',$userid,PDO::PARAM_INT);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$depts=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Department</th><th>Volunteer</th></tr>";

	//delcare variables so they can be user outside the while
	$depname=null;

	if($depts){
		while($dept=$stmt->fetch()){
			//Build the formatted string to be returned
			$depname=$dept['dept_name'];
			$volnames=$dept['vnames'];

			//May exist multiple vols/dept, explode them
			$volarray=explode(';',$volnames);

			//Format result
			$temp.="<tr><td>$depname</td><td>$volarray[0]";
			for($i=1;$i<count($volarray);$i++){
				$temp.="<br>$volarray[$i]";
			}
			$temp.="</td></tr>";

		}
	}

	$temp.="</table>";

	//If no results returned for the selected convention year,
	//display a message:
	if(is_null($depname)){
		$temp="(No volunteers worked in your departments during $convoyear)";
	}




	return $temp;
}

/*
*Return names of all contests in a given convention year, formatted for use in a dropdown menu
*$tag is appended to the end of returned variables and defaults to the empty string
*(this allows multiple uses of this function on the same page without overwriting variables)
*/
function getContestNamesForDropdown($dest, $convoyear,$tag=""){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetContestNamesForDropdown();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//Bind variables
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$contests=$stmt->execute();

	$temp="";

	if($contests){
		//Build the formatted string to be returned
		while($contest=$stmt->fetch()){
			$name=$contest['contest_name'];
			//Display contest name
			$temp.="<li><a href=\"$dest?contestnameadd$tag=$name$tag&convoyearadd$tag=$convoyear\">$name</a></li>";
			//Note: need to pass in existing year to preserve value of Convention Year drop down when pg refreshed (if two drop-downs are being used in same page)
		}
	}

	return $temp;
}


/*
*Return names of all volunteers, formatted for use in a drop-down list
*Also saves existing form values
*I know this hard coding is terrible and am duly ashamed. But we're pressed for time, don't judge.
*$tag is appended to the end of returned variables and defaults to the empty string
*(this allows multiple uses of this function on the same page without overwriting variables)
*/
function getVolunteersForDropdown3($dest, $exyr, $excontest,$tag=""){

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
			$volid=$vol['volunteer_id'];
			$volname=$lname.", ".$fname;
			$prev=$volname;
			//Display volunteer name, but store volunteer id for easy queries
			$temp.="<li><a href=\"$dest?volname$tag=$volname&volid$tag=$volid&convoyearadd$tag=$exyr&contestnameadd$tag=$excontest$tag\">$lname, $fname</a></li>";
			//Note: need to pass in existing year, contest name to preserve value of Convention Year, contest name drop down when pg refreshed (if three drop-downs are being used in same page)
		}
	}

	return $temp;
}


/*
*Return names of all volunteers, formatted for use in a drop-down list
*Also saves existing form values
*Ok, this is getting really embarasing now. But desparate times call for desparate measures.
*$tag is appended to the end of returned variables and defaults to the empty string
*(this allows multiple uses of this function on the same page without overwriting variables)
*/
function getVolunteersForDropdown4($dest, $exyr, $exschol,$tag=""){

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
			$volid=$vol['volunteer_id'];
			$volname=$lname.", ".$fname;
			$prev=$volname;
			//Display volunteer name, but store volunteer id for easy queries
			$temp.="<li><a href=\"$dest?volname$tag=$volname&volid$tag=$volid&convoyear=$exyr&scholnameadd=$exschol\">$lname, $fname</a></li>";
			//Note: need to pass in existing year, contest name to preserve value of Convention Year, contest name drop down when pg refreshed (if three drop-downs are being used in same page)
		}
	}

	return $temp;
}


/*
*Insert a new Contest Judge into the database
*/
function createNewContestJudge($convoyr, $contestname, $volid){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLcreateNewContestJudge();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyr,PDO::PARAM_STR);
	$stmt->bindParam(':contestname',$contestname,PDO::PARAM_STR);
	$stmt->bindParam(':volid',$volid,PDO::PARAM_INT);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$contests=$stmt->execute();

	return $contests;
}

/*
*Insert a new Scholarship Judge into the database
*/
function createNewScholarshipJudge($convoyr, $scholname, $volid){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLcreateNewScholarshipJudge();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyr,PDO::PARAM_STR);
	$stmt->bindParam(':scholname',$scholname,PDO::PARAM_STR);
	$stmt->bindParam(':volid',$volid,PDO::PARAM_INT);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$judges=$stmt->execute();


	return $judges;
}


/*
*Return all existing scholarships (used for drop-down menus)
*/
function getScholNamesForDropdown($dest, $exyr){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetScholNamesForDropdown();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$schols=$stmt->execute();

	$temp="";

	if($schols){
		//Build the formatted string to be returned
		while($row=$stmt->fetch()){
			$name=$row['scholarship_name'];
			$temp.="<li><a href=\"$dest?convoyear=$exyr&&scholnameadd=$name\">$name</a></li>";
		}
	}

	return $temp;
}


/*
*Return names of all departments in a given convention year, formatted for use in a dropdown menu
*$tag is appended to the end of returned variables and defaults to the empty string
*(this allows multiple uses of this function on the same page without overwriting variables)
*/
function getDeptNamesForDropdown($dest, $convoyear,$tag=""){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetDeptNamesForDropdown();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//Bind variables
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$depts=$stmt->execute();

	$temp="";

	if($depts){
		//Build the formatted string to be returned
		while($dept=$stmt->fetch()){
			$name=$dept['dept_name'];
			//Display dept name
			$temp.="<li><a href=\"$dest?dept$tag=$name&convoyear$tag=$convoyear\">$name</a></li>";
			//Note: need to pass in existing year to preserve value of Convention Year drop down when pg refreshed (if two drop-downs are being used in same page)
		}
	}

	return $temp;
}

/*
*Return names of all shifts in a given convention year, formatted for use in a dropdown menu
*$tag is appended to the end of returned variables and defaults to the empty string
*(this allows multiple uses of this function on the same page without overwriting variables)
*/
function getShiftsForDropdown($dest, $convoyear,$deptname,$tag=""){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetShiftsForDropdown();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//Bind variables
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$shifts=$stmt->execute();

	$temp="";

	if($shifts){
		//Build the formatted string to be returned
		while($shift=$stmt->fetch()){
			$shiftstart=$shift['shift_start'];
			$shiftend=$shift['shift_end'];
			$shiftname=$shiftstart." - ".$shiftend;
			//Display shift name
			$temp.="<li><a href=\"$dest?shiftstart$tag=$shiftstart$tag&shiftend$tag=$shiftend$tag&shiftname$tag=$shiftname$tag&convoyear=$convoyear&dept=$deptname\">$shiftname</a></li>";
			//Note: need to pass in existing year to preserve value of Convention Year drop down when pg refreshed (if two drop-downs are being used in same page)
		}
	}

	return $temp;
}

/*
*Return volunteers available to work a given shift
*/
function displayAvailableVolunteers($dest, $convoyear, $deptname, $shiftstart, $shiftend, $shiftname){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLdisplayAvailableVolunteers();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind input values to parameters
	//this prevents little billy tables
	$stmt->bindParam(':convoyear',$convoyear,PDO::PARAM_STR);
	$stmt->bindParam(':convoyear2',$convoyear,PDO::PARAM_STR);
	$stmt->bindParam(':deptname',$deptname,PDO::PARAM_STR);
	$stmt->bindParam(':deptname2',$deptname,PDO::PARAM_STR);
	$stmt->bindParam(':shiftstart',$shiftstart,PDO::PARAM_STR);
	$stmt->bindParam(':shiftstart2',$shiftstart,PDO::PARAM_STR);
	$stmt->bindParam(':shiftend',$shiftend,PDO::PARAM_STR);
	$stmt->bindParam(':shiftend2',$shiftend,PDO::PARAM_STR);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$shifts=$stmt->execute();

	//Declare $volid in this scope for use later
	$volid=null;

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Click on Volunteer to Assign Them To This Shift</th></tr>";

	if($shifts){
		while($shift=$stmt->fetch()){
			//Build the formatted string to be returned
			$fname=$shift['firstName'];
			$lname=$shift['lastName'];
			$volid=$shift['volunteer_id'];
			$temp.="<tr><td><a href='$dest?convoyear=$convoyear&&shiftstart=$shiftstart&&shiftend=$shiftend&&volid=$volid&&dept=$deptname&shiftname=$shiftname&go=1'>$fname $lname</a></td></tr>";
		}
	}
	$temp.="</table>";


	//If query returns zero rows, return message instead
	if(is_null($volid)){
		$temp="(No volunteers are available to work in $deptname from $shiftstart to $shiftend)";
	}


	return $temp;
}


/*
*Insert a new entry into the VolunteerWorks table
*/
function insertVolunteerWorks($volid, $dept, $shiftstart, $shiftend, $convoyear){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLinsertVolunteerWorks();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter
	//this prevents little billy tables
	$stmt->bindParam(':dept',$dept,PDO::PARAM_STR);
	$stmt->bindParam(':volid',$volid,PDO::PARAM_INT);
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);
	$stmt->bindParam(':shiftstart',$shiftstart,PDO::PARAM_STR);
	$stmt->bindParam(':shiftend',$shiftend,PDO::PARAM_STR);



	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$works=$stmt->execute();


	return $works;
}


/*
*Insert a new entry into the VolunteerApplies table
*/
function insertVolunteerApplies($volid, $dept, $shiftstart, $shiftend, $convoyear){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLinsertVolunteerApplies();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter
	//this prevents little billy tables
	$stmt->bindParam(':dept',$dept,PDO::PARAM_STR);
	$stmt->bindParam(':volid',$volid,PDO::PARAM_INT);
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);
	$stmt->bindParam(':shiftstart',$shiftstart,PDO::PARAM_STR);
	$stmt->bindParam(':shiftend',$shiftend,PDO::PARAM_STR);



	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$applies=$stmt->execute();


	return $applies;
}

/*
*Return names of all volunteers, formatted for use in a drop-down list
*Also saves existing form values
*$tag is appended to the end of returned variables and defaults to the empty string
*(this allows multiple uses of this function on the same page without overwriting variables)
*/
function getVolunteersForDropdownExtend($dest, $exyr, $tag="", $savestring=""){

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
			$volid=$vol['volunteer_id'];
			$volname=$lname.", ".$fname;
			$prev=$volname;
			//Display volunteer name, but store volunteer id for easy queries
			$temp.="<li><a href=\"$dest?volname$tag=$volname&volid$tag=$volid&convoyear$tag=$exyr&$savestring\">$lname, $fname</a></li>";
			//Note: need to pass in existing year, contest name to preserve value of Convention Year, contest name drop down when pg refreshed (if three drop-downs are being used in same page)
		}
	}

	return $temp;
}


/*
*Return names of all volunteers WHO HAVE NOT BEEN BLACKLISTED
*formatted for use in a drop-down list
*Also saves existing form values
*$tag is appended to the end of returned variables and defaults to the empty string
*(this allows multiple uses of this function on the same page without overwriting variables)
*/
function getVolNotBLForDropdownExtend($dest, $exyr, $tag="", $savestring=""){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetVolNotBLForDropdown();

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
			$volid=$vol['volunteer_id'];
			$volname=$lname.", ".$fname;
			$prev=$volname;
			//Display volunteer name, but store volunteer id for easy queries
			$temp.="<li><a href=\"$dest?volname$tag=$volname&volid$tag=$volid&convoyear$tag=$exyr&$savestring\">$lname, $fname</a></li>";
			//Note: need to pass in existing year, contest name to preserve value of Convention Year, contest name drop down when pg refreshed (if three drop-downs are being used in same page)
		}
	}

	return $temp;
}


/*
*Update manager of a selected dept for a selected convo year
*/
function updateDeptManager($convoyearadd, $deptnameadd, $volidadd){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLupdateDeptManager();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyearadd,PDO::PARAM_STR);
	$stmt->bindParam(':dept',$deptnameadd,PDO::PARAM_STR);
	$stmt->bindParam(':volid',$volidadd,PDO::PARAM_INT);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$managers=$stmt->execute();

	return $managers;
}

/*
*Return all Panels run in a given convention year
*(pass in $accesslev to allow future finer-graned access control)
*/
function getPanels($convoyear, $accesslev){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetPanels();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);


	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$panels=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";

	$temp.="<tr><th>Panel Name</th><th>Category</th><th>Presenter</th><th>Presenter Phone</th><th>Room Number</th><th>Age Rating</th><th>Start Time and Date</th><th>End Time and Date</th></tr>";

	//Declare $name in this scope so can be used later
	$name=null;

	if($panels){
		while($panel=$stmt->fetch()){
			//Build the formatted string to be returned
			$name=$panel['panel_name'];
			$category=$panel['category'];
			$presenter=$panel['presenter'];
			$presenterphone=$panel['presenter_phone_num'];
			$room=$panel['room_num'];
			$age=$panel['age_rating'];
			$start=$panel['start_time_date'];
			$end=$panel['end_time_date'];

			$temp.="<tr><td> $name</td><td>$category</td><td>$presenter</td><td>$presenterphone</td><td>$room</td><td>$age</td><td>$start</td><td>$end</td></tr>";

		}
	}
	$temp.="</table>";

	//If no panels were returned, return a message instead
	if(is_null($name)){
		$temp="(There were no panels held during $convoyear)";
	}

	return $temp;

}


/*
*Return names of all managers, formatted for use in a drop-down list
*Also saves existing form values
*$tag is appended to the end of returned variables and defaults to the empty string
*(this allows multiple uses of this function on the same page without overwriting variables)
*/
function getManagersForDropdownExtend($dest, $exyr){

	//echo "savestring=$savestring";

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetManagersForDropdown();

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
			$mgrid=$vol['volunteer_id'];
			$mgrname=$lname.", ".$fname;
			$prev=$mgrname;
			//Display volunteer name, but store volunteer id for easy queries
			$temp.="<li><a href=\"$dest?mgrname=$mgrname&mgrid=$mgrid&convoyear=$exyr\">$lname, $fname</a></li>";
			//Note: need to pass in existing year, contest name to preserve value of Convention Year, contest name drop down when pg refreshed (if three drop-downs are being used in same page)
		}
	}

	return $temp;
}

/*
*Returns the volunteer id of the manager for the speicified department
*/
function getDeptMgr($convoyear, $dept){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetDeptMgr();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);


	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);
	$stmt->bindParam(':dept',$dept,PDO::PARAM_STR);


	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$managers=$stmt->execute();

	//Result is returned as a single int
	//(This is safe since each dept can have at most one manager)

	//init return variable in this context
	$id=-1;

	if($managers){
		$manager=$stmt->fetch();
		$id=$manager['manager_id'];
	}
	return $id;
}



/*
*Insert a new Panel in the database
*/
function createNewPanel($convoyear, $panelname, $category, $presenter, $presenterphone, $room, $age, $starttd, $endtd, $dept){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLcreateNewPanel();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter
	//this prevents little billy tables
	$stmt->bindParam(':panelname',$panelname,PDO::PARAM_STR);
	$stmt->bindParam(':presenter',$presenter,PDO::PARAM_STR);
	$stmt->bindParam(':category',$category,PDO::PARAM_STR);
	$stmt->bindParam(':presenterphone',$presenterphone,PDO::PARAM_STR);
	$stmt->bindParam(':room',$room,PDO::PARAM_STR);
	$stmt->bindParam(':age',$age,PDO::PARAM_STR);
	$stmt->bindParam(':starttd',$starttd,PDO::PARAM_STR);
	$stmt->bindParam(':endtd',$endtd,PDO::PARAM_STR);
	$stmt->bindParam(':dept',$dept,PDO::PARAM_STR);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$panels=$stmt->execute();

	if(!$panels){
		echo "\nPDO::errorInfo():\n";
		print_r($con->errorInfo());
	}


	return $panels;
}

/*
*Updates website access level
*/
function updateAccessLevel($volid, $newlevel){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLupdateAccessLevel();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter
	//this prevents little billy tables
	$stmt->bindParam(':volid',$volid,PDO::PARAM_INT);
	$stmt->bindParam(':newlevel',$newlevel,PDO::PARAM_INT);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$vols=$stmt->execute();

	return $vols;


}



/*
*Return info for given convention
*(pass in $accesslev to allow future finer-graned access control)
*/
function getConvention($convoyear, $accesslev){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetConvention();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);


	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$convos=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";

	$temp.="<tr><th>Convention Name</th><th>Venue</th><th>Start Date</th><th>End Date</th></tr>";

	//Declare $name in this scope so can be used later
	$name=null;

	if($convos){
		while($convo=$stmt->fetch()){
			//Build the formatted string to be returned
			$name=$convo['convention_name'];
			$venue=$convo['venue_name'];
			$start=$convo['start_date'];
			$end=$convo['end_date'];

			$temp.="<tr><td> $name</td><td>$venue</td><td>$start</td><td>$end</td></tr>";

		}
	}
	$temp.="</table>";

	//If no convos were returned, return a message instead
	if(is_null($name)){
		$temp="(No details on file for $convoyear)";
	}

	return $temp;

}


/*
*Return Venue info for given convention
*(pass in $accesslev to allow future finer-graned access control)
*/
function getVenue($convoyear, $accesslev){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetVenue();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);


	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$venues=$stmt->execute();

	//Result is returned in a table format
	$address="<table class='table table-condensed'>";
	$contact="<table class='table table-condensed'>";

	$address.="<tr><th>Venue Address</th><th>Postal Code</th></tr>";
	$contact.="<tr><th>Venue Contact Person</th><th>Venue Contact Phone</th><th>Coordinating Volunteer</th></tr>";

	if($venues){
		while($venue=$stmt->fetch()){

			//Build the formatted string to be returned
			$addr=$venue['streetAddress'];
			$post=$venue['postalCode'];
			$venuecontact=$venue['contact_person_name'];
			$contactphone=$venue['contact_person_number'];
			$volfname=$venue['firstName'];
			$vollname=$venue['lastName'];

			$address.="<tr><td> $addr</td><td>$post</td></tr>";
			$contact.="<tr><td> $venuecontact</td><td>$contactphone</td><td>$volfname $vollname</td></tr>";

		}
	}
	$address.="</table>";
	$contact.="</table>";

	$result=$address."<br>".$contact;


	return $result;

}


/*
*Return all venues (used for drop-down menus with list of venues)
*/
function getVenues($dest){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetVenues();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$venues=$stmt->execute();

	$temp="";

	if($venues){
		//Build the formatted string to be returned
		while($row=$stmt->fetch()){
			$name=$row['venue_name'];
			$temp.="<li><a href=\"$dest?venuename=$name\">$name</a></li>";
		}
	}

	return $temp;
}

/*
*Return all venues in table format
*/
function getVenuesTable(){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetVenuesTable();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$venues=$stmt->execute();

	$temp="<table class='table table-condensed'>";

	$temp.="<tr><th>Venue Name</th><th>Street Address</th><th>Postal Code</th><th>Contact Person</th><th>Contact Phone</th><th>Coordinating Volunteer</th></tr>";


	if($venues){
		//Build the formatted string to be returned
		while($row=$stmt->fetch()){
			$venuename=$row['venue_name'];
			$addr=$row['streetAddress'];
			$post=$row['postalCode'];
			$contact=$row['contact_person_name'];
			$phone=$row['contact_person_number'];
			$volfirst=$row['firstName'];
			$vollast=$row['lastName'];
			$temp.="<tr><td>$venuename</td><td>$addr</td><td>$post</td><td>$contact</td><td>$phone</td><td>$volfirst $vollast</td></td>";
		}
	}

	$temp.="</table>";

	return $temp;
}


/*
*Insert a new Covention in the database
*/
function createNewConvo($convoname, $venuename, $startdate, $enddate){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLcreateNewConvo();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter
	//this prevents little billy tables
	$stmt->bindParam(':convoname',$convoname,PDO::PARAM_STR);
	$stmt->bindParam(':venuename',$venuename,PDO::PARAM_STR);
	$stmt->bindParam(':startdate',$startdate,PDO::PARAM_STR);
	$stmt->bindParam(':enddate',$enddate,PDO::PARAM_STR);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$newconv=$stmt->execute();

	return $newconv;
}

/*
*Insert a new Department in the database
*/
function createNewDept($convoyear, $mgrid, $deptname, $numvols){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLcreateNewDept();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter
	//this prevents little billy tables
	$stmt->bindParam(':deptname',$deptname,PDO::PARAM_STR);
	$stmt->bindParam(':mgrid',$mgrid,PDO::PARAM_STR);
	$stmt->bindParam(':numvols',$numbols,PDO::PARAM_INT);
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$newdept=$stmt->execute();

	return $newdept;
}



/*
*Insert a new Venue into the database
*/
function createNewVenue($venuename, $addr, $postal, $contact, $phone, $volid){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLcreateNewVenue();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter
	//this prevents little billy tables
	$stmt->bindParam(':venuename',$venuename,PDO::PARAM_STR);
	$stmt->bindParam(':addr',$addr,PDO::PARAM_STR);
	$stmt->bindParam(':postal',$postal,PDO::PARAM_STR);
	$stmt->bindParam(':contact',$contact,PDO::PARAM_STR);
	$stmt->bindParam(':phone',$phone,PDO::PARAM_STR);
	$stmt->bindParam(':volid',$volid,PDO::PARAM_INT);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$newvenue=$stmt->execute();

	return $newvenue;
}


/*
*Return supervisee info for a given manager and convo year
*/
function displaySupervisees($convoyear, $userid){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLdisplaySupervisees();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameters
	//this prevents little billy tables
	$stmt->bindParam(':convoyr',$convoyear,PDO::PARAM_STR);
	$stmt->bindParam(':userid',$userid,PDO::PARAM_INT);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$vols=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Volunteer ID</th><th>Volunteer Name</th><th>Phone Number</th></tr>";

	//delcare variables so they can be user outside the while
	$id=null;

	if($vols){
		while($vol=$stmt->fetch()){
			//Build the formatted string to be returned
			$id=$vol['volunteer_id'];
			$fname=$vol['firstName'];
			$lname=$vol['lastName'];
			$phone=$vol['phoneNumber'];
			$temp.="<tr><td>$id</td><td>$fname $lname</td><td>$phone</td></tr>";
		}
	}
	//If no results returned for the selected convention year,
	//display a message:
	if(is_null($id)){
		$temp="(No one directly reported to you during $convoyear)";
	}

	$temp.="</table>";


	return $temp;
}

/*
*Return all shifts that a volunteer has applied for
*/
function getAppliedFor($userid){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetAppliedFor();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//bind to parameter
	//this prevents little billy tables
	$stmt->bindParam(':userid',$userid,PDO::PARAM_INT);

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$shifts=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";
	$temp.="<tr><th>Department</th><th>Shift Start</th><th>Shift End</th><th>Convention</th></tr>";

	//Declare $depname in this context
	$depname=null;

	if($shifts){
		while($shift=$stmt->fetch()){
			//Build the formatted string to be returned
			$depname=$shift['dept_name'];
			$start=$shift['shift_start'];
			$end=$shift['shift_end'];
			$convo=$shift['convention_name'];
			$temp.="<tr><td> $depname</td><td>$start</td><td>$end</td><td>$convo</td></tr>";
		}
	}
	$temp.="</table>";

	//If user did not apply for any shifts, return message instead
	if(is_null($depname)){
		$temp="You have not applied for any shifts.";
	}

	return $temp;
}


/*
*Return all Scholarship Judges
*Pass in accesslev for future finer-grained access control
*/
function getJudges($convoyear, $accesslev){

	//call SQL fxn to perform the query, store returned string
	$sql = SQLgetJudges();

	//Conncet to database
	$con = connectToDB();

	//On the open connection, create a prepared statement from $sql
	$stmt = $con->prepare($sql);

	//Initialize convo in this scope
	$convo=null;

	//create a variable for the result of the query
	//execute the statment - returns a bool of whether successfull
	$judges=$stmt->execute();

	//Result is returned in a table format
	$temp="<table class='table table-condensed'>";

	$temp.="<tr><th>Convention</th><th>Scholarship Judge(s)</th></tr>";


	if($judges){
		while($judge=$stmt->fetch()){
			//Build the formatted string to be returned
			$convo=$judge['convention_name'];
			$judgenames=$judge['names'];

			//May exist multiple judges, explode them
			$judgearray=explode(';',$judgenames);

			//Format result
			$temp.="<tr><td> $convo</td><td>$judgearray[0]";
			for($i=1;$i<count($judgearray);$i++){
				$temp.="<br>$judgearray[$i]";
			}
			$temp.="</td></tr>";

		}
	}
	$temp.="</table>";

	//If there were no judges, return a message string
	if(is_null($convo)){
		$temp="There are no scholarship judges on file.";
	}

	return $temp;

}
