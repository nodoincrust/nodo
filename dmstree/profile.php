<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
require('CodeIgniter-old/external.php');
$ci = &get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();

$userdepartid = '';
$tenantid = '';
$tenantname = '';
if (isset($_SESSION['userdepartmentid'])) {
	$userdepartid = $_SESSION['userdepartmentid'];
}
if (isset($_SESSION['usertenant'])) {
	$tenantid = $_SESSION['usertenant'];
}
if (isset($_SESSION['tenantname'])) {
	$tenantname = $_SESSION['tenantname'];
	$tenantname = str_replace(" ", "_", $tenantname);
}

$path = 'DMSTree_clients/' . $tenantname . '_' . $tenantid;
$ar = getDirectorySize($path);
$tenantspace = sizeFormat($ar['size']);
$tenantspace = (float) $tenantspace;
$filesize = (float) fileSizeInMB($ar['size']);
$activepackspace = $g1->get_mongodb->getActivePackageSize($tenantid);
$activepackspace = (float) $activepackspace;

?>


<html>

<head>
	<meta charset="utf-8">
	<title>Dash-Board</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="discription" content="">
	<meta name="author" content="">

	<link rel="stylesheet" href="dist/css/bootstrap.css" />
	<link rel="stylesheet" href="css/stylesheet.css" />
	<link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css" />
	<link rel="stylesheet" href="css/fileinput.min.css" />
	<link rel="stylesheet" href="css/jquery.tag-editor.css">


	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
	<script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
	<script src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
	<script src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/fileinput.min.js"></script>
	<script>
		window.onload = function() {
			value = <?php echo $filesize ?>;
			max = <?php echo $activepackspace * 1000 ?>;
			if (document.getElementById('g1')) {
				showmeter(value, max);
			}
		};
		$(document).ready(function() {
			var directoryspace = <?php echo $tenantspace ?>;
			var tenantspace = <?php echo $activepackspace ?>;
			if (parseFloat(directoryspace) >= parseFloat(tenantspace)) {
				$('input').attr('disabled', 'disabled');
				$('button').attr('disabled', 'disabled');
				$('input').css('opacity', '0.5');
				$('button').css('opacity', '0.5');
				var spacemsg = 'Package Size is full';
				$('.spaceerror').text(spacemsg);
			} else {
				$('button').removeAttr('disabled');
				$('input').removeAttr('disabled');
				$('.spaceerror').text('');
			}
		});
	</script>
	<style>
		body {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
			/* background-color: #2a2a2a; */
			background: #F6F8F9;
			/* display: flex;
            justify-content: center;
            align-items: center; */
			/* min-height: 100vh; */
			/* padding: 20px; */
		}

		.navbar-nav li .prof_cls {
			font-size: 16px;
			color: #fff;
			padding: 10px;
			margin-top: 14px;
		}

		.navbar-nav li .pass_cls {
			font-size: 16px;
			color: #fff;
			padding: 10px;
			margin-top: 14px;
		}

		.navbar-nav li a.active {
			background: #1B5563;
			/* color: #fff; */
			/* Active button background */
		}

		.navbar-nav li a.inactive {
			background: gray;
			color: black;
			/* Inactive button background */
		}

		.add_btn {
			display: flex;
			gap: 8px;
			justify-content: end;
			margin-right: -10px;
		}

		/* test  */
		.main-container {
			background: white;
			max-width: 600px;
			/* margin: auto; */
			border-radius: 8px;
			padding: 20px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			margin: 22px auto;
			overflow: hidden;
		}

		.form-input {
			width: 100% !important;
			height: 45px !important;
			padding: 8px 12px !important;
			border: 1px solid #d1d5db;
			border-radius: 8px;
			font-size: 14px;
			background: #FAFAFA;
			/* color: #374151; */
			/* background-color: #ffffff; */
			border: 1px solid #E0E0E0 !important;
			box-shadow: 0px 1px 2px 0px #1018280D;
		}

		.form-select {
			width: 100% !important;
			height: 50px !important;
			padding: 8px 12px !important;
			border: 1px solid #d1d5db;
			border-radius: 8px;
			font-size: 14px;
			background: #FAFAFA;
			/* color: #374151; */
			/* background-color: #ffffff; */
			border: 1px solid #E0E0E0;
			box-shadow: 0px 1px 2px 0px #1018280D;
		}

		input[type="text"] {
			height: 40px !important;
		}

		.heading {
			max-width: 600px;
			font-family: 'Space Grotesk', Arial, sans-serif;
			height: 58px;
			padding: 16px 24px;
			display: flex;
			gap: 10px;
			/* border-bottom: 1px solid #E5E9EB; */
			/* margin: 22px auto; */
			margin: 22px -23px;
			overflow: hidden;
			margin-top: -15px;
		}

		.heading h2 {
			width: 552px;
			height: 26px;
			font-size: 24px;
			font-weight: 700;
			color: #1B5563;
			margin: auto;
		}

		h2 {
			color: #0f4d5f;
			margin-bottom: 16px;
		}

		.upload-area {
			border: 2px dashed #cdcdcd;
			border-radius: 8px;
			text-align: center;
			padding: 30px;
			cursor: pointer;
			margin-bottom: 20px;
			position: relative;
		}

		.upload-area input {
			display: none;
		}

		.upload-area p {
			margin: 10px 0;
			/* color: #555; */
			color: #292D32;

		}

		.upload-area button {
			background-color: #fff;
			border: 1px solid #ccc;
			padding: 8px 12px;
			cursor: pointer;
			border-radius: 4px;
			/* color: */
			color: #111729;
			font-weight: 500;

		}

		.uploaded-files {
			margin-bottom: 20px;
		}

		.file-item {
			background: #f1f5f9;
			border-radius: 6px;
			padding: 8px 12px;
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 8px;
		}

		.file-item span {
			display: flex;
			align-items: center;
		}

		.file-item i {
			color: #dc2626;
			margin-right: 8px;
		}

		.delete-btn {
			background: none;
			border: none;
			color: #dc2626;
			cursor: pointer;
			font-size: 16px;
		}

		.form-group {
			margin-bottom: 16px;
		}

		.upload_file {
			display: block;
			margin-bottom: 4px;
			font-weight: 500;
			color: #292D32;
			font-size: 16px;
			font-style: normal;

		}

		label {
			display: block;
			margin-bottom: 4px;
			font-weight: 500;
			font-size: 14px;
			color: #111729;
			font-style: normal;

		}

		select,
		input[type="date"] {
			width: 420px;
			height: 44px;
			padding: 12px;
			gap: 4px;
			/* Only affects children in flex/grid layout */
			transform: rotate(0deg);
			/* 'angle' becomes 'transform' */
			opacity: 1;
			border-radius: 8px;
			border: 1px solid #ccc;
			/* Add color to make the border visible */
			box-sizing: border-box;
		}

		.checkbox-group {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
			ancient
		}

		.privacy-toggle {
			display: flex;
			align-items: center;
			color: #666666;
			gap: 4px;
		}

		.privacy-toggle input {
			margin-right: 8px;
		}

		.buttons {
			display: flex;
			justify-content: flex-end;
			gap: 10px;
		}

		.buttons button {
			padding: 8px 16px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			font-weight: 500;
			width: 73px;
			height: 32px;
		}

		.cancel-btn {
			background-color: #fff;
			border: 1px solid #DDE2E4 !important;
		}

		.save-btn {
			/* background-color: #0f766e; */
			background: #1B5563;

			color: white;
		}

		.clear-date {
			margin-top: 8px;
			background: #d1fae5;
			border: none;
			color: #065f46;
			padding: 4px 8px;
			cursor: pointer;
			border-radius: 4px;
		}

		.privacy-toggle input[type="checkbox"] {
			/* accent-color: red; */
			accent-color: #00684A;

		}

		.form-lable input[type="checkbox"] {
			accent-color: #00684A;
		}

		.date-input-group {
			display: flex;
			gap: 12px;
		}

		.clear-date-btn {
			width: 140px;
			height: 44px;
			gap: 6px;
			/* Only applies in flex/grid layouts */
			transform: rotate(0deg);
			/* 'angle' is not a CSS property */
			opacity: 1;
			padding: 8px 16px;
			border-radius: 8px;
			border: 1px solid #ccc;
		}

		.form-date-group {
			width: 420px;
			height: 44px;
			padding: 12px;
			gap: 4px;
			/* Only affects children in flex/grid layout */
			transform: rotate(0deg);
			/* 'angle' becomes 'transform' */
			opacity: 1;
			border-radius: 8px;
			border: 1px solid #ccc;
			/* Add color to make the border visible */
			box-sizing: border-box;
		}

		.heading {
			max-width: 600px;
			height: 58px;
			padding: 16px 24px;
			display: flex;
			gap: 10px;
			/* border-bottom: 1px solid #E5E9EB; */
			/* margin: 22px auto; */
			margin: 22px -23px;
			overflow: hidden;
			margin-top: -15px;
		}

		.heading h2 {
			width: 552px;
			height: 26px;
			font-size: 24px;
			font-weight: 700;
			color: #1B5563;
			margin: auto;
		}

		h2 {
			color: #0f4d5f;
			margin-bottom: 16px;
		}

		.saveprofile {
			background-color: #1B5563;
			color: #fff;
		}

		.changepassword {
			background-color: #1B5563;
			color: #fff;

		}

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

		.footer-fixed {
			position: fixed;
			left: 0;
			bottom: 0;
			width: 100%;
			/* z-index: 999; */
			background: #fff;
			/* box-shadow: 0 -1px 6px rgba(0,0,0,0.07); */
		}

		body {
			/* height: 100vh; */
			overflow: hidden;
		}
	</style>
