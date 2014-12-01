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
    
    if ($handle = opendir ($path)) 
    { 
        while (false !== ($file = readdir($handle))) 
        { 
            $nextpath = $path . '/' . $file; 
            if ($file != '.' && $file != '..' && !is_link ($nextpath)) 
            { 
                if (is_dir ($nextpath)) 
                { 
                $dircount++; 
                $result = getDirectorySize($nextpath); 
                $totalsize += $result['size']; 
                $totalcount += $result['count']; 
                $dircount += $result['dircount']; 
                } 
                elseif (is_file ($nextpath)) 
                { 
                $totalsize += filesize ($nextpath); 
                $totalcount++; 
                } 
            } 
        }    
  } 
        closedir ($handle); 
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