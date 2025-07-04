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
            // Read file directly from upload and encode as base64
            $fileData = file_get_contents($_FILES[$filename]["tmp_name"]);
            $base64   = base64_encode($fileData);

            $file = $_FILES[$filename]["name"];
            if($revision == '') {
                $revision1 = 0;
                $docname = explode(".",$file);
                $documentname = $docname[0];
                $documentextextension = $docname[1];
                $file = $documentname.'_'.$revision1.'.'.$documentextextension;
                $file = str_replace(" ","_",$file);
            } else {
                $revision1 = (int)$revision + 1;
                $docname = explode(".",$file);
                $documentname = $docname[0];
                $documentextextension = $docname[1];
                $file = $documentname.'_'.$revision1.'.'.$documentextextension;
                $file = str_replace(" ","_",$file);
            }

            // Insert file document directly (no file path)
            $fileInfo = array(
                'tenant_id'      => $tenantid,
                'tenant_name'    => $tenantname,
                'user_department_id' => $userdepartid,
                'file_name'      => $file,
                'original_name'  => $_FILES[$filename]["name"],
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

            // Insert metadata document, linking to fileId
            /*
            $metadata = array(
                'TenantId' => $tenantid,
                'DepartmentId' => $userdepartid, // Always from session, never from POST
                'DocumentName' => $documentname,
                'LatestRevision' => $revision1,
                'IsPrivate' => false, // Set as needed
                'FileId' => $fileId, // Link to file document
                'FileName' => $file,
                'UploadDate' => new MongoDate(),
                'DownloadUrl' => $downloadUrl, // Store download URL
                // Add other metadata fields as needed
            );
            $metadataCollection->insert($metadata);
            */
        }
    }
}

header("Location:upload.php");
exit;
?>