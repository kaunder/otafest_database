<?--Page content to support adding new convo, venue -->
<?--Can only be loaded if user has correct access level -->
<?php
   include "dashboard.php";
?>
<!-- Contests specific stuff starts here-->
	<div class="col-sm-9 col-md-10 main">
	<h1 class="page-header">Conventions</h1>
 
<h3> Create New Convention</h3>

 <!-- Get convention year, if it's already been set-->
	       <?php
	       if(isset($_GET['venuename'])){
		   $venuename = $_GET['venuename'];
		}else{
		   $venuename="Select Venue:";
		}
	       ?>

<div class="row">
	<div class="form-group required">
    	     <label class="col-md-2 control-label" for="venuename">Venue:</label>
 <div class="col-md-4">
<a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $venuename;?> <span class="caret"></span></a>
		  </button>
		    <ul class="dropdown-menu" role="menu">
		    	<?php echo getVenues("manageconvos.php");?>
		    </ul>

            </div>
		  <div class="col-md-6"></div>
       </div>
</div>
 


<?php 
if(isset($_GET['venuename'])&&$accesslev==0){
	include "newconvo.php";	
}
?>



