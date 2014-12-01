<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';

$tenantid = '';
$userdepartid = '';
 if(isset($_SESSION['usertenant']))
    {
        $tenantid = $_SESSION['usertenant'];
    }
    if(isset($_SESSION['userdepartmentid'] ))
    {
        $userdepartid = $_SESSION['userdepartmentid'];
    }  

$tenantname = $_POST['tenantname'];
$tenantid   = $_POST['tenantid'];
$revision = '';
if(isset($_POST['revision']))
{
$revision = $_POST['revision'];
}

for ($fileindex = 1; $fileindex <= 5 ; $fileindex++) {
   $filename = 'sfile'.$fileindex;
   if(!empty($_FILES[$filename]['name'])){
        if ($_FILES[$filename]["error"] > 0)
        {
            //echo "Return Code: " . $_FILES[$filename]["error"] . "<br>";
        }
        else
        {
//            echo "Upload: " . $_FILES[$filename]["name"] . "<br>";
//            echo "Type: " . $_FILES[$filename]["type"] . "<br>";
//            echo "Size: " . ($_FILES[$filename]["size"] / 1024) . " kB<br>";
//            echo "Stored in: " . $_FILES[$filename]["tmp_name"]. "<br>";
            $tenantName = str_replace(" ","_",$tenantname);
            $file = $_FILES[$filename]["name"];
            if($revision == '')
            {
                $revision1 = 0;
                $docname = explode(".",$file);
                $documentname = $docname[0];
                $documentextextension = $docname[1];
                $file = $documentname.'_'.$revision1.'.'.$documentextextension;
                $file = str_replace(" ","_",$file);
                
            }
            else {
                $revision1 = (int)$revision + 1;
                $docname = explode(".",$file);
                $documentname = $docname[0];
                $documentextextension = $docname[1];
                $file = $documentname.'_'.$revision1.'.'.$documentextextension;
                $file = str_replace(" ","_",$file);
            }
            move_uploaded_file($_FILES[$filename]["tmp_name"],"DMSTree_clients/".$tenantName."_".$tenantid."/Documents/" .$file);
            //echo "Stored in: " . "DMSTree_Clients/".$tenantName."_".$tenantid."/Documents/". $file;
            
        }
    }
}
 
header("Location:upload.php");

?>