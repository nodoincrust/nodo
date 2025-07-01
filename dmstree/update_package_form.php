<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
require('../CodeIgniter-old/external.php');
$ci = & get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();

// Get current package info
$tenantid = $_SESSION['usertenant'];
$packageInfo = $g1->get_mongodb->getActivePackageSize($tenantid);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Package Size</title>
    <link rel="stylesheet" href="dist/css/bootstrap.css"/>
    <link rel="stylesheet" href="css/stylesheet.css"/>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2>Update Package Size</h2>
                <form action="package_process.php" method="post">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="package_name" value="Corporate-1">
                    <input type="hidden" name="package_type" value="Corporate">
                    <input type="hidden" name="duration_or_size" value="Size">
                    <input type="hidden" name="package_base_rate" value="100">
                    <input type="hidden" name="package_tax_percentage" value="10">
                    <input type="hidden" name="selected_val" value="<?php echo $tenantid; ?>">
                    
                    <div class="form-group">
                        <label>New Package Size (GB)</label>
                        <input type="number" name="txt_size" class="form-control" value="<?php echo $packageInfo; ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Package Size</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 