<?php
ob_start();
session_start();
include 'session_config.php';
$bouquet_documents = $_POST['docbunch'];
if(isset($_POST['docbunch']))
{
   $bouquet_documents = $_POST['docbunch']; 
}
if(isset($_POST['docform']))
{
    if($_POST['docform'] == 1)
    {
        $_SESSION['current_document'] =  $bouquet_documents;
        echo($_SESSION['current_document']);
    }
    
}

//header("Location:document_bouquet.php");
?>