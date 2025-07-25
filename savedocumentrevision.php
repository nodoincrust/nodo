<?php
require('CodeIgniter-old/external.php');
$ci =& get_instance();
$ci->load->library("cimongo/cimongo");
		$ci->load->model('get_mongodb');
                $g1 = new Get_mongodb();

$currDate = date('Y-m-d H:i:s');
$currDate = new MongoDate(strtotime($currDate));                

$tenantid          = $_POST['tenantid'];
$tenantid          = (int)$tenantid;
$userid            = $_POST['userid'];
$documentfile      = $_POST['documentfile'];
$documentnameinfo  = explode(".",$documentfile) ;
$documentname      = $documentnameinfo[0];
$documentpath      = $_POST['documentpath']; 
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
if(isset($_POST['docexpirydate']))      {$docexpirydate     = $_POST['docexpirydate'];      }

if(isset($docexpirydate))               {$docexpirydate = new MongoDate(strtotime($docexpirydate));}

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
                        $tblsubarr[] = array("Column" =>$tblrowdata[1], "Row" => $tblrowdata[0], "Value" => $tblrowdata[2]);
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
            
            $documentinfoarr = array();
            if($userid != '')
            {
                $documentinfoarr['UserId']     = new MongoID($userid);
            }
                $documentinfoarr['RevisionNo']   =  2;
                $documentinfoarr['FileName'] = $documentfile;
            if($documentpath != '')
            {
                $documentinfoarr['FileLocation'] = $documentpath;
            }
            if($currDate != '')
            {
                $documentinfoarr['UploadDate'] = $currDate;
            }
                $documentinfoarr['CurrentStatus']   =  "CheckedOut";
            if($docexpirydate != '')
            {
                $documentinfoarr['ExpiryDate'] = $docexpirydate;
            }
            if($taglistarray != '' && isset($taglistarray))
            {
                $documentinfoarr['TagList'] = $taglistarray;
            }
            
            if(isset($labarr) && $labarr != null) 
            {
                $documentinfoarr['Label'] = $labarr;
            }
            
            if(isset($txtarr) && $txtarr != null)
            {
                $documentinfoarr['TextBox'] = $txtarr;
            }
            if(isset($textarr) && $textarr != null) 
            {
                $documentinfoarr['TextArea'] = $textarr;
            }
            if(isset($cuslistarr) && $cuslistarr != null)
            {
                $documentinfoarr['CustomList'] = $cuslistarr;
            }
            if(isset($radioarr) && $radioarr != null) 
            {
                $documentinfoarr['RadioButton'] = $radioarr;
            }
            if(isset($checkboxarr) && $checkboxarr != null) 
            {
                $documentinfoarr['MultipleCheckBox'] = $checkboxarr;
            }
            if(isset($tablearr) && $tablearr != null) 
            {
                $documentinfoarr['Table'] = $tablearr;
            }
            if(isset($datearr) && $datearr != null) 
            {
                $documentinfoarr['Date'] = $datearr;
            }
            print_r($documentinfoarr);
            /*$documentmetadata['docresult'] = $g1->get_mongodb->saveDocumentRevision($tenantid,$documentname,$documentinfoarr);

            echo $documentmetadata['docresult'];*/
?>