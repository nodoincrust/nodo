<?php
// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$idletime=1200;//after 20 min the user gets logged out

// Initialize timestamp if not set
if (!isset($_SESSION['timestamp'])) {
    $_SESSION['timestamp'] = time();
}

if (time()-$_SESSION['timestamp']>$idletime){
    session_destroy();
    session_unset();
    header('Location:login.php');
}else{
    $_SESSION['timestamp']=time();
}
?>