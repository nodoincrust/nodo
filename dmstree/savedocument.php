<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
require('../CodeIgniter-old/external.php');
$ci =& get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();

$currDate = date('Y-m-d H:i:s');
$currDate = new MongoDate(strtotime($currDate));

$physicalloctags = '';
$physicallocpath = '';
//$tempphysical = $g1->get_mongodb->();


if(isset($_SESSION['documentimageurl'])) {
    $imagepath = $_SESSION['documentimageurl'];
    if ($imagepath != '') {
        $physicallocpath = $imagepath;
        if (isset($_SESSION['imagetags'])) {
            $imagtags = $_SESSION['imagetags'];
            if ($imagtags != '') {
                $physicalloctags = $imagtags;
            }
        }
    }
}

$usermailid = '';
if(isset($_SESSION['useremail']))
{
    $usermailid = $_SESSION['useremail'];
}    
if(isset($_SESSION['usertenant']))
{
  $tenantid = $_SESSION['usertenant'];
}
//$tenantid          = $_POST['tenantid'];
$tenantid          = (int)$tenantid;
if(isset($_SESSION['userdepartmentid'])) {
    $departmenid = (int)$_SESSION['userdepartmentid'];
} else {
    $departmenid = '';
}
if(isset($_POST['tempid']))             {$tempid            = $_POST['tempid'];             } else{ $tempid  ='';          }
if(isset($_POST['labelarray']))         {$labelarray        = $_POST['labelarray'];         }
if(isset($_POST['textnamearray']))      {$textnamearray     = $_POST['textnamearray'];      }
if(isset($_POST['textvalarray']))       {$textvalarray      = $_POST['textvalarray'];       }
if(isset($_POST['textareanamearray']))  {$textareanamearray = $_POST['textareanamearray'];  }
if(isset($_POST['textareavalarray']))   {$textareavalarray  = $_POST['textareavalarray'];   }
if(isset($_POST['selectnamearray']))    {$selectnamearray   = $_POST['selectnamearray'];    }
if(isset($_POST['selectvalarray']))     {$selectvalarray    = $_POST['selectvalarray'];     }
if(isset($_POST['radionamearray']))     {$radionamearray    = $_POST['radionamearray'];     }
if(isset($_POST['radiovalarray']))      {$radiovalarray     = $_POST['radiovalarray'];      }
if(isset($_POST['checkboxnamearray']))  {$checkboxnamearray = $_POST['checkboxnamearray'];  }
if(isset($_POST['checkboxvalarray']))   {$checkboxvalarray  = $_POST['checkboxvalarray'];   }
if(isset($_POST['tablenmarray']))       {$tablenmarray      = $_POST['tablenmarray'];       }
if(isset($_POST['tablearray']))         {$tablearray        = $_POST['tablearray'];         }
if(isset($_POST['datenamearray']))      {$datenamearray     = $_POST['datenamearray'];      }
if(isset($_POST['datevalarray']))       {$datevalarray      = $_POST['datevalarray'];       }
if(isset($_POST['taglistarray']))       {$taglistarray      = $_POST['taglistarray'];       } else{ $taglistarray = '';}
if(isset($_POST['docexpirydate']))      {$docexpirydate     = $_POST['docexpirydate'];      } else{ $docexpirydate = '';}
if(isset($_POST['filearray']))          {$filearray         = $_POST['filearray'];          } else{ $filearray = '';}
if(isset($_POST['type']))               {$type              = $_POST['type'];               } else{$type ='';}
if(isset($_POST['revision']))           {$revision          = $_POST['revision'];           } else{$revision ='';}
if(isset($_POST['documentid']))         {$documentid        = $_POST['documentid'];         } else{$documentid ='';}
if(isset($_POST['filepath']))           {$filepath          = $_POST['filepath'];           } else{$filepath = '';} 
if(isset($_POST['tempname']))           {$templatename      = $_POST['tempname'];           } else{$templatename = '';} 
if(isset($_POST['physicallocurl']))     {$phylocurl         = $_POST['physicallocurl'];     } else{$phylocurl = '';}
if(isset($_POST['phyloctags']))         {$phyloctags        = $_POST['phyloctags'];         } else{$phyloctags = '';}
if(isset($_POST['isPrivate']))          {$isPrivate         = $_POST['isPrivate'];             }
$userid            = $_SESSION['userid']; 

/*if($docexpirydate != '')               {
                                            $expdate = date('Y-m-d', strtotime($docexpirydate));
                                            $docexpirydate = new MongoDate(strtotime(date($expdate)));
                                        }*/
