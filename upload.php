<?php
require 'vendor/autoload.php';
session_start();

// MongoDB connection
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->dmstree;
$documents = $db->documents;
$templates = $db->templates;

// Session management
include 'dmstree/session_timeout.php';
include 'dmstree/session_config.php';

// Check session variables
if (!isset($_SESSION['usertenant']) || !isset($_SESSION['userdepartmentid']) || 
    !isset($_SESSION['tenantname']) || !isset($_SESSION['userid']) || 
    !isset($_SESSION['userrole'])) {
    header('Location: dmstree/login.php');
    exit;
}

$tenantid = isset($_SESSION['usertenant']) ? $_SESSION['usertenant'] : '';
$userdepartid = isset($_SESSION['userdepartmentid']) ? $_SESSION['userdepartmentid'] : '';
$tenantname = isset($_SESSION['tenantname']) ? $_SESSION['tenantname'] : '';
$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
$userrole = isset($_SESSION['userrole']) ? $_SESSION['userrole'] : '';

// Initialize variables
$docid = isset($_POST['docinfo']) ? explode("-", $_POST['docinfo'])[0] : "";
$docrevision = isset($_POST['docinfo']) ? explode("-", $_POST['docinfo'])[1] : "";
$docinfo = isset($_POST['docinfo']) ? $_POST['docinfo'] : '';
$docName = isset($_POST['docname']) ? $_POST['docname'] : '';
$temploc = '';
$tempnm = '';
$templatename = '';
$fileext = '';
$documentprivate = isset($_POST['documentprivate']) ? $_POST['documentprivate'] : '';

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpPath = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileType = $file['type'];
    
    // Generate unique filename
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $fileExtension;
    
    // Create upload directory if it doesn't exist
    $uploadDir = "DMSTree_clients/{$tenantname}_{$tenantid}/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Move uploaded file
    $targetPath = $uploadDir . $newFileName;
    if (move_uploaded_file($fileTmpPath, $targetPath)) {
        // Store file metadata in MongoDB
        $document = [
            'TenantId' => (int)$tenantid,
            'DepartmentId' => (int)$userdepartid,
            'DocumentName' => $docName,
            'LatestRevision' => 0,
            'IsPrivate' => $documentprivate === 'true',
            'DocumentInfo' => [[
                'RevisionNo' => 0,
                'FileName' => $newFileName,
                'OriginalName' => $fileName,
                'FileLocation' => $targetPath,
                'FileSize' => $fileSize,
                'FileType' => $fileType,
                'UploadDate' => new MongoDB\BSON\UTCDateTime(),
                'CurrentStatus' => 'Active',
                'TagList' => [],
                'Comments' => [],
                'IsLatestRevision' => true
            ]],
            'AuditData' => [
                'DateAdded' => new MongoDB\BSON\UTCDateTime(),
                'AddedBy' => $userid,
                'DateModified' => new MongoDB\BSON\UTCDateTime(),
                'ModifiedBy' => $userid,
                'DeleteFlag' => false
            ]
        ];
        
        try {
            $result = $documents->insertOne($document);
            if ($result->getInsertedCount() > 0) {
                echo json_encode(['success' => true, 'message' => 'File uploaded successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to store file metadata']);
            }
        } catch (Exception $e) {
            error_log("MongoDB Error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Database error occurred']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Document Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .upload-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .file-input {
            margin: 20px 0;
        }
        .upload-status {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="upload-container">
            <h2>Upload Document</h2>
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="file">Select File:</label>
                    <input type="file" class="form-control file-input" id="file" name="file" required>
                </div>
                
                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="isPrivate" name="is_private">
                    <label class="form-check-label" for="isPrivate">Mark as Private</label>
                </div>
                <?php endif; ?>
                
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
            <div class="upload-status"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);
                
                $.ajax({
                    url: 'upload.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            $('.upload-status').html('<div class="alert alert-success">' + result.message + '</div>');
                            $('#uploadForm')[0].reset();
                        } else {
                            $('.upload-status').html('<div class="alert alert-danger">' + result.message + '</div>');
                        }
                    },
                    error: function() {
                        $('.upload-status').html('<div class="alert alert-danger">An error occurred during upload</div>');
                    }
                });
            });
        });
    </script>
</body>
</html> 