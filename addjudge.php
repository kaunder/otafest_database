<div class="col-sm-9 col-md-10 main">
<h3> Add Contest Judge</h3>

<form action="managecontests.php" method="get">

	  <b>Convention Year:</b> <!-- Single button -->
	  <div class="btn-group">
<!--	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> -->

	    <!-- Get convention year for new judge form, if it's already been set-->
	       <?php
	       if(isset($_GET['convoyearadd'])){
		   $convoyearadd = $_GET['convoyearadd'];
		}else{
		   $convoyearadd="Select Convention:";
		}
	       ?>


	    <!-- Get convention year from previous form to preserve value-->
	       <?php
	       if(isset($_GET['convoyear'])){
		   $convoyear = $_GET['convoyear'];
		}else{
		   $convoyear="Select Convention:";
		}
	       ?>


	       <!--Convention Year Dropdown -->

	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyearadd;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getConvoYearsAdd("managecontests.php", $convoyear);?>
		    </ul>
	   </div>



	    <!-- Get contest name, if it's already been set-->
	       <?php
	       if(isset($_GET['contestnameadd'])){
		   $contestnameadd = $_GET['contestnameadd'];
		}else{
		   $contestnameadd="Select Contest:";
		}
	       ?>

	       <!-- Initialize fake bool to id whether all fields for add judge are filled in-->
	       <?php
	       if(isset($_GET['go'])){
		$go=$_GET['go'];
	       }else{
		$go=0;
	       }
	       ?>


	       <!--Contest Name Dropdown -->
	  <div class="btn-group">
	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $contestnameadd;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getContestNamesForDropdown("managecontests.php", $convoyearadd);?>
		    </ul>
	   </div>


	   <!--Volunteer dropdown menu -->

	   <b>New Judge:</b> <!-- Single button -->
	  <div class="btn-group">

	    <!-- Get volunteer name,id if it's already been set-->
	       <?php
	       if(isset($_GET['volname'])){
		   $volname = $_GET['volname'];
		}else{
		   $volname="Select Volunteer:"; 
		}

		if(isset($_GET['volid'])){
		   $volid=$_GET['volid'];
		}
	       ?>


	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $volname;?> <span class="caret"></span></a>
	    </button>
	    <ul class="dropdown-menu scrollable-menu "role="menu">
		    	<?php echo getVolunteersForDropdown3("managecontests.php", $convoyearadd, $contestnameadd);?>
		    </ul>
	   </div>

	   <input type="hidden" name="convoyearadd" value="<?php echo $convoyearadd; ?>">
	   <input type="hidden" name="contestnameadd" value="<?php echo $contestnameadd; ?>">
	   <input type="hidden" name="volname" value="<?php echo $volname; ?>">
	   <input type="hidden" name="volid" value="<?php echo $volid; ?>">
	   <input type="hidden" name="go" value="1">
	   </div>
  <input type="submit" value="Add Judge!"/>
</form>

	<!-- Get New Judge form variables-->
	       <?php
	       if(isset($_GET['convoyearadd'])){
		   $convoyearadd = $_GET['convoyearadd'];
		}
		if(isset($_GET['contestnameadd'])){
		   $contestnameadd=$_GET['contestnameadd'];
		}
		if(isset($_GET['volid'])){
		   $volid=$_GET['volid'];
		}
	       ?>

	 <!--Call function to insert the new Contest Judge into the database-->
	       <?php
		if((isset($_GET['convoyearadd']))&&(isset($_GET['contestnameadd']))&&(isset($_GET['volid']))&&($go==1)){
		//echo "Inserting judge...$convoyearadd, $contestname, $volname";
		if(!createNewContestJudge($convoyearadd, $contestnameadd, $volid)){
			echo "ERROR: Could not add judge!";
		}else{
			echo "Judge Added!";
		}
		}
	       ?>

        </div>

	

    <?php include "footer.php";?>