if($docexpirydate != '')               {  
                                            $docexpirydate = explode('/',$docexpirydate);
                                            $date =$docexpirydate[2].'-'.$docexpirydate[1].'-'.$docexpirydate[0];
                                            $docexpirydate = new MongoDate(strtotime($date));
                                            
                                       }                                        

            $labarr = array();
            if(isset($labelarray) && $labelarray != null){
            for ($labindex = 0; $labindex < count($labelarray); $labindex++) {
                 $labarr[] = array("Name" => $labelarray[$labindex]);
            }} 
            
            $txtarr = array();
            if(isset($textnamearray) && isset($textvalarray) && $textnamearray != null && $textvalarray != null){
            for ($txtindex = 0, $txtvalindex = 0; $txtindex < count($textnamearray),$txtvalindex < count($textvalarray); $txtindex++,$txtvalindex++) {
                $txtarr[] = array("Name" => $textnamearray[$txtindex], "Value" => $textvalarray[$txtvalindex]);
            }}
            
            $textarr = array();
            if(isset($textareanamearray) && isset($textareavalarray) && $textareanamearray != null && $textareavalarray != null){
            for ($textnmindex = 0, $textvalindex = 0; $textnmindex < count($textareanamearray), $textvalindex < count($textareavalarray); $textnmindex++, $textvalindex++) {
                $textarr[] =  array("Name" => $textareanamearray[$textnmindex], "Value" => $textareavalarray[$textvalindex]);
            }}
            
            $cuslistarr = array();
            if(isset($selectnamearray) && isset($selectvalarray) && $selectnamearray != null && $selectvalarray != null){
            for ($selnmindex = 0, $selvalindex = 0; $selnmindex < count($selectnamearray), $selvalindex < count ($selectvalarray); $selnmindex++, $selvalindex++) {
                $cuslistarr[] = array("Name" => $selectnamearray[$selnmindex], "SelectedValue" => $selectvalarray[$selvalindex]);
            }}
                                    
            $radioarr = array();
            if(isset($radionamearray) && isset($radiovalarray) && $radionamearray != null && $radiovalarray != null){
            for ($radionmindex = 0, $radiovalindex = 0; $radionmindex < count($radionamearray), $radiovalindex < count($radiovalarray); $radionmindex++, $radiovalindex++) {
                $radioarr[] = array("Name" => $radionamearray[$radionmindex],"SelectedOption" => $radiovalarray[$radiovalindex]);
            }}
            
            $checkboxarr = array();
            if(isset($checkboxnamearray) && isset($checkboxvalarray) && $checkboxnamearray != null && $checkboxvalarray != null){
            for ($checkboxnmindex = 0, $checkboxvalindex = 0; $checkboxnmindex < count($checkboxnamearray), $checkboxvalindex < count($checkboxvalarray); $checkboxnmindex++, $checkboxvalindex++) {
                    $checkboxarr[] = array("Name" => $checkboxnamearray[$checkboxnmindex], "SelectedOption" => $checkboxvalarray[$checkboxvalindex] );
            }}
            
            $tablearr = array();
            $tbllist = '';
            if( isset($tablenmarray) && $tablenmarray != null){
            for ($totindex = 0; $totindex < count($tablenmarray); $totindex++) {
               $tblsubarr = array();
                for ($tableindex = 0; $tableindex < count($tablearray); $tableindex++) {
                    $tblrow = $tablearray[$tableindex];
                    $tblrowdata = explode('||',$tblrow);
                    $tbllist = $tablenmarray[$totindex];
                    $tblnm = $tblrowdata[3];
                    if($tbllist == $tblnm)
                    {
                        $tblsubarr[] = array("Column" =>(int)$tblrowdata[1], "Row" => (int)$tblrowdata[0], "Value" => $tblrowdata[2]);
                    }
                }
                $tablearr[] = array("TableId" => $tbllist, "Values" => $tblsubarr);
            }}
            
            
            $datearr = array();
            $nisodate = '';
            if(isset($datenamearray) && isset($datevalarray) && $datenamearray != null && $datevalarray != null){
            for ($datenmindex = 0, $datevalindex = 0; $datenmindex < count($datenamearray),$datevalindex < count($datevalarray); $datenmindex++,$datevalindex++) {
                $nisodate = new MongoDate(strtotime($datevalarray[$datevalindex]));
                $datearr[] = array("Name" => $datenamearray[$datenmindex], "Value" => $nisodate);
            }}
            
            
            $physicallocarr = array();
            $locationtagarr = array();
            if($physicallocpath != '' && $physicalloctags != null)
            {
                $physicallocarr['LocationPath'] = $physicallocpath;
                for ($imagetagindex = 0; $imagetagindex < count($physicalloctags); $imagetagindex++) {
                    $tagindexval = explode("::",$physicalloctags[$imagetagindex]);
                    $tagname = $tagindexval[1];
                    $tagposition = explode(";",$tagindexval[0]);
                    $poslist = '';
                    $count = 0;
                    if(count($tagposition) == 5)
                    {
                        for ($tagindex = 0; $tagindex < (count($tagposition) - 1); $tagindex++) {
                        $tagvalues = explode(":",$tagposition[$tagindex]);
                        if($count == 0)
                        {
                            $poslist .= $tagvalues[1];
                        }
                        else
                        {
                            $poslist .= ','.$tagvalues[1];
                        }
                        $count++;
                        }
                    }
                    else
                    {
                        for ($tagindex = 0; $tagindex < (count($tagposition) - 2); $tagindex++) {
                        $tagvalues = explode(":",$tagposition[$tagindex]);
                        if($count == 0)
                        {
                            $poslist .= $tagvalues[1];
                        }
                        else
                        {
                            $poslist .= ','.$tagvalues[1];
                        }
                        $count++;
                        }
                    }
                    
                    $locationtagarr[] = array("TagName" =>$tagname,"TagPosition" => $poslist);
                }
                $physicallocarr['LocationTags'] = $locationtagarr;
                $physicallocarr['AuditData'] = array("DateAdded" => $currDate, "AddedBy" => $usermailid );
                
            }  
            else if( $physicallocpath == '' && $physicalloctags == null && $phylocurl != '' && $phyloctags !='')
            {
                $physicallocarr['LocationPath'] = $phylocurl;
                $taginfo = explode('||',$phyloctags);
                $plocationtagarr = array();
                foreach ($taginfo as $taginfovalue) {
                   $loctaglist = explode('::',$taginfovalue);
                   $plocationtagarr[] = array("TagName" => $loctaglist[0],"TagPosition" =>$loctaglist[1]);
                }
                $physicallocarr['LocationTags'] = $plocationtagarr;
                $physicallocarr['AuditData'] = array("DateAdded" => $currDate, "AddedBy" => $usermailid );
            }
            
            
            
            $documentinfoarr = array();
            if($userid != '')
            {
                $documentinfoarr['UserId']     = new MongoID($userid);
            }
            if($documentid != '')
            {
                  $revision = (int)$revision + 1;
                  $documentinfoarr['RevisionNo']   =  $revision; 
            }
            else
            {
                  $documentinfoarr['RevisionNo']   =  0; 
            }
            $documentinfoarr['IsLatestRevision']   =  true;
            $documentinfoarr['RevisionBlock'] = false;
            $documentinfoarr['IsArchived'] = false;
            if($filepath != '')
            {
                $documentinfoarr['FileLocation'] = $filepath;
            }
            if($currDate != '')
            {
                $documentinfoarr['UploadDate'] = $currDate;
            }
                $documentinfoarr['CurrentStatus']   =  "CheckedIn";
            if($docexpirydate != '')
            {
                
                $documentinfoarr['ExpiryDate'] = $docexpirydate;
            }
            if($taglistarray != '' && isset($taglistarray))
            {
                $documentinfoarr['TagList'] = $taglistarray;
            }
            
            if(isset($labarr) && $labarr != null) //!(array_key_exists("Name", $labarr) && is_null($labarr["Name"]))
            {
                $documentinfoarr['Label'] = $labarr;
            }
            
            if(isset($txtarr) && $txtarr != null)//!(array_key_exists("Name", $txtarr) && is_null($txtarr["Name"]))
            {
                $documentinfoarr['TextBox'] = $txtarr;
            }
            if(isset($textarr) && $textarr != null) //!(array_key_exists("Name", $textarr) && is_null($textarr["Name"]))
            {
                $documentinfoarr['TextArea'] = $textarr;
            }
            if(isset($cuslistarr) && $cuslistarr != null)//!(array_key_exists("Name", $cuslistarr) && is_null($cuslistarr["Name"]))
            {
                $documentinfoarr['CustomList'] = $cuslistarr;
            }
            if(isset($radioarr) && $radioarr != null) //!(array_key_exists("Name", $radioarr) && is_null($radioarr["Name"]))
            {
                $documentinfoarr['RadioButton'] = $radioarr;
            }
            if(isset($checkboxarr) && $checkboxarr != null) //!(array_key_exists("Name", $checkboxarr) && is_null($checkboxarr["Name"]))
            {
                $documentinfoarr['MultipleCheckBox'] = $checkboxarr;
            }
            if(isset($tablearr) && $tablearr != null) //!(array_key_exists("TableId", $tablearr) && is_null($tablearr["TableId"]))
            {
                $documentinfoarr['Table'] = $tablearr;
            }
            if(isset($datearr) && $datearr != null) //!(array_key_exists("Name", $datearr) && is_null($datearr["Name"]))
            {
                $documentinfoarr['Date'] = $datearr;
            }
            if(isset($physicallocarr) && $physicallocarr != null)
            {
                $documentinfoarr['PhysicalLocation'] = $physicallocarr;
            }
            
            
             //print_r($_SESSION['documentimageurl']);
            $documentmetadata['docresult'] = $g1->get_mongodb->saveDocumentMetada($tenantid,$departmenid,$filearray,$documentinfoarr,$tempid,$type,$revision,$documentid,$templatename,$currDate,$usermailid,$isPrivate);
            echo $documentmetadata['docresult'];
            //print_r($documentmetadata['docresult']);
            //print_r($type);
//            print_r($physicallocarr);
            
?>