<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// session_start();
//   $this->load->library('session');
class Get_mongodb extends CI_Model {

	public $name;
	public $project;
	function getAll($collection = 'UserData')
	{
			$query = $this->cimongo->get($collection);
			$result = $query->result();
			return $result ;
                  
	}
 
        function loginProcess($loginUsername,$loginPassword,$collection = 'UserData')
        {
            
            $username = strip_tags(trim($loginUsername));
            $password = strip_tags(trim($loginPassword));
            
                $searchLoginStream = array("LoginInfo.EmailId"=>$username,"LoginInfo.Password"=>$password);
                $selectarray       = array("_id","Name","UserRole","LoginInfo.EmailId","LoginInfo.Password","TenantId","DepartmentId");
                $loginquery        = $this->cimongo->select($selectarray)->where($searchLoginStream)->get($collection);
                $loginresult       = $loginquery->result_array();
                $loginresult_row   = $loginquery->num_rows();
                /*return json_encode($userdataResponse);*/
                $this->session->set_userdata('loginresult', $loginresult); 
                // $this->session->userdata('loginresult');
                
                if($loginresult_row > 0)
                    return $loginresult;
                else 
                    return 0;
        }
        
        function tenantInfo($tenantid,$collection = 'TenantInfo')
        {
                $tenantsearch      = array("TenantName");
                $tenantwhere       = array("_id" => $tenantid);
                $tenantquery       = $this->cimongo->select($tenantsearch)->where($tenantwhere)->get($collection);
                $tenantresult      = $tenantquery->result_array();
                $tenantresult_row   = $tenantquery->num_rows(); 
                if($tenantresult_row > 0)
                    return $tenantresult;
                else 
                    return 0;
        }
        
        function tenantUserData($tenantid,$collection = 'UserData')
        {
                //$this->cimongo->cache_on();
                $selectuserdata = array("_id","Name","UserRole");
                $userdatawhere  = array("TenantId" => $tenantid);
                $userdataquery = $this->cimongo->select($selectuserdata)->where($userdatawhere)->get($collection);
                $userdataresult = $userdataquery->result_array();
                return $userdataresult;
        }
        
        function getActivePackageSize($tenantid, $collection = 'TenantInfo')
        {
                $tenantid       = (int)$tenantid;
                // var_dump($tenantid);
                $wherecond      = array("_id" => $tenantid,"PackageInfo.DurationOrSize" => 'Size');//, "PackageInfo.IsActivePackage" => true);
                $selectcond     = array("PackageInfo.PackageSizeInGB");
                // var_dump($selectcond);
                $packagequery   = $this->cimongo->select($selectcond)->where($wherecond)->get($collection);
                // var_dump($packagequery);
                // die();
                $packagequeryresult = $packagequery->result_array();
                $test = 0;
                foreach ($packagequeryresult as $packagevalue) {
                    if(array_key_exists('PackageInfo',$packagevalue))
                    {
                        foreach ($packagevalue['PackageInfo'] as $packvalue) {
                            if(array_key_exists('PackageSizeInGB',$packvalue))
                            {
                                    $test = $packvalue['PackageSizeInGB'];
                            }      
                            
                        }
                    }       
                }
                return $test;
        }
        
        


        /*---------------------------------------------------------  Track History Page --------------------------------------------------------------------------*/
       function saveTrackAction($tenantid,$userid,$actiontext,$currDate,$collection = 'TenantHistory')
       {
           $historyinfoobj = array( "TenantId" => $tenantid, 
                                    "HistoryInformation" => array(
                                                                    "Userid" => new MongoID($userid),
                                                                    "UserAction" => $actiontext,
                                                                    "ActionDate" => $currDate
                                                                  )
                                   );
           $trackhistory = $this->cimongo->insert($collection,$historyinfoobj);
       }
        
/*--------------------------------------------------------- Create Custom Template -----------------------------------------------------------------------------------------*/        
        
        
function get_standcombodata($tenantid,$type,$comboname,$collection = 'StandardList')
{
        if($type == 'combo')
        {
           $combowherecond  = array("TenantId" => $tenantid,"Type" => "Combo"); 
           $comboselectcond = array("ListName");
        }
        if($type == 'combooptions')
        {
           $combowherecond  = array("TenantId" => $tenantid,"Type" => "Combo","ListName" => $comboname);
           $comboselectcond = array("List.Description","List.IsActive","List.AuditData.DeleteFlag"); 
        }
        if($type == 'list')
        {
           $combowherecond  = array("TenantId" => $tenantid,"Type" => "List"); 
           $comboselectcond = array("ListName");
        } 
        if($type == 'listoptions')
        {
           $combowherecond  = array("TenantId" => $tenantid,"Type" => "List","ListName" => $comboname); 
           $comboselectcond = array("List.Description","List.IsActive","List.AuditData.DeleteFlag");
        } 
        $combodataquery = $this->cimongo->select($comboselectcond)->where($combowherecond)->get($collection);
        $combodataquery_result = $combodataquery->result_array();
        $combodataquery_rows  = $combodataquery->num_rows();
        if($combodataquery_rows > 0)
            return $combodataquery_result;
        else 
            return 0;
}




function saveTemplate($filename,$myFile,$file_desc,$usetenantid,$userdepartid,$currDate,$useremail)
        {
                $fname = str_replace(" ","_",$filename).".html";
                if($userdepartid != '' ){
                $templateInfo = array("HtmlFileName" => $fname, "HtmlFileLocation" => $myFile, "TenantId" => $usetenantid,"DepartmentId" => $userdepartid,
                                      "TemplateHeader" => $filename,"SingleLineTextBox" => $filename, "MultiLineTextBox" => $file_desc,
                                      "AuditData" => array(
                                                            "DateAdded" => $currDate,
                                                            "AddedBy" => $useremail,
                                                            "DateModified" => $currDate,
                                                            "ModifiedBy" => $useremail,
                                                            "DeleteFlag" => false)
                                     ); //"DepartmentId" => new MongoID($userdepartid)
                }
                else 
                {
                  $templateInfo = array("HtmlFileName" => $fname, "HtmlFileLocation" => $myFile, "TenantId" => $usetenantid,
                                      "TemplateHeader" => $filename,"SingleLineTextBox" => $filename, "MultiLineTextBox" => $file_desc,
                                      "AuditData" => array(
                                                            "DateAdded" => $currDate,
                                                            "AddedBy" => $useremail,
                                                            "DateModified" => $currDate,
                                                            "ModifiedBy" => $useremail,
                                                            "DeleteFlag" => false)
                                     );  
                }
                $templatequery = $this->cimongo->insert('TemplateMetaData',$templateInfo);
                if($templatequery)
                    return 1;
                else 
                    return 0;
        
        }
        
/*---------------------------------------------------------------- Upload Document Functions -------------------------------------------------------*/        
        
        function getTemplatelocation($tenantid,$tempname,$collection = "TemplateMetaData")
        {
            $criteria = array('TenantId' => $tenantid,'HtmlFileName'=>$tempname);
            $select = array('HtmlFileLocation');
            $query = $this->cimongo->select($select)->where($criteria)->get($collection);
            $result =  $query->result_array();
            $result_row = $query->num_rows();
            if($result_row > 0)
                return $result;
            else 
                return 0;
        }
        
        function getTemplateslist($tenantid,$userdepartid,$collection = 'TemplateMetaData')
        {
                $selectTemp = array("_id","HtmlFileName","HtmlFileLocation","TemplateHeader");
                if($userdepartid != ''){
                    $wheretenanttemp = array("TenantId" => $tenantid,"DepartmentId" => $userdepartid);
                }
                else
                {
                    $wheretenanttemp = array("TenantId" => $tenantid);
                }
                $templatequery = $this->cimongo->select($selectTemp)->where($wheretenanttemp)->get($collection);
                $tempresult =  $templatequery->result_array();
                $tempresult_row = $templatequery->num_rows();
                if($tempresult_row > 0)
                    return $tempresult;
                else 
                    return 0;
        }
        
        function documentrevisionData($tenantid,$userdepartid,$collection = 'DocumentMetaData')
        {
            $selectrevdata   = array("DocumentInfo.RevisionNo");
            $whererevdata    = array("TenantId" => $tenantid, "DepartmentId" => $userdepartid);
            $docrevsionquery = $this->cimongo->select($selectrevdata)->order_by(array("DocumentInfo.RevisionNo" => 'DESC'))->limit(1)->where($whererevdata)->get($collection);
            $documentrevisionresult =  $docrevsionquery->result_array();
            return $documentrevisionresult;
        }
        
