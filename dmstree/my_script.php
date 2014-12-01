<?php
//ob_start();
//session_start();

require('../CodeIgniter-old/external.php');
$ci =& get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();
				
                                
    /*------- login screen --------*/
    $btnname =$_POST['loginbtn'];
           if($btnname == 'login')
           {
                $username = $_POST['username'];
                $password = $_POST['password'];                
                $logindata['loginresult'] = $g1->get_mongodb->loginProcess($username,$password);   
                //var_dump($logindata);
                $collectionUsername = '';
                $collectionPassword = '';
                $tenantname = '';
                //var_dump($logindata['loginresult']);
               
                if($logindata['loginresult'] == '' || $logindata['loginresult'] == 0)
                {
                    header('Location: login.php');
                }
                else 
                {
                    
                    foreach ($logindata['loginresult'] as $userkey) {
                       
                        //$userId = $userkey['_id'];
                        $tenantId = $userkey['TenantId'];
                        $userid = $userkey['_id'];
                        $loginUser = $userkey['Name'];
                        $userrole = $userkey['UserRole'];
                        $userdepartmentid = '';
                        //$loginUsername = $userkey['Name'];
                        $collectionUsername = $userkey['LoginInfo']['EmailId'];
                        $collectionPassword = $userkey['LoginInfo']['Password'];
                        $tenantid = $userkey['TenantId'];
                        if(array_key_exists('DepartmentId',$userkey))
                        {
                           $userdepartmentid = $userkey['DepartmentId']; 
                        }        
                        $tenantuserdata = $g1->get_mongodb->tenantUserData($tenantid);
                        //var_dump($tenantuserdata);
                        }
                        
                        $tenant['tenantresult'] = $g1->get_mongodb->tenantInfo($tenantid);
                         if($tenant['tenantresult'] != 0)
                         {
                             foreach ($tenant['tenantresult'] as $tenantkey) {
                                 $tenantname = $tenantkey['TenantName'];
                                 //$tenantidname = $tenantkey['TenantName'];
                             }
                         }
                         
                         $currDate = date('Y-m-d H:i:s');
                         $currDate = new MongoDate(strtotime($currDate));
                         $actiontext = 'User login into the system';
                         
                         $historytrtrack['trackresult'] = $g1->get_mongodb->saveTrackAction($tenantid,$userid,$actiontext,$currDate);
    
                        session_start();
                        //$_SESSION['username']=$loginUserfname.' '.$loginUserlname;
                        $_SESSION['userid']             =  $userid;
                        $_SESSION['username']           =  $loginUser;
                        $_SESSION['usertenant']         =  $tenantid;
                        $_SESSION['tenantname']         =  $tenantname;
                        $_SESSION['tenantuserdata']     =  $tenantuserdata;
                        $_SESSION['userdepartmentid']   =  $userdepartmentid;
                        $_SESSION['useremail']          =  $collectionUsername;
                        $_SESSION['timestamp']          =  time();
                        $_SESSION['imagetags']          = '';
                        $_SESSION['documentimageurl']   = '';
                        $_SESSION['userrole']           = $userrole;
                        
                        //$_SESSION['val']['username'] = $loginUsername;
                        //$_SESSION['val']['id'] = $userId;
                        //$_SESSION['val']['tenantId'] = $tenantId;
                        //$_SESSION['username'] = $loginUsername;
                        //$_SESSION['userid'] = $userId;;
                        //$_SESSION['tenantname'] = $tenantidname;
                        //$_SESSION['usertenant'] = $tenantId;
                        //$_SESSION['id'] = $userId;
                        
                        if($tenantid != -999)
                        {
                               header('Location: dashboard.php');     
                        }
                        else if($tenantid == -999)
                        {
                                header('Location: packages.php');
                        }
                        //echo $tenantid;
                }
           }
           elseif ($btnname == 'signup') 
           {
                        $tenantType = strip_tags(trim($_POST['optionsRadios']));
                        if($tenantType == 'individual')
                        {
                            $tenantPackage = strip_tags(trim($_POST['individualoptionsRadiosPackage']));
                        }
                        else
                        {
                            $tenantPackage = strip_tags(trim($_POST['corporateoptionsRadiosPackage']));
                        }
                        $tenantName = strip_tags(trim($_POST['companyname']));
                        $tenantUsername = strip_tags(trim($_POST['adminname']));
                        $adminCountrycode =strip_tags(trim($_POST['country_code']));
                        $adminContactNo = strip_tags(trim($_POST['admincontact']));
                        $adminEmailId = strip_tags(trim($_POST['adminemail']));
                        $useName = strip_tags(trim($_POST['individualname']));
                        $userCountrycode =strip_tags(trim($_POST['user_countrycode']));
                        $userContactNo = strip_tags(trim($_POST['usercontact']));
                        $userEmailId = strip_tags(trim($_POST['useremail']));
                        $rechargeDate = strip_tags(trim($_POST['recharge_date']));
                        $packagePrice = strip_tags(trim($_POST['package_price']));
                        $tax = strip_tags(trim($_POST['tax']));
                        $total_amount = strip_tags(trim($_POST['total_amount']));
                        $months = 0;
                        $today = date("m/d/Y");
                        $date2 = strtotime($rechargeDate);
                        $date1 =strtotime($today);

                        while (($date1 = strtotime('+1 MONTH', $date1)) <= $date2)
                        {
                        $months++;
                        }
                        $durationinmonths = $months;
                                    $currDate = date('Y-m-d H:i:s');
                                    $currDate = new MongoDate(strtotime($currDate));
                                    $expdate = new MongoDate(strtotime($rechargeDate));

                
                        $tenantPost = array("_id" => getNextSequence("signupid"),"TenantName"=>$tenantName,"TenantType"=>$tenantType,
                                          "PaymentInfo" =>  array(
                                              "DurationOrSize" => 'Duration',
                                              "PackageDurationInMonths" => $durationinmonths,
                                              "PackagePrice" => $packagePrice,
                                              "TaxesPaidPercentage" => '10',
                                              "TaxAmount" => $tax,
                                              "TotalPaid" => $total_amount,
                                              "DateOfSubscription" => $currDate,
                                              "ExpiryDate" => $expdate,
                                              "IsActivePackage"=>'true'
                                          ),
                                          "AuditData" => array(
                                              "DateAdded" => $currDate,
                                              "AddedBy" => $adminEmailId,
                                              "DateModified" => $currDate,
                                              "ModifiedBy" => $adminEmailId,
                                              "DeleteFlag" => 'false'
                                          )
                                        );
                        if($tenantType == 'individual')
                        {  
                            $signupData['signupresult'] = $g1->get_mongodb->signupProcess($tenantPost);
                        }
                        else
                        {

                        }
                
            }        
          
                   
?>