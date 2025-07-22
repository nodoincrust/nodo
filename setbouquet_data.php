<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';

if(isset($_POST['bouquetname']))
{
    $documentnm = $_POST['bouquetname'];
    $_SESSION['bouquetnm'] = $documentnm;
}
if(isset($_POST['bouquetdesc']))
{
    $docdesc = $_POST['bouquetdesc'];
    $_SESSION['bouquetdesc'] = $docdesc;
}
?>