<?php
include "dashboard.php";
?>
<!-- Contests specific stuff starts here-->
<div class="col-sm-9 col-md-10 main">
  <h1 class="page-header">Contests</h1>
  
  <h3>View Contests</h3>

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
    <?php echo getConvoYears("contests.php");?>
  </ul>
</div>


<!--Display all contest winners-->
<div class="container-fluid voffset">
  <?php
  if(isset($_GET['convoyear'])){
    echo getContests($convoyear, $accesslev);
  }
  ?>
</div>
