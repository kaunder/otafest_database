<?php
   include "dashboard.php";
?>

	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Shifts</h1>




 <!---------------Apply For A Shift------------------>
	
<h3>Apply For A Shift</h3>

<form action="myshiftsapply.php" method="get">

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

	       <!--Convention Year Dropdown -->
	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyear;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getConvoYears("myshiftsapply.php");?>
		    </ul>
	   </div>



	    <!-- Get dept name, if it's already been set-->
	       <?php
	       if(isset($_GET['dept'])){
		   $dept = $_GET['dept'];
		}else{
		   $dept="Select Department:";
		}
	       ?>

	       <!-- Initialize fake bool to id whether all fields for add judge are filled in-->
	       <?php
	       if(isset($_GET['go'])){
		$go=$_GET['go'];
	       }else{
		$go=0;
	       }
	       ?>


	       <!--Department Name Dropdown -->
	  <div class="btn-group">
	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $dept;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getDeptNamesForDropdown("myshiftsapply.php", $convoyear);?>
		    </ul>
	   </div>



<b>Shift:</b> <!-- Single button -->
	  <div class="btn-group">
<!--	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> -->

	    <!-- Get shifts, if they have already been set-->
	       <?php
	       if(isset($_GET['shiftname'])){
		   $shiftname = $_GET['shiftname'];
		}else{
		   $shiftname="Select Shift:";
		}	
		if(isset($_GET['shiftstart'])){
		   $shiftstart=$_GET['shiftstart'];
		}
		if(isset($_GET['shiftend'])){
		   $shiftend=$_GET['shiftend'];
		}
	       ?>

	       <!--Shifts Dropdown -->
	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $shiftname;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getShiftsForDropdown("myshiftsapply.php", $convoyear, $dept);?>
		    </ul>
	   </div>



	   
	   <input type="hidden" name="convoyear" value="<?php echo $convoyear; ?>">
	   <input type="hidden" name="dept" value="<?php echo $dept; ?>">
	   <input type="hidden" name="shiftname" value="<?php echo $shiftname; ?>">
	   <input type="hidden" name="shiftstart" value="<?php echo $shiftstart; ?>">
	   <input type="hidden" name="shiftend" value="<?php echo $shiftend; ?>">
	   <input type="hidden" name="go" value="1">
	   
  <input type="submit" value="Apply"/>

</form>

	<!-- Get Availability form variables-->
	       <?php
	       if(isset($_GET['convoyear'])){
		   $convoyear = $_GET['convoyear'];
		}
		if(isset($_GET['dept'])){
		   $dept=$_GET['dept'];
		}
		if(isset($_GET['shiftstart'])){
		   $shiftstart=$_GET['shiftstart'];
		}
		if(isset($_GET['shiftend'])){
		   $shiftend=$_GET['shiftend'];
		}
		if(isset($_GET['shiftname'])){
		   $shiftname=$_GET['shiftname'];
		}
	       ?>


	       <!--If volid is set, insert the selected volunteer into the Applies table-->
	       <?php
		if((isset($_GET['convoyear']))&&(isset($_GET['dept']))&&(isset($_GET['shiftstart']))&&(isset($_GET['shiftend']))&&($go==1)){
			//Insert selected volunteer into Applies table for the selected dept, shift, convo
			if(!insertVolunteerApplies($username, $dept, $shiftstart, $shiftend, $convoyear)){
				echo "Could not apply for shift.";
			}else{
				echo "You have applied for $shiftname in $dept!";
			}
		}
	       ?>


	 
  </div>
</div>


    <?php include "footer.php";?>

