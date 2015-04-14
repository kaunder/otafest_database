<?php
	include_once "otafunctions.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			Otafest Volunteer Database
		</title>
<link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Fugaz+One' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="otatheme.css">
	</head>
	<body>
	<!-- 2+2=<?php echo 2+2; ?> -->
	     <h1>
	     Otafest Volunteers
	     </h1>
	     
	     <form action="index.php">
	     	   How many volunteers you want? 
		   <input type="number" name="maxid" min="1">
		   <input type="submit" value="Do It">
	     </form>

	     Here is a list of volunteers:
	     <?php
		echo listvolunteers();
	     ?>
		
		<footer>
			<a href="about.php">About</a>
		</footer>
	     
	</body>
</html>

