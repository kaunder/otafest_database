<?php
include "dashboard.php";
?>

<div class="col-sm-9 col-md-10 main">
  <h1 class="page-header">Shift Management</h1>




  <!---------------Show available volunteers for each shift------------------>
  
  <h3>View Available Volunteers</h3>

  <form action="shifts.php" method="get">

    <b>Convention Year:</b> <!-- Single button -->
    <div class="btn-group">
      <!--	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> -->

      <!-- Get convention year, if it's already been set-->
      <?php
      if(isset($_GET['convoyear'])){
        $convoyear = $_GET['convoyear'];
      }else{
        $convoyear="Select Convention:";
      }
      ?>

      <!--Convention Year Dropdown -->
      <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyear;?> <span class="caret"></span></a>
    </button>
    <ul class="dropdown-menu" role="menu">
      <?php echo getConvoYears("shifts.php");?>
    </ul>
  </div>



  <!-- Get dept name, if it's already been set-->
  <?php
  if(isset($_GET['dept'])){
    $dept = $_GET['dept'];
  }else{
    $dept="Select Department:";
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
  <b>Department:</b> <!-- Single button -->
  <div class="btn-group">
    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $dept;?> <span class="caret"></span></a>
  </button>
  <ul class="dropdown-menu" role="menu">
    <?php echo getDeptNamesForDropdown("shifts.php", $convoyear);?>
  </ul>
</div>



<b>Shift:</b> <!-- Single button -->
<div class="btn-group">
  <!--	    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> -->

  <!-- Get shifts, if they have already been set-->
  <?php
  if(isset($_GET['shiftname'])){
    $shiftname = $_GET['shiftname'];
  }else{
    $shiftname="Select Shift:";
  }
  if(isset($_GET['shiftstart'])){
    $shiftstart=$_GET['shiftstart'];
  }
  if(isset($_GET['shiftend'])){
    $shiftend=$_GET['shiftend'];
  }
  ?>

  <!--Shifts Dropdown -->
  <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $shiftname;?> <span class="caret"></span></a>
</button>
<ul class="dropdown-menu" role="menu">
  <?php echo getShiftsForDropdown("shifts.php", $convoyear, $dept);?>
</ul>
</div>







<input type="hidden" name="convoyear" value="<?php echo $convoyear; ?>">
<input type="hidden" name="dept" value="<?php echo $dept; ?>">
<input type="hidden" name="shiftname" value="<?php echo $shiftname; ?>">
<input type="hidden" name="shiftstart" value="<?php if(isset($shiftstart)){echo $shiftstart;} ?>">
<input type="hidden" name="shiftend" value="<?php if(isset($shiftend)){echo $shiftend;} ?>">
<input type="hidden" name="go" value="1">

<input type="submit" value="View Available Volunteers"/>

</form>

<!-- Get Availability form variables-->
<?php
if(isset($_GET['convoyear'])){
  $convoyear = $_GET['convoyear'];
}
if(isset($_GET['dept'])){
  $dept=$_GET['dept'];
}
if(isset($_GET['shiftstart'])){
  $shiftstart=$_GET['shiftstart'];
}
if(isset($_GET['shiftend'])){
  $shiftend=$_GET['shiftend'];
}
if(isset($_GET['shiftname'])){
  $shiftname=$_GET['shiftname'];
}
if(isset($_GET['volid'])){
  $volid=$_GET['volid'];
}
?>


<!--If volid is set, insert the selected volunteer into the Works table-->
<?php
if(isset($_GET['volid'])&&(isset($_GET['convoyear']))&&(isset($_GET['dept']))&&(isset($_GET['shiftstart']))&&(isset($_GET['shiftend']))&&($go==1)){
  //Insert selected volunteer into the Works table for the selected dept, shift and convo
  if(!insertVolunteerWorks($volid, $dept, $shiftstart, $shiftend, $convoyear)){
    echo "Could not insert the selected volunteer!";
  }else{
    echo "Volunteer with ID $volid has been assigned to $shiftname in $dept";
  }
}
?>


<!--Call function to display available volunteers-->
<!--i.e. volunteers who have applied for that shift but are not yet working it-->
<div>
  <?php
  if((isset($_GET['convoyear']))&&(isset($_GET['dept']))&&(isset($_GET['shiftstart']))&&(isset($_GET['shiftend']))&&($go==1)){
    //echo "Inserting judge...$convoyearadd, $contestname, $volname";
    echo displayAvailableVolunteers("shifts.php", $convoyear, $dept, $shiftstart, $shiftend, $shiftname);


  }
  ?>
</div>
</div>
</div>


<?php include "footer.php";?>
