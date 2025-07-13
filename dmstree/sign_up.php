<?php
require('../CodeIgniter-old/external.php');
$ci = &get_instance();
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

	<link rel="stylesheet" href="dist/css/bootstrap.css" />
	<link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css" />
	<link rel="stylesheet" href="css/stylesheet.css" />
	<link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen" type="text/css" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
	<script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/date.js"></script>
	<script src="facebox-master/src/facebox.js" type="text/javascript"></script>

</head>
<style>
	/* body {
		height:100vh;
		overflow: scroll;
	} */

	@font-face {
		font-family: 'Space Grotesk';
		src: url('fonts/SpaceGrotesk-VariableFont_wght.ttf') format('truetype');
		font-weight: 400 700;
		font-style: normal;
	}

	@font-face {
		font-family: 'Inter';
		src: url('fonts/Inter-VariableFont_opsz,wght.ttf') format('truetype');
		font-weight: 100 900;
		font-style: normal;
	}

	.form_title {
		/* text-align: center; */
		font-family: 'Space Grotesk', Arial, sans-serif;
	}

	.text-muted {
		font-size: 26px;
		/* margin-left: 15px; */
		font-weight: 700;
		columns: #1B5563;
	}

	.section-heading1 {
		margin-left: 15px;
		display: flex;
		justify-content: center;
	}

	.signup-subtitle {
		font-size: 20px;
		color: #6c757d;
		margin-bottom: 20px;
		margin-right: 25px;
		line-height: 1.5;
		font-family: 'Inter', Arial, sans-serif;
	}

	.package-title {
		margin-left: 15px;
		font-size: 18px;
		font-weight: 700;
		color: #1B5563;
		font-family: 'Space Grotesk', Arial, sans-serif;
	}

	.signup-btns {
		display: flex;
		justify-content: space-between;
	}

	.view-package {
		margin-left: 30px;
	}

	.view-package-next {
		margin-right: 15px;
		/* background-color: #1B5563; */
	}

	.next-btn {
		background-color: #1B5563;
		color: #fff;
	}

	.form-group {
		margin-bottom: 18px;
	}

	.form-group label {
		font-weight: 500;
		margin-bottom: 6px;
		display: block;
	}

	.signup-btn {
		background-color: #1B5563;
		color: #fff;
	}

	.package-size,
	.package-duration,
	.user-label {
		white-space: nowrap;
		color: #1B5563 !important;
	}

	.signin-link {
		display: flex;
		justify-content: center;
		margin-top: 30px;
	}

	.view-package2 {
		color: #1B5563;
	}

	.section-heading {
		display: flex;
		justify-content: start;
	}

	/* Add background color to all form controls */
	.form-control {
		background-color: #FAFAFA !important;
	}
</style>

