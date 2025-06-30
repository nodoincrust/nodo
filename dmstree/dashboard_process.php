<?php
ob_start();
session_start();
include 'session_config.php';

require('../CodeIgniter-old/external.php');
$ci =& get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();

$userdepartid = '';
$tenantid = '';
$userarr = '';
$skipdoc = 0;


if(isset($_SESSION['userdepartmentid'] ))
{
    $userdepartid = $_SESSION['userdepartmentid'];
}  
if(isset($_SESSION['usertenant']))
{
    $tenantid = $_SESSION['usertenant'];
} 
if(isset($_SESSION['tenantuserdata']))
{
    $userarr = $_SESSION['tenantuserdata'];
}
if(isset($_POST['skipdoc']))
{
   $skipdoc =  $_POST['skipdoc'];
}
       $companytags = array();
            $usertagdata = $g1->get_mongodb->companytagData($tenantid);
            if($usertagdata != 0){
            foreach ($usertagdata as $companytagkey)
            {
                if(array_key_exists('DepartmentId',$companytagkey))
                {
                    if($companytagkey['DepartmentId'] == $userdepartid){
                        if(array_key_exists('TagList',$companytagkey))
                        {
                            foreach ($companytagkey['TagList'] as $cmptagval) {
                                $companytags[] = $cmptagval['Tag'];
                            }
                        }
                    }
                }
                else
                {
                    if(array_key_exists('TagList',$companytagkey))
                        {
                        foreach ($companytagkey['TagList'] as $cmptagval) {
                                $companytags[] = $cmptagval['Tag'];
                            }
                    }
                }
            }
            }
            
//print_r($companytags);
//echo $skipdoc;
$filterdata = $g1->get_mongodb->nextfilterdashboarddata($tenantid,$userdepartid,$skipdoc);
//print_r($filterdata);
//var_dump($filterdata);
//print_r($filterdata['result']);
$dochtml = '';

