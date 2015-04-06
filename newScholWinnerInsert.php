<!-- Perform logic to load new scholarship winners, if there are any-->
	<!-- Get New Contest form variables-->
	       <?php
	       if(isset($_GET['convoyearadd'])){
		   $convoyearadd = $_GET['convoyearadd'];
		}
		if(isset($_GET['scholname'])){
		   $scholname=$_GET['scholname'];
		}
		if(isset($_GET['amount'])){
		   $amount=$_GET['amount'];
		}
		if(isset($_GET['winnername'])){
		   $winnername=$_GET['winnername'];
		}
	       ?>



	 <!--If all required inputs captureed, Call function to insert the new scholarship winner into the database-->
	       <?php
		if((isset($_GET['convoyearadd']))&&(isset($_GET['scholname']))&&(isset($_GET['winnername']))&&(isset($_GET['amount']))){
		//echo "Inserting scholarship winner...";
		if(!createNewScholWinner($scholname, $convoyearadd, $winnername, $amount)){
			echo "ERROR: Could not add your scholarship winner!";
		}
		}
	       ?>
