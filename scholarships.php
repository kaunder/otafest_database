<?php
   include "dashboard.php";
?>
<!-- Scholarship specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Scholarships</h1>


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


	   <!--Display all scholarship winners-->
	   <h3>Scholarship Winners</h3>
	  <div class="container-fluid voffset">
	       <?php
		echo getSchoWinners();
	       ?>
	  </div>


	   <!--Insert new scholarship winners-->
	  <h3> Add New Winner</h3>
<form action="scholarships.php" method="get">

	  <b>Convention Year:</b> <!-- Single button -->
	  <div class="btn-group">
<!--	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> -->

	    <!-- Get convention year, if it's already been set-->
	       <?php
	       if(isset($_GET['convoyearadd'])){
		   $convoyearadd = $_GET['convoyearadd'];
		}else{
		   $convoyearadd="Select Convention:";
		}
	       ?>




	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyearadd;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getConvoYearsAdd("scholarships.php", $convoyearadd);?>
		    </ul>
	   </div>



	   <b>Winner:</b> <!-- Single button -->
	  <div class="btn-group">

	    <!-- Get winnername, if it's already been set-->
	       <?php
	       if(isset($_GET['winnername'])){
		   $winnername = $_GET['winnername'];
		}else{
		   $winnername="Select Winner:";
		}
	       ?>


	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $winnername;?> <span class="caret"></span></a>
	    </button>
	    <ul class="dropdown-menu scrollable-menu "role="menu">
		    	<?php echo getVolunteersForDropdown("scholarships.php", $convoyearadd);?>
		    </ul>
	   </div>


	   <b>Scholarship Name: </b>
	   <input type="text" name="scholname">
	   
	   <b>Amount:</b>
	   <input type="text" name="amount"></input>
	   <br/>

	   <input type="hidden" name="convoyearadd" value="<?php echo $convoyearadd; ?>">
	   <input type="hidden" name="winnername" value="<?php echo $winnername; ?>">
	   
  <input type="submit" value="Create!"/>
</form>

	

        </div>









    <?php include "footer.php";?>









