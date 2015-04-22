<?php
include "dashboard.php";
?>
<!-- Blacklist specific stuff starts here-->
<div class="col-sm-9 col-md-10 main">
  <h1 class="page-header">The Blacklist</h1>

  <h3>These Volunteers Are Not Welcome Back:</h3>

  <!--Display all depts with managers-->
  <div class="container-fluid voffset">
    <?php
    echo getBlacklist();
    ?>
  </div>

  <?php include "footer.php";?>
  
