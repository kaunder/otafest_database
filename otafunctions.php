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

		$temp=$temp."<li> Full Name: ".$vol['firstName']." ".$vol['lastName']."</li>";
		$temp.="<li> Nickname: ".$vol['nickName']."</li>";
		$temp.="<li> Phone Number: ".$vol['phoneNumber']."</li>";
		$temp.="<li>Date Of Birth: ".$vol['date_of_birth']."</li>";
		$temp.="<li>Department: ".$vol['dept_name']."</li>";
		$temp.="<li>Emergency Contact: ".$vol['contact_name']."</li>";
		$temp.="<li>Emergency Contact Relationship: ".$vol['relationship']."</li>";
		$temp.="<li>Emergency Contact Phone Number: ".$vol['phone_num']."</li>";
		$temp.="</ul>";

	 	return $temp;
		}
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

