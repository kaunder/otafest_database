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