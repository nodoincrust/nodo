<?php
//function csrf_startup() {
//   csrf_conf('rewrite-js', 'csrf-magic-1.0.4/csrf-magic.js');
//}
//require_once 'csrf-magic-1.0.4/csrf-magic.php';

$user       = '';
$tenantname = '';
$tenantid   = '';


if(isset($_SESSION['username']))
{
    $user       = $_SESSION['username'];
    $userid     = $_SESSION['userid'];
    $tenantname = $_SESSION['tenantname'];
    $tenantid   = $_SESSION['usertenant'];
}
 else 
{
    header("Location:login.php");
}

function getDirectorySize($path) 
{ 
    $totalsize = 0; 
    $totalcount = 0; 
    $dircount = 0;
    // Validate path first to avoid PHP warnings when directory is missing
    if (empty($path) || !is_dir($path)) {
        return array('size' => 0, 'count' => 0, 'dircount' => 0);
    }

    // Suppress opendir warnings and handle failure gracefully
    $handle = @opendir($path);
    if ($handle === false) {
        return array('size' => 0, 'count' => 0, 'dircount' => 0);
    }

    while (false !== ($file = readdir($handle))) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        $nextpath = rtrim($path, "\/") . DIRECTORY_SEPARATOR . $file;
        if (is_link($nextpath)) {
            continue;
        }
        if (is_dir($nextpath)) {
            $dircount++;
            $result = getDirectorySize($nextpath);
            $totalsize += $result['size'];
            $totalcount += $result['count'];
            $dircount += $result['dircount'];
        } elseif (is_file($nextpath)) {
            $filesize = @filesize($nextpath);
            if ($filesize !== false) {
                $totalsize += $filesize;
            }
            $totalcount++;
        }
    }
    closedir($handle);
    $total['size'] = $totalsize; 
    $total['count'] = $totalcount; 
    $total['dircount'] = $dircount; 
    return $total; 
} 

function sizeFormat($size) 
{ 
    /*if($size<1024) 
    { 
        return $size." bytes"; 
    } 
    else if($size<(1024*1024)) 
    { 
        $size=round($size/1024,1); 
        return $size." KB"; 
    } 
    else if($size<(1024*1024*1024)) 
    { 
        $size=round($size/(1024*1024),1); 
        return $size." MB"; 
    } 
    else 
    { */
        $size=round($size/(1024*1024*1024),1); 
        return $size; //." GB"; 
    //} 
}
        function fileSizeInMB($size){
            $size=round($size/(1024*1024),1); 
        return $size;
        }

 
?>