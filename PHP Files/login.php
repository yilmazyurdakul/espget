<?php
session_start();
include "db.php";
?>
<html>
 <head>
 <title>ESP Mobile Data Station</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
 <body>
<div class="container mt-3">
             <center>
               <p><h1>Login Page</h1><br>
             <form  action="login.php"  method="post" autocomplete="off">
             <input type="text" name="uid" class="form-control" required="required" placeholder="User" value=""><br><br>
             <input type="password" name="pass" class="form-control" placeholder="Pass" value=""><br><br>
             <input type="submit" class="btn btn-outline-success btn-lg" name="submit" value="Login" />
       </form><br>
<?php if (isset($_POST["submit"])) {
    $uid = mysqli_real_escape_string($conn, $_POST["uid"]);
    $passa = mysqli_real_escape_string($conn, $_POST["pass"]);
    $pass = md5($passa);
    $sql = "SELECT * FROM user_data WHERE uid='$uid'";
    if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_row($result)) {
            $count = $row[3];
            $idx = $row[1];
            $passx = $row[2];
            if ($idx == $uid && $passx == $pass && $count < 3) {
                $count = 0;
                $logged = 1;
            } else {
                $logged = 0;
                $count++;
            }
            //------------------------------------------------
            $sql = "UPDATE user_data SET attempCount='$count' WHERE uid='$uid'";

            if ($conn->query($sql) === true) {
                
            } else {
                echo "Error updating record: " . $conn->error;
            }
            //----------------------------
        }
        mysqli_free_result($result);
    }
    mysqli_close($conn);
    if ($logged == 1) {
        $_SESSION["active"] = $pass;
        echo "<div class='alert alert-success alert-dismissible'>";
        echo "<strong>Success!</strong> You are logged in. Redirecting... </div>";
        echo "<meta http-equiv='refresh' content='2;url=index.php'>";
    } else {
        $remain = 3-$count;
        echo "<div class='alert alert-danger alert-dismissible'>";
        echo "<a href='login.php' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
        echo "Username or password is wrong<br>";
      if ($remain > 0){
        echo "<strong>Warning!</strong> You have ".$remain." attemps</div>";
      } else {
        echo "Account suspended<br>";
      }
    }
}
?>
