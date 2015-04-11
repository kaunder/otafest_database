<?php
   include "dashboard.php";
?>
<!-- Scholarship specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Scholarships</h1>


<!--Only load portion of page to enter new scholarhsip winners if user has permission -->

	 <?php
		if($accesslev==0){
		  include "newScholWinnerInsert.php";
		}
	 ?>




	   <!--Display all scholarship winners-->
	   <h3>Scholarship Winners</h3>
	  <div class="container-fluid voffset">
	       <?php
		echo getSchoWinners();
	       ?>
	  </div>


<!--Only load portion of page to enter new scholarhsip winners if user has permission -->

	 
    <?php include "footer.php";?>









