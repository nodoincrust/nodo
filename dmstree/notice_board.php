<?php

ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
require('../CodeIgniter-old/external.php');
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
$tenantspace = (float)$tenantspace;
$filesize = (float)fileSizeInMB($ar['size']);
$activepackspace = $g1->get_mongodb->getActivePackageSize($tenantid);
$activepackspace = (float)$activepackspace;

$userId = '';
if (isset($_SESSION['userid'])) {
	$userId = $_SESSION['userid'];
}
$result = $g1->get_mongodb->getNoticeInfo($userId);
//var_dump($result);
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
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
	<link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css" />
	<link rel="stylesheet" href="css/jquery.tag-editor.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">

	<script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
	<script type="text/javascript" src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
	<script type="text/javascript" src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
	<script type="text/javascript" src="js/dmstree_js/bootstrap-select.js"></script>
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
				//alert('dir'+directoryspace);
				$('input').attr('disabled', 'disabled');
				$('button').attr('disabled', 'disabled');
				$('select').attr('disabled', 'disabled');
				$('textarea').attr('disabled', 'disabled');

				$('input').css('opacity', '0.5');
				$('button').css('opacity', '0.5');
				$('select').css('opacity', '0.5');
				$('textarea').css('opacity', '0.5');
				var spacemsg = 'Package Size is full';
				$('.spaceerror').text(spacemsg);
			} else {
				$('button').removeAttr('disabled');
				$('input').removeAttr('disabled');
				$('select').removeAttr('disabled');
				$('textarea').removeAttr('disabled');
				$('.spaceerror').text('');
			}
		});
	</script>
