<?php
   include "dashboard.php";
?>
<!-- My Shifts specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Shifts</h1>
	   <h3> Your Shifts:</h3>
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

	       <!--Options in the dropdown menu are all the convention years-->
	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyear;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getConvoYears("myshifts.php");?>
		    </ul>
	   </div>


	   <!--Display shifts for the year selected-->
	  <div class="container-fluid voffset">
	       <?php
	       if(isset($_GET['convoyear'])){
		   $convoyear = $_GET['convoyear'];
		echo getShifts($username, $convoyear);
		}
	       ?>
	  </div>
        </div>

    <?php include "footer.php";?>









