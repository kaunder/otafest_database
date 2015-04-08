<?php
   include "dashboard.php";
?>

	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Volunteers</h1>




 <!---------------Insert new volunteer---------------------------->
	
	  <h3> Add New Volunteer</h3>



<form action="addNewVolunteer.php" method="get">
<div class="row">
         <div class="form-group required">
     	 	  <label class="col-md-2 control-label" for="firstName">First Name</label>
    		    <div class="col-md-4">
    	  	    	 <input type="text" class="form-control required" id="firstName" placeholder="e.g. Donald" required>
		    </div>
		    <div class="col-md-6"> </div>
	</div>
</div>		    

<div class="row">
	<div class="form-group required">
    	     <label class="col-md-2 control-label" for="lastName">Last Name</label>
    	     <div class="col-md-4">
    	     	  <input type="text" class="form-control required" id="lastName" placeholder="e.g. Chamberlin" required>
       	     </div>
		  <div class="col-md-6"></div>
	</div>
</div>


<div class="row">
	<div class="form-group">
    	     <label class="col-md-2 control-label" for="nickName">Nickname</label>
    	     <div class="col-md-4">
    	     	  <input type="text" class="form-control" id="nickName" placeholder="e.g. Mr. SQL">
       	    </div>
       </div>
</div>

<div class="row">
	<div class="form-group">
    	     <label class="col-md-2 control-label" for="phoneNumber">Phone Number</label>
    	     <div class="col-md-4">
    	     	  <input type="tel" class="form-control" id="phoneNumber" placeholder="e.g. 408-997-3188">
       	    </div>
       </div>
</div>


<div class="row">
	<div class="form-group">
    	     <label class="col-md-2 control-label" for="dob">Date Of Birth</label>
    	     <div class="col-md-4">
    	     	  <input type="date" class="form-control" id="dob" placeholder="">
       	    </div>
       </div>
</div>



	   <input type="hidden" name="convoyearadd" value="<?php echo $convoyearadd; ?>">
	   <input type="hidden" name="volname" value="<?php echo $volname; ?>">
	   
  <input type="submit" value="Create!"/>
</form>


  </div>



    <?php include "footer.php";?>

