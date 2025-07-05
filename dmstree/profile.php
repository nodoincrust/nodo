<?php
	ob_start();
	session_start();
        include 'session_timeout.php';
	include 'session_config.php';
	require('../CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
	$g1 = new Get_mongodb();
        
        $userdepartid = '';
        $tenantid = '';
        $tenantname = '';
        if(isset($_SESSION['userdepartmentid'] ))
        {
            $userdepartid = $_SESSION['userdepartmentid'];
        }  
        if(isset($_SESSION['usertenant']))
        {
            $tenantid = $_SESSION['usertenant'];
        } 
        if(isset($_SESSION['tenantname']))
        {
            $tenantname = $_SESSION['tenantname'];
            $tenantname = str_replace(" ","_",$tenantname);
        }
        
        $path='DMSTree_clients/'.$tenantname.'_'.$tenantid; 
        $ar=getDirectorySize($path);
        $tenantspace = sizeFormat($ar['size']);
        $tenantspace = (float)$tenantspace;
        $filesize = (float)fileSizeInMB($ar['size']);
        $activepackspace = $g1->get_mongodb->getActivePackageSize($tenantid);
        $activepackspace = (float)$activepackspace;

?>


<html>
    <head>
        <meta charset="utf-8">
        <title>Dash-Board</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="discription" content="">
        <meta name="author" content="">

        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
        <link rel="stylesheet" href="css/fileinput.min.css"/>
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
             window.onload = function(){
                value = <?php echo $filesize ?>;
                max = <?php echo $activepackspace*1000 ?>;
                showmeter(value,max);
            };
            $(document).ready(function(){
            var directoryspace = <?php echo $tenantspace?>;
                  var tenantspace    = <?php echo $activepackspace?>;
                  if(parseFloat(directoryspace) >= parseFloat(tenantspace))
                      {
                          $('input').attr('disabled','disabled');
                          $('button').attr('disabled','disabled');
                          $('input').css('opacity','0.5');
                          $('button').css('opacity','0.5');
                          var spacemsg = 'Package Size is full';
                          $('.spaceerror').text(spacemsg);    
                      }
                  else
                      {
                          $('button').removeAttr('disabled');
                          $('input').removeAttr('disabled');
                          $('.spaceerror').text(''); 
                      }
            });  
        </script>
		<style>
			
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
    background: #c4d1dc; /* Active button background */
}

