<?php
   include "dashboard.php";
?>
<!-- My Info specific stuff starts here-->
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
<!--	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> -->

	    <!-- Get convention year, if it's already been set-->
	       <?php
	       if(isset($_GET['convoyear'])){
		   $convoyear = $_GET['convoyear'];
		}else{
		   $convoyear="Select Convention Year:";
		}
	       ?>


	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyear;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getConvoYears();?>
		    </ul>
	   </div>


	  <div class="container-fluid voffset">
	       <?php
	       if(isset($_GET['convoyear'])){
		   $convoyear = $_GET['convoyear'];
		echo getVolDeptsByYearWMgr($username, $convoyear);
		}
	       ?>
	  </div>
        </div>

    <?php include "footer.php";?>









