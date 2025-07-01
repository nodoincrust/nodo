<?php
	require('../CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
        $g1 = new Get_mongodb();
?>

<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <title>Sign up Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        <link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen"  type="text/css" />

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script> 
        <script type="text/javascript" src="js/dmstree_js/date.js"></script>
        <script src="facebox-master/src/facebox.js" type="text/javascript"></script>
		
    </head>
	<body>

	<!-- logo of company-->
		<div class="header_nav">  
			<div class="container header-container ">
				<div class="row">
					<div class="col-md-4"><img src="img/LOGO-2.jpg" alt="Logo_image" id="dms_logo" width="280" height="75"></div>
				</div>
			</div> 
		</div> 
		 
		<!--Registration Page -->
		<div class="container form_container well container-narrow div-padding-top">
			<div class="row">
				<div class="col-md-12 form_title "><h2 class="text-muted"><b>Sign Up</b></h2></div>
			</div>
			<!-- Form start-->	
			<div class="row">
<!--                                <form id="formDemo" method="post" class="form-horizontal col-md-12 form-action" action="sign_up_process.php">
                                  <input type="text" class="form-control" id="txtname" placeholder="Name" name="name">  
                                  <input type="button" class="form-control" id="btnsubmit" name="btnsubmit" value="submit" onclick="sumitForm();">
                                </form>-->
				<form id="registrationForm" method="post" class="form-horizontal col-md-12 form-action" action="sign_up_process.php"> 
					<div class="row gap">
						<div class="col-md-4 form-group">
							<div class="radio">
								<label>
									<input type="radio" name="optionsRadios" id="rd_individual" value="Individual">
										Individual
								</label>
							</div>
						</div>
						<div class="col-md-4 form-group">
							<div class="radio">
								<label>
									<input type="radio"  name="optionsRadios" id="rd_corporate" value="Corporate">
										Corporate
								</label>
							 </div>
						</div>
						<div class="col-md-4 form-group">
								<label><a href="package_info.php" rel="facebox">View Package Details</a></label>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-6">
							<div class="row">
								<label for="" class="col-md-6 col-sm-6 control-label">Package in Size</label>
								<div class="col-md-6 col-sm-6">	
									<select size="2" name="listbox_size[]" class="form-control select_size" multiple>	
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<label for="" class="col-md-6 col-sm-6 control-label div-padding-menu">Package in Duration</label>
								<div class="col-md-6 col-sm-6">	
									<select size="1" name="listbox_month[]" class="form-control select_month" multiple>	
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row space">
						<label for="txt_company_name" class="col-md-4 control-label">Name of Company</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="txt_company_name" placeholder="Name of Company" name="companyname">
						</div>
					</div>
					<div class="form-group row">
						<label for="txt_admin_name" class="col-md-4  control-label">Name of Admin</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="txt_admin_name" placeholder="Name of Admin" name="adminname">
						</div>
					</div>
					<div class="form-group row">
						<label for="txt_admin_contact" class="col-md-4  control-label">Admin Contact No.</label>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-5">
									<select class="form-control" name="admincontactcode">
										<option value="+91">+91</option>
										<option value="+92">+92</option>
										<option value="+93">+93</option>
										<option value="+94">+94</option>
										<option value="+95">+95</option>
									</select>
								</div>
								<div class="col-md-7 txt-padding">
									<input type="text" class="form-control" id="txt_admin_contact"  placeholder="Admin Contact No." name="admincontact">
								</div>
							</div>
						 </div> 
					</div>
					<div class="form-group row">
						<label for="txt_admin_mail" class="col-md-4 control-label">Admin E-Mail</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="txt_admin_mail" placeholder="Admin E-Mail" name="adminemail">
						</div>
					</div>
					<div class="individual">
						<div class="form-group row ">
							<label for="txt_user_name" class="col-md-4 control-label">Name of User</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="txt_user_name" placeholder="Name of User" name="individualname">
							</div>
						</div>
						<div class="form-group row ">
							<label for="txt_user_contact" class="col-md-4  control-label">User Contact No.</label>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-5">
										<select class="form-control" name="usercontactcode">
											<option value="+91">+91</option>
											<option value="+92">+92</option>
											<option value="+93">+93</option>
											<option value="+94">+94</option>
											<option value="+95">+95</option>
										</select>
									</div>
									<div class="col-md-7 txt-padding">
										<input type="text" class="form-control" id="txt_user_contact" placeholder="User Contact No." name="usercontact">
									</div>
								</div>   
							</div>
						</div>

						<div class="form-group row ">
							<label for="txt_user_mail" class="col-md-4 control-label">User E-Mail</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="txt_user_mail" placeholder="User E-Mail" name="useremail">
							</div>
						</div>
					</div>
					<div class="form-group row ">
							<label for="txt_add1" class="col-md-4 control-label">Address1</label>
							<div class="col-md-6">
								<textarea name="address1" id="txt_add1" class="form-control col-md-12"  rows="5" placeholder="Address1"></textarea>
							</div>
					</div>
					<div class="form-group row ">
							<label for="txt_add2" class="col-md-4 control-label">Address2</label>
							<div class="col-md-6">
								<textarea name="address2" id="txt_add2" class="form-control col-md-12"  rows="5" placeholder="Address2"></textarea>
							</div>
					</div>
					<div class="form-group row ">
							<label for="txt_city" class="col-md-4 control-label">City</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="txt_city" placeholder="City" name="city">
							</div>
					</div>
					<div class="form-group row ">
							<label for="txt_pincode" class="col-md-4 control-label">Pincode</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="txt_pincode" placeholder="Pincode" name="pincode">
							</div>
					</div>
					<div class="form-group row ">
							<label for="txt_state" class="col-md-4 control-label">State</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="txt_state" placeholder="State" name="state">
							</div>
					</div>
					<div class="form-group row ">
							<label for="txt_country" class="col-md-4 control-label">Country</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="txt_country" placeholder="Country" name="country">
							</div>
					</div>
					<div class="form-group row ">
						<label for="txt_user_mail" class="col-md-4 control-label">Security Question</label>
						<div class="col-md-6">
							<input type="text" class="form-control add-more" id="txt_security_question" placeholder="Security Question" name="security_question" >
						</div>
					</div>
					<div class="form-group row ">
						<label for="txt_user_mail" class="col-md-4 control-label">Security Answer</label>
						<div class="col-md-6">
							<input type="text" class="form-control add-more" id="txt_security_answer" placeholder="Security Answer" name="security_answer" >
						</div>
					</div>    
					<div class="form-group row ">
						<label for="txt_user_mail" class="col-md-4 control-label">Date of Recharge</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="txt_recharge_date" placeholder="Date of Recharge" value="" name="" disabled>
						</div>
					</div>
					<div class="form-group row ">
						<label for="txt_user_mail" class="col-md-4 control-label">Total amount to be paid</label>
						<div class="col-md-6">
							<input type="text" class="form-control add-more" id="txt_total_amount" placeholder="Total Amount to be Paid" name="" disabled>
						</div>
					</div>
					<div class="row control-label">
						<?php
							require_once('recaptcha-php/recaptchalib.php');
							$publickey = "6LfQePcSAAAAAL2qmeWyCJzYwbOKPeWIXzK1F8iz"; //  got this from the signup page for dmstree domain
							//$publickey = "6LdmDPgSAAAAAHSetV7qYiSj-SXYt5C8h88_ELhB"; //  got this from the signup page for incrustsoftware domain
							echo recaptcha_get_html($publickey);
						?>
					</div>
					<div class="row control-label">
					<div class="col-md-12 ">
						<input type="button" class="btn btn-success ctrl-btn  btn-space" name="btnsubmit"  value="Submit" onclick="valdationForm()" > 
						<input type="reset" class="btn btn-primary btn-space" value="Reset" onclick="reset_registrationform()">
						<input type="button" class="btn ctrl-btn btn-space " value="Cancel">
					</div>
					</div>
				</form>
			</div>
		</div>	
		<br><br>
		<script type="text/javascript" src="js/dmstree_js/sign_validation.js"></script>
		<script type="text/javascript" src="js/dmstree_js/formvalidation.js"></script>
	</body>
</html>
