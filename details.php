<?php
ob_start();
session_start();
if(isset($_SESSION) && isset($_SESSION['lab']) && $_SESSION['lab'] !== ""){
require("dbconnect.php");
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $id = $_GET['id'];
        $lab = $_SESSION['lab'];
        $sql = "SELECT * FROM equipments WHERE id='$id' AND lab_code ='$lab'";
        $res = $mysqli->query($sql);
        if(mysqli_num_rows($res)==0){
            header("Location: noaccess.php");
        }
        else{
            $row = mysqli_fetch_assoc($res);
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
<div class="container">
  <table class="table">
    <tbody>
    <tr>
        <td><b>Item Details</b></td>
        <td>
            <button type="button" class="btn btn-primary" onClick=<?php echo "location.href='additem.php?id=".$row['id']."'";?>>Add</button>
            <button type="button" class="btn btn-success" onClick=<?php echo "location.href='issue.php?id=".$row['id']."'";?> >Issue</button>
        </td>
      </tr>    
     <tr>
        <td>Name</td>
        <td>
            <?php echo $row['name']; ?>
        </td>
      </tr>
      <tr>
        <td>Specifications</td>
        <td>
            <?php echo nl2br($row['specifications']); ?>
        </td>
      </tr>
      <tr>
        <td>Total Quantity</td>
        <td>
            <?php echo $row['quantity']; ?>
        </td>
      </tr>
      <tr>
        <td>Quantity Issued</td>
        <td>
            <?php echo $row['quantity_issue']; ?>
        </td>
      </tr>
      <tr>
        <td>Quantity Available</td>
        <td>
            <?php echo  $row['quantity'] - $row['quantity_issue']; ?>
        </td>
      </tr>
      <tr>
        <td>Purchase History(Date of Purchase, Date of Warranty, Quantity ,PO No.)</td>
        <td>
            <?php 
                $sql = "SELECT * FROM history WHERE e_id='$id'";
                $res = $mysqli->query($sql);
                while($temp = mysqli_fetch_assoc($res)){
                    if($temp['po']==""){
                        $temp['po'] = 'NA';
                    }
                    if($temp['dop']=="0000-00-00"){
                        $temp['dop'] = 'NA';
                    }
                    if($temp['dow']=="0000-00-00"){
                        $temp['dow'] = 'NA';
                    }
                    echo $temp['dop'].", ".$temp['dop'].", ".$temp['quantity'].", ".$temp['po']."<br>";
                }
            ?>
        </td>
      </tr>
      <tr>
        <td>Current Issue(Roll No., Date of issue, Expected Date of Return , Quantity)</td>
        <td>
            <?php 
                $sql = "SELECT * FROM issue WHERE e_id='$id' AND status=1";
                $res = $mysqli->query($sql);
                while($temp = mysqli_fetch_assoc($res)){
                    if($temp['dor']=="0000-00-00"){
                        $temp['dor'] = 'NA';
                    }
                    if($temp['qty']=="0000-00-00"){
                        $temp['qty'] = 'NA';
                    }
                    echo $temp['roll_no'].", ".$temp['doi'].", ".$temp['dor'].", ".$temp['qty']."<br>";
                }
            ?>
        </td>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>
