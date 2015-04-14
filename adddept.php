	<div class="col-sm-9 col-md-10 main">
 
<form action="createdept.php" method="get">

<div class="btn-group">

	    <!-- Get manager and id, if already set-->
	       <?php
	       if(isset($_GET['mgrname'])){
		   $mgrname = $_GET['mgrname'];
		}else{
		   $mgrname="Department Manager:";
		}
		if(isset($_GET['mgrid'])){
		   $mrgid=$_GET['mgrid'];
		}
	       ?>

<div class="row">
     <div class="btn-group requried">
    	     <label class="col-md-2 control-label" for="mgrname">Manager:</label>
	     <div class="col-md-4">
	    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $mgrname;?> <span class="caret"></span></a>
	    </button>
	    <ul class="dropdown-menu scrollable-menu "role="menu">
		    	<?php echo getVolunteersForDropdown("createdept.php", "","");?>
	   </ul>
	   </div>
		  <div class="col-md-6"></div>
	</div>
</div>


<div class="row">
	<div class="form-group required">
    	     <label class="col-md-6 control-label" for="deptname">Department Name</label>
    	     <div class="col-md-6">
    	     	  <input type="text" class="form-control required" name="deptname" placeholder="" required>
       	     </div>
	</div>
</div>


 
<div class="row">
	<div class="form-group">
    	     <label class="col-md-6 control-label" for="numvols">Number of Volunteers Required</label>
    	     <div class="col-md-6">
    	     	  <input type="number" class="form-control" name="numvols" placeholder="">
       	     </div>
	</div>
</div>

	   <input type="hidden" name="convoyear" value="<?php echo $convoyear; ?>">
	   
  <input type="submit" value="Create Department!"/>
</form>


        </div>

