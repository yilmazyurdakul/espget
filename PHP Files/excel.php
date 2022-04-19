<?php
include 'db.php';
$device = mysqli_real_escape_string($conn, $_GET['device']);

$table_name = "espdata"; //MySQL Table Name   
$date = date("Y.m.d.h.i.sa");         //File Name
$filename = $date."Device_".$device;
//create MySQL connection   
$sql = "SELECT * FROM espdata WHERE device = '$device'";
$result = $conn->query($sql);

$file_ending = "xls";
//header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   

$sep = "\t"; //tabbed character

for ($i = 0; $i < mysqli_num_fields($result); $i++) {
  $finfo = mysqli_fetch_field($result);
echo $finfo->name . "\t";
}
print("\n");    
//end of printing column names  
//start while loop to get data
    while($row = mysqli_fetch_row($result))
    {
        $schema_insert = "";
        for($j=0; $j<mysqli_num_fields($result);$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    }   
?>