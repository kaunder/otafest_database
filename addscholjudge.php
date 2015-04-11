<div class="col-sm-9 col-md-10 main">
<h3> Add Scholarship Judge</h3>

<form action="newScholWinnerDialog.php" method="get">

	  <b>Convention Year:</b> <!-- Single button -->
	  <div class="btn-group">
<!--	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> -->

	    <!-- Get convention year for new schol form, if it's already been set-->
	       <?php
	       if(isset($_GET['convoyear'])){
		   $convoyear = $_GET['convoyear'];
		}else{
		   $convoyear="Select Convention:";
		}
	       ?>


	    <!-- Get convention year from previous form to preserve value-->
	       <?php
	       if(isset($_GET['convoyearadd'])){
		   $convoyearadd = $_GET['convoyearadd'];
		}else{
		   $convoyearadd="Select Convention:";
		}
	       ?>


	       <!--Convention Year Dropdown -->

	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyear;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getConvoYears("newScholWinnerDialog.php", $convoyearadd);?>
		    </ul>
	   </div>



	    <!-- Get schol name, if it's already been set-->
	       <?php
	       if(isset($_GET['scholnameadd'])){
		   $scholnameadd = $_GET['scholnameadd'];
		}else{
		   $scholnameadd="Select Contest:";
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


	       <!--Schol Name Dropdown -->
	  <div class="btn-group">
	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $scholnameadd;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getScholNamesForDropdown("newScholWinnerDialog.php", $convoyear);?>
		    </ul>
	   </div>


	   <!--Judge dropdown menu -->

	   <b>New Judge:</b> <!-- Single button -->
	  <div class="btn-group">

	    <!-- Get volunteer name,id if it's already been set-->
	       <?php
	       if(isset($_GET['volnamej'])){
		   $volnamej = $_GET['volnamej'];
		}else{
		   $volnamej="Select Volunteer:"; 
		}

		if(isset($_GET['volidj'])){
		   $volidj=$_GET['volidj'];
		}
	       ?>


	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $volnamej;?> <span class="caret"></span></a>
	    </button>
	    <ul class="dropdown-menu scrollable-menu "role="menu">
		    	<?php echo getVolunteersForDropdown4("newScholWinnerDialog.php", $convoyear, $scholnameadd, "j");?>
		    </ul>
	   </div>

	   <input type="hidden" name="convoyear" value="<?php echo $convoyear; ?>">
	   <input type="hidden" name="scholnameadd" value="<?php echo $scholnameadd; ?>">
	   <input type="hidden" name="volnamej" value="<?php echo $volnamej; ?>">
	   <input type="hidden" name="volidj" value="<?php echo $volidj; ?>">
	   <input type="hidden" name="go" value="1">
	   </div>
  <input type="submit" value="Add Judge!"/>
</form>

	<!-- Get New Judge form variables-->
	       <?php
	       if(isset($_GET['convoyear'])){
		   $convoyear = $_GET['convoyear'];
		}
		if(isset($_GET['scholnameadd'])){
		   $scholnameadd=$_GET['scholnameadd'];
		}
		if(isset($_GET['volidj'])){
		   $volidj=$_GET['volidj'];
		}
	       ?>

	 <!--Call function to insert the new Scholarship Judge into the database-->
	       <?php
		if((isset($_GET['convoyear']))&&(isset($_GET['scholnameadd']))&&(isset($_GET['volidj']))&&($go==1)){
		echo "Inserting judge...$convoyear, $scholnameadd, $volnamej";
		if(!createNewScholarshipJudge($convoyear, $scholnameadd, $volidj)){
			echo "ERROR: Could not add judge!";
		}
		}
	       ?>

        </div>

	

    <?php include "footer.php";?>
