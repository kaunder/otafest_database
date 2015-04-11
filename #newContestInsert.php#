<!-- Perform logic to load new contest, if there are any-->
	<!-- Get New Contest form variables-->
	       <?php
	       if(isset($_GET['convoyearadd'])){
		   $convoyearadd = $_GET['convoyearadd'];
		}
		if(isset($_GET['contestname'])){
		   $contestname=$_GET['contestname'];
		}
		if(isset($_GET['type'])){
		   $type=$_GET['type'];
		}
	       ?>



	 <!--If all required inputs captureed, Call function to insert the new contest into the database-->
	       <?php
		if((isset($_GET['convoyearadd']))&&(isset($_GET['contestname']))&&(isset($_GET['type']))){
		//echo "Inserting contest...";
		if(!createNewContest($contestname, $convoyearadd, $type)){
			echo "ERROR: Could not add your contest!";
		}
		}
	       ?>
