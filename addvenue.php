<form action="managevenues.php" method="get">

<div class="row">
	<div class="form-group required">
    	     <label class="col-md-2 control-label" for="venuename">Venue Name</label>
    	     <div class="col-md-4">
    	     	  <input type="text" class="form-control required" name="venuename" placeholder="" required>
       	     </div>
		  <div class="col-md-6"></div>
	</div>
</div>

<div class="row">
	<div class="form-group">
    	     <label class="col-md-2 control-label" for="addr">Street Address</label>
    	     <div class="col-md-4">
    	     	  <input type="text" class="form-control" name="addr" placeholder="" required>
       	     </div>
		  <div class="col-md-6"></div>
	</div>
</div>

<div class="row">
	<div class="form-group">
    	     <label class="col-md-2 control-label" for="postal">Postal Code</label>
    	     <div class="col-md-4">
    	     	  <input type="text" class="form-control" name="postal" placeholder="" required>
       	     </div>
		  <div class="col-md-6"></div>
	</div>
</div>

<div class="row">
	<div class="form-group">
    	     <label class="col-md-2 control-label" for="contact">Venue Contact Person</label>
    	     <div class="col-md-4">
    	     	  <input type="text" class="form-control" name="contact" placeholder="" required>
       	     </div>
		  <div class="col-md-6"></div>
	</div>
</div>

<div class="row">
	<div class="form-group">
    	     <label class="col-md-2 control-label" for="phone">Contact Phone</label>
    	     <div class="col-md-4">
    	     	  <input type="text" class="form-control" name="phone" placeholder="" required>
       	     </div>
		  <div class="col-md-6"></div>
	</div>
</div>

	<input type="hidden" name="volid" value="<?php echo $volid;?>">


  <input type="submit" value="Add New!"/>
</form>

	<!-- Get New Venue form variables-->
	       <?php
	       if(isset($_GET['venuename'])){
		   $venuename = $_GET['venuename'];
		}
		if(isset($_GET['addr'])){
		   $addr=$_GET['addr'];
		}
		if(isset($_GET['postal'])){
		   $postal=$_GET['postal'];
		}
		if(isset($_GET['contact'])){
		   $contact=$_GET['contact'];
		}
		if(isset($_GET['phone'])){
		   $phone=$_GET['phone'];
		}
		if(isset($_GET['volid'])){
		   $volid=$_GET['volid'];
		}
	       ?>

	 <!--Call function to insert the new Venue into the database, then reload page-->
	       <?php
		if((isset($_GET['venuename']))&&(isset($_GET['volid']))){
		     echo "Inserting venue $venuename";
		if(!createNewVenue($venuename, $addr, $postal, $contact, $phone, $volid)){
		     echo "ERROR: Could not add venue!";
		}
		}
	       ?>



        

	