        function saveDocumentMetada($tenantid,$departmenid,$filearray,$documentinfoarr,$tempid,$type,$revision,$documentid,$templatename,$currDate,$usermailid,$isPrivate)
        {
            // Prevent saving template-only entries in DocumentMetaData
            if((empty($filearray) || $filearray == null) && $type == 'new' && !empty($templatename)) {
                // This is a template save, do not insert into DocumentMetaData
                return 'skip_template_entry';
            }
            if($filearray != null)
            {
            for ($fileindex = 0; $fileindex < count($filearray); $fileindex++) {
                $docext  = $filearray[$fileindex];
                $docname = explode(".",$docext);
                $documentname = $docname[0];
                $documentdata = array();
                $locationflag = 0;
                $documentdata['TenantId'] = $tenantid;
                if($departmenid != '')
                {
                    $documentdata['DepartmentId'] = $departmenid;
                }
                $documentdata['DocumentName'] = $documentname;
                $documentdata['LatestRevision'] = 0;
                if($isPrivate=='true'){
                    $documentdata['IsPrivate'] = true;
                }
                else{
                     $documentdata['IsPrivate'] = false;
                }
                
                if($tempid != '')
                {
                    $documentdata['TemplateId'] = new MongoID($tempid);
                }
                if(array_key_exists('PhysicalLocation',$documentinfoarr))
                {
                    $physicallocation= $documentinfoarr['PhysicalLocation'];
                    $locationpath = $physicallocation['LocationPath'];
                    $locationpath = explode('/',$locationpath);
                    $locationFilename = $locationpath[count($locationpath) -1];
                    $locationflag = 1;
                }        
                   
                if($type == 'new'){
                    $revision = 0;
                    $auditdataarr = array("DateAdded" =>$currDate, "AddedBy" =>$usermailid,"DateModified" =>$currDate,"ModifiedBy" =>$usermailid,"DeleteFlag" => false);
                    $orgDocName = str_replace(" ","_",$docname[0]);
                    $documentinfoarr['FileName'] = $orgDocName."_".$revision.".".$docname[1];

                    // --- Store file as base64 in 'documents' collection and get FileId ---
                    $filePath = isset($documentinfoarr['FileLocation']) ? $documentinfoarr['FileLocation'] : null;
                    // Ensure FileLocation includes the filename
                    if ($filePath && isset($documentinfoarr['FileName'])) {
                        $filename = $documentinfoarr['FileName'];
                        // If FileLocation does not already end with the filename, append it
                        if (substr($filePath, -strlen($filename)) !== $filename) {
                            $filePath = rtrim($filePath, '/\\') . '/' . $filename;
                            $documentinfoarr['FileLocation'] = $filePath;
                        }
                    }
                    $fileId = null;
                    if ($filePath && file_exists($filePath)) {
                        $fileData = file_get_contents($filePath);
                        $base64   = base64_encode($fileData);
                        $fileDoc = array(
                            'tenant_id' => $tenantid,
                            'tenant_name' => $documentname,
                            'user_department_id' => $departmenid,
                            'file_name' => $documentinfoarr['FileName'],
                            'original_name' => $docext,
                            'mime_type' => isset($documentinfoarr['FileType']) ? $documentinfoarr['FileType'] : '',
                            'size' => isset($documentinfoarr['FileSize']) ? $documentinfoarr['FileSize'] : '',
                            'revision' => $revision,
                            'upload_time' => $currDate,
                            'file_data' => $base64
                        );
                        $this->cimongo->insert('documents', $fileDoc);
                        $fileId = $fileDoc['_id'];
                        $downloadUrl = 'http://13.234.7.43/dmstree/download.php?id=' . (string)$fileId;
                        $documentinfoarr['FileId'] = $fileId;
                        $documentinfoarr['DownloadUrl'] = $downloadUrl;
                        error_log('File saved to documents collection: ' . (string)$fileId . ' from path: ' . $filePath);
                    } else {
                        error_log('File not found at expected location: ' . $filePath);
                    }
                    // --- End block ---

                    $documentdata['DocumentInfo'] = array($documentinfoarr);
                    $documentdata['AuditData'] = $auditdataarr;
                    $documentquery = $this->cimongo->insert('DocumentMetaData',$documentdata);
                    /*if($locationflag == 1)
                    {
                        $documentwherearray = array("TenantId" => 2, "Photo.FileName" => "Desert.jpg");	
                        $documentselectarray = array("Photo.FileLocation");
                        $documentquery  = $this->cimongo->select($documentselectarray)->where($documentwherearray)->get($collection);
                        $photogallarywhere = array("Photo.FileName" =>$locationFilename);
                        $photogalleryquery = $this->cimongo->update();
                    }*/
                }
                else if($type == 'revision'){
                    $revision = $revision;
                    $oldrev = (int)$revision - 1;
                    $oldrevinfo = array("DocumentInfo.RevisionNo");
                    $setauditdata = array("AuditData.DateModified" =>$currDate, "AuditData.ModifiedBy" =>$usermailid);
					$orgDocName = str_replace(" ","_",$docname[0]);
                    $documentinfoarr['FileName'] = $orgDocName."_".$revision.".".$docname[1];
                    $criteria = array('_id'=> new MongoID($documentid));
                    $doc = array('DocumentInfo'=>$documentinfoarr);
                    $documentquery = $this->cimongo->push($doc)->where($criteria )->update('DocumentMetaData');
                    $documentauditdata = $this->cimongo->set($setauditdata)->where($criteria)->update('DocumentMetaData');
                    
                }
                
            }
                if($documentquery)
                    return "success";
                else 
                    return "fail";
               // return $locationFilename;
            }
            else 
            {
                $documentdata = array();
                $documentdata['TenantId'] = $tenantid;
                if($departmenid != '')
                {
                    $documentdata['DepartmentId'] = $departmenid;
                }
                $documentdata['DocumentName'] = $templatename;
                if($tempid != '')
                {
                    $documentdata['TemplateId'] = new MongoID($tempid);
                }
                
                if($type == 'new'){
                    $revision = 0;
                    //$documentinfoarr['FileName'] = $docname[0]."_".$revision.".".$docname[1];
                    $documentdata['DocumentInfo'] = array($documentinfoarr);
                    $documentquery = $this->cimongo->insert('DocumentMetaData',$documentdata);
                    if($documentquery)
                        return 1;
                    else 
                        return 0;
                }
                else if($type == 'revision'){
                    $revision = $revision;
                    //$documentinfoarr['FileName'] = $docname[0]."_".$revision.".".$docname[1];
                    $criteria = array('_id'=> new MongoID($documentid));
                    $doc = array('DocumentInfo'=>$documentinfoarr);
                    $documentquery = $this->cimongo->push($doc)->where($criteria )->update('DocumentMetaData');
                    if($documentquery)
                        return 1;
                    else 
                        return 0;
                }
                //return $type;
            }
        }
        
        
        
        function saveDocumentRevision($tenantid,$documentname,$documentinfoarr, $collection = 'DocumentMetaData')
        {
            $wherecond = array("TenantId" =>$tenantid,"DocumentName" =>$documentname);
            $documentquery = $this->cimongo->where($wherecond)->get($collection);
            return $documentquery;
        }
        
        
        function getDocumentMetadata($documentid,$doctempname,$tenantid,$departmentid, $collection = 'DocumentMetaData') 
        {
            $docsearchstream = array();
            if($documentid != '')
            {
                $docsearchstream['_id'] = new MongoID($documentid);
            }
           $docsearchstream['DocumentName'] = $doctempname;
            $docsearchstream['TenantId'] = $tenantid;
            if($departmentid != '')
            {
               // $docsearchstream['DepartmentId'] = new MongoTD($departmentid);
               $docsearchstream['DepartmentId'] = $departmentid; 
            }
            /*$docsearchstream = array( "TenantId" =>$tenantid,"DocumentName" => $doctempname); 
              $documentdataquery = $this->cimongo->where($docsearchstream)->get($collection);
              $documentdataresult = $documentdataquery->result_array();*/
            $docselectarray = array("DocumentInfo.RevisionNo","DocumentInfo.FileName","DocumentInfo.FileLocation","DocumentInfo.TagList","DocumentInfo.CurrentStatus","DocumentInfo.ExpiryDate",
                                    "DocumentInfo.Label", "DocumentInfo.TextBox", "DocumentInfo.TextArea", "DocumentInfo.CustomList", "DocumentInfo.Date", 
                                    "DocumentInfo.RadioButton","DocumentInfo.MultipleCheckBox","DocumentInfo.Table","DocumentInfo.Comments","DocumentInfo.PhysicalLocation"); 
            $documentdataquery = $this->cimongo->select($docselectarray)->where($docsearchstream)->get($collection);
            $documentdataresult = $documentdataquery->result_array();
            $documentdataresult_row = $documentdataquery->num_rows();
            if($documentdataresult_row > 0)
                return $documentdataresult;
            else 
                return 0;          
        }
        
