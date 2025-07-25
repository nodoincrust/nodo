<?php
	ob_start();
	session_start();
        include 'session_timeout.php';
	include 'session_config.php';
	require('CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
	$g1 = new Get_mongodb();
	$userId =  $_SESSION['userid'];
	$userInfo = $g1->get_mongodb->getUserInfo($userId);
	$userEmailId = $userInfo[0]['LoginInfo']['EmailId'];
	$tenantId = $_SESSION['usertenant'];
        date_default_timezone_set('Asia/Calcutta');
	$currDate = date('Y-m-d H:i:s');
	$currDate = new MongoDate(strtotime($currDate)); 
	$type = $_POST['type'];
        $tenant =  $g1->get_mongodb->tenantInfo($tenantId);
	$company_name = $tenant[0]['TenantName'];
        $company_name = str_replace(" ","_",$company_name);
	if($type == 'insert')
	{
		$id = strip_tags(trim($_POST['id']));
		$name = strip_tags(trim($_POST['name']));
		$doc = array("List" => array("Description" => $name,"IsActive" => true, "AuditData"=>array("DateAdded" => $currDate,"AddedBy"=>$userEmailId,"DateModified"=>$currDate,"ModifiedBy"=>$userEmailId,"DeleteFlag"=>false)));
		
		$result = $g1->get_mongodb->insertStandardList($id,$doc);
		
		if($result == 1)
		{
                        $name = str_replace(" ","_",$name);
			$templatePath = "DMSTree_clients/".$company_name."_".$tenantId."/Templates/".$name;
			mkdir($templatePath, 0700);
		}
	}
	else if($type == 'delete')
	{
		$id = strip_tags(trim($_POST['id']));
		$name = strip_tags(trim($_POST['name']));
		$index = 0;
		$standList = $g1->get_mongodb->getStandardListDescription($id);
		foreach($standList[0]['List'] as $key)
		{
			if($key['Description'] == $name)
			{
				break;
			}
			$index++;
		}
		$doc = array("List.".$index.".AuditData.DateModified"=>$currDate,"List.".$index.".AuditData.ModifiedBy"=>$userEmailId,"List.".$index.".AuditData.DeleteFlag"=>true);
		
		$result = $g1->get_mongodb->deleteStandardLists($id,$doc);
		echo $result;
	}
	else if($type == 'deleteTemplate')
	{
		$id = strip_tags(trim($_POST['id']));
		$doc = array('AuditData.DeleteFlag'=>true);
		$result = $g1->get_mongodb->deleteTemplateMetaData($id,$doc);
		echo $result;
	}
        else if($type == 'getTemplate')
        {
            $id = $_POST['id'];
            $doc = explode("::",$id);
            $subdomain = $doc[0];
            $subdomain = str_replace(" ","_",$subdomain);
            $domain = $doc[1];
            $domain = str_replace(" ","_",$domain);
            $templateHeader = array();
            $templateLocation = array();
            $fileName = array();
            $id = array();
            $result = $g1->get_mongodb->getTemplateslist_new($tenantId );
            foreach($result as $key){
                $domainName = explode("/",$key['HtmlFileLocation']);
                if(!$key['AuditData']['DeleteFlag'])
                {
                        if( $domainName[3] == $domain)
                        {
                            if($domainName[4] == $subdomain)
                            {
                                $templateHeader[] = $key['TemplateHeader'];
                                $templateLocation[] = $key['HtmlFileLocation'];
                                $fileName[] = $key['HtmlFileName'];
                                $id[] = $key['_id'];
                            }
                        }
                }
            }
            $response['id'] = $id;
            $response['name'] = $templateHeader;
            $response['location'] = $templateLocation;
            $response['extension'] = $fileName;
           echo json_encode($response);
        }
        else if($type == 'subInsert')
        {
            $id = strip_tags(trim($_POST['id']));
            $subName = strip_tags(trim($_POST['name']));
            $name = strip_tags(trim($_POST['domainName']));
            $index = 0;
            $flag = true;
            echo $id;
            $standList = $g1->get_mongodb->getStandardListDescription($id);
            foreach($standList[0]['List'] as $listdoc)
            {
                if($listdoc['Description'] == $name){
                   
                    foreach($listdoc['SubDomain'] as $key){
                        if($key['DomainName'] == $subName)
                        {
                           $flag = false;
                           break;
                        }
                    }
                }
            }
            
            if($flag)
            {
                $originaldomainnm = str_replace(" ","_",$name);
                $originalsubdomainnm = str_replace(" ","_",$subName);
                $templatePath = "DMSTree_clients/".$company_name."_".$tenantId."/Templates/".$originaldomainnm."/".$originalsubdomainnm;
                echo $templatePath;
		mkdir($templatePath, 0700);
                foreach($standList[0]['List'] as $listdoc)
                {
                    if($listdoc['Description'] == $name){
                        break;
                   }
                    $index++;
                }
                $newsubDomain = array("DomainName"=>$subName,"IsActive" => true,"AuditData"=>  array("DateAdded"=>$currDate,"AddedBy"=>$userEmailId,"DateModified"=>$currDate,"ModifiedBy"=>$userEmailId,"DeleteFlag" =>false));
                $sudDomainIndex = "List.".$index.".SubDomain";
                $doc = array($sudDomainIndex=>$newsubDomain);
                $result = $g1->get_mongodb->saveSubDomain($id,$doc);
                echo $result;
            }
            else{
                $index = 0;
                $subIndex = 0;
                foreach($standList[0]['List'] as $listdoc)
                {
                    if($listdoc['Description'] == $name){
                           break;
                    }
                    $index++;
                }
                foreach($standList[0]['List'] as $listdoc)
                {
                    if($listdoc['Description'] == $name){

                        foreach($listdoc['SubDomain'] as $key){
                            if($key['DomainName'] == $subName)
                            {
                               break;
                            }
                            $subIndex++;
                        }

                    }
                }
                
               $docIndex = array("List.".$index.".SubDomain.".$subIndex.".AuditData.DeleteFlag"=>false,
                              "List.".$index.".SubDomain.".$subIndex.".AuditData.DateModified"=>$currDate,
                              "List.".$index.".SubDomain.".$subIndex.".AuditData.ModifiedBy"=>$userEmailId );
                $result = $g1->get_mongodb->updateSubDomain($id,$docIndex);
                echo $result;
            }
        }
        else if($type == 'getsubdomain')
        {
            $id = strip_tags(trim($_POST['id']));
            $domain = strip_tags(trim($_POST['domain']));
            $domain = str_replace(" ","_",$domain);
            $standList = $g1->get_mongodb->getStandardListDescription($id);
            $subDomain = array();
            foreach($standList[0]['List'] as $listdoc)
            {
                if($listdoc['Description'] == $domain){
                   
                    foreach($listdoc['SubDomain'] as $key){
                        if(!$key['AuditData']['DeleteFlag']){
                            $subDomain[] = $key['DomainName']; 
                        }
                    }
                }
            }
            $response['subDomain'] =  $subDomain;
            echo json_encode($response);
        }
        else if($type == 'deletesubdomain'){
            $id = strip_tags(trim($_POST['id']));
            $domain = strip_tags(trim($_POST['domain']));
            $domain = str_replace(" ","_",$domain);
            $subDomain = strip_tags(trim($_POST['subdomain']));
            $subdomain = str_replace(" ","_",$subdomain);
            $subIndex = 0;
            $index = 0;
            $standList = $g1->get_mongodb->getStandardListDescription($id);
            foreach($standList[0]['List'] as $listdoc)
            {
                if($listdoc['Description'] == $domain){
                       break;
                }
                $index++;
            }
            foreach($standList[0]['List'] as $listdoc)
            {
                if($listdoc['Description'] == $domain){
                   
                    foreach($listdoc['SubDomain'] as $key){
                        if($key['DomainName'] == $subDomain)
                        {
                           break;
                        }
                        $subIndex++;
                    }
                    
                }
            }
            $docIndex = array("List.".$index.".SubDomain.".$subIndex.".AuditData.DeleteFlag"=>true,
                              "List.".$index.".SubDomain.".$subIndex.".AuditData.DateModified"=>$currDate,
                              "List.".$index.".SubDomain.".$subIndex.".AuditData.ModifiedBy"=>$userEmailId );
            $result = $g1->get_mongodb->deleteSubDomain($id,$docIndex);
            echo $result;
        }
        else if($type == 'buyTemplate')
        {
            $id = strip_tags(trim($_POST['id']));
            $doc = explode("::",$id);
            $subdomain = $doc[0];
            $subdomain = str_replace(" ","_",$subdomain);
            $domain = $doc[1];
            $domain = str_replace(" ","_",$domain);
            $templateHeader = array();
            $templateLocation = array();
            $fileName = array();
            $id = array();
            $systemtenant = -999;
            $result = $g1->get_mongodb->getTemplateslist_new($systemtenant );
            foreach($result as $key){
                $domainName = explode("/",$key['HtmlFileLocation']);
                if(!$key['AuditData']['DeleteFlag'])
                {
                        if( $domainName[3] == $domain)
                        {
                            if($domainName[4] == $subdomain)
                            {
                                $templateHeader[] = $key['TemplateHeader'];
                                $templateLocation[] = $key['HtmlFileLocation'];
                                $fileName[] = $key['HtmlFileName'];
                                $id[] = $key['_id'];
                            }
                        }
                }
            }
            $response['id'] = $id;
            $response['name'] = $templateHeader;
            $response['location'] = $templateLocation;
            $response['extension'] = $fileName;
            
           echo json_encode($response);
        }
        else if($type == 'purchaseTemplate')
        {
            $pathLoaction = strip_tags(trim($_POST['tempPath']));
            $pathArray = explode("/",$pathLoaction);
            $pathLen = sizeof($pathArray);
            $tempNameExt = $pathArray[$pathLen-1];
            $temp =  explode(".",$tempNameExt);
            $tempName = $temp[0];
            $tempName = str_replace("_"," ",$tempName);
            $tenantTempPath = "DMSTree_Clients/".$company_name."_".$tenantId."/Templates";
            
            $doc = array('HtmlFileName'=>$tempNameExt ,"HtmlFileLocation"=>$tenantTempPath,"TenantId"=>$tenantId,"TemplateHeader"=>$tempName,"SingleLineTextBox"=>$tempName,"MultiLineTextBox"=>"","AuditData"=>  array(
                                                                                                                                                                                                                    "DateAdded"=>$currDate,
                                                                                                                                                                                                                     "AddedBy"=>$userEmailId,
                                                                                                                                                                                                                     "DateModified"=>$currDate,
                                                                                                                                                                                                                     "ModifiedBy"=>$userEmailId,
                                                                                                                                                                                                                     "DeleteFlag" => false
                                                                                                                                                                                                                    ));
            if( copy($pathLoaction,$tenantTempPath."/".$tempNameExt))
            {
                $result = $g1->get_mongodb->savePurchaseTemplate($doc);
            }
            else{
                $result = "Fail in Copying Template";
            }
            echo $result;
        }
?>