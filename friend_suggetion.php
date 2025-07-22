<?php 
require_once("class.phpmailer.php");
//if(isset($_POST['mailid'])){$from = $_POST['mailid'];}
//if(isset($_POST['category'])){$category = $_POST['category'];}
//if(isset($_POST['title'])){$title = $_POST['title'];}
//if(isset($_POST['discription'])){$discription = $_POST['discription'];}
//if(isset($_POST['comments'])){$comments = $_POST['comments'];}

$subject="test";
$message="test sms";
$to = '9970171989@airtelkk.com';
$from = 'dmstree.helpline@gmail.com';
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: PHP". phpversion() ."\r\n";
smtpmailer($to,"-f",$from,$subject,$message);
echo $message."<br>";
?>

