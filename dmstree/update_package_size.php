<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
require('CodeIgniter-old/external.php');
$ci = & get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();

// Get tenant ID from session
$tenantid = 8; // Hardcoded for your tenant
$tenantname = "increw pvt ltd";

// New package size in GB
$newPackageSize = 1000; // Set to 1000GB

// Create new package info
$currDate = date('Y-m-d H:i:s');
$currDate = new MongoDate(strtotime($currDate));

$packageInfo = array(
    'PackageSelected' => 'Individual-1',
    'DurationOrSize' => 'Size',
    'PackageSizeInGB' => $newPackageSize,
    'PackagePrice' => 100,
    'TaxesPaidPercentage' => 10,
    'TaxAmount' => 10,
    'TotalPaid' => 110,
    'DateOfSubscription' => $currDate,
    'ExpiryDate' => $currDate,
    'IsActivePackage' => true,
    'AuditData' => array(
        'DateAdded' => $currDate,
        'AddedBy' => $tenantname
    )
);

// Convert to JSON string
$packageInfoJson = json_encode($packageInfo);

// Update the tenant document
$doc = array(
    'PackageInfo' => array($packageInfoJson),
    'AuditData.DateModified' => $currDate,
    'AuditData.ModifiedBy' => $tenantname
);

// Update in MongoDB
$result = $g1->get_mongodb->updatePackageInfo($doc, $tenantid, 'TenantInfo');

if($result) {
    echo "Package size updated successfully to " . $newPackageSize . "GB";
} else {
    echo "Failed to update package size";
}
?> 