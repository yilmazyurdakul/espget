<?php include "db.php";
require "logincheck.php";

if ($_SESSION["active"])
{
    if (isset($_SESSION["device"]))
    {
        $device = $_SESSION["device"];
    }
    else
    {
        $device = 1;
    }
    if (isset($_SESSION["records"]))
    {
        $records = $_SESSION["records"];
    }
    else
    {
        $records = 20;
    }
    if (isset($_SESSION["ascdesc"]))
    {
        $ascdesc = $_SESSION["ascdesc"];
    }
    else
    {
        $ascdesc = "ASC";
    }
    //------------------------------------------
    $sql = "SELECT * FROM espset WHERE id='1'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
        while ($row = $result->fetch_assoc())
        {
            $pin1Stat = $row["pin1"];
            $pin2Stat = $row["pin2"];
            $pin3Stat = $row["pin3"];
            $pageint = $row["interv"];
            if ($row["slp"] == 1)
            {
                $sleepStat = "Enabled";
            }
            else
            {
                $sleepStat = "Disabled";
            }
        }
    }
    else
    {
        echo "0 results";
    }
    //---------------------------------//
    
?>
<!DOCTYPE html>
<html>
<head>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  

</head>
<body>

<div class="container mt-3">
    <div class='alert alert-success alert-dismissible sticky-top'><span id="timer"></span> - 
    <a href="index.php" style="text-decoration:none" aria-label="close">Refresh Now</a>
    <a href="" class="close" data-dismiss='alert' aria-label="close">&times;</a>
  </div>
  <h1><a href="index.php" style="text-decoration:none">ESP Data Logger</h1></a> 
  
<div id="selects" class="collapse">
  <form  action="index.php" method="post" autocomplete="off" >
      
  <div class="input-group mb-3">
  <div class="input-group-prepend">
   <select class="custom-select" id="pin" name="pin">
    <option selected>Select Pin</option>
    <option value="pin1">Pin 1</option>
    <option value="pin2">Pin 2</option>
    <option value="pin3">Pin 3</option>
  </select>
    </div>
  <select class="custom-select" id="val" name="val">
    <option selected>Choose State</option>
    <option value="1">On</option>
    <option value="0">Off</option>
  </select>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit" name="submit">Update</button>
  </div>
     </div> 
         <div class='alert alert-success alert-dismissible'>
           <strong>Pin 1</strong> State: <?php echo  $pin1Stat; ?> <br>
           <strong>Pin 2</strong> State: <?php echo  $pin2Stat; ?> <br>
           <strong>Pin 3</strong> State: <?php echo  $pin3Stat; ?> <br>
    </div>
    <br>

  </div>
  <div id="settings" class="collapse">

  <div class="input-group mb-3">
  <select class="custom-select" id="device" name="device">
    <option value="" selected disabled hidden>Device <?php echo $device; ?></option>
    <option value="1">Device 1</option>
    <option value="2">Device 2</option>
  </select>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit" name="submit5">Update</button>
  </div>
 </div>

      <div class="input-group mb-3">
  <select class="custom-select" id="int" name="int">
    <option value="" selected disabled hidden><?php echo $pageint; ?> Min. Refresh</option>
    <option value="1">1 Min</option>
    <option value="2">2 Min</option>
    <option value="5">5 Min</option>
    <option value="10">10 Min</option>
    <option value="20">20 Min</option>
  </select>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit" name="submit2">Update</button>
  </div>
 </div>
   
  <div class="input-group mb-3">
  <select class="custom-select" id="slp" name="slp">
    <option value="" selected disabled hidden>Sleep <?php echo $sleepStat; ?></option>
    <option value="1">Sleep Enable</option>
    <option value="0">Sleep Disable</option>
  </select>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit" name="submit4">Update</button>
  </div>
 </div>

  <div class="input-group mb-3">
  <select class="custom-select" name="records" id="records">
    <option value="" selected disabled hidden><?php echo $records; ?> Records</option>
    <option value="20">20 Records</option>
    <option value="50">50 Records</option>
    <option value="100">100 Records</option>
    <option value="150">150 Records</option>
    <option value="200">200 Records</option>
  </select>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit" name="submit6">Update</button>
  </div>
 </div>
  
      <div class="input-group mb-3">
  <select class="custom-select" name="ascdesc" id="ascdesc">
    <option value="" selected disabled hidden><?php echo $ascdesc; ?></option>
    <option value="ASC">Ascending</option>
    <option value="DESC">Descending</option>
  </select>
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit" name="submit7">Update</button>
  </div>
 </div>
 </div>
 
  
  <button type="button" class="btn btn-outline-primary" data-toggle="collapse" data-target="#selects">Pin Controls</button> | 
  <button type="button" class="btn btn-outline-info " data-toggle="collapse" data-target="#settings">Settings</button> | 
  <a href="chart.php" class="btn btn-outline-info" role="button" >Chart</a> | 
  <input type="submit" onclick="return confirm('Are your sure?')" class="btn btn-outline-warning " name="submit3" value="Clear data" />  | 
  <a href="excel.php?device=<?php echo $device; ?>" class="btn btn-outline-warning " role="button"> Download Data</a> | 
  <a href="logout.php" onclick="return confirm('Are your sure?')" class="btn btn-outline-danger " role="button"> Logout</a>
   </form>
  <br><br>
