<?php
ob_start();
session_start();
if(isset($_SESSION) && isset($_SESSION['lab']) && $_SESSION['lab'] !== ""){
require("dbconnect.php");
	if ($_SERVER['REQUEST_METHOD'] === 'POST'){
		$search = $_POST['search'];
        $lab = $_SESSION['lab'];
			$sql = "SELECT *,MATCH(name,specifications) AGAINST('$search') as rel FROM equipments,labs WHERE lab_name='$lab' and lab_name=lab_code and soundex(name) like concat('%',soundex('$search'),'%') ORDER BY rel DESC";	
		$searchRes = $mysqli->query($sql);
		if(mysqli_num_rows($searchRes)==0)
		{
				$sql = "SELECT *,MATCH(name,specifications) AGAINST('$search') as rel FROM equipments,labs where lab_name='$lab' and lab_name=lab_code having rel>0 ORDER BY rel DESC";
			$searchRes = $mysqli->query($sql);
		}
		if(mysqli_num_rows($searchRes)==0){
				$sql = "SELECT name,MATCH(name,specifications) AGAINST('$search') as rel FROM equipments,labs WHERE name LIKE '%$search%' and lab_name='$lab' and lab_name=lab_code ORDER BY rel DESC";
	            $searchRes = $mysqli->query($sql);
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
    $(document).ready(function() {
        $(".search").autocomplete({
            source: "autocomplete.php",
            minLength: 1
        });
    });
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
                                        <input class="form-control form-control-lg form-control-borderless search" type="search" placeholder="Search topics or keywords" name="search">
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
  <?php if($_SERVER['REQUEST_METHOD'] === 'POST' && mysqli_num_rows($searchRes)>0){ ?>      
  <table class="table">
    <thead>
      <tr>
        <th>Equipment</th>
        <th>Specifications</th>
        <th>Quantity(Avl.)</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($searchRes)){?>
      <tr>
        <td><?php echo $row['name'];?></td>
        <td><?php echo nl2br($row['specifications']);?></td>
        <td><?php echo $row['quantity'].'('.($row['quantity']-$row['quantity_issue']).')';?></td>
        <td>
            <button type="button" class="btn btn-primary" onClick=<?php echo "location.href='additem.php?id=".$row['id']."'";?>>Add</button>
            <button type="button" class="btn btn-danger" onClick=<?php echo "location.href='details.php?id=".$row['id']."'";?>>Details</button>
            <button type="button" class="btn btn-success" onClick=<?php echo "location.href='issue.php?id=".$row['id']."'";?> >Issue</button>
        </td>
      </tr>
 	<?php } ?>
    </tbody>
  </table>
<?php }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
	echo "<br><br><div class='alert alert-danger' role='alert'>
  No result found. Please enter some different keywords.
</div>";
} ?>

</div>

</body>
</html>
