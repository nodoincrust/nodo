<?php
	ob_start();
	session_start();
        $idletime=1200;//after 20 min the user gets logged out
        if (time()-$_SESSION['timestamp']>$idletime){
            session_destroy();
            session_unset();
            header('Location:login.php');
        }else{
            $_SESSION['timestamp']=time();
        }
	include 'session_config.php';
	require('../CodeIgniter-old/external.php');
        $ci = & get_instance();
        $ci->load->library("cimongo/cimongo");
        $ci->load->model('get_mongodb');
        $g1 = new Get_mongodb();
	$userId = $_SESSION['userid'];
	$tenantId = $_SESSION['usertenant'];
	$result = $g1->get_mongodb->getPackages();
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Dash-Board</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
		
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	<script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
   	</head>
    <body>
        <?php include_once 'admin_header.php'; ?> 
        <div class="row row-margin">
			<div class="col-md-2 col-sm-2 div-padding-top" id="body1">
				<?php include_once'admin_dash_menu.php'?>  
			</div>
			<div class="col-md-10 col-sm-10 div-padding-top" id="body-content">
				<div class="well container-narrow">
					<div class="row">
						<div class="col-md-12 form_title "><h2 class="text-muted"><b>Packages</b></h2></div>
							<form id="package_form" method="post" class="form-horizontal col-md-12 form-action" action="" >
								<div class="form-group row ">
									<label for="txt_user_mail" class="col-md-4 control-label">Package Selected</label>
									<div class="col-md-6">
											<select id="package" class="form-control selectpicker col-md-6" name="package" readonly>
												<option id='' value=""></option>
												<?php foreach($result as $key)
													{
														if(!$key['AuditData']['DeleteFlag'])
														{
												?>
															<option value="<?php echo $key['PackageName']?>" id="<?php echo $key['_id']?>"><?php echo $key['PackageName']?></option>
												<?php 	} 
													}
												?>
											</select>
									</div>
								</div>
								<div id = "package_info">
										<div class="form-group row ">
											<label for="package_name" class="col-md-4 control-label">Package Name</label>
											<div class="col-md-6">
												<input type="text" class="form-control" id="package_name" placeholder="Package Name" value="" name="package_name">
											</div>
										</div>
										<div class="form-group row ">
											<label for="package_type" class="col-md-4 control-label">Package Type</label>
											<div class="col-md-6">
												<select id="package_type" class="form-control selectpicker" name="package_type">
													<option id='' value=""></option>
													<option value="individual"> Individual </option>
													<option value="corporate"> Corporate </option>
												</select>
											</div>
										</div>
										<div class="form-group row ">
											<label for="duration_or_size" class="col-md-4  control-label">Duration Or Size</label>
											<div class="col-md-6">
												<select id="duration_or_size" class="form-control selectpicker" name="duration_or_size">
													<option id='' value=""></option>
													<option value="duration"> Duration </option>
													<option value="size"> Size </option>
												</select>
											</div>	
										</div>
										<div class="form-group row hide">
											<label for="txt_user_mail" class="col-md-4 control-label"></label>
											<div class="col-md-6">
												<input type="text" class="form-control add-more " id="txt_size" placeholder="" name="size">
											</div>
										</div>
										<div class="form-group row ">
											<label for="package_base_rate" class="col-md-4 control-label">Package Base Rate</label>
											<div class="col-md-6">
												<input type="text" class="form-control add-more" id="package_base_rate" placeholder="Package Base Rate" name="package_base_rate">
											</div>
										</div>
										<div class="form-group row ">
											<label for="package_tax_percentage" class="col-md-4 control-label">Package Tax Percentage</label>
											<div class="col-md-6">
												<input type="text" class="form-control add-more" id="package_tax_percentage" placeholder="Package Tax Percentage" name="package_tax_percentage">
											</div>
										</div>
								</div>
								<div class="col-md-12">
									<input class="btn btn-success ctrl-btn  btn-space" type="button" value="Update" onclick="update_package();"/>
									<input type="button" class="btn btn-primary btn-space" value="Delete" onclick="delete_package();">
									<input type="button" class="btn ctrl-btn btn-space " value="Reset">
								</div>
							</form>
					</div>
				</div>
				
			</div>
        </div>
        <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
		<script src="js/dmstree_js/package_update_page.js"></script>
    </body>
</html>