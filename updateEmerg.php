<!---------------Update Emergency Contact Info---------------------------->

<h3>Add/Modify Emergency Contact</h3>

<form action="manageVols.php" method="get">
	<b>Volunteer:</b> <!-- Single button -->
	<div class="btn-group">

		<!-- Get volname and id, if already set-->
		<?php
		if(isset($_GET['volnameEC'])){
			$volnameEC = $_GET['volnameEC'];
		}else{
			$volnameEC="Select Volunteer:";
		}
		if(isset($_GET['volidEC'])){
			$volidEC=$_GET['volidEC'];
		}
		?>


		<a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $volnameEC;?> <span class="caret"></span></a>
	</button>
	<ul class="dropdown-menu scrollable-menu "role="menu">
		<?php echo getVolunteersForDropdown("manageVols.php", "","EC");?>
	</ul>
</div>

<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label" for="emergname">Contact Name</label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="emergname" placeholder="e.g. Jenny Tutone">
		</div>
	</div>
</div>


<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label" for="emergphone">Phone Number:</label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="emergphone" placeholder="e.g.403-867-5309">
		</div>
	</div>
</div>

<div class="row">
	<div class="form-group">
		<label class="col-md-2 control-label" for="emergrel">Relationship:</label>
		<div class="col-md-4">
			<input type="text" class="form-control" name="emergrel" placeholder="e.g. Spouse">
		</div>
	</div>
</div>

<?php if(isset($_GET['volidEC'])){
	echo '<input type="hidden" name="volidEC" value="'.$volidEC.'"></input>';
}?>

<input type="submit" value="Update Contact"/>
</form>

<!-- Perform logic to load selected volunteer, new comment-->
<!-- If new emerg contact values set, update. Else, take existing emerg contact values
from database -->
<?php
if(isset($_GET['volidEC'])){
	$volidEC = $_GET['volidEC'];

	if(isset($_GET['emergname']) && $_GET['emergname'] != ''){
		$emergname=$_GET['emergname'];
	}else{
		$emergname=getEmergInfo(0,$volidEC);
	}
	if(isset($_GET['emergphone']) && $_GET['emergphone'] != ''){
		$emergphone=$_GET['emergphone'];
	}else{
		$emergphone=getEmergInfo(1,$volidEC);
	}
	if(isset($_GET['emergrel']) && $_GET['emergrel'] != ''){
		$emergrel=$_GET['emergrel'];
	}else{
		$emergrel=getEmergInfo(2,$volidEC);
	}
}
?>

<!--If all required inputs captureed, call function to insert new comment-->
<?php
if((isset($_GET['volidEC']))&&(isset($_GET['emergname'])||isset($_GET['emergphone'])||isset($_GET['emergrel']))){
	if(!modifyEmergContact($volidEC, $emergname, $emergphone, $emergrel)){
		echo "ERROR: Could update Emergency Contact!";
	}else{
		echo "Emergency Contact updated!";
	}
}
?>