</head>

<body>
	<!----------- Header page--------------------------------------------->
	<div id="header">
		<?php include_once 'header.php'; ?>
	</div>
	<!-- <div class="row row-margin"> -->
	<!-- <div class="row row-margin  div-padding-top"> -->
	<div class="col-md-3" style="background-color: #FFFFFF;height: 100vh;">
		<!--------- dash board side menu------------------------------------------------>
		<?php include_once 'dash_menu.php' ?>
	</div>

	<div class="main-container" style="max-height: calc(100vh - 115px);
    overflow-y: auto;">
		<div class="heading">
			<h2>Profile</h2>
			<!-- <div> -->
			<ul class="nav navbar-nav navbar-right" style="display: flex;margin-top: -13px;">
				<li><a id="profileBtn" class="prof_cls active" onclick="show('profile');"
						style="color: #fff;">Profile</a></li>
				<li><a id="passwordBtn" class="pass_cls inactive" onclick="show('password');"
						style="color: #fff;">Password</a></li>
			</ul>
			<!-- </div> -->
		</div>
		<hr>
		<!-- <div class="col-md-9 div-padding-top"> -->
		<!-- <div class="row">
				<p class="spaceerror col-md-12" style="color:red"> </p>
			</div>     -->
		<!-- <div class="upload_temp well-padding"> -->
		<!-- <div class="well well-padding"> -->
		<!-- <div class="row">
						<div class="col-md-12 prof_form_title"><h3 class="text-muted upload_doc_cls">Profile</h3>
					<ul class="nav navbar-nav navbar-right">
									<li><a id="profileBtn" class="prof_cls active"onclick="show('profile');" style="color: black;">Profile</a></li>
									<li><a  id="passwordBtn" class="pass_cls inactive" onclick="show('password');" style="color: black;">Password</a></li>
								</ul>
							</div>
					</div> -->
		<!-- commented below code for show only one row  -->
		<!-- <div class="row">
						<div class="row"> -->
		<!-- <div class="col-md-11"> -->
		<!-- <ul class="nav navbar-nav navbar-right">
									<li><a id="profileBtn" class="prof_cls active"onclick="show('profile');">Profile</a></li>
									<li><a  id="passwordBtn" class="pass_cls inactive" onclick="show('password');">Password</a></li>
								</ul> -->
		<!-- </div> -->
		<!-- </div>
					</div> -->
		<!-- </div> -->
		<!-- <div class="well" id="profile_profile"> -->
		<div id="profile_profile" style="display: block;">
			<?php $userid = $_SESSION['userid'];
			$userinfo = $g1->get_mongodb->getUserInfo($userid);
			$tenantInfo = $g1->get_mongodb->getTenantInfo($userinfo[0]["TenantId"]); ?>
			<!-- <div class="row" class="well-padding"> -->
			<form name="profile_info" id="profile_info">
				<div class="form-group">
					<label for="txt_profile_name" class="form-label">Name</label>
					<!-- <div class="col-md-6"> -->
					<input type="text" class="form-input form-control" id="txt_profile_name" placeholder="Name" name="name"
						value="<?php echo $userinfo[0]['Name'] ?>" readonly />
					<!-- </div> -->
				</div>
				<div class="form-group">
					<label for="txt_profile_contact" class="form-label">Contact</label>
					<!-- <div class="col-md-6"> -->
					<input type="text" class="form-input form-control" id="txt_profile_contact" placeholder="Contact"
						name="contact" value="<?php echo $userinfo[0]['Contact'] ?>" readonly />
					<!-- </div> -->
				</div>
				<div class="form-group">
					<label for="txt_profile_add1" class="form-label ">Address 1</label>
					<!-- <div class="col-md-6"> -->
					<input type="text" class="form-input form-control" id="txt_profile_add1" placeholder="Address 1"
						name="add1" value="<?php echo $tenantInfo[0]['AddressInfo']['Add1'] ?>" readonly />
					<!-- </div> -->
				</div>
				<div class="form-group">
					<label for="txt_profile_add2" class="form-label ">Address 2</label>
					<!-- <div class="col-md-6"> -->
					<input type="text" class="form-input form-control" id="txt_profile_add2" placeholder="Address 2"
						name="add2" value="<?php echo $tenantInfo[0]['AddressInfo']['Add2'] ?>" readonly />
					<!-- </div> -->
				</div>
				<div class="form-group">
					<label for="txt_profile_city" class="form-label ">City</label>
					<!-- <div class="col-md-6"> -->
					<input type="text" class="form-input form-control" id="txt_profile_city" placeholder="City" name="city"
						value="<?php echo $tenantInfo[0]['AddressInfo']['City'] ?>" readonly />
					<!-- </div> -->
				</div>
				<div class="form-group">
					<label for="txt_profile_pincode" class="form-label ">Pincode</label>
					<!-- <div class="col-md-6"> -->
					<input type="text" class="form-input form-control" id="txt_profile_pincode" placeholder="Pincode"
						name="pincode" value="<?php echo $tenantInfo[0]['AddressInfo']['PinCode'] ?>" readonly />
					<!-- </div> -->
				</div>
				<div class="form-group">
					<label for="txt_profile_state" class="form-label ">State</label>
					<!-- <div class="col-md-6"> -->
					<input type="text" class="form-input form-control" id="txt_profile_state" placeholder="State"
						name="state" value="<?php echo $tenantInfo[0]['AddressInfo']['State'] ?>" readonly />
					<!-- </div> -->
				</div>
				<div class="form-group">
					<label for="txt_profile_country" class="form-label ">Country</label>
					<!-- <div class="col-md-6"> -->
					<input type="text" class="form-input form-control" id="txt_profile_country" placeholder="Country"
						name="country" value="<?php echo $tenantInfo[0]['AddressInfo']['Country'] ?>" readonly />
					<!-- </div> -->
				</div>
				<div class="form-group row space add_btn">
					<!-- <input type="button"  class="btn-hide btn btn-success ctrl-btn btn-space" value="Save" onclick="save_changes();"/>
								 <input type="reset"  class="btn-hide btn ctrl-btn btn-space" value="Reset" onclick="cancel_changes();"/> -->
					<input type="button" class="save_btn_bg_cancel saveprofile" value="Save" onclick="save_changes();" />
					<input type="reset" class="save_btn_bg_cancel" value="Reset" onclick="cancel_changes();" />
					<!-- <input type="button" class="btn ctrl-btn btn-space" value="Edit"  onclick="edit_form();"/> -->
					<input type="button" class="save_btn_bg_cancel" value="Edit" style="color: black;"
						onclick="edit_form();" />
				</div>

			</form>
		</div>
		<!-- </div> -->
		<!-- </div> -->
		<div class="well" id="profile_password" style="display: none;">
			<!-- <div class="row"> -->
			<form action="" method="post" id="profilePassword" name="" class=" well-padding">
				<div class="form-group">
					<label for="txt_profile_old_password" class="form-label">Old Password</label>
					<!-- <div class="col-md-6"> -->
					<input type="password" class="form-control form-input" id="txt_profile_old_password"
						placeholder="Old Password" name="password">
					<!-- </div> -->
				</div>
				<div class="form-group">
					<label for="txt_profile_new_password" class="form-label">New Password</label>
					<!-- <div class="col-md-6"> -->
					<input type="password" class="form-control form-input" id="txt_profile_new_password"
						placeholder="New Password" name="new_password">
					<!-- </div> -->
				</div>
				<div class="form-group">
					<label for="txt_profile_new_password" class="form-label">Confirm Password</label>
					<!-- <div class="col-md-6"> -->
					<input type="password" class="form-control form-input" id="txt_profile_new_confirm_password"
						placeholder=" Confirm Password" name="confirmPassword">
					<!-- </div> -->
				</div>
				<div class="form-group row space add_btn">
					<!-- <input type="button" class="btn btn-success ctrl-btn btn-space" value="Save" onclick="saveChangesPassword('password');"/>
								 <input type="reset" class="btn btn-primary btn-space" value="Reset" onclick="reset_profile_password();"/> -->
					<input type="button" class="save_btn_bg_cancel changepassword" value="Save"
						onclick="saveChangesPassword('password');" />
					<input type="reset" class="save_btn_bg_cancel" value="Reset"
						onclick="reset_profile_password();" />
				</div>
			</form>
			<!-- </div> -->
		</div>
	</div>
	<!-- </div> -->
	<!-- </div> -->
	<!-- </div> -->
	<!--------- dash board footer------------------------------------------------>
	<div class="footer-fixed"><?php include_once 'footer.php' ?></div>
	<script type="text/javascript" src="js/dmstree_js/profile_page.js"></script>
</body>

</html>