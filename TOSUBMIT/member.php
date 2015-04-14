<?php
   include_once "FUNCTIONS/otafunctions.php"
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>
	  Otafest Volunteer Database - Welcome
	</title>

	<link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Fugaz+One' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="STYLE/otatheme.css">

		<script>
	function gotoregister() {
    location.href = "register.php";
}
</script>
    </head>
    
    <body> 
       <h1>
	 Welcome to Otafest Volunteer Database
       </h1>

<html>
    <head>
        <title>Member</title>		
    </head>
        <body bgcolor="#FFFFCC">
<?php  

session_start();
//require_once 'connect.php';  	


 



//3. If the form is submitted or not.
//3.1 If the form is submitted
if (isset($_POST['username']) and isset($_POST['password'])){
   //3.1.1 Assigning posted values to variables.
   $username = $_POST['username'];
   $password = $_POST['password'];





   //3.1.2 Checking the values are existing in the database or not
   $query = "SELECT access_level FROM Volunteer WHERE volunteer_id=:uid";
   

   //Conncet to database
   $con = connectToDB();


         //On the open connection, create a prepared statement from $sql
	 //prepared statements are the things that allow you to user placeholders
	 $stmt = $con->prepare($query);


         //bind to parameter maxid the value 10, which is of type INT
	 $stmt->bindParam(':uid',$username,PDO::PARAM_INT);
	 
 
         //create a variable for the result of the query
	 //execute the statment - returns a bool of whether successfull
	 $result=$stmt->execute();


   //$result = mysqli_query($con,$query) or die(mysqli_error());
   $count = $stmt->rowCount();

  //mysqli_num_rows($result);

   //echo $count;

   //3.1.2 If the posted values are equal to the database values, then session will be created for the user.
   if ($count == 1){
        $_SESSION['username'] = $username;
        $row=$stmt->fetch();
        $_SESSION['accesslev']= $row["access_level"];
        $accesslev=$_SESSION['accesslev'];
}else{
   //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
   echo "Invalid Login Credentials! Please try again.";
   }
}
//3.1.4 if the user is logged in Greets the user with message
if (isset($_SESSION['username'])){
$username = $_SESSION['username'];

if($accesslev==2){
echo "Welcome, Volunteer!<br>";
}else if($accesslev==1){
echo "Welcome, Manager!<br>";
}else{
echo "Welcome, Robert Collier!<br>";
}

echo "<a href='logout.php'>Logout</a>"; 
}else{
header("Location: index.php");
 } 
 ?>
 </body>
</html>
