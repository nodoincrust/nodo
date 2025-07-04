<?php
ob_start();
session_start();
// include 'session_config.php'; // Uncomment only if session validation is needed

// Create Mongo connection
$mongo = new MongoClient();
$db = $mongo->selectDB('DMSTree');
$collection = $db->documents;

if (isset($_GET['id'])) {
    $id = new MongoId($_GET['id']);
    $file = $collection->findOne(array('_id' => $id));

    if ($file) {
        header('Content-Type: ' . $file['mime_type']);
        header('Content-Disposition: attachment; filename="' . $file['file_name'] . '"');
        echo base64_decode($file['file_data']); // Only if stored as base64
        exit;
    } else {
        echo "❌ File not found in database.";
    }
} else {
    echo "❌ No file ID specified.";
}
?>
