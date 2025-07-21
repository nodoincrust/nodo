<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';

// Use the old Mongo extension for PHP 5.5
$mongo = new MongoClient(); // Connect to MongoDB
$db = $mongo->selectDB('DMSTree');
$collection = $db->documents; // File data collection
$metadataCollection = $db->document_metadata; // Metadata collection

$tenantid = '';
$userdepartid = '';
if(isset($_SESSION['usertenant'])) {
    $tenantid = $_SESSION['usertenant'];
}
if(isset($_SESSION['userdepartmentid'] )) {
    $userdepartid = $_SESSION['userdepartmentid'];
}

$tenantname = isset($_POST['tenantname']) ? $_POST['tenantname'] : '';
$tenantid   = isset($_POST['tenantid']) ? $_POST['tenantid'] : '';
$revision = '';
if(isset($_POST['revision'])) {
    $revision = $_POST['revision'];
}

for ($fileindex = 1; $fileindex <= 5 ; $fileindex++) {
    $filename = 'sfile'.$fileindex;
    if(!empty($_FILES[$filename]['name'])){
        if ($_FILES[$filename]["error"] > 0) {
            // handle error
        } else {
            // --- NEW: Store file in correct tenant Documents folder ---
            $session_tenantname = isset($_SESSION['tenantname']) ? $_SESSION['tenantname'] : $tenantname;
            $session_tenantid = isset($_SESSION['usertenant']) ? $_SESSION['usertenant'] : $tenantid;
            $safe_tenantname = str_replace(" ", "_", $session_tenantname);
            $uploadDir = __DIR__ . "/DMSTree_clients/{$safe_tenantname}_{$session_tenantid}/Documents/";
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $originalFileName = basename($_FILES[$filename]["name"]);
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
            $baseName = pathinfo($originalFileName, PATHINFO_FILENAME);
            if($revision == '') {
                $revision1 = 0;
            } else {
                $revision1 = (int)$revision + 1;
            }
            $storedFileName = str_replace(" ", "_", $baseName) . "_" . $revision1 . "." . $fileExtension;
            $targetPath = $uploadDir . $storedFileName;
            if (move_uploaded_file($_FILES[$filename]["tmp_name"], $targetPath)) {
                // Now read file from correct location and encode as base64
                $fileData = file_get_contents($targetPath);
                $base64   = base64_encode($fileData);
                // Insert file document directly (no file path)
                $fileInfo = array(
                    'tenant_id'      => $session_tenantid,
                    'tenant_name'    => $session_tenantname,
                    'user_department_id' => $userdepartid,
                    'file_name'      => $storedFileName,
                    'original_name'  => $originalFileName,
                    'mime_type'      => $_FILES[$filename]["type"],
                    'size'           => $_FILES[$filename]["size"],
                    'revision'       => $revision1,
                    'upload_time'    => new MongoDate(),
                    'file_data'      => $base64, // Store as base64 string
                    // add other metadata as needed
                );
                $collection->insert($fileInfo);
                $fileId = $fileInfo['_id']; // Get the inserted file's _id
                // Generate download URL
                $downloadUrl = 'http://localhost/dmstree/download.php?id=' . (string)$fileId;
                // Update the document with DownloadUrl
                $collection->update(
                    array('_id' => $fileId),
                    array('$set' => array('DownloadUrl' => $downloadUrl))
                );
                // Insert metadata document, linking to fileId (optional, as before)
            } else {
                // Handle error moving file
                error_log("Failed to move uploaded file to $targetPath");
            }
        }
    }
}

header("Location:upload.php");
exit;
?>