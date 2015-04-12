<?php
   include_once "otafunctions.php";

   //Retrieve session cookie if one already exists in the browser
   session_start();
   //Unset the session for that user
   unset($_SESSION["username"]);  
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>
	  Otafest Volunteer Database - Login
	</title>


<!--Include bootstrap stuff for fancy stylz -->

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="/css/bootstrap-theme.min.css">

<!-- Load jquery for no good reason other than bootstrap complaining-->
<script src="/js/jquery-1.11.2.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="/js/bootstrap.min.js"></script>





	<link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Fugaz+One' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="otatheme.css">



		<script>
	function gotoregister() {
    location.href = "register.php";
}
</script>
    </head>
    
    <body> 

    <div class="container">

       <h1>
	 Welcome to Otafest Volunteer Database
       </h1>
       <h2>
	 Please Login To Continue
       </h2>

<form action="myinfo.php" method="post">
<table border="0" >
<tr>
<td>
<b>Username</b>
</td>
<td><input type="text" name="username">
</tr>
<tr>
<td><b>Password</b></td>
<td><input name="password" type="password"></input></td>
</tr> <br/>
<tr>
<td><input type="submit" value="Submit"/>

</table>
</form>
</center>

</div>
</body>
</html>
