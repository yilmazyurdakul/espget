<html>
  <head>
  <title>ESP Data Logger - Setup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
   <div class="container mt-3">

<?php
if (isset($_POST["submit"]))
{

    include 'db.php';
    echo "<h1>Setup started...</h1><br><hr>";

    $sql = "CREATE TABLE espdata (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	temp FLOAT(5),
	hum FLOAT(5),
    probe FLOAT(5),
    charge INT(5),
    device INT(5),
	`TimeStamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";

    if ($conn->query($sql) === true)
    {
        echo "<h1>Data tables are ready</h1>";

    }
    else
    {
        echo "Error creating table: " . $conn->error;

    }

    echo "<br><hr><br>";

    $sql = "CREATE TABLE espset (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pin1 INT(3),
    pin2 INT(5),
    pin3 INT(5),
    interv INT(5),
	`TimeStamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";

    if ($conn->query($sql) === true)
    {
        echo "<h1>Setting tables are ready</h1>";

    }
    else
    {
        echo "Error creating table: " . $conn->error;

    }

    echo "<br><hr><br>";

    $sql = "CREATE TABLE user_data (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	uid VARCHAR(30),
	pass VARCHAR(50),
	attempCount INT(6)
	)";

    if ($conn->query($sql) === true)
    {
        echo "<h1>User tables are ready</h1>";

    }
    else
    {
        echo "Error creating table: " . $conn->error;

    }

    echo "<br><hr><br>";

    $uid = mysqli_real_escape_string($conn, $_POST["uid"]);
    $passa = mysqli_real_escape_string($conn, $_POST["pass"]);
    $pass = md5($passa);

    $sql = "INSERT INTO user_data (uid, pass, attempCount)
   
	VALUES ('" . $uid . "', '" . $pass . "', '"0"')";

    if ($conn->query($sql) === true)
    {
        echo "<b>Username: $uid <br><br>";
        echo "Password: $passa</b><br><hr>";

    }
    else
    {
        echo "Error updating record: " . $conn->error;

    }

    $sql = "INSERT INTO espset (pin1, pin2, pin3, interv)
   
	VALUES ('0', '0', '0', '1')";

    if ($conn->query($sql) === true)
    {
        echo "<b>Pin settings are done.<br><br>";
    }
    else
    {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();

?>
      <a href="index.php" onclick="return confirm('Rename or delete this file')" class="btn btn-success btn-sm" role="button"> Main Page</a><br><br>
      <?php
}
else
{
?>
 <div class="container mt-3">
      <h1> Setup Database </h1>
        <form  action="setup.php"  method="post" autocomplete="off">
        <input type="text" name="uid" class="form-control"  placeholder="Username" value=""><br><br>
        <input type="text" name="pass" class="form-control"  placeholder="Password" value=""><br><br>
        <input type="submit" class="btn btn-success btn-lg" name="submit" value="Setup" />
</form>
   <?php
} ?>