.navbar-nav li a.inactive {
    background: #F8FF8A; /* Inactive button background */
}
 .add_btn{
                display:flex;
                gap:8px;
                justify-content:end;
                
            }
		</style>
    </head>
    <body >
    <!----------- Header page--------------------------------------------->
	<div id="header">
		<?php include_once 'header.php'; ?> 
	</div>	
        <div class="row row-margin">
			<!-- <div class="row row-margin  div-padding-top"> -->
			<div class="col-md-3">
            <!--------- dash board side menu------------------------------------------------>
                <?php include_once'dash_menu.php'?>  
            </div>
            <div class="col-md-9 div-padding-top">
            <!-- <div class="row">
                <p class="spaceerror col-md-12" style="color:red"> </p>
            </div>     -->
			<div class="upload_temp well-padding">
				<!-- <div class="well well-padding"> -->
					<div class="row">
						<div class="col-md-12 prof_form_title"><h3 class="text-muted upload_doc_cls">Profile</h3>
					<ul class="nav navbar-nav navbar-right">
									<li><a id="profileBtn" class="prof_cls active"onclick="show('profile');" style="color: black;">Profile</a></li>
									<li><a  id="passwordBtn" class="pass_cls inactive" onclick="show('password');" style="color: black;">Password</a></li>
								</ul>
							</div>
					</div>
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
				</div>
				<div class="well" id="profile_profile">
					<?php  $userid = $_SESSION['userid']; $userinfo=$g1->get_mongodb->getUserInfo($userid); $tenantInfo = $g1->get_mongodb->getTenantInfo($userinfo[0]["TenantId"]);?>
					<div class="row" class="well-padding">
						<form class="well-padding" name="profile_info" id="profile_info">
							<div class="form-group row space">
								<label for="txt_profile_name" class="col-md-2 control-label" >Name</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id = "txt_profile_name" placeholder = "Name" name = "name" value = "<?php echo $userinfo[0]['Name'] ?>" readonly /> 
								</div>
							</div>
							<div class="form-group row space">
								<label for="txt_profile_contact" class="col-md-2 control-label">Contact</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="txt_profile_contact" placeholder="Contact" name="contact" value = "<?php echo $userinfo[0]['Contact'] ?>" readonly />
								</div>
							</div>
							<div class="form-group row space">
								<label for="txt_profile_add1" class="col-md-2 control-label ">Address 1</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="txt_profile_add1" placeholder="Address 1" name="add1" value = "<?php echo $tenantInfo[0]['AddressInfo']['Add1'] ?>" readonly />
								</div>
							</div>
							<div class="form-group row space">
								<label for="txt_profile_add2" class="col-md-2 control-label ">Address 2</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="txt_profile_add2" placeholder="Address 2" name="add2" value = "<?php echo $tenantInfo[0]['AddressInfo']['Add2'] ?>" readonly />
								</div>
							</div>
							<div class="form-group row space">
								<label for="txt_profile_city" class="col-md-2 control-label ">City</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="txt_profile_city" placeholder="City" name="city" value = "<?php echo $tenantInfo[0]['AddressInfo']['City'] ?>" readonly />
								</div>
							</div>
							<div class="form-group row space">
								<label for="txt_profile_pincode" class="col-md-2 control-label ">Pincode</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="txt_profile_pincode" placeholder="Pincode" name="pincode" value = "<?php echo $tenantInfo[0]['AddressInfo']['PinCode'] ?>" readonly />
								</div>
							</div>
							<div class="form-group row space">
								<label for="txt_profile_state" class="col-md-2 control-label ">State</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="txt_profile_state" placeholder="State" name="state" value = "<?php echo $tenantInfo[0]['AddressInfo']['State'] ?>" readonly />
								</div>
							</div>
							<div class="form-group row space">
								<label for="txt_profile_country" class="col-md-2 control-label ">Country</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="txt_profile_country" placeholder="Country" name="country" value = "<?php echo $tenantInfo[0]['AddressInfo']['Country'] ?>" readonly />
								</div>
							</div>
							<div class="form-group row space add_btn">
								<!-- <input type="button"  class="btn-hide btn btn-success ctrl-btn btn-space" value="Save" onclick="save_changes();"/>
                                 <input type="reset"  class="btn-hide btn ctrl-btn btn-space" value="Reset" onclick="cancel_changes();"/> -->
								 <input type="button"  class="save_btn_bg_cancel btn-success" value="Save" onclick="save_changes();"/>
                                 <input type="reset"  class="save_btn_bg_cancel btn-primary" value="Reset" onclick="cancel_changes();"/>
								<!-- <input type="button" class="btn ctrl-btn btn-space" value="Edit"  onclick="edit_form();"/> -->
								 <input type="button" class="save_btn_bg_cancel" value="Edit" style="color: black;" onclick="edit_form();"/>
							</div>	
						</form>
					</div>
				</div>
				<div class="well" id="profile_password">
					<div class="row">
						<form action="" method="post" id="profilePassword" name="" class=" well-padding" >
							<div class="form-group row space">
								<label for="txt_profile_old_password" class="col-md-2 control-label">Old Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="txt_profile_old_password" placeholder="Old Password" name="password">
								</div>
							</div>
							<div class="form-group row space">
								<label for="txt_profile_new_password" class="col-md-2 control-label">New Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="txt_profile_new_password" placeholder="New Password" name="new_password">
								</div>
							</div>
							<div class="form-group row space">
								<label for="txt_profile_new_password" class="col-md-2 control-label">Confirm Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control" id="txt_profile_new_confirm_password" placeholder=" Confirm Password" name="confirmPassword">
								</div>
							</div>
							<div class="form-group row space well-padding add_btn">
								 <!-- <input type="button" class="btn btn-success ctrl-btn btn-space" value="Save" onclick="saveChangesPassword('password');"/>
								 <input type="reset" class="btn btn-primary btn-space" value="Reset" onclick="reset_profile_password();"/> -->
								 <input type="button" class="save_btn_bg_cancel" value="Save" onclick="saveChangesPassword('password');"/>
								 <input type="reset" class="save_btn_bg_cancel" value="Reset" onclick="reset_profile_password();"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
        <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
	<script type="text/javascript" src="js/dmstree_js/profile_page.js"></script>
    </body>
</html>