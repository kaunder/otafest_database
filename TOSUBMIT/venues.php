<!-- Convention specific stuff starts here-->

	<h3>Venue Details</h3>



	   <!--Display selected convention details-->
	  <div class="container-fluid voffset">
	       <?php
		if(isset($_GET['convoyear'])){
			echo getVenue($convoyear, $accesslev);
		}
	       ?>
	  </div>


<br>
<h3>Venues:</h3>


	   <!--Display all venues-->
	  <div class="container-fluid voffset">
	       <?php
		  echo getVenuesTable();
	       ?>

	  </div>