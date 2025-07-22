<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';

// Array of required session variables
$required_sessions = array(
    'username' => 'Username',
    'userid' => 'User ID',
    'usertenant' => 'User Tenant',
    'tenantname' => 'Tenant Name',
    'userdepartmentid' => 'Department ID',
    'userrole' => 'User Role'
);

// HTML header
echo '<!DOCTYPE html>
<html>
<head>
    <title>Session Check</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .session-check { margin-bottom: 20px; }
        .status { padding: 5px; margin: 5px 0; }
        .present { background-color: #dff0d8; color: #3c763d; }
        .missing { background-color: #f2dede; color: #a94442; }
    </style>
</head>
<body>
    <h2>Session Variables Status</h2>';

// Check each session variable
foreach ($required_sessions as $var => $label) {
    echo '<div class="session-check">';
    echo '<strong>' . $label . ':</strong> ';
    if (isset($_SESSION[$var]) && !empty($_SESSION[$var])) {
        echo '<div class="status present">';
        echo 'Present - Value: ' . htmlspecialchars($_SESSION[$var]);
        echo '</div>';
    } else {
        echo '<div class="status missing">';
        echo 'Missing or Empty';
        echo '</div>';
    }
    echo '</div>';
}

// Display all session variables for debugging
echo '<h3>All Session Variables:</h3>';
echo '<pre>';
print_r($_SESSION);
echo '</pre>';

echo '</body></html>';
?> 