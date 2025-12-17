<?php
require('CodeIgniter-old/external.php');
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
		font-size: 32px;
		/* margin-left: 15px; */
		font-weight: 700;
		columns: #1B5563;
	}

	.section-heading1 {
		margin-left: -15px;
		display: flex;
		/* justify-content: center; */
	}

	.signup-subtitle {
		font-size: 22px;
		color: #6c757d;
		margin-bottom: 10px;
		/* margin-right: 55px; */
		margin-left: -45px;
		line-height: 1.5;
		font-family: 'Inter', Arial, sans-serif;
	}

	.package-title {
		/* margin-left: 15px; */
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

	.next-btn1 {
		background-color: #1B5563;
		color: #fff;
	}

	.next-btn2 {
		background-color: #1B5563;
		color: #fff;
		margin-right: -15px;
	}


	.form-group {
		/* margin-bottom: 18px; */
	}

	.form-group label {
		font-weight: 500;
		/* margin-bottom: 6px; */
		display: block;
	}

	.signup-btn {
		background-color: #1B5563;
		color: #fff;
		margin-right: -15px;
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
		/* margin-top: 30px; */
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
		/* background-color: #E0E0E0; */
	}

	@font-face {
		font-family: 'Space Grotesk';
		src: url('fonts/SpaceGrotesk-VariableFont_wght.ttf') format('truetype');
		font-weight: 400 700;
		font-style: normal;
	}

	.main-title,
	.welcome-heading {
		font-family: 'Space Grotesk', Arial, sans-serif !important;
	}

	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	body {
		font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
		background: #f8f9fa;
		min-height: 100vh;
		display: flex;
		flex-direction: column;
		overflow: hidden;
	}

	.header {
		background: #FFDA79;
		padding: 10px 55px;
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.logo {
		display: flex;
		align-items: center;
		gap: 8px;
		font-weight: 600;
		font-size: 18px;
		color: #1B5563;
	}

	.logo-icon {
		width: 24px;
		height: 24px;
		background: #1B5563;
		border-radius: 4px;
		display: flex;
		align-items: center;
		justify-content: center;
		color: white;
		font-weight: bold;
		font-size: 12px;
	}

	.main-container {
		flex: 1;
		display: flex;
		min-height: calc(100vh - 64px);
		
        /* align-items: stretch; */
		/* overflow: hidden; */
	}

	.left-section {
		/* height: 100vh; */
		flex: 1;
		/* background: rgba(255, 218, 121, 0.3); */
		background: linear-gradient(to bottom right, #FCF5E5, #FFFDE6);
	padding: 25px 60px;
		display: flex;
		flex-direction: column;
		position: relative;
	}

	.content-wrapper {
		max-width: 550px;
		text-align: start;
	}

	.main-title {
		font-size: 32px;
		font-weight: 700;
		font-family: 'Space Grotesk', Arial, sans-serif;
		color: #1B5563;
		line-height: 1.2;
		margin-bottom: 16px;
	}

	.subtitle {
		font-size: 16px;
		color: #6c757d;
		margin-bottom: 20px;
		line-height: 1.5;
		font-family: 'Inter', Arial, sans-serif;
	}

	/* .features-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-top: 20px;
    } */

	/* .feature-card {
      background-color: #FFEAAD;
      border-radius: 16px;
      padding: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
    } */

	/* .feature-card:hover {
      transform: translateY(-4px);
    } */

	.feature-icon {
		width: 48px;
		height: 48px;
		border-radius: 8px;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 24px;
	}

	.folder-icon {
		background: #ffd43b;
		color: #b8860b;
	}

	.cloud-icon {
		background: #87ceeb;
		color: #4682b4;
	}

	.chip-icon {
		background: #ffb347;
		color: #d2691e;
	}

	.shield-icon {
		background: #98fb98;
		color: #228b22;
	}

	.right-section {
		/* height: 100vh; */
		width:50%;
		overflow-y: scroll;
		/* width: 575px; */
		background: white;
		/* padding: 60px 60px; */
		display: flex;
		flex-direction: column;
		justify-content: center;
		box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
	}

	.login-form {
		width: 100%;
		max-width: 450px;
	}

	.login-title {
		margin-bottom: 20px;
	}

	.login-title h2 {
		font-size: 32px;
		font-weight: 700;
		color: #1B5563;
		margin-bottom: 8px;
	}

	.welcome-subtitle {
		font-size: 16px;
		color: #6c757d;
		font-weight: 400;
		font-family: 'Inter', Arial, sans-serif;
	}

	.form-group {
		/* margin-bottom: 20px; */
	}

	.form-label {
		display: block;
		font-weight: 500;
		font-size: 14px;
		color: #374151;
		margin-bottom: 8px;
	}

	.input-wrapper {
		position: relative;
	}

	.form-input {
		width: 100%;
		padding: 12px 16px 12px 44px;
		border: 1px solid #d1d5db;
		border-radius: 8px;
		background: #f9fafb;
		font-size: 14px;
		color: #374151;
		transition: all 0.2s ease;
	}

	.form-input:focus {
		outline: none;
		border-color: #1B5563;
		background: white;
		box-shadow: 0 0 0 3px rgba(27, 85, 99, 0.1);
	}

	.input-icon {
		position: absolute;
		left: 14px;
		top: 50%;
		transform: translateY(-50%);
		width: 16px;
		height: 16px;
		color: #9ca3af;
		pointer-events: none;
	}

	.form-options {
		/* display: flex;
		justify-content: space-between; */
		align-items: center;
		margin-bottom: 24px;
	}

	.remember-me {
		display: flex;
		align-items: center;
		gap: 8px;
		font-size: 14px;
		color: #374151;
		cursor: pointer;
	}

	.remember-me input[type="checkbox"] {
		width: 16px;
		height: 16px;
		accent-color: #1B5563;
	}

	.forgot-password {
		color: #1B5563;
		font-size: 14px;
		text-decoration: none;
		font-weight: 500;
	}

	.forgot-password:hover {
		text-decoration: underline;
	}

	.login-button {
		width: 100%;
		padding: 12px;
		background: #1B5563;
		color: white;
		border: none;
		border-radius: 8px;
		font-size: 16px;
		font-weight: 600;
		cursor: pointer;
		transition: background-color 0.2s ease;
		margin-bottom: 24px;
	}

	.login-button:hover {
		background: #164449;
	}

	.login-button:active {
		transform: translateY(1px);
	}

	.signup-link {
		text-align: center;
		font-size: 14px;
		color: #6c757d;
	}

	.signup-link a {
		color: #1B5563;
		/* text-decoration: none; */
		font-weight: 600;
	}

	.signup-link a:hover {
		/* text-decoration: underline; */
	}

	.password-toggle {
		position: absolute;
		right: 12px;
		top: 50%;
		transform: translateY(-50%);
		background: none;
		border: none;
		color: #6c757d;
		cursor: pointer;
		font-size: 12px;
		padding: 4px;
	}

	.password-toggle:hover {
		color: #1B5563;
	}


	@media (max-width: 968px) {
  .main-container {
    flex-direction: column;
    align-items: stretch;
  }

  .left-section,
  .right-section {
    flex-grow: 1;
  }

  .left-section {
    padding: 30px 20px;
    justify-content: center;
    align-items: center;
  }

  .right-section {
    width: 100%;
    padding: 40px 20px;
    justify-content: center;
    align-items: center;
  }
}


	/* Laptops - 1025px to 1280px */
	@media (min-width: 1025px) and (max-width: 1280px) {
		.header {
			padding: 10px 57px;
		}

	}

	/* Desktops (HD+) - 1281px and above */
	@media (min-width: 1281px) {
		.header {
			padding: 10px 57px;
		}

		.left-section {
			
		}

		.right-section {
			  flex:1 0 0;
		}
	}


	/* .features-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      padding: 20px;
      background-color: #FFF0CA;
      light background
      border-radius: 20px;
    } */

	/* .feature-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 25px rgba(255, 180, 50, 0.3);
    } */

	.feature-icon {
		font-size: 48px;
		color: #ffb700;
		filter: drop-shadow(0 2px 4px rgba(255, 200, 0, 0.4));
	}

	@font-face {
		font-family: 'Inter';
		src: url('fonts/Inter-VariableFont_opsz,wght.ttf') format('truetype');
		font-weight: 100 900;
		font-style: normal;
	}

	/* Validation error styles for login page */
	.has-error .form-label,
	.has-error .form-input,
	.has-error .form-control {
		color: #d9534f !important;
		border-color: #d9534f !important;
	}

	.help-block {
		color: #d9534f !important;
		font-size: 13px;
		margin-top: 4px;
		margin-bottom: 0;
	}

	.div-padding-top {
		padding-top: 0px;
		margin-top: 150px;
	}

	.signup-nxt {
		display: flex;
		justify-content: space-between;
	}

	#step1 {
		margin-top: 80px;
	}

	.packgsize {
		margin-left: -30px;
	}

	.packgdur {
		margin-left: 45px;
	}

	.signup-country,
	.signup-city {
		margin-left: -30px;
	}

	.signup-state,
	.signup-pincode {
		margin-left: 45px;
	}

	/* #step2 {
			margin-top: 200px;
			margin-bottom: 20px;
		}

		#step3 {
			margin-top: 200px;
			margin-bottom: 20px;
		} */
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
	<div class="header">
		<div class="logo">
			<img src="img/Logo.svg" alt="DMS Logo">
		</div>
	</div>
	<div class="main-container">
		<div class="main-container">
			<div class="left-section">
				<div class="content-wrapper">
					<h1 class="main-title">Intelligent Document Management, Powered by AI</h1>
					<p class="subtitle">Nodo AI helps you store, organize, edit and summarize your business documents - all in one secure platform.</p>

					<div class="features-grid">
						<img src="img/Features.svg" alt="Features" style="width:100%;height:auto;display:block;" />
					</div>
				</div>
			</div>

			<div class="right-section">
				<div class="container container-narrow">
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
								<div class="form-group">
									<label class="package-title">Select a Package</label>
									<div class="package-type-toggle" style="display: flex; gap: 16px;">
										<label class="package-type-card" id="card_individual" style="flex:1; display:flex; align-items:center; padding:12px 18px; border-radius:8px; border:1px solid #d1d5db; background:#FAFAFA; cursor:pointer; font-weight:500; gap:10px;">
											<input type="radio" name="optionsRadios" id="rd_individual" value="Individual" style="margin-right:10px;"> Individual
										</label>
										<label class="package-type-card" id="card_corporate" style="flex:1; display:flex; align-items:center; padding:12px 18px; border-radius:8px; border:1px solid #d1d5db; background:#FAFAFA; cursor:pointer; font-weight:500; gap:10px;">
											<input type="radio" name="optionsRadios" id="rd_corporate" value="Corporate" style="margin-right:10px;"> Corporate
										</label>
									</div>
								</div>
								<div class="container" style="width: 100%;">
									<div class="row" style="display: flex;">
										<div class="col-md-6 form-group packgsize">
											<label for="" class="package-size">Package Size</label>
											<select name="listbox_size[]" class="form-control select_size" style="background:#FAFAFA;border-radius: 8px;width: 270px;" required>
												<option value="" disabled selected>-Select Package Size-</option>
											</select>
										</div>
										<div class="col-md-6 form-group packgdur">
											<label for="" class="package-duration">Package Duration</label>
											<select name="listbox_month[]" class="form-control select_month" style="background:#FAFAFA;border-radius: 8px;width: 270px;" required>
												<option value="" disabled selected>-Select Package Duration-</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="recharge_date">Recharge Date</label>
									<input type="text" class="form-control" id="recharge_date" name="recharge_date" placeholder="" disabled>
								</div>
								<div class="form-group">
									<label for="total_amount">Total Amount to be Paid</label>
									<input type="text" class="form-control" id="total_amount" name="total_amount" placeholder="" disabled>
								</div>
								<div class="signup-nxt">
									<div class="form-group" style="margin-bottom: 10px;">
										<a href="package_info.php" rel="facebox" class="view-package2">View all package details</a>
									</div>
									<div class="form-group">
										<button type="button" class="btn next-btn1" style="min-width:120px; border-radius:8px; font-weight:600; font-size:16px; display:flex; align-items:center; justify-content:center; gap:8px;" onclick="nextStep(2)">
											Next <img src="img/arrow-right.svg" alt="Next" style="height: 20px;width:20px; margin-left: 8px;">
										</button>
									</div>
								</div>
								<p class="signin-link">
									Alreday a user? <a href="http://13.201.180.131/nodo/login.php" style="text-decoration: underline;color: #1B5563;font-weight: 600;margin-left: 5px;">Login</a>
								</p>
							</div>

							<!-- Step 2: Company/Admin/User Details -->
							<div class="form-step" id="step2" style="display:none;margin-top: 200px;margin-bottom: 20px;">
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
									<button type="button" class="btn next-btn2" onclick="nextStep(3)">Next <img src="img/arrow-right.svg" alt="Next" style="height: 20px;width:20px; margin-left: 8px;"></button>
								</div>
							</div>

							<!-- Step 3: Address/Security Details -->
							<div class="form-step" id="step3" style="display:none;margin-top: 200px;margin-bottom: 20px;">
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
								<div class="container" style="width: 100%;">
									<div class="row row-cols-2">
										<div class="country-state">
											<div class="col-md-6 form-group signup-country">
												<label for="txt_country">Country</label>
												<input type="text" class="form-control" id="txt_country" placeholder="Country" name="country" style="width: 270px;">
											</div>
											<div class="col-md-6 form-group signup-state">
												<label for="txt_state">State</label>
												<input type="text" class="form-control" id="txt_state" placeholder="State" name="state" style="width: 270px;">
											</div>
										</div>
										<div class="city-pincode">
											<div class="col-md-6 form-group signup-city">
												<label for="txt_city">City</label>
												<input type="text" class="form-control" id="txt_city" placeholder="City" name="city" style="width: 270px;">
											</div>
											<div class="col-md-6 form-group signup-pincode">
												<label for="txt_pincode">Pincode</label>
												<input type="text" class="form-control" id="txt_pincode" placeholder="Pincode" name="pincode" style="width: 270px;">
											</div>
										</div>
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
									<input type="submit" class="btn btn-success ctrl-btn signup-btn" name="btnsubmit" value="Sign up">
									<!-- <input type="reset" class="btn btn-primary btn-space" value="Reset" onclick="reset_registrationform()"> -->
									<!-- <input type="button" class="btn ctrl-btn btn-space " value="Cancel"> -->
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br><br>
	<script type="text/javascript" src="js/dmstree_js/sign_validation.js"></script>
	<script type="text/javascript" src="js/dmstree_js/formvalidation.js"></script>
	<script>
		$(document).ready(function() {
			// On next button click
			$('.next-btn1, .next-btn2').on('click', function(e) {
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
					$('#step2').css('margin-top', '0');
				} else {
					$('.individual-fields').show();
					$('#step2').css('margin-top', '230px');
				}
			}
			toggleFields();
			$('input[name="optionsRadios"]').on('change', function() {
				toggleFields();
			});
		});
	</script>
	<script>
		// Highlight selected package card
		$(document).ready(function() {
			function updateCardSelection() {
				if ($('#rd_individual').is(':checked')) {
					$('#card_individual').css({
						'border-color': '#1B5563',
						'background': '#E6F2F5',
						'font-weight': '700'
					});
					$('#card_corporate').css({
						'border-color': '#d1d5db',
						'background': '#FAFAFA',
						'font-weight': '500'
					});
				} else if ($('#rd_corporate').is(':checked')) {
					$('#card_corporate').css({
						'border-color': '#1B5563',
						'background': '#E6F2F5',
						'font-weight': '700'
					});
					$('#card_individual').css({
						'border-color': '#d1d5db',
						'background': '#FAFAFA',
						'font-weight': '500'
					});
				} else {
					$('#card_individual, #card_corporate').css({
						'border-color': '#d1d5db',
						'background': '#FAFAFA',
						'font-weight': '500'
					});
				}
			}
			$('input[name="optionsRadios"]').on('change', updateCardSelection);
			updateCardSelection();
		});
	</script>
</body>

</html>