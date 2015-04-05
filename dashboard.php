<?php
   include_once "otafunctions.php"
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Otafest Database</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

 <!--Include bootstrap stuff for fancy stylz -->

 <!-- Latest compiled and minified CSS -->
 <link rel="stylesheet" href="/css/bootstrap.min.css">

 <!-- Optional theme -->
 <link rel="stylesheet" href="/css/bootstrap-theme.min.css">

 <!-- Load jquery for no good reason other than bootstrap complaining-->
 <script src="/js/jquery-1.11.2.min.js"></script>

 <!-- Latest compiled and minified JavaScript -->
 <script src="/js/bootstrap.min.js"></script>


    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Fugaz+One' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="otatheme.css">



    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


	<script>
		function gotoregister() {
    		location.href = "register.php";
		}
	</script>


  </head>



  <body>
  
  <?php  

session_start();

//SAMPLE LOGIN CODE FROM TUTORIAL
//3. If the form is submitted or not.
//3.1 If the form is submitted
if (isset($_POST['username']) and isset($_POST['password'])){
   //3.1.1 Assigning posted values to variables.
   $username = $_POST['username'];
   $password = $_POST['password'];
   //$accesslev = $_POST['accesslev'];
   

   //3.1.2 Checking the values are existing in the database or not
   $query = "SELECT access_level FROM Volunteer WHERE volunteer_id=:uid";
   

   //Conncet to database
   $con = connectToDB();

   //On the open connection, create a prepared statement from $sql
   //prepared statements are the things that allow you to user placeholders
   $stmt = $con->prepare($query);



   //Check if user inputted an integer - if not, kick back to the login page
   if(ctype_digit(strval($username))){
	//bindto parameter maxid the value 10, which is of type INT
   	$stmt->bindParam(':uid',$username,PDO::PARAM_INT);
   }else{
      header("Location: index.php");   
   }
 
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
   //3.1.3 If the login credentials doesn't match, display error and redirect
   //back to the login page.
   //echo "Invalid Login Credentials! Please try again.";
   header("Location: index.php");   
   }
}
//3.1.4 if the user is logged in Greets the user with message
if (isset($_SESSION['username'])){
$username = $_SESSION['username'];
$accesslev=$_SESSION['accesslev'];

//Set $usertitle string based on user's access level
if($accesslev==2){
$usertitle="Volunteer";
}else if($accesslev==1){
$usertitle="Manager";
}else{
$usertitle="Robert Collier";
}

echo "<a href='logout.php'>Logout</a>"; 
}else{
header("Location: index.php");
 } 
 ?>



    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo "Welcome, " . $usertitle . "!"; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">About</a></li>
	    <li><a href='logout.php'>Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>



    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
	    <li><a href="#">My Info</a></li>
	    <?php
		//Perform access level check to det which tabs should be shown
		//Volunteers have a more restricted set of operations they can perform
            	if($accesslev<2){
			echo"<li><a href=\"#\">Manage My Volunteers</a></li>";
            		echo"<li><a href=\"#\">Departments</a></li>";
            		echo"<li><a href=\"#\">Panels</a></li>";
            		echo"<li><a href=\"#\">Conventions</a></li>";
		}
	    ?>         
	        <li><a href="#">Contests</a></li>
            	<li><a href="#">Scholarships</a></li>
     	</ul>
        </div>
        
	<div class="col-sm-9 col-md-10 main">

	<h1 class="page-header">Hi, <?php echo getVolName($username);?>!</h1>

          <h3>Your Information:</h3>

	  <div class="container-fluid voffset">
	       <?php
	       echo getVolInfo($username);
	
	       ?>
	  </div>


	   <h3> Your Departments:</h3>
	  <!-- Single button -->
	  <div class="btn-group">
	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	        Select Convention Year: <span class="caret"></span>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getConvoYears();?>
		    </ul>
	   </div>


	  <div class="container-fluid voffset">
	       <?php
	       if(isset($_GET['convoyear'])){
		   $convoyear = $_GET['convoyear'];
		echo getVolDeptsByYear($username, $convoyear);
		}
	       ?>
	  </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

<html>
    <head>
        <title>
	  Otafest Volunteer Database - Login
	</title>








	
    </head>
    
    <body> 

    <div class="container">


</div>
</body>
</html>
