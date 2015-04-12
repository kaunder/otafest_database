<!--This page is only displayed if user has manager or higher privileges -->

<!-- Manager specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">

	  <h3>Update Department Managers</h3>

<form action="depts.php" method="get">

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
		    	<?php 
			if(isset($_GET['convoyear'])){
				$yeartopreserve=$_GET['convoyear'];
			}else{
				$yeartopreserve=null;
			}
			echo getConvoYearsAdd("depts.php", $yeartopreserve);?>
		    </ul>
	   </div>




	   <b>Department:</b> <!-- Single button -->
	    <!-- Get dept name, if it's already been set-->
	       <?php
	       if(isset($_GET['deptadd'])){
		   $deptadd = $_GET['deptadd'];
		}else{
		   $deptadd="Select Department:";
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


	       <!--Department Name Dropdown -->
	  <div class="btn-group">
	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $deptadd;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getDeptNamesForDropdown("depts.php", $convoyearadd, "add");?>
		    </ul>
	   </div>





	   <b>Volunteer:</b> <!-- Single button -->
	  <div class="btn-group">

	    <!-- Get volname, id, if already set-->
	       <?php
	       if(isset($_GET['volnameadd'])){
		   $volnameadd = $_GET['volnameadd'];
		}else{
		   $volnameadd="Select Volunteer:";
		}
		
		if(isset($_GET['volidadd'])){
		   $volidadd=$_GET['volidadd'];
		}

	       ?>


	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $volnameadd;?> <span class="caret"></span></a>
	    </button>
	    <ul class="dropdown-menu scrollable-menu "role="menu">
		    	<?php
			  $preserve="deptadd=$deptadd";
			  if(isset($_GET['volidadd'])){
			    $preserve.="&volidadd=$volidadd";
			  }
			  //Only existing managers should exist in the dropdown
			  echo getVolunteersForDropdownExtend("depts.php", $convoyearadd, "add", $preserve);?>
		    </ul>
	   </div>






	   <input type="hidden" name="convoyearadd" value="<?php echo $convoyearadd; ?>">
	   <input type="hidden" name="volnameadd" value="<?php echo $volnameadd; ?>">
	   <input type="hidden" name="deptadd" value="<?php echo $deptadd; ?>">
	   <input type="hidden" name="go" value="1">
	   <?php
	     if(isset($volidadd)){
		echo "<input type=\"hidden\" name=\"volidadd\" value=\"$volidadd\">";
	     }
	   ?>
  <input type="submit" value="Assign Manager"/>
</form>


	<!-- Get Update Manager form variables-->
	       <?php
	       if(isset($_GET['convoyearadd'])){
		   $convoyearadd = $_GET['convoyearadd'];
		}
		if(isset($_GET['deptadd'])){
		   $deptnameadd=$_GET['deptadd'];
		}
		if(isset($_GET['volidadd'])){
		   $volidadd=$_GET['volidadd'];
		}
	       ?>



	 <!--If all required inputs captureed, Call function to update manager -->
	       <?php
		if((isset($_GET['convoyearadd']))&&(isset($_GET['deptadd']))&&(isset($_GET['volidadd']))&&$go==1){
		echo "Updating manager...";
		if(!updateDeptManager($convoyearadd, $deptadd, $volidadd)){
			echo "ERROR: Could not update manager for $deptnameadd!";
		}
		if(!updateAccessLevel($volidadd, 1)){
			echo "ERROR: Could not update website access level for new manager. Please contact webmaster.";
		}
		}
	       ?>



<?php include "footer.php";?>

