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
		    	<?php echo getVolunteersForDropdownExtend("depts.php", $convoyearadd, "add", "deptadd=$deptadd");?>
		    </ul>
	   </div>






	   <input type="hidden" name="convoyearadd" value="<?php echo $convoyearadd; ?>">
	   <input type="hidden" name="volnameadd" value="<?php echo $volnameadd; ?>">
	   <input type="hidden" name="deptadd" value="<?php echo $deptadd; ?>">
	   
  <input type="submit" value="Assign Manager"/>
</form>





<?php include "footer.php";?>

