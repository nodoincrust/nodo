<?php
$con = mysql_connect("localhost","root", "");
if (!$con){
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("dmstree", $con);
$listid = '';
$listvalues = '';
$i = 1;
$listname = $_POST['listname'];
$defaultquery = "SELECT list_id FROM list WHERE list_name = '$listname'";
$defaultresult = mysql_query($defaultquery,$con);
while ($row = mysql_fetch_array($defaultresult)) {
    $listid = $row['list_id'];
}
$query1 ="SELECT list_values FROM listvalues WHERE list_name_id = '$listid'";
$result =mysql_query($query1,$con);
while ($row1 = mysql_fetch_array($result)) {
    if($i == 1)
    {
        $listvalues .= $row1['list_values']; 
    }
 else  
    {
         $listvalues .= '::'.$row1['list_values'];
    }
   $i++;
}
echo $listvalues;
?>