       function setPhotogalleryImagetags($tenantid,$userdepartid,$imgtagarr,$imagename,$currDate,$usermailid,$collection = 'PhotoGallery')
        {
            if($userdepartid != '')
            {
                $wherecond = array("TenantId" => $tenantid,"DepartmentId" =>$userdepartid );
            }
            else {$wherecond = array("TenantId" => $tenantid );}
            $selectdata = array("Photo");
            $documentinfoquery = $this->cimongo->select($selectdata)->where($wherecond)->get($collection);
            $documentinfoqueryresult = $documentinfoquery->result_array();  
            
            $revisionarr = array();
            $revtagarr = array();
            $revisionindex = 0;
            $revisionindexval = '';
          
            foreach ($documentinfoqueryresult as $dockey) {
                if(array_key_exists("Photo",$dockey))
                {
                    foreach ($dockey['Photo'] as $subdockey)
                    {
                        if($subdockey['FileName'] == $imagename)
                        {
                            $revisionarr[]    = $subdockey;
                            if(array_key_exists('ImageTags',$subdockey))
                            {
                                $revtagarr = $subdockey['ImageTags'];
                            }
                            $revisionindexval  = $revisionindex;
                            break;
                        }
                        $revisionindex++;
                    }
                    
                }
            }
            
          $count = 0;
            foreach ($revisionarr as $revisionarrvalue) {
               if(array_key_exists('ImageTags', $revisionarrvalue)) 
                {
                    foreach($revisionarrvalue['ImageTags'] as $key) 
                    {
                        $count++;
                    }
                } 
            }
            
            $tagindex = $count;
            if ($revisionindexval !== '' && $tagindex !== 0) 
            {
                $statuscharr = array();
                $deletetagarr = array();
                $phototagarr = array();
                $newtagarr = array();
                foreach ($revtagarr as $rvalue) {
                    $phototagarr[] = $rvalue['TagName'];
                }
                $subdocumentindex = "Photo.".$revisionindexval.".ImageTags";
                for ($tagarrindex = 0; $tagarrindex < count($imgtagarr); $tagarrindex++) {
                    $revflag = 0;
                     $tagname = '';
                    foreach ($revtagarr as $revtagvalue) {
                            if($imgtagarr[$tagarrindex]['TagName'] == $revtagvalue['TagName'])
                            {
                                $revflag = 1;
                                $tagname = $imgtagarr[$tagarrindex]['TagName'];
                            } 
                    }
                    if($revflag == 1)
                    {
                        $statuscharr[] = $tagname;
                    }
                    else if($revflag ==  0)
                    {
                        $newtagarr[] = $imgtagarr[$tagarrindex];
                    }
                    $deletetagarr[] = $imgtagarr[$tagarrindex]['TagName'];
                }
                $test = array_diff($phototagarr,$deletetagarr);
                
                if($newtagarr != null){
                    for ($newtagindex = 0; $newtagindex < count($newtagarr); $newtagindex++) {
                        $newtagarr[$newtagindex]['AuditData'] = array("DateAdded" => $currDate, "AddedBy" => $usermailid, "DateModified" => $currDate, "ModifiedBy" =>$usermailid, "DeleteFlag" => false );
                    }
                }
                
                foreach ($newtagarr as $ntagvalue) {
                   $pushcomment = array($subdocumentindex => $ntagvalue);
                    $commentquery = $this->cimongo->where($wherecond)->push($pushcomment)->update($collection); 
                }
                
                foreach ($statuscharr as $oldtag)
                {
                    $settagindex = 0;
                    $settagindexval = '';
                    foreach ($revtagarr as $rvalue) {
                            if($oldtag == $rvalue['TagName'])
                            {
                                $settagindexval = $settagindex;
                            }
                            $settagindex++;
                    }
                    $settagstatus = array($subdocumentindex.".".$settagindexval.".AuditData.DeleteFlag" => false);
                    $tagstatusquery = $this->cimongo->set($settagstatus)->where($wherecond)->update($collection);
                }
                
                foreach ($test as $testvalue) {
                    $settagdelindex = 0;
                    $settagdelindexval = '';
                    foreach ($revtagarr as $rvalue) {
                            if($testvalue == $rvalue['TagName'])
                            {
                                $settagdelindexval = $settagdelindex;
                            }
                            $settagdelindex++;
                    }
                    $setdeltagstatus = array($subdocumentindex.".".$settagdelindexval.".AuditData.DeleteFlag" => true);
                    $tagdelstatusquery = $this->cimongo->set($setdeltagstatus)->where($wherecond)->update($collection);
                }
                
                return 1;
                
                //return $settagstatus;
            }
            if($revisionindexval !== '' && $tagindex === 0)
            {
                for ($tagarrindex = 0; $tagarrindex < count($imgtagarr); $tagarrindex++) {
                    $imgtagarr[$tagarrindex]['AuditData']= array("DateAdded" => $currDate, "AddedBy" => $usermailid, "DateModified" => $currDate, "ModifiedBy" =>$usermailid, "DeleteFlag" => false );
                }
                $subdocumentindex = "Photo.".$revisionindexval.".ImageTags"; 
                $setimagetag = array($subdocumentindex => $imgtagarr ); 
                $commentquery = $this->cimongo->set($setimagetag)->where($wherecond)->update($collection); 
                return 0;
            }
            //return $revtagarr;
        }
        
/*---------------------------------------------------------------- Dashboard Function -----------------------------------------------------------------*/
        
        
        /*function test($collection = 'DocumentMetaData')
        {
            $documentwherearray = array("TenantId" => 1, "DepartmentId" => 1, "DocumentName" => "Chrysanthemum");	
            $documentselectarray = array("DocumentInfo.TagList","DocumentInfo.RevisionNo","DocumentInfo.Comments");
            $documentquery  = $this->cimongo->select($documentselectarray)->where($documentwherearray)->order_by(array('DocumentInfo.UploadDate' => 'DESC'))->get($collection);
            $documentresult = $documentquery->result_array();
            return $documentresult;
        }*/
        
        function test($collection = 'PhotoGallery')
        {
            $documentwherearray = array("TenantId" => 2, "Photo.FileName" => "Desert.jpg");	
            $documentselectarray = array("Photo.FileLocation");
            $documentquery  = $this->cimongo->select($documentselectarray)->where($documentwherearray)->get($collection);
            $documentresult = $documentquery->result_array();
            return $documentresult;
        }
        
        function dashboardData($tenantid,$userdepartid,$collection = 'DocumentMetaData',$userCollection = 'UserData')
        {
            $useridarr = array();
            if($userdepartid == ''){
                $documentwherearray = array("TenantId" => $tenantid);
            }
            else
            {
                $documentwherearray = array("TenantId" => $tenantid, "DepartmentId" => $userdepartid);
            }    
            $documentselectarray = array("DocumentName","TemplateId","DocumentInfo.TagList","DocumentInfo.RevisionNo","DocumentInfo.IsArchived","DocumentInfo.FileName","DocumentInfo.CurrentStatus","DocumentInfo.UploadDate","DocumentInfo.Comments");
            $documentquery  = $this->cimongo->select($documentselectarray)->where($documentwherearray)->order_by(array('DocumentInfo.UploadDate' => 'DESC'))->get($collection);
            $documentresult = $documentquery->result_array();
            $documentresult_row = $documentquery->num_rows();
            if($documentresult_row > 0)
                return $documentresult;
            else
                return 0;
        }
        
        
        function getlatestDocumentrevision($tenantid,$userdepartid,$documentid,$collection = 'DocumentMetaData')
        {
            $tenantid = (int)$tenantid;
            $userdepartid = (int)$userdepartid;
            $latestrevision = '';
            if($userdepartid != '')
            {
                $wherecondition = array("TenantId" => $tenantid,"DepartmentId" => $userdepartid, "_id" => new MongoID($documentid));
            }
            else
            {
                $wherecondition = array("TenantId" => $tenantid, "_id" => new MongoID($documentid));
            }
            $selectcond = array("DocumentInfo.RevisionNo");
            $documentquery = $this->cimongo->select($selectcond)->where($wherecondition)->order_by(array('DocumentInfo.RevisionNo' => 'DESC'))->limit(1)->get($collection);
            $documentresult = $documentquery->result_array();
            foreach ($documentresult as $revvalue) {
                if(array_key_exists('DocumentInfo',$revvalue))
                {
                     foreach ($revvalue['DocumentInfo'] as $value) {
                          $latestrevision = $value;
                      }
                } 
            }
            return $latestrevision;
        }


        function templatenameData($tenantid,$userdepartid,$doctemplate, $collection = 'TemplateMetaData')
        {
            $tenantid = (int)$tenantid;
            $userdepartid = (int)$userdepartid;
            if($userdepartid != '')
            {
                $wheretemp = array("_id" => new MongoID($doctemplate),"TenantId" =>$tenantid, "DepartmentId" => $userdepartid);
            }
            else
            {
                $wheretemp = array("_id" => new MongoID($doctemplate),"TenantId" =>$tenantid);
            }    
            $tempselectarray = array("HtmlFileName","HtmlFileLocation","TemplateHeader");
            $tempquery   = $this->cimongo->select($tempselectarray)->where($wheretemp)->get($collection);
            $tempqueryresult = $tempquery->result_array();
            $tempqueryresult_row =$tempquery->num_rows();
            if($tempqueryresult_row > 0)
                return $tempqueryresult;
            else 
                return 0;
        }
        
        function tagData($tenanrid,$userdeptid,$collection = 'TagList')
        {
            if($userdeptid == '')
            {
                $taglistwhere = array("TenantId" =>$tenanrid);
            }
            else 
            {
                $taglistwhere = array("TenantId" =>$tenanrid,"DepartmentId" =>$userdeptid);
            }
            $tagselectopt = array("TagList.Tag");   
            $taglistquery  = $this->cimongo->select($tagselectopt)->where($taglistwhere)->get($collection);
            $taglistresult = $taglistquery->result_array();
            $taglistresult_row = $taglistquery->num_rows();
            if($taglistresult_row > 0)
                return $taglistresult;
            else
                return 0;
        }
        
        function companytagData($tenantid,$collection = 'TagList')
        {
            $wheretenant = array("TenantId" => $tenantid); //select()->
            $companytag = $this->cimongo->where($wheretenant)->get($collection);
            $companytagresult = $companytag->result_array();
            $companytag_row = $companytag->num_rows();
            if($companytag_row > 0)
                return $companytagresult;
            else 
                return 0;
        }
        
        
        function changedocumentstate($tenantid,$departmentid,$docid,$docrev,$collection = 'DocumentMetaData')
        {
            if($departmentid != '')
            {
              $wherestate = array("TenantId" => $tenantid, "DepartmentId" => $departmentid,"_id" => new MongoID($docid));  //, "DocumentInfo.RevisionNo" => $docrev
            }
            else 
            {
              $wherestate = array("TenantId" => $tenantid, "_id" => new MongoID($docid)); //, "DocumentInfo.RevisionNo" => $docrev
            }
            $selectstate = array("DocumentInfo"); // => 'CheckedOut'
            
            $documentstatequery = $this->cimongo->select($selectstate)->where($wherestate)->get($collection);
            $dresult = $documentstatequery->result_array();
            $docrevindex = '';
            $revisionindex = 0;
            foreach ($dresult as $docrevval) {
                if(array_key_exists("DocumentInfo",$docrevval))
                {
                    foreach ($docrevval['DocumentInfo'] as $subdockey)
                    {
                         if($subdockey['RevisionNo'] == $docrev)
                        {
                            $docrevindex  = $revisionindex;
                            break;
                        }
                        $revisionindex++;
                    }
                }
            }
            $setfield = 'DocumentInfo.'.$docrevindex.'.CurrentStatus';
            $setstate = array( $setfield => 'CheckedOut');
            $docstatequery = $this->cimongo->set($setstate)->where($wherestate)->update($collection);
            /*
            $documentstatequery
            if($documentstatequery)
                return 1;
            else
                return 0;*/
           /* if($docrevindex)
                return 1;
            else
                return 0;*/
            return $docrevindex;
        }


