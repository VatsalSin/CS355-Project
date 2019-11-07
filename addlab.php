<?php
  session_start();
  require("dbconnect.php");
  $success = false;
  $fail = false;
  if($_SERVER['REQUEST_METHOD'] === 'POST' && sha1($_POST['superkey']) === 'e9f58b895b534f8c23ad5c06fc5c3eb796193ca1'){
      $lab = $_POST['lab_name'];
      $pswd = sha1($_POST['pswd']);
      $email = $_POST['email'];
      $incharge = $_POST['lab_incharge'];
      $dept = $_POST['dept'];
      $sql = "INSERT INTO labs VALUES('$lab','$pswd','$dept','$incharge','$email')";
      $res = $mysqli->query($sql);
      if($mysqli->affected_rows==1){
          $success = true;
      }
    }
    elseif($_SERVER['REQUEST_METHOD'] === 'POST' && sha1($_POST['superkey']) !== 'e9f58b895b534f8c23ad5c06fc5c3eb796193ca1'){
        $fail = true; 
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
  <div class="container-fluid h-100">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <form action="" method="POST">
                <?php if($success){ ?>
                <div class="alert alert-success">
                    <strong>Lab Added Successfully!</strong>
                </div>
                <?php } ?>
                 <?php if($fail){ ?>
                <div class="alert alert-danger">
                    <strong>Authentication Failed!</strong>
                </div>
                <?php } ?>
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="Lab Name*" type="text" name="lab_name" required>
                </div>
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="Password*" type="password" name="pswd" required>
                </div>
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="Department*" type="text" name="dept" required>
                </div>
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="Lab Incharge" type="text" name="lab_incharge" required>
                </div>
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="email" type="text" name="email" required>
                </div>
                <div class="form-group">
                    <input _ngcontent-c0="" class="form-control form-control-lg" placeholder="Super User Password*" type="password" name="superkey" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-info btn-lg btn-block">Add Lab</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
