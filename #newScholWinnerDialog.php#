<?php
   include "dashboard.php";
   include "newScholWinnerInsert.php";
?>
<!-- Scholarship specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Scholarships</h1>


<!--Only load portion of page to enter new scholarhsip winners if user has permission -->

	




	   <!--Insert new scholarship winners-->
	  <h3> Add New Scholarship Winner</h3>
<form action="newScholWinnerDialog.php" method="get">

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
		    	<?php echo getConvoYearsAdd("newScholWinnerDialog.php", $convoyearadd);?>
		    </ul>
	   </div>



	   <b>Winner:</b> <!-- Single button -->
	  <div class="btn-group">

	    <!-- Get volname, id, if already set-->
	       <?php
	       if(isset($_GET['volname'])){
		   $volname = $_GET['volname'];
		}else{
		   $volname="Select Winner:";
		}
		
		if(isset($_GET['volid'])){
		   $volid=$_GET['volid'];
		}

	       ?>


	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $volname;?> <span class="caret"></span></a>
	    </button>
	    <ul class="dropdown-menu scrollable-menu "role="menu">
		    	<?php echo getVolunteersForDropdown("newScholWinnerDialog.php", $convoyearadd);?>
		    </ul>
	   </div>


	   <b>Scholarship Name: </b>
	   <input type="text" name="scholname">
	   
	   <b>Amount:</b>
	   <input type="text" name="amount"></input>
	   <br/>

	   <input type="hidden" name="convoyearadd" value="<?php echo $convoyearadd; ?>">
	   <input type="hidden" name="volname" value="<?php echo $volname; ?>">
	   
  <input type="submit" value="Create!"/>
</form>


</div>  

<?php include "addscholjudge.php";?>

