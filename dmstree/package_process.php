<?php
    ob_start();
    session_start();
    $idletime=1200;//after 20 min the user gets logged out
    if (time()-$_SESSION['timestamp']>$idletime){
        session_destroy();
        session_unset();
        header('Location:login.php');
    }else{
        $_SESSION['timestamp']=time();
    }
    include 'session_config.php';
    require('CodeIgniter-old/external.php');
    $ci = & get_instance();
    $ci->load->library("cimongo/cimongo");
    $ci->load->model('get_mongodb');
    $g1 = new Get_mongodb();
    $userId = $_SESSION['userid'];
    $tenantId = $_SESSION['usertenant'];
    date_default_timezone_set('Asia/Calcutta');
    $currDate = date('Y-m-d h:i:s');
    $currDate = new MongoDate(strtotime($currDate));
    $tenantInfo = $g1->get_mongodb->getUserInfo($userId);
    $tenantId = $tenantInfo[0]['TenantId'];
    $userEmailId = $tenantInfo[0]['LoginInfo']['EmailId'];
    $type = $_POST['type'];
    if($type == 'insert')
    {
        $packageName = strip_tags(trim($_POST['package_name']));
        $packageCategory =strip_tags(trim($_POST['package_type']));
        $packageType = strip_tags(trim($_POST['duration_or_size']));
        $sizeOrDuration = (int)strip_tags(trim($_POST['txt_size']));
        $packageBase = (float)strip_tags(trim($_POST['package_base_rate']));
        $packageTax = (float)strip_tags(trim($_POST['package_tax_percentage']));
        $labelOfSizeOrDuration =strip_tags(trim($_POST['selected_val']));
        if(strcmp($labelOfSizeOrDuration,'Size'))
        {
                $label = 'PackageDurationInMonths';
        }
        else if (strcmp($labelOfSizeOrDuration,'Duration'))
        {
                $label = 'PackageSizeInGB';
        }
        $doc =array('PackageName'=>$packageName,'PackageType'=>$packageCategory,'DurationOrSize'=>$packageType,$label=>$sizeOrDuration,'IsPackageActive'=>true,'PackageBaseRate'=>$packageBase,'PackageTaxPercentage'=>$packageTax,'AuditData'=>array('DateAdded'=>$currDate,
                                                                                                                                                                                                                                                    'AddedBy'=>$userEmailId,
                                                                                                                                                                                                                                                    'DateModified'=>$currDate,
                                                                                                                                                                                                                                                    'ModifiedBy'=>$userEmailId,
                                                                                                                                                                                                                                                    'DeleteFlag'=>false));
        echo $result = $g1->get_mongodb->insertPackageInfo($doc);
		
    }
    else if($type == 'getInfo')
    {
            $packageId = $_POST['selected_val'];
            $result = $g1->get_mongodb->getPackagesById($packageId);
            echo json_encode($result[0]);
    }
    else if($type == 'update')
    {
            $packageName = strip_tags(trim($_POST['package_name']));
            $packageCategory =strip_tags(trim($_POST['package_type']));
            $packageType = strip_tags(trim($_POST['duration_or_size']));
            $sizeOrDuration = (int)strip_tags(trim($_POST['txt_size']));
            $packageBase = (float)strip_tags(trim($_POST['package_base_rate']));
            $packageTax = (float)strip_tags(trim($_POST['package_tax_percentage']));
            $id =strip_tags(trim($_POST['selected_val']));
            if(strcmp($packageType,'Size'))
            {
                    $label = 'PackageDurationInMonths';
            }
            else if (strcmp($packageType,'Duration'))
            {
                    $label = 'PackageSizeInGB';
            }

            $doc = array('PackageName'=>$packageName,'PackageType'=>$packageCategory,'DurationOrSize'=>$packageType,$label=>$sizeOrDuration,'IsPackageActive'=>true,'PackageBaseRate'=>$packageBase,'PackageTaxPercentage'=>$packageTax,'AuditData.DateModified'=>$currDate,'AuditData.ModifiedBy'=>$userEmailId);
            echo $result = $g1->get_mongodb->updatePackageInfo($doc,$id);
    }
    else if($type == 'delete')
    {
            $id =strip_tags(trim($_POST['selected_val']));
            $doc = array('AuditData.DeleteFlag'=>true,'AuditData.DateModified'=>$currDate,'AuditData.ModifiedBy'=>$userEmailId,);
            echo $result = $g1->get_mongodb->deletePackageInfo($doc,$id);
    }

?>