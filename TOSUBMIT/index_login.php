<?php
   include_once "FUNCTIONS/otafunctions.php"
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>
	  Otafest Volunteer Database - Login
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
       <h2>
	 Please Login To Continue
       </h2>

<form action="index.php" >
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

<footer>
  <a href="about.php">About</a>
</footer>

</body>
</html>
