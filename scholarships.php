<?php
   include "dashboard.php";
?>
<!-- Scholarship specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Scholarships</h1>

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


	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyearadd;?> <span class="caret"></span></a>
	    </button>
	    <ul class="dropdown-menu scrollable-menu "role="menu">
		    	<?php echo getVolunteersForDropdown("scholarships.php");?>
		    </ul>
	   </div>



	   <b>Scholarship Name: </b>
	   <input type="text" name="scholname">
	   
	   <b>Amount:</b>
	   <input type="text" name="amount"></input>
	   <br/>

	   <b>Winner's First Name:</b>
	   <input type="text" name="wfname"></input>
	   <br/>

	   <b>Winner's Last Name:</b>
	   <input type="text" name="wlname"></input>
	   <br/>


	   <input type="hidden" name="convoyearadd" value="<?php echo $convoyearadd; ?>">
	   
  <input type="submit" value="Create!"/>
</form>

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
		if(isset($_GET['wfname'])){
		   $wfname=$_GET['wfname'];
		}
		if(isset($_GET['wlname'])){
		   $wlname=$_GET['wlname'];
		}
		if(isset($_GET['amount'])){
		   $amount=$_GET['amount'];
		}
	       ?>

	 <!--If all required inputs captureed, Call function to insert the new scholarship winner into the database-->
	       <?php
		if((isset($_GET['convoyearadd']))&&(isset($_GET['scholname']))&&(isset($_GET['wfname']))&&(isset($_GET['wlname']))&&(isset($_GET['amount']))){
		echo "Inserting scholarship winner...";
		if(!createNewScholWinner($scholname, $convoyearadd, $wfname, $wlname, $amount)){
		echo "ERROR: Could not add your scholarship winner!";
		}
		}
	       ?>

        </div>









    <?php include "footer.php";?>