</head>
<style>
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

	body {
		font-family: 'Inter', Arial, sans-serif;
		overflow: hidden;
	}

	.create-notice-btn {
		background-color: #1B5563;
		color: #fff;
		font-weight: 600;
		border: 1px solid #ccc;
	}

	.notice-head {
		display: flex;
	}

	.notice-desc {
		display: flex;
	}

	.notice-descri-val {
		margin-left: 5px;
		display: flex;
		align-items: center;
	}

	.notice-date {
		display: flex;
		justify-content: end;
		align-items: center;
	}

	.notice-descri {
		margin-left: 13px;
	}

	.notice-title {
		margin-left: 13px;

	}

	.div-padding1 {
		padding: 10px;
	}

	.div-padding2 {
		padding: 10px;

	}

	.div-padding3 {
		padding: 10px;

	}

	.notice-label,

	.notice-title,

	.notice-descri {

		display: inline-block;

		border-radius: 6px;

		padding: 4px 10px;

		font-size: 0.95em;

		margin-right: 8px;

		/* margin-bottom: 4px; */

		background: #FFFCC2;

		color: #835101;

		font-family: 'Inter', Arial, sans-serif;

		font-weight: 600;

	}

	.notice-title2 {
		font-size: 16px;
		font-weight: 700;
		font-family: 'Space Grotesk', Arial, sans-serif;
		color: #1B5563 !important;
	}

	/* Modern Modal Styles */
	.modal-dialog {
		max-width: 500px;
		margin: 30px auto;
	}

	.modal-content {
		border-radius: 12px;
		border: none;
		box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
	}

	.modal-header {
		border-bottom: 1px solid #e9ecef;
		padding: 20px 24px 16px;
		background: #fff;
		border-radius: 12px 12px 0 0;
	}

	.modal-title {
		font-size: 22px;
		font-weight: 700;
		font-family: 'Space Grotesk', Arial, sans-serif;
		color: #1B5563;
		margin: 0;
	}

	.modal-body {
		padding: 24px;
		background: #fff;
	}

	.form-group {
		margin-bottom: 20px;
	}

	.form-group label {
		font-weight: 500;
		color: #374151;
		margin-bottom: 8px;
		display: block;
	}

	.form-control {
		border: 1px solid #d1d5db;
		border-radius: 8px;
		padding: 12px 14px;
		font-size: 14px;
		transition: all 0.2s ease;
		background: #fff;
		width: 100%;
	}

	.form-control:focus {
		border-color: #1B5563;
		box-shadow: 0 0 0 3px rgba(27, 85, 99, 0.1);
		outline: none;
	}

	.form-control::placeholder {
		color: #9ca3af;
	}

	textarea.form-control {
		resize: vertical;
		min-height: 80px;
	}

	/* Date picker styling */
	.input-group {
		position: relative;
		display: flex;
		width: 100%;
	}

	.input-group .form-control {
		border-radius: 8px 0 0 8px;
		flex: 1;
	}

	.input-group-addon {
		background: #f8f9fa;
		border: 1px solid #d1d5db;
		border-left: none;
		border-radius: 0 8px 8px 0;
		/* padding: 12px 14px; */
		color: #6b7280;
		display: flex;
		align-items: center;
	}

	/* File upload area */
	.file-upload-area {
		border: 2px dashed #d1d5db;
		border-radius: 8px;
		padding: 40px 20px;
		text-align: center;
		background: #fafafa;
		transition: all 0.2s ease;
		cursor: pointer;
		position: relative;
	}

	.file-upload-area:hover {
		border-color: #1B5563;
		background: #f8faff;
	}

	.file-upload-area.dragover {
		border-color: #1B5563;
		background: #f0f7ff;
	}

	.upload-icon {
		font-size: 24px;
		color: #6b7280;
		margin-bottom: 12px;
	}

	.upload-text {
		color: #374151;
		font-weight: 500;
		margin-bottom: 4px;
	}

	.upload-subtext {
		color: #9ca3af;
		font-size: 12px;
		margin-bottom: 16px;
	}

	.browse-btn {
		background: #fff;
		border: 1px solid #d1d5db;
		border-radius: 6px;
		padding: 8px 16px;
		font-size: 14px;
		color: #374151;
		cursor: pointer;
		transition: all 0.2s ease;
	}

	.browse-btn:hover {
		background: #f9fafb;
		border-color: #9ca3af;
	}

	.file-input {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		opacity: 0;
		cursor: pointer;
	}

	/* Image preview */
	.image-preview {
		margin-top: 16px;
	}

	.image-preview img {
		max-width: 100%;
		height: 120px;
		object-fit: cover;
		border-radius: 8px;
		border: 1px solid #e5e7eb;
	}

	.preview-placeholder {
		width: 100%;
		height: 120px;
		background: #fef3cd;
		border-radius: 8px;
		display: flex;
		align-items: center;
		justify-content: center;
		border: 1px solid #fbbf24;
	}

	.preview-icon {
		font-size: 40px;
		color: #f59e0b;
	}

	/* Modal footer */
	.modal-footer {
		border-top: 1px solid #e9ecef;
		padding: 16px 24px;
		background: #fff;
		border-radius: 0 0 12px 12px;
		text-align: right;
	}

	.btn {
		border-radius: 8px;
		padding: 10px 20px;
		font-weight: 500;
		font-size: 14px;
		transition: all 0.2s ease;
		border: none;
		cursor: pointer;
	}

	.btn-primary {
		background: #1B5563;
		color: white;
	}

	.btn-primary:hover {
		background: #164047;
	}

	.btn-default {
		background: #fff;
		color: #6b7280;
		border: 1px solid #d1d5db;
		margin-right: 12px;
	}

	.btn-default:hover {
		background: #f9fafb;
		border-color: #9ca3af;
	}

	.close {
		position: absolute;
		top: 16px;
		right: 20px;
		font-size: 24px;
		font-weight: 300;
		color: #9ca3af;
		opacity: 1;
		border: none;
		background: none;
		cursor: pointer;
		padding: 4px;
	}

	.close:hover {
		color: #6b7280;
	}

	/* Bootstrap 3 overrides for the modal */
	.modal-dialog .row {
		margin: 0;
	}

	.modal-dialog .col-md-3,
	.modal-dialog .col-md-6 {
		padding: 0;
	}

	.modal-dialog .form-group.row {
		margin-bottom: 20px;
	}

	.modal-dialog .space {
		margin-bottom: 20px;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.modal-dialog {
			margin: 20px;
			max-width: none;
		}

		.modal-body {
			padding: 20px;
		}

		.file-upload-area {
			padding: 30px 15px;
		}
	}

	.modal-body {
		max-height: 60vh;
		/* 60% of viewport height */
		overflow-y: auto;
		padding-right: 15px;
		/* to avoid content hiding under scrollbar */
	}

	#body-content3 {
		padding-bottom: 85px;
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
</style>

