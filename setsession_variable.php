<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
$_SESSION['current_document'] = '';
if(isset($_SESSION['new_documents']))
{
 
 unset($_SESSION['bouquetnm']);
 unset($_SESSION['bouquetdesc']);
}
unset($_SESSION['new_documents']);
?>