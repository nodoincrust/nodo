<?php
$idletime=1200;//after 20 min the user gets logged out
if (time()-$_SESSION['timestamp']>$idletime){
    session_destroy();
    session_unset();
    header('Location:login.php');
}else{
    $_SESSION['timestamp']=time();
}
?>