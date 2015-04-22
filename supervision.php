<?php
include "dashboard.php";
?>
<!-- Department specific stuff starts here-->
<div class="col-sm-9 col-md-10 main">
  <h1 class="page-header">Supervision</h1>

  <h3>Your Direct Supervisees</h3>

  <!-- Single button -->
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


    <a class="btn dropdown-toggle btn-select2" data-toggle="dropdown" href="#"><?php echo $convoyear;?> <span class="caret"></span></a>
  </button>
  <ul class="dropdown-menu" role="menu">
    <?php echo getConvoYears("supervision.php");?>
  </ul>
</div>


<!--Display all depts with managers-->
<div class="container-fluid voffset">
  <?php
  if(isset($_GET['convoyear'])){
    echo displaySupervisees($convoyear, $username);
  }
  ?>
</div>

<?php include "footer.php";?>