<body>

	<!----------- Header page--------------------------------------------->
	<?php include_once 'header.php'; ?>

	<div class="row row-margin">
		<div class="col-md-3 col-sm-3" style="background-color: #FFFFFF;">
			<!--------- dash board side menu------------------------------------------------>
			<?php include_once 'dash_menu.php' ?>
		</div>
		<!-- <div class="col-md-9 col-sm-9" id=""> -->
		<div class="col-md-9 div-padding-left" id="body-content3">
			<div class="row">
				<p class="spaceerror col-md-12" style="color:red"> </p>
			</div>
			<div class="div-padding-top">
				<button class="btn create-notice-btn" data-toggle="modal" data-target="#myModal">Create Notice</button>
			</div>
			<div class="div-padding-top">
				<div class="problem">
					<?php
					if ($result != null) {
						foreach ($result as $key) {
							if (empty($key['NoticeImage'])) {
					?>
								<div class="well">
									<div class="row">
										<!--<div class="col-md-9 col-sm-9 ">-->
										<div class="row">
											<div class="col-md-8 col-sm-8">
												<div class="div-padding">
													<a class="notice-label"><i>Notice Category:</i></a>
													<span class="notice-category"><?php echo $key['NoticeCategory']; ?></span>
												</div>
											</div>
											<div class="col-md-4 col-sm-4 date colour">
												<?php date_default_timezone_set('Asia/Calcutta');
												$date = $key['NoticeDate'];
												echo date('Y-M-d', $date->sec); ?>
											</div>
										</div>
										<div class="more-comment div-padding">
											<a>Notice Title:</a>
											<span class="notice-title"><?php echo $key['NoticeTitle']; ?></span>
										</div>
										<div class="more-comment div-padding notice-desc">
											<a>Description:</a>
											<article> <?php echo $key['NoticeDescription']; ?></article>
										</div>
									</div>
								</div>
							<?php
							} else {
							?>
								<div class="well">
									<div class="row">
										<div class="col-md-9 col-sm-9 ">
											<div class="row notice-head">
												<div class="col-md-8 col-sm-8">
													<div class="div-padding1">
														<span class="notice-label">
															Notice Category: <?php echo $key['NoticeCategory']; ?>
														</span>
													</div>
												</div>

												<div class="col-md-4 col-sm-4 date colour notice-date">
													<?php date_default_timezone_set('Asia/Calcutta');
													$date = $key['NoticeDate'];
													echo date('Y-M-d h:i:s', $date->sec); ?>
												</div>
											</div>
											<div class="more-comment div-padding2">
												<a class="notice-title">Notice Title:</a>
												<span class="notice-title2"><?php echo $key['NoticeTitle']; ?></span>
											</div>

											<div class="more-comment div-padding3 notice-desc">
												<a class="notice-descri">Description:</a>
												<article class="notice-descri-val"> <?php echo $key['NoticeDescription']; ?></article>
											</div>

										</div>
										<div class="col-md-3 col-sm-3">
											<img src="DMSTree_clients/<?php echo $tenantname . '_' . $tenantid; ?>/Images/<?php echo $key['NoticeImage']; ?>" id="notice_image1" class="img-responsive" style="height:130px;width:100%;" />
										</div>
									</div>
								</div>

					<?php }
						}
					} ?>
				</div>
			</div>

			<!-- Modern Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">&times;</span>
								<span class="sr-only">Close</span>
							</button>
							<h4 class="modal-title" id="myModalLabel">Create Notice</h4>
						</div>
						<div class="modal-body">
							<form name="form_notice" id="form_notice" method="post" action="" enctype="multipart/form-data">
								<div class="form-group">
									<label for="notice_category_input">Notice Category</label>
									<input list="notice_category" name="notice_category" id="notice_category_input" class="form-control" placeholder="Type or Select Notice Category">
									<datalist id="notice_category">
										<option value="Creating Template">Creating Template</option>
										<option value="Add Tags">Adding Tags</option>
										<option value="Uploading Document">Uploading Document</option>
										<option value="Profile Update">Profile Update</option>
									</datalist>
								</div>

								<div class="form-group">
									<label for="txt_notice_title">Notice Title</label>
									<input type="text" class="form-control" id="txt_notice_title" placeholder="Enter Notice Title" name="notice_title">
								</div>

								<div class="form-group">
									<label for="txt_notice_description">Notice Description</label>
									<textarea class="form-control" id="txt_notice_description" rows="3" placeholder="Enter Notice Description" name="notice_description"></textarea>
								</div>

								<div class="form-group">
									<label for="expiry_date">Notice Valid Till</label>
									<div class='input-group date' id='datetimepicker' data-date-format="DD/MM/YYYY">
										<input type='text' class="form-control date1" id="expiry_date" name="date" value="" readonly placeholder="Enter Notice Title" />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-time"></span>
										</span>
									</div>
								</div>

								<div class="form-group">
									<div class="file-upload-area" id="fileUploadArea">
										<div class="upload-icon"><img src="img/Upload Icon.svg" alt=""></div>
										<div class="upload-text">Drag and Drop your Image here</div>
										<div class="upload-subtext">Only .png, .jpg, .jpeg</div>
										<button type="button" class="browse-btn" onclick="document.getElementById('txt_notice_image').click()">Browse Files</button>
										<input type="file" id="txt_notice_image" name="notice_img" class="file-input" accept=".png,.jpg,.jpeg" />
									</div>
								</div>

								<div class="form-group">
									<label>Image Preview</label>
									<div class="image-preview">
										<!-- <div class="preview-placeholder" id="imagePlaceholder">
											<div class="preview-icon">🔒</div>
										</div> -->
										<img src="" id="notice_image" class="img-responsive" style="display: none;" />
									</div>
								</div>
							</form>
						</div>

						<div class="modal-footer">
							<button class="btn btn-primary" type="button" id="sub" onclick="saveNotice();">Save</button>
							<button type="button" class="btn btn-default" data-dismiss="modal" onclick="clearForm();">Cancel</button>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>
	<div class="footer-fixed"><?php include_once 'footer.php' ?></div>

	<!--------- dash board footer------------------------------------------------>
	<!--<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>-->
	<script src="js/dmstree_js/readmore.js"></script>
	<script src="jqueryui/ui/minified/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/notice_board_page.js"></script>

	<script>
		// Modern file upload functionality
		$(document).ready(function() {
			const fileUploadArea = document.getElementById('fileUploadArea');
			const fileInput = document.getElementById('txt_notice_image');
			const imagePreview = document.getElementById('notice_image');
			const imagePlaceholder = document.getElementById('imagePlaceholder');

			// Drag and drop functionality
			fileUploadArea.addEventListener('dragover', function(e) {
				e.preventDefault();
				fileUploadArea.classList.add('dragover');
			});

			fileUploadArea.addEventListener('dragleave', function() {
				fileUploadArea.classList.remove('dragover');
			});

			fileUploadArea.addEventListener('drop', function(e) {
				e.preventDefault();
				fileUploadArea.classList.remove('dragover');
				const files = e.dataTransfer.files;
				if (files.length > 0) {
					handleFileSelect(files[0]);
				}
			});

			// File input change
			fileInput.addEventListener('change', function(e) {
				if (e.target.files.length > 0) {
					handleFileSelect(e.target.files[0]);
				}
			});

			// Handle file selection
			function handleFileSelect(file) {
				if (file && file.type.startsWith('image/')) {
					const reader = new FileReader();
					reader.onload = function(e) {
						imagePreview.src = e.target.result;
						imagePreview.style.display = 'block';
						imagePlaceholder.style.display = 'none';
					};
					reader.readAsDataURL(file);
				}
			}

			// Clear form function enhancement
			window.clearForm = function() {
				document.getElementById('form_notice').reset();
				imagePreview.style.display = 'none';
				if (imagePlaceholder) {
					imagePlaceholder.style.display = 'flex';
				}
				imagePreview.src = '';
			};
		});
	</script>

</body>

</html>