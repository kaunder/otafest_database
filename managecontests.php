<?--Page content to support adding new contest -->
<?--Can only be loaded if user has correct access level -->
<?php
   include "dashboard.php";
?>
<!-- Contests specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Contests</h1>
 
<h3> Create New Contest</h3>
<form action="managecontests.php" method="get">

	  <b>Convention Year:</b> <!-- Single button -->
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
		    	<?php echo getConvoYears("managecontests.php");?>
		    </ul>
	   </div>

	   <b>Contest Name: </b>
	   <input type="text" name="contestname">
	   
	   <b>Contest Type:</b>
	   <input type="text" name="contesttype"></input>
	   <br/>

	   <input type="hidden" name="convoyear" value="<?php echo $convoyear; ?>">
	   
  <input type="submit" value="Create!"/>
</form>

	<!-- Get New Contest form variables-->
	       <?php
	       if(isset($_GET['convoyear'])){
		   $convoyear = $_GET['convoyear'];
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
		if((isset($_GET['convoyear']))&&(isset($_GET['contestname']))&&(isset($_GET['contesttype']))){
		echo "Inserting contest...$convoyear, $contestname, $contesttype";
		if(!createNewContest($contestname, $contesttype, $convoyear)){
		echo "ERROR: Could not add your contest!";
		}
		}
	       ?>



        </div>

	

    <?php include "addjudge.php";?>
