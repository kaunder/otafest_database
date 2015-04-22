<?php
include "dashboard.php";
?>
<!-- Volunteer specific stuff starts here-->
<div class="col-sm-9 col-md-10 main">
  <h1 class="page-header">Volunteers</h1>

  <h3>View Volunteer Record</h3>

  <b>Volunteer:</b> <!-- Single button -->
  <div class="btn-group">

    <!-- Get volunteer name,id if it's already been set-->
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


    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $volname;?> <span class="caret"></span></a>
  </button>
  <ul class="dropdown-menu scrollable-menu "role="menu">
    <?php echo getVolunteersForDropdown("volunteers.php", " ");?>
  </ul>
</div>





<!--Display requested volunteer info-->
<div class="container-fluid voffset">
  <?php
  if(isset($_GET['volid'])){
    echo getVolInfoWithComments($volid);
  }
  ?>
</div>



<?php include "footer.php";?>
