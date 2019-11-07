<?php
  ob_start();
  session_start();
  if(isset($_SESSION) && isset($_SESSION['lab']) && $_SESSION['lab'] !== ""){
  require("dbconnect.php");
  $success = false;
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $equipment = $_POST['equipment'];
      $specifications = $_POST['specifications'];
      $dop = $_POST['dop'];
      $dow = $_POST['dow'];
      $po = $_POST['po'];
      $qty = $_POST['quantity'];
      $lab = $_SESSION['lab'];
      if($dow==""){
          $dow = '00-00-0000';
      }
      if($dop==""){
          $dop = '00-00-0000';
      }
      $sql = "INSERT INTO equipments(`name`, `specifications`, `quantity`,`quantity_issue` ,`lab_code`) VALUES('$equipment','$specifications','$qty',0,'$lab')";
      $res = $mysqli->query($sql);
      if($res){
        $sql = "SELECT id FROM equipments WHERE name='$equipment' and specifications='$specifications' and quantity='$qty' and lab_code='$lab'";
        $res = $mysqli->query($sql);
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];
        $sql = "INSERT INTO history VALUES('$id','$dop','$dow','$po','$qty')";
        $res = $mysqli->query($sql);
        if($mysqli->affected_rows>=1){
          $success = true;
        }
      }
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
  <div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <form action="" method="POST">
                <?php if($success){ ?>
                <div class="alert alert-success">
                    <strong>Item Added Successfully!</strong>
                </div>
                <?php } ?>
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="Equipment Name*" type="text" name="equipment" required>
                </div>
                <div class="form-group">
                    <textarea rows = "5" cols = "60" _ngcontent-c0="" class="form-control form-control-lg" placeholder="Product Specifications (Features, Model, Serial Number, etc)*" name="specifications" wrap="hard" required></textarea>
                </div>
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="Quantity*" type="number" name="quantity" required>
                </div>
                <div class="form-group">
                    <lable>Date of Purchase:-</lable>
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="Date of Purchase" type="date" name="dop">
                </div>
                <div class="form-group">
                    <lable>Date of Warranty:-</lable>
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="Date of Warranty" type="date" name="dow">
                </div>
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="P.O. Number" type="text" name="po">
                </div>
                <div class="form-group">
                    <button class="btn btn-info btn-lg btn-block">Add Item</button>
                </div>
            </form>
            <div class="form-group">
                    <button class="btn btn-info btn-lg btn-block" onclick = "location.href='search.php'">Search Similar Item</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
