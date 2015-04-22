<?--Page content to support adding new department -->
<?--Can only be loaded if user has correct access level (exec) -->
<?php
include "dashboard.php";
?>
<!-- New Dept specific stuff starts here-->
<div class="col-sm-9 col-md-10 main">
  <h1 class="page-header">Create Department</h1>

  <h3> Add New Department</h3>


  <!-- Get convention year, if it's already been set-->
  <?php
  if(isset($_GET['convoyear'])){
    $convoyear = $_GET['convoyear'];
  }else{
    $convoyear="Select Convention:";
  }
  ?>

  <!-- Get manager and id, if already set-->
  <?php
  if(isset($_GET['mgrname'])){
    $mgrname = $_GET['mgrname'];
  }else{
    $mgrname="Department Manager:";
  }
  if(isset($_GET['mgrid'])){
    $mgrid=$_GET['mgrid'];
  }else{
      $mgrid=-1;
  }
  ?>

  <form action="createdept.php" method="get">

    <div>

      <div class="row">
        <div class="form-group required">
          <div class="col-md-2">
            <label class="control-label" for="convoyear">Convention:</label>
          </div>
          <div class="col-md-6">
            <div class="btn-group requried">
              <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyear;?> <span class="caret"></span></a>
              <ul class="dropdown-menu scrollable menu" role="menu">
                <?php echo getConvoYears("createdept.php");?>
              </ul>
            </div>
          </div>
            <input type="text" class="form-control required secretbox" name="convoyear" value="<?php if($convoyear!="Select Convention:"){echo $convoyear;} ?>" required>
        </div>
      </div>



      <div class="row">
        <div class="form-group required">
          <div class="col-md-2">
            <label class="control-label required" for="mgrid">Manager:</label>
          </div>
        <div class="col-md-6">
          <div class="btn-group requried">
            <a class="btn dropdown-toggle btn-select2 required" data-toggle="dropdown" href="#"><?php echo $mgrname;?> <span class="caret"></span></a>
          <ul class="dropdown-menu scrollable-menu "role="menu">
            <?php echo getManagersForDropdownExtend("createdept.php", $convoyear);?>
          </ul>
        </div>
      </div>
      <input type="text" class="form-control required secretbox" name="mgrid" value="<?php if($mgrid!=-1){echo $mgrid;} ?>" required>
    </div>
    </div>


    <div class="row">
      <div class="form-group required">
        <div class="col-md-2">
          <label class="control-label" for="deptname">Department Name</label>
        </div>
        <div class="col-md-4">
          <input type="text" class="form-control required" name="deptname" placeholder="" required>
        </div>
      </div>
    </div>



    <div class="row">
      <div class="form-group">
        <div class="col-md-2">
          <label class="control-label" for="numvols">Number of Volunteers Required</label>
        </div>
        <div class="col-md-4">
          <input type="number" class="form-control" name="numvols" placeholder="">
        </div>
      </div>
    </div>

    <!--Set manager ID-->
    <?php if(isset($_GET['mgrid'])){
      $mgrid=$_GET['mgrid'];
    }?>






    <input type="submit" value="Create Department!"/>
  </form>


</div>


<!-- Get New Contest form variables-->
<?php
if(isset($_GET['convoyear'])){
  $convoyear = $_GET['convoyear'];
  //echo "convoyear got set and is equal to $convoyear";
}
if(isset($_GET['mgrid'])){
  $mgrid=$_GET['mgrid'];
  //echo "mgrid got set and is equal to $mgrid";
}
if(isset($_GET['deptname'])){
  $deptname=$_GET['deptname'];
  //echo "deptname got set and is equal to $deptname";
}
if(isset($_GET['numvols'])){
  $numvols=$_GET['numvols'];
  //echo "numvols got set and is equal to $numvols";
}

?>
</div>


<!--Call function to insert the new Department into the database-->
<?php
if((isset($_GET['convoyear']))&&(isset($_GET['mgrid']))&&(isset($_GET['deptname']))){
  if(!createNewDept($convoyear, $mgrid, $deptname, $numvols)){
    echo "ERROR: Could not add your department!";
  }else{
    echo "Created new department: $deptname<br>";
  }
}
?>






<?php include "footer.php";?>
