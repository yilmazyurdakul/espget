<?php
include "db.php"; 
require "logincheck.php"; ?>
<!DOCTYPE HTML>
<html>
<head>
  <title>Data Logger - Chart View</title>
 <meta charset="utf-8">

 <!-- js of google of chart --> 
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 <script type="text/javascript">
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
 var data_val = google.visualization.arrayToDataTable([

 ['Id', 'Humidity', 'Temperature', 'Probe'],
 <?php
 $select_query = "SELECT * FROM espdata ORDER BY id";

 $query_result = mysqli_query($conn, $select_query);
 while ($row_val = mysqli_fetch_array($query_result)) {
     echo "['" .$row_val["id"]."',".$row_val["hum"].",".$row_val["temp"].",".$row_val["probe"]."],";
 }
 ?>
 
 ]);

 var options_val = {title: 'Temperature, Humidity and Probe Values'};
 var chart_val = new google.visualization.LineChart(document.getElementById("columnchart"));
 chart_val.draw(data_val, options_val);
 }
 </script>
</head>
  <body>
     <div id="columnchart" style="width: 100%; height: 600px;"></div>
</html>