<?php
include 'db.php';

    if(!empty($_GET['temp']) && !empty($_GET['hum']) && !empty($_GET['probe']) && !empty($_GET['charge']) && !empty($_GET['device']))
    {
        $temp = mysqli_real_escape_string($conn, $_GET['temp']);
        $hum = mysqli_real_escape_string($conn, $_GET['hum']);
        $probe = mysqli_real_escape_string($conn, $_GET['probe']);
        $charge = mysqli_real_escape_string($conn, $_GET['charge']);
        $device = mysqli_real_escape_string($conn, $_GET['device']);
      
	    $sql = "INSERT INTO espdata (temp, hum, probe, charge, device)
		
		VALUES ('".$temp."', '".$hum."', '".$probe."', '".$charge."', '".$device."')";

		if ($conn->query($sql) === TRUE) {
                   
          
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

    $sql = "SELECT * FROM espset WHERE id='1'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo $row["slp"];
    echo $row["pin1"];
    echo $row["pin2"];
    echo $row["pin3"];
    echo $row["interv"];
  }
} else {
  echo "0 results";
}

	$conn->close();
?>