<?php
    if (isset($_POST["submit"]))
    {
        $pin = addslashes($_POST["pin"]);
        $val = addslashes($_POST["val"]);

        $sql = "UPDATE espset SET $pin='$val' WHERE id=1";

        if ($conn->query($sql) === true)
        {

            echo "<div class='alert alert-success alert-dismissible'>";
            echo "<a href='index.php' class='close' aria-label='close'>&times;</a>";
            echo "<strong>Success!</strong> " . $pin . " successfully updated to " . $val . " </div>";

        }
        else
        {
            echo "Error updating record: " . $conn->error;
        }
    }

    //---------------------------------------------------------------------
    if (isset($_POST["submit2"]))
    {
        $interv = addslashes($_POST["int"]);

        $sql = "UPDATE espset SET interv='$interv' WHERE id=1";

        if ($conn->query($sql) === true)
        {
            echo "<div class='alert alert-success alert-dismissible'>";
            echo "<a href='index.php' class='close' aria-label='close'>&times;</a>";
            echo "<strong>Success! </strong>Interval updated successfully to " . $interv . " minutes </div>";
        }
        else
        {
            echo "Error updating record: " . $conn->error;
        }
    }

    //---------------------------------------------------------------------
    if (isset($_POST["submit3"]))
    {
        //SQL Command
        $sql_command = "TRUNCATE TABLE espdata";

        if (mysqli_query($conn, $sql_command))
        {

            echo "<div class='alert alert-success alert-dismissible'>";
            echo "<a href='index.php' class='close' data-dismiss='alert' aria-label='close'>&times;</a>";
            echo "<strong>Success!</strong> All data successfully deleted. </div>";

        }
        else
        {
            echo "SQL Error " . mysqli_error($connection);
        }
    }
    //-----------------------------------------
    if (isset($_POST["submit4"]))
    {
        $slp = addslashes($_POST["slp"]);

        $sql = "UPDATE espset SET slp='$slp' WHERE id=1";

        if ($conn->query($sql) === true)
        {
            echo "<div class='alert alert-success alert-dismissible'>";
            echo "<a href='index.php' class='close' aria-label='close'>&times;</a>";
            echo "<strong>Success!</strong> Sleep settings successfully updated to " . $sleepStat . "</div>";
        }
        else
        {
            echo "Error updating record: " . $conn->error;
        }
    }

    //---------------------------------------------------------------------
    if (isset($_POST["submit5"]))
    {
        $device = addslashes($_POST["device"]);

        $_SESSION["device"] = $device;

        if (($_SESSION["device"]) == $device)
        {
            echo "<div class='alert alert-success alert-dismissible'>";
            echo "<a href='index.php' class='close' aria-label='close'>&times;</a>";
            echo "<strong>Success!</strong> Device settings successfully updated to " . $device . "</div>";
        }
        else
        {
            echo "Error";
        }
    }
    //---------------------------------------------------------------------
    if (isset($_POST["submit6"]))
    {
        $records = addslashes($_POST["records"]);

        $_SESSION["records"] = $records;

        if (($_SESSION["records"]) == $records)
        {
            echo "<div class='alert alert-success alert-dismissible'>";
            echo "<a href='index.php' class='close' aria-label='close'>&times;</a>";
            echo "<strong>Success!</strong> Record settings successfully updated to " . $records . "</div>";
        }
        else
        {
            echo "Error";
        }
    }
    //---------------------------------------------------------------------
    if (isset($_POST["submit7"]))
    {
        $ascdesc = addslashes($_POST["ascdesc"]);

        $_SESSION["ascdesc"] = $ascdesc;

        if (($_SESSION["ascdesc"]) == $ascdesc)
        {
            echo "<div class='alert alert-success alert-dismissible'>";
            echo "<a href='index.php' class='close'  aria-label='close'>&times;</a>";
            echo "<strong>Success!</strong> Data ordering settings successfully updated to " . $ascdesc . "</div>";
        }
        else
        {
            echo "Error";
        }
    }
    //---------------------------------------------------------------------
    $sql = "SELECT * FROM espdata WHERE device = '$device' ORDER BY id $ascdesc LIMIT $records";
    if ($result = mysqli_query($conn, $sql))
    { ?>
     <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Temperature</th>
        <th>Humidity</th>
        <th>Probe</th>
        <th>Charge</th>
        <th>Device ID</th>
       <th>Time</th>
      </tr>
    </thead>
        <tbody>
       <?php
        //while ($row = mysqli_fetch_row($result))
        while ($row = $result->fetch_assoc())
        {
            echo "<TR>";
            echo "<TD>" . $row["id"] . "</TD>";
            echo "<TD>" . $row["temp"] . "</TD>";
            echo "<TD>" . $row["hum"] . "</TD>";
            echo "<TD>" . $row["probe"] . "</TD>";
            echo "<TD>" . $row["charge"] . "</TD>";
            echo "<TD>" . $row["device"] . "</TD>";
            echo "<TD>" . $row["TimeStamp"] . "</TD>";
            echo "</TR>";
        }
        echo "</TABLE>";
        mysqli_free_result($result);
    }
    mysqli_close($conn);
?>
<script type='text/javascript'> 
title = "ESP Data Logger - #<?php echo $pageint; ?> min auto refresh - ";
position = 0;
function scrolltitle() {
    document.title = title.substring(position, title.length) + title.substring(0, position); 
    position++;
    if (position > title.length) position = 0;
    titleScroll = window.setTimeout(scrolltitle,200);
}
scrolltitle();
  
  function checklength(i) {
    'use strict';
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

var minutes, seconds, count, counter, timer;
count = <?php echo $pageint * 60; ?>; //seconds
counter = setInterval(timer, 1000);

function timer() {
    'use strict';
    count = count - 1;
    minutes = checklength(Math.floor(count / 60));
    seconds = checklength(count - minutes * 60);
    if (count < 0) {
        clearInterval(counter);
        return;
    }
    document.getElementById("timer").innerHTML = 'Next refresh in ' + minutes + ':' + seconds + ' ';
    if (count === 0) {
        location.reload();
    }
}
  
 

</script>
</body>
</html>
  <?php
} ?>