        function savecommentdata($tenantid,$userdepartid,$documentname,$documentrevision,$comment, $userid, $currDate,$documentid, $collection = 'DocumentMetaData')
        {
            $tenantid = (int)$tenantid;
            $userdepartid =(int)$userdepartid;
            $newcomment = array("CommentText"  => $comment ,"CommentDate" => $currDate,"UserId" => new MongoID($userid));
            if($userdepartid != '')
            {
                $wheredoc   = array("_id" => new MongoID($documentid),"DocumentName" => $documentname, "TenantId" =>$tenantid, "DepartmentId" => $userdepartid);
            }
            else
            {
                $wheredoc   = array("_id" => new MongoID($documentid),"DocumentName" => $documentname, "TenantId" =>$tenantid);
            }
            $selectdoc  = array("DocumentInfo");
            $documentinfoquery = $this->cimongo->select($selectdoc)->where($wheredoc)->get($collection);
            $documentinfoqueryresult = $documentinfoquery->result_array();
            $revisionarr = array();
            $commentsindex = '';
            $revisionindex = 0;
            $revisionindexval = '';
          
            foreach ($documentinfoqueryresult as $dockey) {
                if(array_key_exists("DocumentInfo",$dockey))
                {
                    foreach ($dockey['DocumentInfo'] as $subdockey)
                    {
                         if($subdockey['RevisionNo'] == $documentrevision)
                        {
                            $revisionarr[]    = $subdockey;
                            $revisionindexval  = $revisionindex;
                            break;
                        }
                        $revisionindex++;
                    }
                }
            }
            
            $count = 0;
            foreach ($revisionarr as $revisionarrvalue) {
               if(array_key_exists('Comments', $revisionarrvalue)) //[$revisionindex]
                {
                    foreach($revisionarrvalue['Comments'] as $key) 
                    {
                        $count++;
                    }
                } 
            }
            
            $commentsindex = $count;
             
                if($userdepartid != '')
                {
                    $wherecomment   = array("_id" => new MongoID($documentid),"DocumentName" => $documentname, "TenantId" =>$tenantid, "DepartmentId" => $userdepartid);
                }
                else
                {
                    $wherecomment   = array("_id" => new MongoID($documentid),"DocumentName" => $documentname, "TenantId" =>$tenantid);
                }
            if ($revisionindexval !== '' && $commentsindex !== 0) 
            {
                $subdocumentindex = "DocumentInfo.".$revisionindexval.".Comments";
                $pushcomment = array($subdocumentindex => $newcomment);
                $commentquery = $this->cimongo->where($wherecomment)->push($pushcomment)->update($collection);
                return 1;
                
            }
            if($revisionindexval !== '' && $commentsindex === 0)
            {
                $subdocumentindex = "DocumentInfo.".$revisionindexval.".Comments"; 
                $setcomment = array($subdocumentindex => array($newcomment)); 
                $commentquery = $this->cimongo->set($setcomment)->where($wherecomment)->update($collection); 
                return 0;
            }
            
            
        }
        
        
        function savetagdata($tenantid,$userdepartid,$documentname,$documentrevision,$taglist,$userid,$documentid, $collection= 'DocumentMetaData')
        {
            $tenantid = (int)$tenantid;
            $userdepartid =(int)$userdepartid;
            if($userdepartid != '')
            {
                $wheredoc   = array("_id" => new MongoID($documentid),"DocumentName" => $documentname, "TenantId" =>$tenantid, "DepartmentId" => $userdepartid);
            }
            else
            {
                $wheredoc   = array("_id" => new MongoID($documentid),"DocumentName" => $documentname, "TenantId" =>$tenantid);
            }
            $selectdoc  = array("DocumentInfo");
            $documentinfoquery = $this->cimongo->select($selectdoc)->where($wheredoc)->get($collection); 
            $documentinfoqueryresult = $documentinfoquery->result_array();
            $revisionarr = array();
            $docrevtagarr = array();
            $tagsindex = '';
            $revisionindex = 0;
            $revisionindexval = '';
          
            
            foreach ($documentinfoqueryresult as $dockey) {
                if(array_key_exists("DocumentInfo",$dockey))
                {
                    foreach ($dockey['DocumentInfo'] as $subdockey)
                    {
                         if($subdockey['RevisionNo'] == $documentrevision)
                        {
                            $revisionarr[]    = $subdockey;
                            $revisionindexval  = $revisionindex;
                            break;
                        }
                        $revisionindex++;
                    }
                }
            }
            
            $count = 0;
            foreach ($revisionarr as $revisionarrvalue) {
                if(array_key_exists('TagList', $revisionarrvalue))
                {
                    foreach($revisionarrvalue['TagList'] as $key)
                    {
                        $docrevtagarr[] = $key;
                        $count++;
                    }
                }  
            }
            
            $tagsindex = $count;
            
            if ($revisionindexval !== '' && $tagsindex !== 0) 
            {
                foreach ($taglist as $inputtagvalue) {
                    $existflag = 0;
                    foreach ($docrevtagarr as $revtagvalue) {
                        if($inputtagvalue == $revtagvalue)
                        {
                            $existflag = 1;
                        }   
                    }
                    if($existflag == 0)
                    {
                        $subdocumentindex = "DocumentInfo.".$revisionindexval.".TagList";
                        $pushcomment = array($subdocumentindex => $inputtagvalue);
                        if($userdepartid != '')
                        {
                            $wherecomment   = array("DocumentName" => $documentname, "TenantId" =>$tenantid, "DepartmentId" => $userdepartid);
                        }
                        else
                        {
                            $wherecomment   = array("DocumentName" => $documentname, "TenantId" =>$tenantid);
                        } 
                        $commentquery = $this->cimongo->where($wherecomment)->push($pushcomment)->update($collection);
                    }    
                }
                return 1;
            }
            if($revisionindexval !== '' && $tagsindex === 0)
            {
                $inputtagindex = 0;
                foreach ($taglist as $inputtagvalue) {
                        if($userdepartid != '')
                        {
                            $wherecomment   = array("DocumentName" => $documentname, "TenantId" =>$tenantid, "DepartmentId" => $userdepartid);
                        }
                        else
                        {
                            $wherecomment   = array("DocumentName" => $documentname, "TenantId" =>$tenantid);
                        }
                    if($inputtagindex == 0)
                    {
                        $subdocumentindex = "DocumentInfo.".$revisionindexval.".TagList"; 
                        $setcomment = array($subdocumentindex => array($inputtagvalue)); 
                        $commentquery = $this->cimongo->set($setcomment)->where($wherecomment)->update($collection);
                    } 
                    else
                    {
                        $subdocumentindex = "DocumentInfo.".$revisionindexval.".TagList"; 
                        $setcomment = array($subdocumentindex => $inputtagvalue); 
                        $commentquery = $this->cimongo->set($setcomment)->where($wherecomment)->update($collection);
                    }  
                }
                return 0;
            }
            
        }
        
        
        function tenantDocuments($tenantid,$collection ='DocumentMetaData')
        {
           $useridarr = array();
            
            $documentwherearray = array("TenantId" => $tenantid,"DocumentName" =>"28aug_meetings");
            $documentselectarray = array("DocumentName","DocumentInfo.RevisionNo","DocumentInfo.FileName","DocumentInfo.UploadDate","DocumentInfo.Comments");
            $documentquery  = $this->cimongo->select($documentselectarray)->where($documentwherearray)->order_by(array('DocumentInfo.UploadDate' => 'DESC',"DocumentInfo.Comments.CommentDate" => 'DESC'))->get($collection);
            //$documentquery = $this->cimongo->get($collection);
            $documentresult = $documentquery->result_array();
           /* foreach ($documentresult as $documentvalue) {
                $docValue = $documentvalue['DocumentInfo'];
                foreach ($docValue as $commentvalue) {
                    $cmtvalue = $commentvalue['Comments'];
                    foreach ($cmtvalue as $userid) {
                        $useridarr = $userid['UserId'];
                    }
                }
            }
            $usernamequery = $this->cimongo->select()->where()->get($userCollection);
            */
            $documentresult_row = $documentquery->num_rows();
            if($documentresult_row > 0)
                return $documentresult;
               // return $useridarr;
            else
                return 0; 
            
            
        }
        
        function getdocumentdata($docname,$docrevision,$tenantid,$departmentid,$collection = 'DocumentMetaData')
        {
            $wherecond  = array("TenantId" =>$tenantid, "DepartmentId" => $departmentid, "DocumentName" => $docname); //, "DocumentInfo.RevisionNo" => $docrevision
            $selectdata = array("TemplateId","DocumentInfo");
            $viewdataquery = $this->cimongo->where($wherecond)->get($collection); //select($selectdata)->
            $viewdataqueryresult = $viewdataquery->result_array();
            $viewdataquery_row = $viewdataquery->num_rows();
            if($viewdataquery_row > 0)
            {
               /* foreach ($viewdataqueryresult as $docvalue) {
                    if (array_key_exists('DocumentInfo', $docvalue)) {
                        foreach ($docvalue['DocumentInfo'] as $docinfokey) {
                            if (array_key_exists('RevisionNo', $docinfokey)) {
                                if($docinfokey['RevisionNo'] == $docrevision)
                                {
                                    return $docinfokey;
                                }
                            }
                        }
                    }
                }*/
                return $viewdataqueryresult;
            }
            else 
                return 0;
        }
        
        function getTemplateName($tenantid,$userdepartid,$templateid,$collection = 'TemplateMetaData')
        {
            $wheretemp = array("TenantId" => $tenantid,"DepartmentId" =>$userdepartid,"_id" =>new MongoID($templateid));
            $selectfield = array("HtmlFileName","HtmlFileLocation");
            $templatedataquery = $this->cimongo->select($selectfield)->where($wheretemp)->get($collection);
            $templatedataresult = $templatedataquery->result_array();
            $templatedatarow = $templatedataquery->num_rows();
            if($templatedatarow > 0)
                    return $templatedataresult;
                
            else 
                return 0;
             //return $templateid;
        }
        
