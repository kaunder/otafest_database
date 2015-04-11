<?--Page content to support adding new contest -->
<?--Can only be loaded if user has correct access level -->
<?php
   include "dashboard.php";
?>
<!-- Contests specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Panels</h1>
 
<h3> Create New Panel</h3>

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
		    	<?php echo getConvoYears("managepanels.php");?>
		    </ul>
	   </div>



<!--Only execs and the manager of the Special Events Dept can add new panels -->
<!--Therefore only load new panel form if user is exec or Special Events mgr -->
<!-- for the selected year-->
<?php

	if(isset($_GET['convoyear'])){
	if(getDeptMgr($convoyear, "Special Events")==$username||($accesslev==0)){
		include "addpanel.php";
	}else{
		echo "<h4>Sorry, you don't have permission to do this!<br><br>Please contact the manager of the Special Events department to request the addition of a new panel.</h4>";
	}
}
?>

<?php include "footer.php";?>

