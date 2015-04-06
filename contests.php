<?php
   include "dashboard.php";
?>
<!-- Contests specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Contests</h1>

	  <h3>View Contests</h3>

<!-- Single button -->
	  <div class="btn-group">
<!--	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> -->

	    <!-- Get convention year, if it's already been set-->
	       <?php
	       if(isset($_GET['convoyear'])){
		   $convoyear = $_GET['convoyear'];
		}else{
		   $convoyear="Select Convention:";
		}
	       ?>


	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyear;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getConvoYears("contests.php");?>
		    </ul>
	   </div>


	   <!--Display all contest winners-->
	  <div class="container-fluid voffset">
	       <?php
		if(isset($_GET['convoyear'])){
		echo getContests($convoyear);
		}
	       ?>
	  </div>


<!-- Only users with Robert Collier level privilege and higher can create new contests-->
<!-- Therefore check privileges before each -->
      
	  <h3> Create New Contest</h3>
<form action="contests.php" method="get">

	  <b>Convention Year:</b> <!-- Single button -->
	  <div class="btn-group">
<!--	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> -->

	    <!-- Get convention year, if it's already been set-->
	       <?php
	       if(isset($_GET['convoyearadd'])){
		   $convoyearadd = $_GET['convoyearadd'];
		}else{
		   $convoyearadd="Select Convention:";
		}
	       ?>


	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyearadd;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getConvoYearsAdd("contests.php", $convoyear);?>
		    </ul>
	   </div>

	   <b>Contest Name: </b>
	   <input type="text" name="contestname">
	   
	   <b>Contest Type:</b>
	   <input type="text" name="contesttype"></input>
	   <br/>

	   <input type="hidden" name="convoyearadd" value="<?php echo $convoyearadd; ?>">
	   
  <input type="submit" value="Create!"/>
</form>

	<!-- Get New Contest form variables-->
	       <?php
	       if(isset($_GET['convoyearadd'])){
		   $convoyearadd = $_GET['convoyearadd'];
		}
		if(isset($_GET['contestname'])){
		   $contestname=$_GET['contestname'];
		}
		if(isset($_GET['contesttype'])){
		   $contesttype=$_GET['contesttype'];
		}
	       ?>

	 <!--Call function to insert the new Contest into the database, then reload page-->
	       <?php
		if((isset($_GET['convoyearadd']))&&(isset($_GET['contestname']))&&(isset($_GET['contesttype']))){
		echo "Inserting contest...$convoyearadd, $contestname, $contesttype";
		if(!createNewContest($contestname, $contesttype, $convoyearadd)){
		echo "ERROR: Could not add your contest!";
		}
		}
	       ?>



        </div>

    <?php include "footer.php";?>
