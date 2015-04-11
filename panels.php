<?php
   include "dashboard.php";
?>
<!-- Panel specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Panels</h1>
	<h3>View Panels</h3>

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
		    	<?php echo getConvoYears("panels.php");?>
		    </ul>
	   </div>


	   <!--Display all contest winners-->
	  <div class="container-fluid voffset">
	       <?php
		if(isset($_GET['convoyear'])){
			echo getPanels($convoyear, $accesslev);
		}
	       ?>
	  </div>






    <?php include "footer.php";?>









