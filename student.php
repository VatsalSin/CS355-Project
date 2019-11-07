<?php
ob_start();
session_start();
if(isset($_SESSION) && isset($_SESSION['lab']) && $_SESSION['lab'] !== ""){
require("dbconnect.php");
    $valid = false;
     $lab = $_SESSION['lab'];
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['roll']) && isset($_GET['id'])){
        $search = $_GET['roll'];
        $roll = $_GET['roll'];
        $id = $_GET['id'];
        $doi = $_GET['doi'];
        $qty = $_GET['qty'];
         $sql = "SELECT * FROM equipments WHERE id='$id' AND lab_code ='$lab'";
        $res = $mysqli->query($sql);
        if(mysqli_num_rows($res)==0){
            header("Location: noaccess.php");
        }
        $sql = "UPDATE issue SET status = 0,dor = CURDATE() WHERE e_id = '$id' AND roll_no='$roll' AND doi='$doi' AND qty='$qty'";
        $res = $mysqli->query($sql);
        if($mysqli->affected_rows==1){
        $sql = "UPDATE equipments SET quantity_issue = quantity_issue - $qty WHERE id = '$id'";
        $res = $mysqli->query($sql);
        }
    }
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $search = $_POST['search'];
    }
    if(($_SERVER['REQUEST_METHOD'] === 'GET'  && isset($_GET['roll']) && isset($_GET['id'])) || $_SERVER['REQUEST_METHOD'] === 'POST'){
        $valid=true;
        $sql = "SELECT * FROM equipments,issue WHERE e_id=id and roll_no = '$search' and status=1 and lab_code='$lab'"; 
        $res_current = $mysqli->query($sql);
        $sql = "SELECT * FROM equipments,issue WHERE e_id=id and roll_no = '$search' and status=0 and lab_code='$lab'";   
        $res_old = $mysqli->query($sql);
    }
}
else{
    header("Location: noaccess.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Equipments Search</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
   <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/smoothness/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" type="text/css">
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
    <script src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js" integrity="sha256-Nnknf1LUP3GHdxjWQgga92LMdaU2+/gkzoIUO+gfy2M=" crossorigin="anonymous"></script>
    <style type="text/css">
        .form-control-borderless {
        border: none;
        }

        .form-control-borderless:hover, .form-control-borderless:active, .form-control-borderless:focus {
        border: none;
        outline: none;
        box-shadow: none;
        }
    </style>
    <script type="text/javascript">
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }   
</script>
</head>
<body>
   <nav class="navbar navbar-expand-sm bg-dark">

  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="search.php">Search</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="add.php" active>Add New Item</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="student.php" active>Student Records</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="logout.php" active>logout</a>
    </li>
  </ul>

</nav><br><br>
<div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <form class="card card-sm" method="POST">
                                <div class="card-body row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <i class="fas fa-search h4 text-body"></i>
                                    </div>
                                    <!--end of col-->
                                    <div class="col">
                                        <input class="form-control form-control-lg form-control-borderless search" type="search" placeholder="Roll Number" name="search">
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-lg btn-success" type="submit">Search</button>
                                    </div>
                                    <!--end of col-->
                                </div>
                            </form>
                        </div>
                        <!--end of col-->
                    </div>
                    <div class="container">
                        <br>
<?php if($_SERVER['REQUEST_METHOD'] === 'POST' || $valid){ ?>
<h3>Equipment to be returned</h3>
<?php } ?>
  <?php if(($_SERVER['REQUEST_METHOD'] === 'POST'|| $valid) && mysqli_num_rows($res_current)>0){ ?>      
  <table class="table">
    <thead>
      <tr>
        <th>Equipment</th>
        <th>Specifications</th>
        <th>Quantity</th>
        <th>Date of Issue</th>
        <th>Date of Return</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($res_current)){?>
      <tr>
        <td><?php echo $row['name'];?></td>
        <td><?php echo nl2br($row['specifications']);?></td>
        <td><?php echo $row['qty'];?></td>
        <td><?php echo $row['doi'];?></td>
        <td><?php echo $row['dor'];?></td>
        <td><button type="button" class="btn btn-danger" onClick=<?php echo "location.href='student.php?id=".$row['id']."&roll=".$search."&doi=".$row['doi']."&qty=".$row['qty']."'";?>>Return</button></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
<?php }elseif($_SERVER['REQUEST_METHOD'] === 'POST'|| $valid){
    echo "No Item";
} ?>

<?php if($_SERVER['REQUEST_METHOD'] === 'POST'|| $valid){ ?>
<br><br>
<hr>
<br><br>
<h3>History</h3>
<?php } ?>
<?php if(($_SERVER['REQUEST_METHOD'] === 'POST'|| $valid) && mysqli_num_rows($res_old)>0){ ?>      
  <table class="table">
    <thead>
      <tr>
        <th>Equipment</th>
        <th>Specifications</th>
        <th>Quantity</th>
        <th>Date of Issue</th>
        <th>Date of Return</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($res_old)){?>
      <tr>
        <td><?php echo $row['name'];?></td>
        <td><?php echo nl2br($row['specifications']);?></td>
        <td><?php echo $row['qty'];?></td>
        <td><?php echo $row['doi'];?></td>
        <td><?php echo $row['dor'];?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
<?php }elseif($_SERVER['REQUEST_METHOD'] === 'POST'|| $valid){
    echo "No Item<br><br><hr>";
} ?>


</div>

</body>
</html>