<body>

	<!-- logo of company-->
	<!-- <div class="header_nav">
		<div class="container header-container ">
			<div class="row">
				<div class="col-md-4"><img src="img/LOGO-2.jpg" alt="Logo_image" id="dms_logo" width="280" height="75"></div>
			</div>
		</div>
	</div> -->

	<!--Registration Page -->
	<div class="container form_container well container-narrow div-padding-top">
		<!-- Form start-->
		<div class="row">
			<!--                                <form id="formDemo" method="post" class="form-horizontal col-md-12 form-action" action="sign_up_process.php">
                                  <input type="text" class="form-control" id="txtname" placeholder="Name" name="name">  
                                  <input type="button" class="form-control" id="btnsubmit" name="btnsubmit" value="submit" onclick="sumitForm();">
                                </form>-->
			<form id="registrationForm" method="post" class="form-horizontal col-md-12 form-action" action="sign_up_process.php">
				<!-- Step 1: Package Selection -->
				<div class="form-step" id="step1">
					<div class="col-md-12 form_title ">
						<h2 class="text-muted section-heading1"><b>Create Your Nodo AI Account</b></h2>
						<p class="signup-subtitle">Organize, edit, and search files - all in one secure platform.</p>
					</div>
					<div class="row gap">
						<div class="select-package-type">
							<h4 class="package-title">Select Package</h4>
							<div class="col-md-6 form-group">
								<div class="radio">
									<label>
										<input type="radio" name="optionsRadios" id="rd_individual" value="Individual">
										Individual
									</label>
								</div>
							</div>
							<div class="col-md-6 form-group">
								<div class="radio">
									<label>
										<input type="radio" name="optionsRadios" id="rd_corporate" value="Corporate">
										Corporate
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-6">
							<div class="row">
								<label for="" class="col-md-6 col-sm-6 control-label package-size">Package in Size</label>
								<div class="col-md-6 col-sm-6">
									<select size="2" name="listbox_size[]" class="form-control select_size" multiple>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<label for="" class="col-md-6 col-sm-6 control-label div-padding-menu package-duration">Package in Duration</label>
								<div class="col-md-6 col-sm-6">
									<select size="1" name="listbox_month[]" class="form-control select_month" multiple>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="signup-btns">
						<div class="form-group view-package">
							<label><a href="package_info.php" rel="facebox" class="view-package2">View all Package Details</a></label>
						</div>
						<div class="view-package-next">
							<button type="button" class="btn next-btn" onclick="nextStep(2)">
								Next
								<img src="img/arrow-right.svg" alt="Next" style="height: 20px;width:20px; margin-left: 8px;">
							</button>
						</div>
					</div>
					<p class="signin-link">
						Alreday a user? <a href="http://localhost/dmstree/dmstree/login.php" style="text-decoration: underline;color: #1B5563;font-weight: 600;">Login</a>
					</p>
				</div>

				<!-- Step 2: Company/Admin/User Details -->
				<div class="form-step" id="step2" style="display:none;">
					<div class="form_title ">
						<h2 class="text-muted section-heading"><b>Enter Details</b></h2>
						<!-- <hr style="border: 1px solid #ccc; margin: 20px 0;"> -->
						<hr>
					</div>
					<div class="form-group">
						<label for="txt_company_name">Name of the Company</label>
						<input type="text" class="form-control" id="txt_company_name" placeholder="Enter your Company Name" name="companyname">
					</div>
					<div class="form-group">
						<label for="txt_admin_name">Name of the Admin</label>
						<input type="text" class="form-control" id="txt_admin_name" placeholder="Enter Admin Name" name="adminname">
					</div>
					<div class="form-group">
						<label for="txt_admin_contact">Contact Number of Admin</label>
						<div style="display: flex; gap: 8px;">
							<select class="form-control" name="admincontactcode" style="max-width: 90px;">
								<option value="+91">+91</option>
								<option value="+92">+92</option>
								<option value="+93">+93</option>
								<option value="+94">+94</option>
								<option value="+95">+95</option>
							</select>
							<input type="text" class="form-control" id="txt_admin_contact" placeholder="Enter Admin Phone Number" name="admincontact">
						</div>
					</div>
					<div class="form-group">
						<label for="txt_admin_mail">Email Address of the Admin</label>
						<input type="text" class="form-control" id="txt_admin_mail" placeholder="Enter Admin Email Address" name="adminemail">
					</div>
					<div class="individual-fields">
						<div class="form-group">
							<label for="txt_user_name" class="user-label">Name of the User</label>
							<input type="text" class="form-control" id="txt_user_name" placeholder="Enter User Name" name="individualname">
						</div>
						<div class="form-group">
							<label for="txt_user_contact">Contact Number of the User</label>
							<div style="display: flex; gap: 8px;">
								<select class="form-control" name="usercontactcode" style="max-width: 90px;">
									<option value="+91">+91</option>
									<option value="+92">+92</option>
									<option value="+93">+93</option>
									<option value="+94">+94</option>
									<option value="+95">+95</option>
								</select>
								<input type="text" class="form-control" id="txt_user_contact" placeholder="Enter User Phone Number" name="usercontact">
							</div>
						</div>
						<div class="form-group">
							<label for="txt_user_mail">Email Address of the User</label>
							<input type="text" class="form-control" id="txt_user_mail" placeholder="Enter User Email Address" name="useremail">
						</div>
					</div>
					<div class="signup-btns">
						<button type="button" class="btn btn-secondary" onclick="nextStep(1)"><img src="img/arrow-left.svg" alt="Next" style="height: 20px;width:20px; margin-right: 8px;">Back </button>
						<button type="button" class="btn next-btn" onclick="nextStep(3)">Next <img src="img/arrow-right.svg" alt="Next" style="height: 20px;width:20px; margin-left: 8px;"></button>
					</div>
				</div>

				<!-- Step 3: Address/Security Details -->
				<div class="form-step" id="step3" style="display:none;">
					<div class="form_title">
						<h2 class="text-muted section-heading"><b>Enter Address Details</b></h2>
						<hr>
					</div>
					<div class="form-group">
						<label for="txt_add1">Address1</label>
						<textarea name="address1" id="txt_add1" class="form-control" rows="3" placeholder="Address1"></textarea>
					</div>
					<div class="form-group">
						<label for="txt_add2">Address2</label>
						<textarea name="address2" id="txt_add2" class="form-control" rows="3" placeholder="Address2"></textarea>
					</div>
					<div class="country-state">
						<div class="col-md-6 form-group">
							<label for="txt_country">Country</label>
							<input type="text" class="form-control" id="txt_country" placeholder="Country" name="country">
						</div>
						<div class="col-md-6 form-group">
							<label for="txt_state">State</label>
							<input type="text" class="form-control" id="txt_state" placeholder="State" name="state">
						</div>
					</div>
					<div class="city-pincode">
						<div class="col-md-6 form-group">
							<label for="txt_city">City</label>
							<input type="text" class="form-control" id="txt_city" placeholder="City" name="city">
						</div>
						<div class="col-md-6 form-group">
							<label for="txt_pincode">Pincode</label>
							<input type="text" class="form-control" id="txt_pincode" placeholder="Pincode" name="pincode">
						</div>
					</div>
					<div class="form-group">
						<label for="txt_security_question">Security Question</label>
						<input type="text" class="form-control add-more" id="txt_security_question" placeholder="Security Question" name="security_question">
					</div>
					<div class="form-group">
						<label for="txt_security_answer">Security Answer</label>
						<input type="text" class="form-control add-more" id="txt_security_answer" placeholder="Security Answer" name="security_answer">
					</div>
					<!-- <div class="form-group">
						<label for="txt_recharge_date">Date of Recharge</label>
						<input type="text" class="form-control" id="txt_recharge_date" placeholder="Date of Recharge" value="" name="" disabled>
					</div>
					<div class="form-group">
						<label for="txt_total_amount">Total amount to be paid</label>
						<input type="text" class="form-control add-more" id="txt_total_amount" placeholder="Total Amount to be Paid" name="" disabled>
					</div> -->
					<div class="form-group">
						<?php
						require_once('recaptcha-php/recaptchalib.php');
						$publickey = "6LfQePcSAAAAAL2qmeWyCJzYwbOKPeWIXzK1F8iz"; //  got this from the signup page for dmstree domain
						//$publickey = "6LdmDPgSAAAAAHSetV7qYiSj-SXYt5C8h88_ELhB"; //  got this from the signup page for incrustsoftware domain
						echo recaptcha_get_html($publickey);
						?>
					</div>
					<div class="signup-btns">
						<button type="button" class="btn btn-secondary" onclick="nextStep(2)"><img src="img/arrow-left.svg" alt="Next" style="height: 20px;width:20px; margin-right: 8px;">Back </button>
						<input type="submit" class="btn btn-success ctrl-btn btn-space signup-btn" name="btnsubmit" value="Sign up">
						<!-- <input type="reset" class="btn btn-primary btn-space" value="Reset" onclick="reset_registrationform()"> -->
						<!-- <input type="button" class="btn ctrl-btn btn-space " value="Cancel"> -->
					</div>
				</div>
			</form>
		</div>
	</div>
	<br><br>
	<script type="text/javascript" src="js/dmstree_js/sign_validation.js"></script>
	<script type="text/javascript" src="js/dmstree_js/formvalidation.js"></script>
	<script>
		$(document).ready(function() {
			// On next button click
			$('.next-btn').on('click', function(e) {
				var step = $(this).closest('.form-step').attr('id');
				var validator = $('#registrationForm').data('bootstrapValidator');
				var fieldsToValidate = [];

				if (step === 'step1') {
					fieldsToValidate = ['optionsRadios', 'listbox_size[]', 'listbox_month[]'];
				} else if (step === 'step2') {
					fieldsToValidate = [
						'companyname', 'adminname', 'admincontact', 'adminemail',
						'individualname', 'usercontact', 'useremail'
					];
				}

				// Validate only the fields in this step
				var isValid = true;
				fieldsToValidate.forEach(function(field) {
					validator.validateField(field);
					if (!validator.isValidField(field)) {
						isValid = false;
					}
				});

				if (isValid) {
					// Go to next step
					var nextStepNum = parseInt(step.replace('step', '')) + 1;
					$('.form-step').hide();
					$('#step' + nextStepNum).show();
				}
				// else: errors will show inline, do not proceed
			});

			// On back button click
			$('.btn-secondary').on('click', function() {
				var step = $(this).closest('.form-step').attr('id');
				var prevStepNum = parseInt(step.replace('step', '')) - 1;
				$('.form-step').hide();
				$('#step' + prevStepNum).show();
			});

			function toggleFields() {
				var selected = $('input[name="optionsRadios"]:checked').val();
				if (selected === 'Corporate') {
					$('.individual-fields').hide();
				} else {
					$('.individual-fields').show();
				}
			}
			toggleFields();
			$('input[name="optionsRadios"]').on('change', function() {
				toggleFields();
			});
		});
	</script>
</body>

</html>