<?--Page content to support adding new venue -->
<?--Can only be loaded if user has correct access level -->
<?php
include "dashboard.php";
?>
<!-- Contests specific stuff starts here-->
<div class="col-sm-9 col-md-10 main">
  <h1 class="page-header">Venues</h1>

  <h3> Create New Venue</h3>


  <!-- Get volname, id, if already set-->
  <?php
  if(isset($_GET['volname'])){
    $volname = $_GET['volname'];
  }else{
    $volname="Select Volunteer:";
  }

  if(isset($_GET['volid'])){
    $volid=$_GET['volid'];
  }

  ?>

  <div class="row">
    <div class="form-group required">
      <label class="col-md-2 control-label" for="volname">Coordinating Volunteer</label>
      <div class="col-md-4">
        <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#" id="volname"><?php echo $volname;?> <span class="caret"></span></a>

        <ul class="dropdown-menu scrollable-menu "role="menu">
          <?php
          //Only volunteers who are not blacklisted should be available for selection
          echo getVolNotBLForDropdownExtend("managevenues.php", "");?>
        </ul>
      </div>
      <div class="col-md-6"></div>
    </div>

  </div>


  <?php
  if(isset($_GET['volid'])){
    include "addvenue.php";
  }
  ?>

  <br>
  <h3>Venues:</h3>


  <!--Display all venues-->
  <div class="container-fluid voffset">
    <?php
    echo getVenuesTable();
    ?>

  </div>


</div>

<?php include "footer.php";?>