        /*---------------------------------------search screen function -------------------------------------------------*/
        function search_documents($searchstr,$tenantid,$departmentid,$dateoption,$filtermongoDate1,$filtermongoDate2,$findinfilter,$filetypefilter,$documentlimit,$andorarr,$datbasetype,$templateid,$collection = 'DocumentMetaData')
        {
            //$selectfield = array("_id","DocumentName","TemplateId","DocumentInfo.RevisionNo","DocumentInfo.UploadDate","DocumentInfo.TagList","DocumentInfo.FileName");
            //new MongoRegex("/$commentword/i")
            $subwherecondarr = array(
                array("TenantId" => (int)$tenantid)
            );
            // Add DepartmentId to the query if provided
            if($departmentid != '' && $departmentid !== null) {
                $subwherecondarr[] = array("DepartmentId" => (int)$departmentid);
            }
            // Remove testing/debug code
            if($searchstr != '')
            {
                $searstrarr = array('$or' => array(
                    array("DocumentName" => array('$regex' => $searchstr, '$options' => 'i')),
                    array("DocumentInfo.FileName" => array('$regex' => $searchstr, '$options' => 'i')),
                    array("DocumentInfo.TagList" => array('$regex' => $searchstr, '$options' => 'i'))
                ));
                $subwherecondarr[] = $searstrarr;
            }
            $whercond = array('$and' => $subwherecondarr);
            if (count($subwherecondarr) > 1) {
                $whercond = array('$and' => $subwherecondarr);
            } else {
                $whercond = $subwherecondarr[0];
            }
            // Log the generated query as JSON
            error_log('SEARCH QUERY JSON: ' . json_encode($whercond));
            // Use direct find query instead of aggregation
            $find_result = $this->cimongo->where($whercond)->get($collection)->result_array();
            return $find_result;
        }
        
 /*---------------------------------------------------------- Bouquet Screen ------------------------------------------------------------------------*/
        
        
        function saveBouquetData($bouquetname,$tenantid,$departmenid,$bouquetdesc,$bouquetdocarr)
        {
            $bouquetdata = array("BouquetName" => $bouquetname,"TenantId" => $tenantid);
           if($departmenid != '')
           {
               $bouquetdata['DepartmentId']       = $departmenid;
               // new MongoID($departmenid)
           }
           $bouquetdata['BouquetDescription'] = $bouquetdesc;
           $bouquetdata['DocumentsInBouquet'] = $bouquetdocarr;
           $bouquetquery = $this->cimongo->insert('BouquetData',$bouquetdata);
                if($bouquetquery > 0)
                    return 1;
                else 
                    return 0;  
        }
        
        
        function getBouquetName($tenantid,$userdepartid,$collection = 'BouquetData')
        {
            $tenantid =(int)$tenantid;
            $userdepartid = (int)$userdepartid;
            if($userdepartid != '')
            {
                $bouquetwherecond = array("TenantId" => $tenantid,"DepartmentId" => $userdepartid);
                //new MongoID($userdepartid);
            }
            else
            {
                $bouquetwherecond = array("TenantId" => $tenantid);
            }
            $bouquetselectdata = array("BouquetName");
            $bouquetdocquery = $this->cimongo->select($bouquetselectdata)->where($bouquetwherecond)->get($collection);
            $bouquetdocresult = $bouquetdocquery->result_array();
            $bouquetdocrows = $bouquetdocquery->num_rows();
                if($bouquetdocrows > 0)
                    return $bouquetdocresult;
                else 
                    return 0;
        }
        
        
        function updateBouquetData($tenantid,$userdepartid,$docid,$docrevision,$bouquetname,$collection = 'BouquetData')
        {
            //$exsitbouquetdoc = array();
            $docrevision = (int)$docrevision;
            $existsflag = 0;
            if($userdepartid != '')
            {
                $bouquetupdate = array("BouquetName" =>$bouquetname,"TenantId" =>$tenantid,"DepartmentId" =>$userdepartid);
            }
            else
            {
                $bouquetupdate = array("BouquetName" =>$bouquetname,"TenantId" =>$tenantid);
            }
            $bouquetselectdata = array("DocumentsInBouquet.DocumentId","DocumentsInBouquet.RevisionNo");
            $bouquetdocquery = $this->cimongo->select($bouquetselectdata)->where($bouquetupdate)->get($collection);
            $bouquetdocarr   = $bouquetdocquery->result_array();
            $bouquetdocno    = $bouquetdocquery->num_rows();
            if($bouquetdocno > 0)
            {
                foreach ($bouquetdocarr as $bdocvalue) {
                    if(array_key_exists("DocumentsInBouquet",$bdocvalue))
                    {
                        foreach ($bdocvalue['DocumentsInBouquet'] as $subdockey)
                        {
                            if(($subdockey['DocumentId'] == $docid) && ($subdockey['RevisionNo'] == $docrevision))
                            {
                                $existsflag = 1;
                            }
                        }
                        if($existsflag != 1)
                        {
                             $bouquetdocpush = array("DocumentsInBouquet"=>array("DocumentId" =>  new MongoID($docid),"RevisionNo" => $docrevision));
                             $bouquetadddocquery = $this->cimongo->push($bouquetdocpush)->where($bouquetupdate )->update($collection);
                             return 1;
                        }
                        else
                        {
                            return 0;
                        }
                    }
                }
            }
            
        }
        
        
        function getPhysicalLocationTags($tenantid,$userdepartid,$docid,$docrev,$collection= 'DocumentMetaData')
        {
            if($userdepartid != '')
            {
                $wherecond = array("_id" => $docid, "TenantId" => $tenantid,"DepartmentId" =>$userdepartid);
            }
            else
            {
                $wherecond = array("_id" => $docid, "TenantId" => $tenantid);
            }
            $selectdoc = array("DocumentInfo.RevisionNo","DocumentInfo.PhysicalLocation");
            $documentinfoquery = $this->cimongo->select($selectdoc)->where($wherecond)->get($collection); 
            $documentinfoqueryresult = $documentinfoquery->result_array();
            
           return $documentinfoqueryresult;
            
        }
        
        
        /*------------------------------------------------------------ Database function created By Mahendra --------------------------------------------*/
        function getPackageName($packagetype,$collection="PackageInfo")
        {

            $condition=array("PackageType"=>$packagetype);
            $selectname = array("PackageName","DurationOrSize");
            $query = $this->cimongo->select($selectname)->where($condition)->get($collection);
            $result =  $query->result_array();
            $result_row = $query->num_rows();
            if($result_row > 0)
                return $result;
            else 
                return 0;
			
        }
        
        /*
        * Summary :This function get the from PackageInfo collection 
        * Parameter:  $collection->'PackageInfo' collection
        *			  $pack_name->'8GBInd' for example
        *			  $pack_type->Individual/Corporate
        *			  $sizeorduration->Months/Size
        */
        function getPackageInfo($pack_name,$pack_type,$sizeorduration,$collection='PackageInfo')
        {
            $condition=array('PackageName'=>$pack_name,'PackageType'=>$pack_type);
            if($sizeorduration=='size')
            {
                    $select=array('_id','DurationOrSize','PackageSizeInGB','PackageBaseRate','PackageTaxPercentage');
            }
            if($sizeorduration=='duration')
            {
                    $select=array('_id','DurationOrSize','PackageDurationInMonths','PackageBaseRate','PackageTaxPercentage');
            }
            $query = $this->cimongo->select($select)->where($condition)->get($collection);
            $result =  $query->result_array();
            $result_row = $query->num_rows();
            if($result_row > 0)
                return $result;
            else 
                return 0;
			
        }
        
        /*
         * Summary :This function get the max _id from TenantInfo collection 
         * Parameter:  $collection->'TenantInfo' collection
         */
         function getMaxId($collection='TenantInfo')
         {
             $select=array('_id');
             $query = $this->cimongo->select($select)->order_by(array('_id' => 'DESC'))->limit(1)->get($collection);
             $result =  $query->result_array();
             return $result;
         }
         
         /*
            * Summary :This function insert the data in TenantInfo collection 
            * Parameter: $doc->provide the signup information
            *			 $collection->'TenantInfo' collection
            */
            function setTenantInfo($doc,$collection='TenantInfo')
            {
                    $query = $this->cimongo->insert($collection,$doc);
                    return $query;
            }
            /*
            * Summary :This function insert the data in UserData collection 
            * Parameter: $doc->provide the signup information
            *			 $collection->'UserData' collection
            */
            function setUserInfo($doc,$collection='UserData')
            {
                    $query = $this->cimongo->insert($collection,$doc);
                    return $query;
            }

            /*
            * Summary :This function returns the data from UserData collection 
            * Parameter: $id-> user id
            *			 $password-> user password
            */
            function getUserInfoPassword($id,$password,$collection='UserData')
            {
                    $select = array('Name','Contact');
                    $condition = array('_id'=>$id,'LoginInfo.Password'=>$password);
                    $query=$this->cimongo->select($select)->where($condition)->get($collection);
                    $result =  $query->result_array();
                    if($result > 0)
                        return $result;
                     else 
                         return 0;
            }
            /*
            * Summary :This function set the password of user in UserData collection 
            * Parameter: $id-> user id
            *			 $password-> user new password
            */
            function setUserInfoPassword($id,$password,$collection = 'UserData')
            {
                   // $condition = array('_id'=>$id);
                    $criteria = array('_id' => new MongoID($id));
                    $query=$this->cimongo->set(array("LoginInfo.Password" => $password))->where($criteria )->update($collection);//->where($condition);
                    $result =  $query->result_array();
                    if($result > 0)
                         return $result;
                    else 
                         return 0;
            }
            /*
            * Summary :This function set the name, contact of user in UserData collection 
            * Parameter: $id-> user id
            *			 $name-> user new name
            *			 $contact-> user contact
            */
            function setUserInfoProfile($id,$name,$contact,$collection = 'UserData')
            {
                    $criteria = array('_id' => new MongoID($id));
                    $query=$this->cimongo->set(array("Name" => $name,"Contact"=>$contact))->where($criteria )->update($collection);//->where($condition);
                    if($query > 0)
                         return $query;
                    else 
                         return 0;
            }
            
