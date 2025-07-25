<?php 
        ob_start();
	session_start();
	include 'session_config.php';
	require('CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
	$g1 = new Get_mongodb();
	$userId =  $_SESSION['userid'];// $_SESSION['val']['id'];
	$result=$g1->get_mongodb->getUserInfo($userId);
	$userEmailId =$result[0]['LoginInfo']['EmailId'];
        $type = $_POST['type'];
        //echo $userEmailId;
       
        require_once("class.phpmailer.php");
        
        $type = $_POST['type'];
        if($type == 'admin')
        {
            $subject="Querys";
            if(isset($_POST['status'])){$status = $_POST['status'];}
            if(isset( $_POST['id'])){$id = $_POST['id'];}
            if(isset($_POST['comments'])){ $comments = $_POST['comments'];}

            $defectInfo = $g1->get_mongodb->getReportDetail($id);

            if($status == 'Notification')
            {

                $message = '<table width="80%" border="0" cellpadding="3" cellspacing="2">
                        <tr>
                             <td width="4%" class="txt">&nbsp;</td>
                             <td colspan="2" class="txt"> Hello,</br><td>
                        </tr>
                        <tr>
                              <td width="4%" class="txt">&nbsp;</td>
                              <td colspan="2"class="txt">
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; We have recieved the Problem Reports details which are as below: <br/><br/>
                              </td>
                       </tr>
                       <tr>
                             <td width="4%" class="txt">&nbsp;</td>
                             <td width="18%" align="left" class="txt"><strong>Problem Category: </strong></td>
                             <td class="txt">' . $defectInfo[0]['IssueCategory']. '</td>
                       </tr>
                       <tr>
                             <td width="4%" class="txt">&nbsp;</td>
                             <td width="18%" align="left" class="txt"><strong>Problem Title: </strong></td>
                             <td class="txt">' . $defectInfo[0]['IssueTitle'] . '</td>
                       </tr>
                     <tr>
                         <td width="4%" class="txt">&nbsp;</td>
                         <td width="18%" align="left" class="txt"><strong>Problem Discription: </strong></td>
                         <td class="txt">' . $defectInfo[0]['IssueDescription']. '</td>
                     </tr>
                     <tr>
                         <td width="4%" class="txt">&nbsp;</td>
                         <td width="18%" align="left" class="txt"><strong>Problem Comments: </strong></td>
                         <td class="txt">' . $defectInfo[0]['DefectLogHistory'][0]['RaisedBy']['Comment']. '</td>
                     </tr>
                     <tr><td width="4%" class="txt">&nbsp;</td>
                     <tr><td width="4%" class="txt">&nbsp;</td>

                     <td colspan="2" class="txt">Thanks & Regards,<br></td>
                     </tr>

                     <tr><td width="4%" class="txt">&nbsp;</td>
                         <td width="18%" class="txt">DMSTree<br></td>
                     </tr>
                </table>';

            $body = '<html><body><style type="text/css">.txt {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px; color:#000000;}</style>'.$message.'</body></html>';
            }
            else if($status != 'Notification')
            {
                $message = '<table width="80%" border="0" cellpadding="3" cellspacing="2">
                        <tr>
                             <td width="4%" class="txt">&nbsp;</td>
                             <td colspan="2" class="txt"> Hello,</br><td>
                        </tr>
                        <tr>
                              <td width="4%" class="txt">&nbsp;</td>
                              <td colspan="2"class="txt">
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; We have provide the solution to the given problem <br/><br/>
                              </td>
                       </tr>
                       <tr>
                             <td width="4%" class="txt">&nbsp;</td>
                             <td width="18%" align="left" class="txt"><strong>Problem Category: </strong></td>
                             <td class="txt">' . $defectInfo[0]['IssueCategory']. '</td>
                       </tr>
                       <tr>
                             <td width="4%" class="txt">&nbsp;</td>
                             <td width="18%" align="left" class="txt"><strong>Problem Title: </strong></td>
                             <td class="txt">' . $defectInfo[0]['IssueTitle'] . '</td>
                       </tr>
                     <tr>
                         <td width="4%" class="txt">&nbsp;</td>
                         <td width="18%" align="left" class="txt"><strong>Problem Discription: </strong></td>
                         <td class="txt">' . $defectInfo[0]['IssueDescription']. '</td>
                     </tr>
                     <tr>
                         <td width="4%" class="txt">&nbsp;</td>
                         <td width="18%" align="left" class="txt"><strong>Problem Comments: </strong></td>
                         <td class="txt">' . $defectInfo[0]['DefectLogHistory'][0]['RaisedBy']['Comment']. '</td>
                     </tr>
                     <tr>
                         <td width="4%" class="txt">&nbsp;</td>
                         <td width="18%" align="left" class="txt"><strong>Problem Solution: </strong></td>
                         <td class="txt">' .$comments. '</td>
                     </tr>
                     <tr><td width="4%" class="txt">&nbsp;</td>
                     <tr><td width="4%" class="txt">&nbsp;</td>

                     <td colspan="2" class="txt">Thanks & Regards,<br></td>
                     </tr>

                     <tr><td width="4%" class="txt">&nbsp;</td>
                         <td width="18%" class="txt">DMSTree<br></td>
                     </tr>
                </table>';

            $body = '<html><body><style type="text/css">.txt {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px; color:#000000;}</style>'.$message.'</body></html>';
            }
            $to = 'mksweetdream2011@gmail.com';
            $cc = 'mahendra@incrustsoftware.com'; 
        }
        else if($type == 'user'){
             if(isset($_POST['mailid'])){$from = $_POST['mailid'];}
                if(isset($_POST['category'])){$category = $_POST['category'];}
                if(isset($_POST['title'])){$title = $_POST['title'];}
                if(isset($_POST['discription'])){$discription = $_POST['discription'];}
                if(isset($_POST['comments'])){$comments = $_POST['comments'];}

               $message = '<table width="80%" border="0" cellpadding="3" cellspacing="2">
                       <tr>
                            <td width="4%" class="txt">&nbsp;</td>
                            <td colspan="2" class="txt"> Hello,</br><td>
                       </tr>
                       <tr>
                             <td width="4%" class="txt">&nbsp;</td>
                             <td colspan="2"class="txt">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; The Problem Reports details are as below: <br/><br/>
                             </td>
                      </tr>
                      <tr>
                            <td width="4%" class="txt">&nbsp;</td>
                            <td width="18%" align="left" class="txt"><strong>Problem Category: </strong></td>
                            <td class="txt">' . $category . '</td>
                      </tr>
                      <tr>
                            <td width="4%" class="txt">&nbsp;</td>
                            <td width="18%" align="left" class="txt"><strong>Problem Title: </strong></td>
                            <td class="txt">' . $title . '</td>
                      </tr>
                    <tr>
                        <td width="4%" class="txt">&nbsp;</td>
                        <td width="18%" align="left" class="txt"><strong>Problem Discription: </strong></td>
                        <td class="txt">' . $discription . '</td>
                    </tr>
                    <tr>
                        <td width="4%" class="txt">&nbsp;</td>
                        <td width="18%" align="left" class="txt"><strong>Problem Comments: </strong></td>
                        <td class="txt">' . $comments . '</td>
                    </tr>
                    <tr><td width="4%" class="txt">&nbsp;</td>
                    <tr><td width="4%" class="txt">&nbsp;</td>

                    <td colspan="2" class="txt">Thanks & Regards,<br></td>
                    </tr>

                    <tr><td width="4%" class="txt">&nbsp;</td>
                        <td width="18%" class="txt">DMSTree<br></td>
                    </tr>
            </table>';
               $to = 'mahendra@incrustsoftware.com';
               $cc = 'mksweetdream2011@gmail.com'; 
               $body = '<html><body><style type="text/css">.txt {font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 12px; color:#000000;}</style>'.$message.'</body></html>';
               $subject="Querys";
                
        }
      
        $from = 'mksweetdream2011@gmail.com';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $headers .= "X-Priority: 3\r\n";
        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
        
        smtpmailer($to,"-f",$from,$cc,$subject,$body);
        echo $message."<br>";
?>

