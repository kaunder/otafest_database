<?php
include "dashboard.php";
?>
<!-- Convention specific stuff starts here-->
<div class="col-sm-9 col-md-10 main">
  <h1 class="page-header">Conventions</h1>

  <h3>View Convention Details</h3>
  
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
    <?php echo getConvoYears("conventions.php");?>
  </ul>
</div>


<!--Display selected convention details-->
<div class="container-fluid voffset">
  <?php
  if(isset($_GET['convoyear'])){
    echo getConvention($convoyear, $accesslev);
  }
  ?>
</div>


<!-- Only Managers and Execs can view Venue information -->
<?php if($accesslev<2){include "venues.php";}?>

</div>


<?php include "footer.php";?>
