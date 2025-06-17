<?php

	require('../CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
			$ci->load->model('get_mongodb');
					$g1 = new Get_mongodb();
	if(isset($_POST['package_type']))
	{
		// var_dump($_POST['package_type']);
		$packname = array();
		$packis   = array();
		$packageType = strip_tags(trim($_POST['package_type']));
		$packagename['result'] = $g1->get_mongodb->getPackageName($packageType);
		foreach ($packagename['result'] as $key) {
			 $packname[] = $key['PackageName'];
			 $packis[] = $key['DurationOrSize'];
		}

		$response['name'] = $packname;
		$response['is'] = $packis;
		echo json_encode($response);
	}
	else 
	{
           
		$type               = strip_tags(trim($_POST['optionsRadios']));
		$package_size[]     = $_POST['listbox_size'];
		$package_month[]    = $_POST['listbox_month'];
		$company_name       = strip_tags(trim($_POST['companyname']));
		$admin_name         = strip_tags(trim($_POST['adminname']));
		$admin_contact      = strip_tags(trim($_POST['admincontact']));
		$admin_contact_code = strip_tags(trim($_POST['admincontactcode']));
		$admin_email        = strip_tags(trim($_POST['adminemail']));
		$add1               = strip_tags(trim($_POST['address1']));
		$add2               = strip_tags(trim($_POST['address2']));
		$city               = strip_tags(trim($_POST['city']));
		$pincode            = strip_tags(trim($_POST['pincode']));
		$state              = strip_tags(trim($_POST['state']));
		$country            = strip_tags(trim($_POST['country']));
		$sec_question       = strip_tags(trim($_POST['security_question']));
		$sec_answer         = strip_tags(trim($_POST['security_answer']));
		
		$package_info_size   = array();
		$package_info_month  = array();
		$package_info_for_size =array();
		$package_info_for_month=array();
		$package;


		foreach ($package_size[0] as $key) {
			$currDate = date('Y-m-d H:i:s');
			$currDate = new MongoDate(strtotime($currDate));
			$sizeorduration='size';
			$package_info_size = $g1->get_mongodb->getPackageInfo($key,$type,$sizeorduration);
			$taxamt=round($package_info_size[0]['PackageBaseRate']*($package_info_size[0]['PackageTaxPercentage']/100),2);
			$total=round($taxamt+$package_info_size[0]['PackageBaseRate'],2);

			$package_info_for_size[]=array('PackageSelected'=>$package_info_size[0]['_id'],
                                                        'DurationOrSize'=>$package_info_size[0]['DurationOrSize'],
                                                        'PackageSizeInGB'=>$package_info_size[0]['PackageSizeInGB'],
                                                        'PackagePrice'=>$package_info_size[0]['PackageBaseRate'],
                                                        'TaxesPaidPercentage'=>$package_info_size[0]['PackageTaxPercentage'],
                                                        'TaxAmount'=>$taxamt,
                                                        'TotalPaid'=>$total,
                                                        'DateOfSubscription'=>$currDate,
                                                        'ExpiryDate'=>$currDate,
                                                        'IsActivePackage'=>'true',
                                                        'AuditData'=>array('DateAdded'=>$currDate,'AddedBy'=>$admin_name)
                                                        );
			}

		foreach ($package_month[0] as $key1) {
			//echo $key1;
			$sizeorduration='duration';
			$package_info_month = $g1->get_mongodb->getPackageInfo($key1,$type,$sizeorduration);
			$taxamt=round($package_info_month[0]['PackageBaseRate']*($package_info_month[0]['PackageTaxPercentage']/100),2);
			$total=round($taxamt+$package_info_month[0]['PackageBaseRate'],2);
			$package_info_for_size[]=array('PackageSelected'=>$package_info_month[0]['_id'],
                                                        'DurationOrSize'=>$package_info_month[0]['DurationOrSize'],
                                                        'PackageDurationInMonths'=>$package_info_month[0]['PackageDurationInMonths'],
                                                        'PackagePrice'=>$package_info_month[0]['PackageBaseRate'],
                                                        'TaxesPaidPercentage'=>$package_info_month[0]['PackageTaxPercentage'],
                                                        'TaxAmount'=>$taxamt,
                                                        'TotalPaid'=>$total,
                                                        'DateOfSubscription'=>$currDate,
                                                        'ExpiryDate'=>$currDate,
                                                        'IsActivePackage'=>'true',
                                                        'AuditData'=>array('DateAdded'=>$currDate,'AddedBy'=>$admin_name)
                                                        );
			

		}

		$pack= $g1->get_mongodb->getMaxId();
		$id = $pack[0]['_id'];
		$id = $id+1;
		if($type=='Corporate')
		{
			//echo 'Type = '.$type.'Company Name =  '.$company_name.'Admin Name = '.$admin_name.'Admin Contact '.$admin_contact_code.$admin_contact.'Admin Email '.$admin_email.'Address1 '.$add1.'Address2 '.$add2.'City = '.$city.'Pincode '.$pincode.'state '.$state.'sec_question '.$sec_question.'sec_answer '.$sec_answer;
		}
		if($type=='Individual')
		{
			
			$user_name=$_POST['individualname'];
			$user_contact=$_POST['usercontact'];
			$user_contact_code=$_POST['usercontactcode'];
			$user_email=$_POST['useremail'];
		}
		
		$document=array('_id'=>$id,'TenantName'=>$company_name,'TenantType'=>$type,
                                                                        'AddressInfo'=>array('Add1'=>$add1,'Add2'=>$add2,'City'=>$city,'PinCode'=>$pincode,'State'=>$state,'Country'=>$country,'AuditData'=>array('DateAdded'=>$currDate,'AddedBy'=>$admin_name)),
                                                                        'PackageInfo'=>$package_info_for_size,
                                                                        'AuditData'=>array('DateAdded'=>$currDate,'AddedBy'=>$admin_name)
						
		);
		if($type=='Corporate')
		{
			$doc=array('TenantId'=>$id,'UserRole'=>'Admin','IsSignUp'=>'True','Name'=>$admin_name,'LoginInfo'=>array(
                                                                                                                                'EmailId'=>$admin_email,
                                                                                                                                'Password'=>$admin_email,
                                                                                                                                'TemporaryPassword'=>'True',
                                                                                                                                'SecurityQuestion'=>$sec_question,
                                                                                                                                'SecurityQuestionAnswer'=>$sec_answer
                                                                                                                                ),
						'Contact'=>$admin_contact_code.$admin_contact,'AuditData'=>array(
                                                                                                                    'DateAdded'=>$currDate,
                                                                                                                    'AddedBy'=>$admin_name
						));
			$result=$g1->get_mongodb->setUserInfo($doc);
			//echo $result;
			
		}
		if($type=='Individual')
		{
			$doc=array('TenantId'=>$id,'UserRole'=>'Admin','IsSignUp'=>'True','Name'=>$admin_name,'LoginInfo'=>array(
                                                                                                                                    'EmailId'=>$admin_email,
                                                                                                                                    'Password'=>$admin_email,
                                                                                                                                    'TemporaryPassword'=>'True',
                                                                                                                                    'SecurityQuestion'=>$sec_question,
                                                                                                                                    'SecurityQuestionAnswer'=>$sec_answer
                                                                                                                                    ),
						'Contact'=>$admin_contact_code.$admin_contact,'AuditData'=>array(
                                                                                                                    'DateAdded'=>$currDate,
                                                                                                                    'AddedBy'=>$admin_name
						));
			$result=$g1->get_mongodb->setUserInfo($doc);
			$doc=array('TenantId'=>$id,'UserRole'=>'User','IsSignUp'=>'True','Name'=>$user_name,'LoginInfo'=>array(
                                                                                                                                'EmailId'=>$user_email,
                                                                                                                                'Password'=>$user_email,
                                                                                                                                'TemporaryPassword'=>'True',
                                                                                                                                'SecurityQuestion'=>$sec_question,
                                                                                                                                'SecurityQuestionAnswer'=>$sec_answer
                                                                                                                                ),
						'Contact'=>$user_contact_code.$user_contact,'AuditData'=>array(
                                                                                                                'DateAdded'=>$currDate,
                                                                                                                'AddedBy'=>$admin_name
						));
			$result=$g1->get_mongodb->setUserInfo($doc);
		}
		$pack= $g1->get_mongodb->setTenantInfo($document);
		if($result == 1)
			{
				$company_name = str_replace(" ","_",$company_name);
				mkdir("DMSTree_Clients/".$company_name."_".$id, 0700);
				$templatePath = "DMSTree_Clients/".$company_name."_".$id."/Templates";
				$documentPath =  "DMSTree_Clients/".$company_name."_".$id."/Documents";
				$imagePath =  "DMSTree_Clients/".$company_name."_".$id."/Images";
				mkdir($templatePath, 0700);
				mkdir($documentPath, 0700);
				mkdir($imagePath, 0700);
			}
		$setTenantHistory =  $g1->get_mongodb->setTenantHistory($id);
		$setPhotoGallary =  $g1->get_mongodb->setPhotoGallery($id,$currDate,$admin_email);
                $setTag = $g1->get_mongodb->setTagList($id,$currDate,$admin_email);
                 echo 'You have Signup Successfully.';
	}
       
 ?>