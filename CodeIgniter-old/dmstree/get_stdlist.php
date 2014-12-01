<?php
$con = mysql_connect("localhost","root", "");
if (!$con){
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("dmstree", $con);
$listarr = '';
$i = 1;
$query1 ="SELECT list_name FROM list";
$result =mysql_query($query1,$con);
while ($row = mysql_fetch_array($result)) {
   if($i == 1)
   {
        $listarr .= $row['list_name'];
   }
 else 
    {
        $listarr .='::'.$row['list_name'];
    }
    $i++;
}
//$lastdate = $row['date'];
//print_r($listarr);
//$resultarr = json_encode((array)$listarr);
//echo $resultarr;
echo $listarr;
?>