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
        
    $userId = '';
    if(isset($_SESSION['userid']))
    {
       $userId = $_SESSION['userid']; 
    }
    $result=$g1->get_mongodb->getNoticeInfo($userId);
	//var_dump($result);
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
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
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
            window.onload = function(){
                value = <?php echo $filesize ?>;
                max = <?php echo $activepackspace*1000 ?>;
                if (document.getElementById('g1')) {
                    showmeter(value,max);
                }
            };
            $(document).ready(function(){
            var directoryspace = <?php echo $tenantspace?>;
                  var tenantspace    = <?php echo $activepackspace?>;
                  if(parseFloat(directoryspace) >= parseFloat(tenantspace))
                      {
                          //alert('dir'+directoryspace);
                          $('input').attr('disabled','disabled');
                          $('button').attr('disabled','disabled');
                          $('select').attr('disabled','disabled');
                          $('textarea').attr('disabled','disabled');
                          
                          $('input').css('opacity','0.5');
                          $('button').css('opacity','0.5');
                          $('select').css('opacity','0.5');
                          $('textarea').css('opacity','0.5');
                          var spacemsg = 'Package Size is full';
                          $('.spaceerror').text(spacemsg);    
                      }
                  else
                      {
                          $('button').removeAttr('disabled');
                          $('input').removeAttr('disabled');
                          $('select').removeAttr('disabled');
                          $('textarea').removeAttr('disabled');
                          $('.spaceerror').text(''); 
                      }
            });  
        </script>
    </head>
    <body >
        

        <!----------- Header page--------------------------------------------->
       <?php include_once 'header.php'; ?> 

        <div class="row row-margin">
            <div class="col-md-3 col-sm-3 div-padding-top">
                <!--------- dash board side menu------------------------------------------------>
                <?php include_once'dash_menu.php'?>  
            </div>
            <div class="col-md-9 col-sm-9 div-padding-left" id="">
            <div class="row">
                            <p class="spaceerror col-md-12" style="color:red"> </p>
            </div>    
				<div class="div-padding-top">
					<button class="btn btn-success" data-toggle="modal" data-target="#myModal">Create Notice</button>
				</div>			
				<div class="div-padding-top">
					<div class="problem">
						<?php 
                                                if($result != null)
                                                {    
                                                foreach($result as $key)
							{
								if(empty($key['NoticeImage']))
								{
						?>
							<div class="well" >
								<div class="row">
									<!--<div class="col-md-9 col-sm-9 ">-->
										<div class="row">
											<div class="col-md-9 col-sm-9">
												<div class="div-padding">
														<a><i>Notice Category:</i></a><?php echo $key['NoticeCategory']; ?>
												</div>
											</div>
											<div class="col-md-3 col-sm-3 date colour">
												<?php date_default_timezone_set('Asia/Calcutta');	$date = $key['NoticeDate'];	echo date('Y-M-d', $date->sec); ?>
											</div>
										</div>
										<div class="more-comment div-padding" >
											<a><i>Notice Title:</i></a><?php echo $key['NoticeTitle']; ?>
										</div>
										<div class="more-comment div-padding">
											<a><i>Description:</i></a><article> <?php echo $key['NoticeDescription']; ?></article>
										</div>
									<!--</div>-->
									<!--<div class="col-md-3 col-sm-3">
										<img src="img/Koala.jpg" id="notice_image1" class="img-responsive" style="height:150px;width:100%;"/>
									</div>-->
								</div>
							</div>
							<?php
								}
								else
								{
							?>
							<div class="well" >
								<div class="row">
									<div class="col-md-9 col-sm-9 ">
										<div class="row">
											<div class="col-md-9 col-sm-9">
												<div class="div-padding">
														<a><i>Notice Category:</i></a><?php echo $key['NoticeCategory']; ?>
												</div>
											</div>
											<div class="col-md-3 col-sm-3 date colour">
												<?php date_default_timezone_set('Asia/Calcutta');	$date = $key['NoticeDate'];	echo date('Y-M-d h:i:s', $date->sec); ?>
											</div>
										</div>
										<div class="more-comment div-padding" >
											<a><i>Notice Title:</i></a><?php echo $key['NoticeTitle']; ?>
										</div>
										<div class="more-comment div-padding">
											<a><i>Description:</i></a><article> <?php echo $key['NoticeDescription']; ?></article>
										</div>
									</div>
									<div class="col-md-3 col-sm-3">
										<img src="DMSTree_clients/<?php echo $tenantname.'_'.$tenantid; ?>/Images/<?php echo $key['NoticeImage'];?>" id="notice_image1" class="img-responsive" style="height:130px;width:100%;"/>
									</div>
								</div>
							</div>
							
						<?php } } }?>
					</div>
				</div>
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									<h4 class="modal-title" id="myModalLabel">Create Notice</h4>
							</div>
							<div class="modal-body">
								<form name="form_notice" id="form_notice" method="post" action="" enctype="multipart/form-data">
									<div class="form-group row space">
										<label for="sel_problem_category" class="col-md-3 control-label" id="txt_problem_category">Notice Category</label>
										<div class="col-md-6">
											<input list="notice_category" name="notice_category" id="list" class="form-control">
												<datalist id="notice_category">
													<!--<option value="select" id="select_std_list">Select </option>-->
													<option value="Creating Template" id="select_std_list1">Creating Template</option>
													<option value="Add Tags" id="select_std_list2">Adding Tags</option>
													<option value="Uploading Document" id="select_std_list3">Uploading Document </option>
													<option value="Profile Update" id="select_std_list4">Profile Update</option>
												</datalist>
										</div>
									</div>
									<div class="form-group row space">
										<label for="txt_notice_title" class="col-md-3 control-label" id="">Notice Title</label>
										<div class="col-md-6">
											<input type="text" class="form-control" id="txt_notice_title" placeholder="Notice Title" name="notice_title">	
										</div>
									</div>
									<div class="form-group row space">
										<label for="txt_notice_description" class="col-md-3 control-label" id="">Notice Description</label>
										<div class="col-md-6">
											<textarea class="form-control" id="txt_notice_description" rows="3" placeholder="Notice Description" name="notice_description"></textarea>	
										</div>
									</div>
									<div class="form-group row space">
										<label for="txt_notice_expiry_date" class="col-md-3 control-label" id="">Notice Valid Till</label>
										<div class="col-md-6">
											<div class='input-group date' id='datetimepicker' data-date-format="DD/MM/YYYY">
												<input type='text' class="form-control date1" id="expiry_date" name="date" value="" readonly/>
												<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
												</span>
											</div>	
										</div>
									</div>
									<div class="form-group row space">
										<label for="txt_notice_image" class="col-md-3 control-label" id="">Image</label>
										<div class="col-md-6">
											<input type="file" id="txt_notice_image" name="notice_img" />	
										</div>
									</div>
									<div class="form-group row space">
										<div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3">
											<img src="" id="notice_image" class="img-responsive" style="height:90px;width:100%;"/>
										</div>
									</div>
								</form>
							</div>
		
							<div class="modal-footer control-label form-model-padding">
								<button class="btn btn-primary btn-space" type="button" id="sub"  onclick="saveNotice();">Send & Save</button>
								<button type="reset" class="btn btn-default" data-dismiss="modal" onclick="clearForm();">Close </button>
							</div>
						</div>
					</div>
				</div>
			</div>				
        </div>
        <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
		<!--<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>-->
		<script src="js/dmstree_js/readmore.js"></script>
		<script src="jqueryui/ui/minified/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/dmstree_js/notice_board_page.js"></script>

    </body>
</html>