<?php
	ob_start();
	session_start();
        include 'session_timeout.php';
	include 'session_config.php';
	
	require('CodeIgniter-old/external.php');
	$ci =& get_instance();
	//echo $ci->somemodel->somemethod();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
	$g1 = new Get_mongodb();
	
        $userdepartid = '';
	$tenantid = '';
        $usermailid = '';
        
        if(isset($_SESSION['userdepartmentid'] ))
        {
            $userdepartid = $_SESSION['userdepartmentid'];
        }  
        if(isset($_SESSION['usertenant']))
        {
            $tenantid = $_SESSION['usertenant'];
        } 
        if(isset($_SESSION['useremail']))
        {
            $usermailid = $_SESSION['useremail'];
        }
        
        $currDate = date('Y-m-d H:i:s');
        $currDate = new MongoDate(strtotime($currDate));
        
        $taglist= '';
        $imagename = '';
        $type = '';
	if(isset($_POST['imagetaglist']))
        {
            $taglist = $_POST['imagetaglist'];
        }
        if(isset($_POST['imgname']))
        {
            $imagename = $_POST['imgname'];
        }
        if(isset($_POST['type']))
        {
            $type = $_POST['type'];
        }    
        
        $imgtagarr = array();
        for($tagindex = 0; $tagindex < count($taglist);$tagindex++)
        {
            $taginfo = explode("::",$taglist[$tagindex]);
            $tagname = $taginfo[1];
            $tagposition = explode(";",$taginfo[0]);
            $tagpoints = '';
            $count = 0;
            for ($index = 0; $index < count($tagposition)-2; $index++) {
                $tag = explode(":",$tagposition[$index]);
                 if($count == 0)
                 {
                    $tagpoints .= $tag[1]; 
                 }
                 else {$tagpoints .= ','.$tag[1];}
                 $count++;
            }
            $imgtagarr[] = array("TagName" => $tagname, "TagPosition" => $tagpoints);
        }
        
        if($type == 'Uploaddoc')
        {
            $gallerytagsInfo = $g1->get_mongodb->setPhysicalLoctags($tenantid,$userdepartid,$imgtagarr,$imagename,$currDate,$usermailid);
            print_r($gallerytagsInfo);
        }
        else
        {
            $gallerytagsInfo = $g1->get_mongodb->setPhotogalleryImagetags($tenantid,$userdepartid,$imgtagarr,$imagename,$currDate,$usermailid);
            print_r($gallerytagsInfo); 
        }
        
        //print_r($imageurl);
?>