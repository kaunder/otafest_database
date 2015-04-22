<?php
include "dashboard.php";
?>

<div class="col-sm-9 col-md-10 main">
  <h1 class="page-header">Volunteers</h1>


  

  <!---------------Insert new volunteer---------------------------->

  <h3>Add New Volunteer</h3>



  <form action="manageVols.php" method="get">
    <div class="row">
      <div class="form-group required">
        <label class="col-md-2 control-label" for="firstName">First Name</label>
        <div class="col-md-4">
          <input type="text" class="form-control required" name="firstName" placeholder="e.g. Donald" required>
        </div>
        <div class="col-md-6"> </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group required">
        <label class="col-md-2 control-label" for="lastName">Last Name</label>
        <div class="col-md-4">
          <input type="text" class="form-control required" name="lastName" placeholder="e.g. Chamberlin" required>
        </div>
        <div class="col-md-6"></div>
      </div>
    </div>


    <div class="row">
      <div class="form-group">
        <label class="col-md-2 control-label" for="nickName">Nickname</label>
        <div class="col-md-4">
          <input type="text" class="form-control" name="nickName" placeholder="e.g. Mr. SQL">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group">
        <label class="col-md-2 control-label" for="phoneNumber">Phone Number</label>
        <div class="col-md-4">
          <input type="tel" class="form-control" name="phoneNumber" placeholder="e.g. 408-997-3188">
        </div>
      </div>
    </div>


    <div class="row">
      <div class="form-group">
        <label class="col-md-2 control-label" for="dob">Date Of Birth</label>
        <div class="col-md-4">
          <input type="date" class="form-control" name="dob" placeholder="">
        </div>
      </div>
    </div>

    <input type="submit" value="Create!"/>
  </form>


  <!-- Get new Volunteer form variables-->
  <?php
  if(isset($_GET['firstName'])){
    $firstName = $_GET['firstName'];
  }
  if(isset($_GET['lastName'])){
    $lastName=$_GET['lastName'];
  }
  if(isset($_GET['nickName'])){
    $nickName=$_GET['nickName'];
  }
  if(isset($_GET['phoneNumber'])){
    $phoneNumber=$_GET['phoneNumber'];
  }
  if(isset($_GET['dob'])){
    $dob=$_GET['dob'];
  }
  ?>



  <!--If all required inputs captureed, Call function to insert the new volunteer into the database-->
  <?php
  //Only require that mandatory fields are set before proceeding
  if((isset($_GET['firstName']))&&(isset($_GET['lastName']))){
    echo "Inserting new volunteer...";
    echo $firstName." ";
    echo "''".$nickName."'' ";
    echo $lastName;
    if(!insertNewVolunteer($firstName, $lastName, $nickName, $phoneNumber, $dob)){
      echo "ERROR: Could not add new volunteer!";
    }
  }

  ?>


  <!---------------Modify Volunteer Comments---------------------------->

  <h3>Add Volunteer Comments</h3>

  <form action="manageVols.php" method="get">
    <b>Volunteer:</b> <!-- Single button -->
    <div class="btn-group">

      <!-- Get volname and id, if already set-->
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
      <?php
      if($accesslev==1){
        //Managers cannot edit other managers comments
        echo getVolunteersForDropdownNoMgr("manageVols.php", "");
      }else if($accesslev==0){
        //Execs can edit all comments
        echo getVolunteersForDropdown("manageVols.php", "");
      }
      ?>
    </ul>
  </div>


  <b>New Comment: </b>
  <input type="text" name="comment">

  <?php if(isset($_GET['volid'])){
    echo '<input type="hidden" name="volid" value="'.$volid.'"></input>';
  }?>

  <input type="submit" value="Add Comment"/>
</form>

<!-- Perform logic to load selected volunteer, new comment-->
<?php
if(isset($_GET['volid'])){
  $volid = $_GET['volid'];
}
if(isset($_GET['comment'])){
  $comment=$_GET['comment'];
}
?>


<!--If all required inputs captureed, call function to insert new comment-->
<?php
if((isset($_GET['volid']))&&(isset($_GET['comment']))){
  if(!insertNewComment($volid, $comment)){
    echo "ERROR: Could not insert comment!";
  }else{
    echo "Added new comment!";
  }
}
?>




<?php
include "updateEmerg.php";
?>



</div>

<?php include "footer.php";?>