            /*
            * Summary :This function set the information of user in TenantInfo collection 
            * Parameter: $id-> Tenant id
            */
            function setTenantInfoProfile($id,$add1,$add2,$city,$pincode,$state,$country,$collection = 'TenantInfo')
            {
                    $criteria = array('_id' => $id);
                    $query=$this->cimongo->set(array("AddressInfo"=>array("Add1" => $add1,"Add2" => $add2,"City"=>$city,"PinCode"=>$pincode,"State"=>$state,"Country"=>$country) ))->where($criteria )->update($collection);//->where($condition);
                    if($query > 0)
                        return $query;
                     else 
                         return 0;
            }
            function setTenantHistory($id,$collection="TenantHistory")
            {
                $historyObj = array("TenantId" => $id,"HistoryInformation" => array());
                $result = $this->cimongo->insert($collection,$historyObj);
                return $result;
            }
            
            /*
            * Summary :This function returns the information of tenant from TenantInfo collection 
            * Parameter: $id-> Tenant id
            */
            function getTenantInfo($id,$collection = 'TenantInfo')
            {
                    $select = array('TenantName','AddressInfo.Add1','AddressInfo.Add2','AddressInfo.City','AddressInfo.PinCode','AddressInfo.State','AddressInfo.Country');
                    $condition =array('_id'=>$id);
                    $query = $this->cimongo->select($select)->where($condition)->get($collection);
                    $result =  $query->result_array();
                    if($result > 0)
                        return $result;
                    else 
                         return 0;
             }
             
             /*
            * Summary :This function returns the information of user from UserData collection 
            * Parameter: $id-> User id
            */
            function getUserInfo($id,$collection='UserData')
            {
                    $select = array('TenantId','Name','LoginInfo.EmailId','Contact');
                    $condition =array('_id'=> new MongoID($id));
                    $query = $this->cimongo->select($select)->where($condition)->get($collection);
                    $result =  $query->result_array();
                    if($result > 0)
                        return $result;
                    else 
                        return 0;
            }
            
            /*
        * Summary :This function set the information of defect in DefectLog collection 
        * Parameter: $userId-> User id
        */
        function setDefectLog($userId,$category,$title,$description,$comments,$tenantId,$isodate,$collection='DefectLog')
        {
                $doc = array("IssueCategory"=>$category, "IssueTitle"=>$title,"IssueDescription"=>$description,"DateRaisedOn"=>$isodate,
                                "DefectLogHistory"=>array(
                                                             array("DefectStatus" =>"Opened",
                                                                    "RaisedBy"    => array(
                                                                                            "TenantId"=>$tenantId,
                                                                                            "UserId"=>$userId,
                                                                                            "Comment"=>$comments,
                                                                                            "Date"=>$isodate),
                                                                    "RaisedTo" => array(
                                                                                            "TenantId"=>-999,
                                                                                            "UserId"=>"ProductAdminUser@DMSTree.com"
                                                                                        ),
                                                                    "Sequence"=>1),
                                                                                                                                                                                                                                                                                                                ));
                $query = $this->cimongo->insert($collection,$doc);
                return $query;
        }
        /*
        * Summary :This function returns the information of defect from DefectLog collection 
        * Parameter: $userId-> User id
        */
        function getReportInfo($id,$collection='DefectLog')
        {
                $select = array('IssueCategory','IssueTitle',"IssueDescription","DateRaisedOn","DefectLogHistory.DefectStatus");
                $condition =array('DefectLogHistory.RaisedBy.UserId'=> $id);
                $query = $this->cimongo->select($select)->where($condition)->order_by(array('DateRaisedOn' => false))->get($collection);
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
	}
              /*
        * Summary :This function returns the information of defect from DefectLog collection 
        * Parameter: $id-> DefectLog collection _id 
        */
        function getReportDetailInfo($id,$collection='DefectLog')
        {
                $select = array("DefectLogHistory");
                $condition =array('_id'=> new MongoID($id));
                $query = $this->cimongo->select($select)->where($condition)->get($collection);
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
        }
        /*
        * Summary :This function returns the information of new from DmstreeNews collection 
        */
        function getNews($id = '',$collection = 'DmstreeNews')
        {
            if(empty($id))
            {
                $query = $this->cimongo->select()->get($collection);
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
            }
            else
            {
                $condition =array('_id'=> new MongoID($id));
                $query = $this->cimongo->select()->where($condition)->get($collection);
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
            }
        }
        /*
        * Summary :This function returns the information of notice from NoticeBoard collection 
        */
        function getNoticeInfo($id,$collection = 'NoticeBoard')
        {
                $condition = array('UserId'=>new MongoID($id));
                $query = $this->cimongo->select()->where($condition)->order_by(array('NoticeDate' => false))->get($collection);
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
        }
        /*
        * Summary :This function set the information of notice in NoticeBoard collection 
        *
        */
        function setNoticeInfo($category,$title,$description,$img,$currDate,$expiryDate,$userId,$tenantId,$collection = 'NoticeBoard')
        {
                if($img !='')
                {
                        $doc = array('NoticeCategory'=>$category,'NoticeTitle'=>$title,'NoticeDescription'=>$description,'NoticeImage'=>$img,'NoticeDate'=>$currDate,'ExpiryDate'=>$expiryDate,'TenantId'=>$tenantId,'UserId'=>$userId);
                }
                else if($img == '')
                {
                        $doc = array('NoticeCategory'=>$category,'NoticeTitle'=>$title,'NoticeDescription'=>$description,'NoticeDate'=>$currDate,'ExpiryDate'=>$expiryDate,'TenantId'=>$tenantId,'UserId'=>$userId);
                }
                $query = $this->cimongo->insert($collection,$doc);
                return $query;
        }

        function setStandardListInfo($doc,$collection = 'StandardList')
        {
                $query = $this->cimongo->insert($collection,$doc);
                return $query;
        }

        function getStandardListName($tenantId,$collection = 'StandardList')
        {
                //$select = array('ListName','AuditData'); changed for view template. 
                $condition =array('TenantId'=> $tenantId);
                $query = $this->cimongo->select()->where($condition)->get($collection);//$select changed for view template.
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
			
        }
        		
