<?php
   include "dashboard.php";
?>
<!-- Contests specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Past Scholarship Winners</h1>

	   <!--Display all scholarship winners-->
	  <div class="container-fluid voffset">
	       <?php
		echo getSchoWinners();
	       ?>
	  </div>
        </div>

    <?php include "footer.php";?>









