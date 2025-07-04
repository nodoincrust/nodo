<?php
ob_start();
session_start();

$mongo = new MongoClient();
$db = $mongo->selectDB('DMSTree');
$collection = $db->documents;

if (isset($_GET['id'])) {
    $id = new MongoId($_GET['id']);
    $file = $collection->findOne(array('_id' => $id));

    if ($file) {
        // Set headers for download
        header('Content-Type: ' . (isset($file['mime_type']) ? $file['mime_type'] : 'application/octet-stream'));
        header('Content-Disposition: attachment; filename="' . (isset($file['file_name']) ? $file['file_name'] : 'downloaded_file') . '"');
        // Output the decoded file data
        echo base64_decode($file['file_data']);
        exit;
    } else {
        echo "❌ File not found in database.";
    }
} else {
    echo "❌ No file ID specified.";
}
?> 