        function getStandardListDescription($id,$collection = 'StandardList')
        {
                if(empty($id)){
                   $condition = array("TenantId" =>$id); 
                }
                else if(!empty($id)){
                     $condition =array('_id'=> new MongoID($id));
                }
                $query = $this->cimongo->select()->where($condition)->get($collection);
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
			
        }
        function deleteStandardListDescription($id,$list,$code,$listIndex,$collection = 'StandardList')
        {
                $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->set(array('List.'.$listIndex.'.AuditData.DeleteFlag'=>true))->where($criteria )->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function deleteStandardList($id,$currDate,$userEmailId,$collection = 'StandardList')
        {
                $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->set(array('AuditData.DeleteFlag'=>true,'AuditData.DateModified'=>$currDate,'AuditData.ModifiedBy'=>$userEmailId))->where($criteria )->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function updateStandardList($id,$doc,$collection = 'StandardList')
        {
                $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->push($doc)->where($criteria )->update($collection);
                //$this->cimongo->where($wherecomment)->push($pushcomment)->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function updateStandardListName($id,$name,$collection = 'StandardList')
        {
                $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->set(array('ListName'=>$name))->where($criteria )->update($collection);
                if($query > 0)
                    return $query;
                else 
                     return 0;
        }
        function getTagList($tenantId,$collection = 'TagList')
        {
                $select = array('TagList.Tag','TagList.IsActive','TagList.AuditData.DeleteFlag');
                $condition =array('TenantId'=> $tenantId);
                $query = $this->cimongo->select($select)->where($condition)->get($collection);
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
        }
        function updateTag($tenantId,$doc,$collection = 'TagList')
        {
                $criteria = array('TenantId' => $tenantId);
                $query = $this->cimongo->set($doc)->where($criteria )->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function insertTag($tenantId,$doc,$collection = 'TagList')
        {
                $criteria = array('TenantId' => $tenantId);
                $query = $this->cimongo->push($doc)->where($criteria )->update($collection);
                //$this->cimongo->where($wherecomment)->push($pushcomment)->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function deleteTag($tenantId,$doc,$collection = 'TagList')
        {
                $criteria = array('TenantId' => $tenantId);
                $query = $this->cimongo->set($doc)->where($criteria )->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function getPhotoList($tenantId,$collection = 'PhotoGallery')
        {
                $select = array('Photo.FileName','Photo.FileLocation','Photo.AuditData.DeleteFlag','Photo.ImageTags');
                $condition =array('TenantId'=> $tenantId);
                $query = $this->cimongo->select($select)->where($condition)->get($collection);
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
        }
        function setPhotoGallary($tenantId,$doc,$collection = 'PhotoGallery')
        {
                $criteria = array('TenantId' => $tenantId);
                $query = $this->cimongo->push($doc)->where($criteria )->update($collection);
                //$this->cimongo->where($wherecomment)->push($pushcomment)->update($collection);
                if($query > 0)
                    return $query;
             else 
                    return 0;
        }
        function deletePhoto($tenantId,$doc,$collection = 'PhotoGallery')
        {
                $criteria = array('TenantId' => $tenantId);
                $query = $this->cimongo->set($doc)->where($criteria )->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function getDocumentMetadataDetails($tenantId,$collection ='DocumentMetaData')
        {
                //$select = array();
                $condition =array('TenantId'=> $tenantId,"DocumentInfo.CurrentStatus" => 'CheckedOut',"DocumentInfo.RevisionBlock"=>false);
                $query = $this->cimongo->select()->where($condition)->get($collection);
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
        }
                function getDocumentMetadataById($id,$collection ='DocumentMetaData')
        {
                //$select = array();
                    
                $condition =array('_id'=> new MongoID($id));
                $query = $this->cimongo->select()->where($condition)->get($collection);
                $result =  $query->result_array();
                if($result > 0)
                    return $result;
                else 
                    return 0;
        }
        function updateDocumentMetadata($id,$doc,$collection ='DocumentMetaData')
        {
                $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->set($doc)->where($criteria)->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function getPackages($collection="PackageInfo")
        {
            //$select = array('_id','PackageName');
            $query = $this->cimongo->select()->get($collection);
            $result =  $query->result_array();
            $result_row = $query->num_rows();
            if($result_row > 0)
                return $result;
            else 
                return 0;
        }
        function getPackagesById($id,$collection="PackageInfo")
        {
            //$select = array('_id','PackageName');
            $criteria = array('_id' => new MongoID($id));
            $query = $this->cimongo->select()->where($criteria)->get($collection);
            $result =  $query->result_array();
            $result_row = $query->num_rows();
            if($result_row > 0)
                return $result;
            else 
                return 0;
        }
        function insertPackageInfo($doc,$collection="PackageInfo")
        {
                $query = $this->cimongo->insert($collection,$doc);
                return $query;
        }
        function updatePackageInfo($doc,$id,$collection="PackageInfo")
        {
                $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->set($doc)->where($criteria)->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function deletePackageInfo($doc,$id,$collection="PackageInfo")
        {
                $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->set($doc)->where($criteria)->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function getStandardList($id,$collection="StandardList")
        {
            $criteria = array('TenantId' => $id);
            //$select = array('List.Description');
            $query = $this->cimongo->select()->where($criteria)->get($collection);
            $result =  $query->result_array();
            $result_row = $query->num_rows();
            if($result_row > 0)
                return $result;
            else 
                return 0;
        }
          function insertStandardList($id,$doc,$collection="StandardList")
        {
                $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->push($doc)->where($criteria )->update($collection);
                if($query > 0)
                    return 1;
                else 
                    return 0;
        }
        function deleteStandardLists($id,$doc,$collection="StandardList")
        {
                $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->set($doc)->where($criteria)->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }

        function deleteTemplateMetaData($id,$doc,$collection="TemplateMetaData")
        {
                $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->set($doc)->where($criteria)->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function setDmstreeNews($doc,$collection = "DmstreeNews")
        {
            $query = $this->cimongo->insert($collection,$doc);
            return $query;
        }
        function deleteNews($id,$doc,$collection = 'DmstreeNews')
        {
            $criteria = array('_id' => new MongoID($id));
                $query = $this->cimongo->set($doc)->where($criteria)->update($collection);
                if($query > 0)
                    return $query;
                else 
                    return 0;
        }
        function getFileLocation($id,$documentrevision,$collection = 'DocumentMetaData')
        {
//            $criteria = array('_id' => new MongoID($id),'DocumentInfo.RevisionNo'=>$documentrevision);
//            $select = array('DocumentInfo.FileLocation','DocumentInfo.FileName');
            $criteria = array('_id' => new MongoID($id));
            $select = array('DocumentInfo');
            $query = $this->cimongo->select($select)->where($criteria)->get($collection);
            $result =  $query->result_array();
            $result_row = $query->num_rows();
            if($result_row > 0)
                return $result;
            else 
                return 0;
        }
        function getBouquetData($tenantId,$collection = 'BouquetData')
        {
            $criteria = array('TenantId' => $tenantId);
            $select = array('BouquetName');
            $query = $this->cimongo->select($select)->where($criteria)->get($collection);
            $result =  $query->result_array();
            $result_row = $query->num_rows();
            if($result_row > 0)
                return $result;
            else 
                return 0;
        }
        function saveSubDomain($id,$doc,$collection="StandardList")
        {
            $criteria = array('_id' => new MongoID($id));
            $result = $this->cimongo->where($criteria)->push($doc)->update($collection);
           //$result = $this->cimongo->push($doc)->where($criteria )->update($collection);
            echo $result;
        }
        function deleteSubDomain($id,$doc,$collection="StandardList")
        {
            $criteria = array('_id' => new MongoID($id));
            $result = $this->cimongo->where($criteria)->set($doc)->update($collection);
            echo $result;
        }
        function savePurchaseTemplate($doc,$collection = "TemplateMetaData")
        {
            $template = $this->cimongo->insert($collection,$doc);
            return $template;
        }
        function getCommentsByDate($docRevision,$docId,$dates,$collection='DocumentMetaData')
        {
            
            $criteria = array('_id' => new MongoID($docId));
            $select = array('DocumentInfo.Comments');
            $query = $this->cimongo->select($select)->where($criteria)->get($collection);
            $result =  $query->result_array();
            $result_row = $query->num_rows();
            if($result_row > 0) 
                return $result;
            else 
                return 0;
            
        }
        function getDocumentByID($id,$collection="DocumentMetaData")
        {
            $criteria = array('_id' => new MongoID($id));
            $select = array('DocumentInfo.Comments','DocumentInfo.RevisionNo');
            $query = $this->cimongo->select($select)->where($criteria)->get($collection);
            $result =  $query->result_array();
            $result_row = $query->num_rows();
            if($result_row > 0) 
                return $result;
            else 
                return 0;
        }
        
        function templatenameData_new($doctemplate, $collection = 'TemplateMetaData')
        {
            $wheretemp       = array("_id" => new MongoID($doctemplate));
            $tempselectarray = array("HtmlFileName","HtmlFileLocation","TemplateHeader");
            $tempquery   = $this->cimongo->select($tempselectarray)->where($wheretemp)->get($collection);
            $tempqueryresult = $tempquery->result_array();
            $tempqueryresult_row =$tempquery->num_rows();
            if($tempqueryresult_row > 0)
                return $tempqueryresult;
            else 
                return 0;
        }
        function getTemplateslist_new($tenantid,$userdepartid = "",$collection = 'TemplateMetaData')
        {
                //$selectTemp = array("_id","HtmlFileName","HtmlFileLocation","TemplateHeader"); change for view_template.php
                //$wheretenanttemp = array("TenantId" => $tenantid);
                if($userdepartid != ''){
                    $wheretenanttemp = array("TenantId" => $tenantid,"DepartmentId" => $userdepartid);
                }
                else
                {
                    $wheretenanttemp = array("TenantId" => $tenantid);
                }

                $templatequery = $this->cimongo->select()->where($wheretenanttemp)->get($collection);
                $tempresult =  $templatequery->result_array();
                $tempresult_row = $templatequery->num_rows();
                if($tempresult_row > 0)
                    return $tempresult;
                else 
                    return 0;
        }
        
        function updateSubDomain($id,$doc,$collection="StandardList")
        {
            $criteria = array('_id' => new MongoID($id));
            $result = $this->cimongo->where($criteria)->set($doc)->update($collection);
            echo $result;
        }
        
        function getReportProblemInfo($collection='DefectLog')
        {
            $select = array('IssueCategory','IssueTitle',"IssueDescription","DateRaisedOn","DefectLogHistory.DefectStatus");
            $condition =array('DefectLogHistory.RaisedTo.TenantId'=> -999);
            $query = $this->cimongo->select($select)->where($condition)->order_by(array('DateRaisedOn' => false))->get($collection);
            $result =  $query->result_array();
            if($result > 0)
                return $result;
            else 
                return 0;
        }
        function updateReportInfo($doc,$id,$collection='DefectLog')
        {
            $criteria = array('_id' => new MongoID($id));
            $result = $this->cimongo->where($criteria)->push($doc)->update($collection);
           //$result = $this->cimongo->push($doc)->where($criteria )->update($collection);
            echo $result;
        }
        function getReportDetail($id,$collection='DefectLog')
        {

            $condition =array('_id'=> new MongoID($id));
            $query = $this->cimongo->select()->where($condition)->get($collection);
            $result =  $query->result_array();
            if($result > 0)
                return $result;
            else 
                return 0;
        }
       function setComments($documentname,$documentrevision,$comment, $userid, $currDate,$id = '', $collection = 'DocumentMetaData')
        {
           $newcomment = array("CommentText"  => $comment ,"CommentDate" => $currDate,"UserId" => new MongoID($userid));
            if(empty($id))
            {
                $wheredoc   = array("DocumentName" => $documentname); 
            }
            else {
                $wheredoc   = array("_id" => new MongoID($id));
            }
            $selectdoc  = array("DocumentInfo");
            $documentinfoquery = $this->cimongo->select($selectdoc)->where($wheredoc)->get($collection);
            $documentinfoqueryresult = $documentinfoquery->result_array();
            $revisionarr = array();
            $commentsindex = '';
            $revisionindex = 0;
            $revisionindexval = '';
            $revcommindex = 0;
            $revisioncomment = '';
            foreach ($documentinfoqueryresult as $dockey) {
                if(array_key_exists("DocumentInfo",$dockey))
                {

                    foreach ($dockey['DocumentInfo'] as $subdockey)
                    {

                         if($subdockey['RevisionNo'] == $documentrevision)
                        {
                            $revisionarr[]    = $subdockey;
                            $revisionindexval  = $revisionindex;
                            break;
                        }
                        $revisionindex++;

                    }

                }
            }

            $count = 0;
            if(array_key_exists('Comments', $revisionarr[$revisionindex]))
            {
                foreach($revisionarr[$revisionindex]['Comments'] as $key)
                {
                    $count++;
                }
            }
            $commentsindex =$count;
           // echo $revisionindexval;
            if ($revisionindexval !== '' && $commentsindex !== '') 
            {
                $subdocumentindex = "DocumentInfo.".$revisionindexval.".Comments";
                $pushcomment = array($subdocumentindex => $newcomment);
                //$wherecomment = array("DocumentName" => $documentname,"DocumentInfo.RevisionNo" => $documentrevision);
                //$wherecomment = array("DocumentName" => $documentname);  // Compare by Document Name
                $wherecomment = array('_id'=>new MongoID($id));       // Comapre by _id
                $commentquery = $this->cimongo->where($wherecomment)->push($pushcomment)->update($collection);
                //$test = "arrindex".$revisionindexval."--commindex".$commentsindex."in push method";
                //return $pushcomment;
                return $commentquery;
            }
            if($revisionindexval !== '' && $commentsindex === '')
            {
                $subdocumentindex = "DocumentInfo.".$revisionindexval.".Comments"; 
                $setcomment = array($subdocumentindex => array($newcomment)); 
                //$wherecomment = array("DocumentName" => $documentname,"DocumentInfo.RevisionNo" => $documentrevision);
                $wherecomment = array('_id'=>new MongoID($id));
                $commentquery = $this->cimongo->set($setcomment)->where($wherecomment)->update($collection); 
                //$test = "arrindex".$revisionindexval."--commindex".$commentsindex."in set method";
                return $setcomment;
            }
            
           
            
        }
        function setPhotoGallery($id,$userEmail,$currDate,$collection='PhotoGallery')
        {
            $photoObj = array("TenantId" => $id,"Photo" => array(),"AuditData" => array('DateAdded'=>$currDate,
                                                                                          'AddedBy'=>$userEmail,
                                                                                          'DateModified'=>$currDate,
                                                                                          'ModifiedBy'=>$userEmail,
                                                                                          'DeleteFlag'=>false));
            $result = $this->cimongo->insert($collection,$photoObj);
            return $result;
        }
        function setTagList($id,$userEmail,$currDate,$collection='TagList')
        {
            $photoObj = array("TenantId" => $id,"TagListGroup" => "Company Level","TagList" => array(),"AuditData" => array('DateAdded'=>$currDate,
                                                                                          'AddedBy'=>$userEmail,
                                                                                          'DateModified'=>$currDate,
                                                                                          'ModifiedBy'=>$userEmail,
                                                                                          'DeleteFlag'=>false));
            $result = $this->cimongo->insert($collection,$photoObj);
            return $result;
        }
        
        /*************************************************************/
        
        
        function getGalleryPhotos($tenantid,$tenantname, $collection = 'PhotoGallery')
        {
            $tenantid = (int)$tenantid;
            $wherecond = array("TenantId" => $tenantid );
            $selectcond = array("Photo.FileName","Photo.FileLocation","Photo.ImageTags","Photo.AuditData");
            $galleryquery = $this->cimongo->select($selectcond)->where($wherecond)->get($collection); 
            $galleryqueryresult = $galleryquery->result_array();
            $galleryrows = $galleryquery-> num_rows();
            if($galleryrows > 0)
               return $galleryqueryresult;
           else 
               return 0;
        }
        
        
        function deleteGalleryPhoto($tenantId,$filename,$collection = 'PhotoGallery')
        {
            $tenantId =(int)$tenantId;
            $wherecond = array("TenantId" => $filename, "Photo.FileName" => $filename);
            $selectdata = array("Photo");
            $documentinfoquery = $this->cimongo->select($selectdata)->where($wherecond)->get($collection);
            $documentinfoqueryresult = $documentinfoquery->result_array();  
            $revisionarr = array();
            $revisionindex = 0;
            $revisionindexval = '';
          
            foreach ($documentinfoqueryresult as $dockey) {
                if(array_key_exists("Photo",$dockey))
                {
                    foreach ($dockey['Photo'] as $subdockey)
                    {
                        if($subdockey['FileName'] == $filename)
                        {
                            $revisionarr[]    = $subdockey;
                            $revisionindexval  = $revisionindex;
                            break;
                        }
                        $revisionindex++;
                    }
                }
            }
            
            $subdocumentindex = "Photo.".$revisionindexval.".AuditData.DeleteFlag";
            foreach ($imgtagarr as $tagvalue) {
                   $setstatus = array($subdocumentindex => true);
                    $delephotoquery = $this->cimongo->where($wherecond)->set($setstatus)->update($collection); 
                    if($delephotoquery)
                        return 1;
                    else 
                        return 0;
                }
        }
        function updateSavedocument($tenantid,$userdepartid,$updaterev,$documentid,$isPrviate,$collection = 'DocumentMetaData')
        {
            if($userdepartid != '')
            {
                $wherecond = array("_id" => new MongoID($documentid),"TenantId" => $tenantid, "DepartmentId" =>$userdepartid );
            }
            else 
            {
                $wherecond = array("_id" => new MongoID($documentid),"TenantId" => $tenantid );
            }
            $selectdata = array("DocumentInfo.RevisionNo");
            $documentquery = $this->cimongo->select($selectdata)->where($wherecond)->get($collection);
            $documentqueryresult = $documentquery->result_array();
            $documentqueryrows = $documentquery->num_rows();
            $oldrevval = '';
            $oldrev = 0;
            if($documentqueryrows > 0)
            {
                foreach ($documentqueryresult as $docvalue) {
                    if(array_key_exists("DocumentInfo",$docvalue))
                    {
                        foreach ($docvalue['DocumentInfo'] as $docrevvalue) {
                            if($docrevvalue['RevisionNo'] == $updaterev)
                            {
                                $oldrevval = $oldrev;
                            }
                            $oldrev++;
                        }
                    }        
                }
            }
                $newupdaterev = (int)$updaterev+1;
                $setfield = "DocumentInfo.".$oldrevval.".RevisionBlock"; 
                $setfield1 = "DocumentInfo.".$oldrevval.".IsLatestRevision";
                if($isPrviate == 'true')
                    $newPrivate = true;
                else 
                    $newPrivate = false;
                $setdata = array($setfield => true,$setfield1=>false,'LatestRevision'=>$newupdaterev,'IsPrivate'=>$newPrivate);
                $docstatequery = $this->cimongo->set($setdata)->where($wherecond)->update($collection);
        }
        function setDocumentToArchive($docid,$doc,$collection='DocumentMetaData')
        {
            $wherecondition = array('_id'=>new MongoID($docid));
            $query = $this->cimongo->set($doc)->where($wherecondition)->update($collection); 
            return $query;
        }
/****************************************************************************************************************************/
        function filterdashboarddata($tenantid,$userdepartid,$collection = 'DocumentMetaData')
        {
            $pipeline = array(
                        array(
                            '$project' =>array  (
                                                    "DocumentName" => 1,"TenantId" =>1,"IsPrivate"=>1,"LatestRevision" => 1,'TemplateId'=>1,"IsPrivate"=> 1,
                                                    "DocumentInfo.RevisionNo" => 1,"DocumentInfo.TagList" => 1,
                                                    "DocumentInfo.UploadDate" => 1,"DocumentInfo.FileName" => 1,"DocumentInfo.CurrentStatus" => 1,
                                                    "DocumentInfo.Comments" => 1, "AuditData.DateModified" =>1,"DocumentInfo.IsLatestRevision" =>1
                                                )
                        ),
                        array(
                            '$unwind' => '$DocumentInfo',
                        ),
                       
                        array(
                            '$match' => array(
                                                    "TenantId"=> $tenantid
                                                   // 'DocumentInfo.IsArchived' =>false
                                             )
                        ),
                        array(
                            '$sort' => array(
                                                    'DocumentInfo.UploadDate' => -1,
                                                    'DocumentInfo.RevisionNo' => -1,
                                                    'DocumentInfo.Comments.CommentDate' => -1
                                            )
                        ),
                        array(
                            '$limit' => 5
                        )
                    );
                    // $cursor = $this->cimongo->aggregate($collection,$pipeline);
                    // return $cursor;
                    
            $result = $this->cimongo->aggregate($collection,$pipeline);
            // Handle the cursor result
            if (isset($result['result']) && is_array($result['result'])) {
                return array('result' => $result['result']);
            }
            // For newer MongoDB versions that return a cursor
            if (isset($result['cursor']) && isset($result['cursor']['firstBatch'])) {
                return array('result' => $result['cursor']['firstBatch']);
            }
            return array('result' => array());
        }
        
        
        function nextfilterdashboarddata($tenantid,$userdepartid,$skipdoc,$collection = 'DocumentMetaData')
        {
            $skipdoc = (int)$skipdoc;
                  $pipeline = array(
                        array(
                            '$project' =>array  (
                                                    "DocumentName" => 1,"TenantId" =>1,"LatestRevision" => 1,'TemplateId'=>1,"IsPrivate"=> 1,
                                                    "DocumentInfo.RevisionNo" => 1,"DocumentInfo.TagList" => 1,
                                                    "DocumentInfo.UploadDate" => 1,"DocumentInfo.FileName" => 1,"DocumentInfo.CurrentStatus" => 1,
                                                    "DocumentInfo.Comments" => 1, "AuditData.DateModified" =>1,"DocumentInfo.IsLatestRevision" =>1
                                                )
                        ),
                        array(
                            '$unwind' => '$DocumentInfo',
                        ),
                       
                        array(
                            '$match' => array(
                                                    "TenantId"=> $tenantid
                                                    //'DocumentInfo.IsArchived' =>  array('$exist'=> false),
                                             )
                        ),
                        array(
                            '$sort' => array(
                                                    'DocumentInfo.UploadDate' => -1,
                                                    'DocumentInfo.RevisionNo' => -1
                                            )
                        ),
                      array(
                          '$skip' => $skipdoc
                      ),
                        array(
                            '$limit' => 5
                        )
                    );
            $cursor = $this->cimongo->aggregate($collection,$pipeline);
            if (isset($cursor['result'])) {
                return $cursor['result'];
            } else {
                return array();
            }
            
//            $cursor = $this->cimongo->aggregate($collection,$pipeline);
//            return $cursor;
        }
        
        // Update DepartmentId in UserData
        function updateUserDepartmentId($userid, $newDepartmentId, $collection = 'UserData') {
            $criteria = array('_id' => new MongoID($userid));
            $update = array('DepartmentId' => $newDepartmentId);
            return $this->cimongo->set($update)->where($criteria)->update($collection);
        }

        // Update DepartmentId in DocumentMetaData for all documents of this user/tenant
        function updateDocumentDepartmentId($tenantid, $userid, $newDepartmentId, $collection = 'DocumentMetaData') {
            $criteria = array('TenantId' => $tenantid, 'DocumentInfo.UserId' => new MongoID($userid));
            $update = array('DepartmentId' => $newDepartmentId);
            return $this->cimongo->set($update)->where($criteria)->update($collection, array('multiple' => TRUE));
        }

        // Atomically increment DepartmentId in UserData
        function incrementUserDepartmentId($userid, $collection = 'UserData') {
            $criteria = array('_id' => new MongoID($userid));
            $update = array('$inc' => array('DepartmentId' => 1));
            // Use the native MongoDB driver for atomic increment
            return $this->db->selectCollection($collection)->update($criteria, $update, array('w' => 1));
        }

}
?>