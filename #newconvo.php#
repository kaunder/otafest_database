<form action="manageconvos.php" method="get">

<div class="row">
	<div class="form-group required">
    	     <label class="col-md-2 control-label" for="convoname">Convention Name</label>
    	     <div class="col-md-4">
    	     	  <input type="text" class="form-control required" name="convoname" placeholder="" required>
       	     </div>
		  <div class="col-md-6"></div>
	</div>
</div>


<div class="row">
	<div class="form-group">
    	     <label class="col-md-2 control-label" for="startdate">Start Date</label>
    	     <div class="col-md-4">
    	     	  <input type="date" class="form-control" name="startdate" placeholder="">
       	    </div>
       </div>
</div>

<div class="row">
	<div class="form-group">
    	     <label class="col-md-2 control-label" for="enddate">End Date</label>
    	     <div class="col-md-4">
    	     	  <input type="date" class="form-control" name="enddate" placeholder="">
       	    </div>
       </div>
</div>

	<input type="hidden" name="venuename" value="<?php echo $venuename;?>">

  <input type="submit" value="Create!"/>
</form>

	<!-- Get New Contest form variables-->
	       <?php
	       if(isset($_GET['convoname'])){
		   $convoname = $_GET['convoname'];
		}
		if(isset($_GET['venuename'])){
		   $venuename=$_GET['venuename'];
		}
		if(isset($_GET['startdate'])){
		   $startdate=$_GET['startdate'];
		}
		if(isset($_GET['enddate'])){
		   $enddate=$_GET['enddate'];
		}
	       ?>

	 <!--Call function to insert the new Convention into the database, then reload page-->
	       <?php
		if((isset($_GET['convoname']))&&(isset($_GET['venuename']))){
		echo "Inserting convention...$convoname, $venuename";
		if(!createNewConvo($convoname, $venuename, $startdate, $enddate)){
		echo "ERROR: Could not add convention!";
		}
		}
	       ?>



        </div>

	
<?php include "footer.php";?>