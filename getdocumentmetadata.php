<?php
require('../CodeIgniter-old/external.php');
    $ci = & get_instance();
    $ci->load->library("cimongo/cimongo");
    $ci->load->model('get_mongodb');
    $g1 = new Get_mongodb();
$documentid='';    
$doctempname = $_POST['docname'];
$docrevision = $_POST['docrevison'];
$tenantid = $_POST['tenantid'];
$departmentid =$_POST['departmentid'];
if(isset($_POST['documentid']))
{
    $documentid = $_POST['documentid'];
}
//$doctempname = 'Employee_Template.html';
//$docname = $doctempname;
$response       = array();

if ($doctempname != '') {
    //echo $tenantid.'--'.$departmentid.'--'.$doctempname;
    $tenantid = intval($tenantid);
    $departmentid = intval($departmentid);
    $commarr = array();
    $documentdata['documentresult'] = $g1->get_mongodb->getDocumentMetadata($documentid,$doctempname,$tenantid,$departmentid);
    if ($documentdata['documentresult'] != '' || $documentdata['documentresult'] != 0) {
       
        foreach ($documentdata['documentresult'] as $doc) {
          if(array_key_exists('DocumentInfo',$doc))
          {
             foreach ($doc['DocumentInfo'] as $docinfo) {
                  if($docinfo['RevisionNo'] == $docrevision){
                        if(array_key_exists('FileName', $docinfo)) 
                        {
                        $response['FileName'] = $docinfo['FileName'];
                        }
                        if(array_key_exists('FileLocation', $docinfo)) 
                        {
                        $response['FileLocation'] = $docinfo['FileLocation'];
                        }
                        if(array_key_exists('CurrentStatus', $docinfo)) 
                        {
                        $response['CurrentStatus'] = $docinfo['CurrentStatus'];
                        }
                        if(array_key_exists('ExpiryDate', $docinfo)) 
                        {
                            $expirydate = $docinfo['ExpiryDate'];
                           /* $exdate = date('d-m-Y',strtotime($expirydate->sec));
                            $response['ExpiryDate'] = $exdate;*/
                            $response['ExpiryDate'] = $expirydate;
                        }
                        if(array_key_exists('TagList', $docinfo)) 
                        {
                        $response['TagList'] = $docinfo['TagList'];
                        }
                        else{
                             $response['TagList']='';
                        }
                        if (array_key_exists('TextBox', $docinfo)) 
                        {
                        $response['textboxctrl'] = $docinfo['TextBox'];
                        } 
                        if(array_key_exists('TextArea',$docinfo))
                        {
                            $response['textareactrl'] = $docinfo['TextArea'];
                        }
                        if(array_key_exists('CustomList',$docinfo))
                        {
                            $response['custlistctrl'] = $docinfo['CustomList'];
                        }
                        if(array_key_exists('RadioButton',$docinfo))
                        {
                            $response['radioctrl'] = $docinfo['RadioButton'];
                        }
                        if(array_key_exists('MultipleCheckBox',$docinfo))
                        {
                            $response['checkboxctrl'] = $docinfo['MultipleCheckBox'];
                        }
                        if(array_key_exists('Table',$docinfo))
                        {
                            $response['tablectrl'] = $docinfo['Table'];
                        }
                        if(array_key_exists('Comments',$docinfo))
                        {
                            $comments = array();
                                //sort($docinfo['Comments'],1);
                               foreach ($docinfo['Comments'] as $key)  
                               {
                                   $userInfo = $g1->get_mongodb->getUserInfo($key['UserId']);
                                   $name = $userInfo[0]['Name'];
                                   $uploadedDate = $key['CommentDate'];
                                   $docDate = date('d-M-Y H:i', $uploadedDate->sec);
                                   $comments[] = array("CommentText"=>$key['CommentText'],"CommentDate"=>$docDate,"Name"=>$name);
                               }
                              $commentsArray = array_reverse($comments);
                              $response['Comments'] = $commentsArray;
                        }
                        if(array_key_exists('PhysicalLocation',$docinfo))
                        {
                            $response['PhysicalLocation'] = $docinfo['PhysicalLocation'];
                        }
                        if(array_key_exists('Date',$docinfo))
                        {
                            $response['Date'] = $docinfo['Date'];
                        }

              }  }
            //$response[] = $doc['DocumentInfo']['PhysicalLocation']
          }
            
            
        }
        
        echo json_encode($response);
    }
    else {
        echo "fail";
    }
 }
 else 
 {
     echo "fail";
 }
?>