if(is_array($filterdata) && isset($filterdata['result']) && $filterdata['result'] != null)
{
    foreach ($filterdata['result'] as $dockey) {
                    $templatename = '';
                    $htmltemplate = '';
                    $htmltemppath = '';
                    $documentid        = $dockey['_id'] ;
                    $doclatestrevision = $dockey['LatestRevision'] ;
                    $documentName      = $dockey['DocumentName'];
                    if(array_key_exists('TemplateId',$dockey)){
                       $doctemplate  = $dockey['TemplateId'];
                       $templatename['tempresult'] = $g1->get_mongodb->templatenameData($tenantid,$userdepartid,$doctemplate); 
                       if($templatename['tempresult'] != 0)
                       {
                           foreach ($templatename['tempresult'] as $tempkey) {
                                if(array_key_exists('HtmlFileName',$tempkey))
                                {
                                        $htmltemplate = $tempkey['HtmlFileName'];
                                }
                                if(array_key_exists('HtmlFileLocation',$tempkey))
                                {
                                        $htmltemppath = $tempkey['HtmlFileLocation'];
                                }
                                if(array_key_exists('TemplateHeader',$tempkey))
                                {
                                    $templatename = $tempkey['TemplateHeader'];
                                }
                            }
                       } 
                    }
                    $commentcount = 0;
                        $commentdate = '';
                        $totalcomments = 0;
                        $totaltagcount = 0;
                        $taglist = '';
                        $documenttag = array();
                        if (array_key_exists('TagList', $dockey['DocumentInfo'])) {
                            $taglist = $dockey['DocumentInfo']['TagList'];
                                foreach ($taglist as $value) {
                                    $totaltagcount++;
                                }
                        }
                        
                        if (array_key_exists('RevisionNo', $dockey['DocumentInfo'])) {
                            $revisionNo = $dockey['DocumentInfo']['RevisionNo'];
                        } 
                        else {
                            $revisionNo = '';
                        }
                        
                        if (array_key_exists('FileName', $dockey['DocumentInfo'])) {
                            $filename = $dockey['DocumentInfo']['FileName'];
                            $filenametype = explode(".",$filename);
                            $filetype     = $filenametype[1]; 
                        } 
                        else {
                            $filtetype = '';
                        }
                        
                        if (array_key_exists('UploadDate', $dockey['DocumentInfo'])) {
                            $uploadedDate = $dockey['DocumentInfo']['UploadDate'];
                            $docDate = date('Y-M-d', $uploadedDate->sec);
                        } 
                        else {
                            $docDate = '';
                        }
                        
                        if (array_key_exists('CurrentStatus', $dockey['DocumentInfo'])) {
                            $currstatus = $dockey['DocumentInfo']['CurrentStatus'];
                        } 
                        else {
                            $currstatus = '';
                        }
                        $dochtml .= '<div class="well div-padding-top">';
                        $dochtml .= '<div class="row">';
                        $dochtml .= '<div class="col-md-2 ">';
                        $dochtml .= '<div class="div-padding fileextension"><img src="img/file_icons/'.$filetype.'.png" style=" height: 60px; width: 80px;object-fit:contain; border: 1px #e5e5e5;">';
                        $dochtml .= '</div></div>';
                        $dochtml .= '<div class="col-md-8">';
                             if($documentName != ''){ $dochtml.= '<p class="documentname">Document Name:<a onclick=\'dynamicURL("'.$documentName.'","'.$revisionNo.'","'.$htmltemplate.'","'.$documentid.'")\'>'.$documentName.'</a><span class="docid" style="display:none">'.$documentid.'</span></p>'; }
                             $dochtml .= '<p class="documentrev">Document latest revision:<span>'.$revisionNo.'</span></p>'; 
                             if($templatename != ''){ $dochtml .= '<p class="documenttemp">Document Template:<span class="tempname">'.$templatename.'</span><span class="tempid" style="display:none">'.$doctemplate.'</span><span class="temppath" style="display:none">'.$htmltemppath.'</span></p>'; }
                             if($docDate != '') { $dochtml .= '<p>Date:<span>'.$docDate.'</span></p>'; }
                             if($htmltemplate !='' && $htmltemppath != ''){$dochtml .= '<p><input type="hidden" class="doctemp" value="'.$htmltemplate.'">
                                                                                    <input type="hidden" class="doctemppath" value="'.$htmltemppath.'"></p>';}
                        $dochtml .= '</div>';
                        $dochtml .= '<div class="col-md-2">';
                        $dochtml .= '<p><button type="button" class="revsioncomment comments_tags" onclick="makefocusComment(this);" value="Comments"><span class="glyphicon glyphicon-comment"> </span> Comments</button></p>
                              <p><button type="button" class="revsiontags comments_tags" onclick="makefocusTag(this);" value="Tags"><span class="glyphicon glyphicon-tag"> </span> Tags</button></p>';
                        if($currstatus == 'CheckedIn')
                        {
                        $dochtml .= '<p><button type="button" class="revsionstatus" onclick="redirecttoupload(this)" value="'.$currstatus.'"><span class="glyphicon glyphicon-bookmark"> </span> '.$currstatus.'</button></p>';
                        $dochtml .= '<input type="hidden" class="doccumentid" value="'.$dockey['_id'].'-'.$revisionNo.'">';
                        
                        $dochtml .= '<p><button type="button" class="add_to_bouquet" value="Add to Bouquet" onclick="showDialog(this)"><span class="glyphicon glyphicon-cloud-upload" style="float:left"> </span> Add to Bouquet</button></p>
                              <p><button type="button" class="add_to_archive" value="Add to Archive"><span class="glyphicon glyphicon-briefcase"> </span> Add to Archive</button></p>';
                        }
                        else
                        {
                        $dochtml .= '<p>Latest Revision: <a href="view_document.php?doc='.$documentName.'&revision='.$doclatestrevision.'&tempname='.$htmltemplate.'&documentid='.$documentid.'" rel="facebox">'.$doclatestrevision.'</a></p>';
                        }
                        $dochtml .= '</div>';
                        $dochtml .= '</div>'; 
                        $dochtml .= '<div class="row">
                              <div class="col-md-1 col-md-offset-11" >';
                        $dochtml .=  '<img src="img/add-icon.png" id="img1" class="img1" style="width:20px;height:20px;" onclick="display_hidediv(this)">
                              </div>
                              </div>';
                        $dochtml .= '<div class="hide_div">';
                        if(array_key_exists('Comments', $dockey['DocumentInfo']))
                        { foreach ($dockey['DocumentInfo']['Comments'] as $commentValue) {
                                $totalcomments++;}
                        }        
                        $dochtml .= '<div class="row comment div-margin">
                              <div class="col-md-6">
                              <div class="row-fluid"><a class="docsubsec_title upload_doc_cls">View More Comments('.$totalcomments.')</a></div>';
                        
                        if(array_key_exists('Comments', $dockey['DocumentInfo']))
                        {        
                            $revcommentarr = array_reverse($dockey['DocumentInfo']['Comments']);
                            foreach ($revcommentarr as $commentValue) {
                                if(array_key_exists('CommentText', $commentValue))
                                {
                                    $commentText = $commentValue['CommentText'];
                                }
                                else
                                {
                                    $commentText = '';
                                }
                                if(array_key_exists('CommentDate', $commentValue))
                                {
                                    $commentDate = $commentValue['CommentDate'];
                                    $commentdate = date('Y-M-d h:m:s', $commentDate->sec);
                                }
                                else
                                {
                                    $commentdate = '';
                                }
                                if(array_key_exists('UserId', $commentValue))
                                {
                                    $userobjId = $commentValue['UserId'];
                                    foreach ($userarr as $userarrvalue) {
                                        if ($userarrvalue['_id'] == $userobjId) {
                                            $userId = $userarrvalue['Name'];
                                        }
                                    }
                                }
                                else
                                {
                                    $userId = '';
                                }
                                 if($commentcount < 2){     
                       $dochtml .=   '          
                               <div class="row-fluid more-comment div-padding">
                                   <i style="color:#2a6496">'.$userId.'</i> :'.$commentText.'
                                   <div class="date colour">'.$commentdate.'</div>    
                               </div>';
                               $commentcount++;
                                       }
                                       
                              }
                         }
                         else
                        {
                            $commentText = '';
                            $commentDate = '';
                            $userId = '';
                        }
                        $dochtml .=  '<div class="form-group row-fluid add-comment">
                                <div class="col-md-9 ">
                                <input type="text" class="form-control txt_comment1 document_commentbox document_border"  id="txt_comment1" placeholder="Comment" name="" autofocus/>
                                </div>
                                <div class="col-md-2">
                                <input type="button" id="btn_comment" class="btn ctrl-btn btn_comment" value="Comment" onclick="add_comment(this)">
                                </div>
                             </div> ';
                       $dochtml .=   '</div>
                                <div class="col-md-6">
                                <div class="row-fluid"><a class="docsubsec_title upload_doc_cls">View More Tags('.$totaltagcount.') </a></div>
                                <div class="row-fluid" style="padding:5px 0px;border-top: 1px solid #B8BFBC;">
                                    <div class="tag_selectbox col-md-9">
                                    <select name="colors" class="form-control chosen-select" multiple data-placeholder="select tags">';
                                    //$testtagarr = array();
                                    
                                    if($taglist != ''){
                                    foreach ($taglist as $depttagvalue) {
                                        $documenttag[] = $depttagvalue;
                                    }
                                    }
                                 foreach ($companytags as $comptagvalue) {
                                     $flagtag = 0;
                                     foreach ($documenttag as $doctagvalue) {
                                         if($comptagvalue == $doctagvalue)
                                         { $flagtag = 1;}
                                     }
                                     if($flagtag == 1)
                                     {
                                         $dochtml .= '<option value="'.$comptagvalue.'" selected>'.$comptagvalue.'</option>';
                                     }
                                     else
                                     {
                                         $dochtml .= '<option value="'.$comptagvalue.'">'.$comptagvalue.'</option>';
                                     }
                                 }
                                                       
                       $dochtml .=   ' </select>
                                </div>
                                <div class="col-md-2">
                                <input type="button" id="btn_tag" class="btn ctrl-btn btn_tags" value="Save Tags" onclick="add_tags(this)">
                                </div>';
                       $dochtml .=    '</div>
                                </div>
                                </div>';
                       $dochtml .=    '</div>';
                       $dochtml .=    '</div>';
     }
 }
 
 echo $dochtml;
?>