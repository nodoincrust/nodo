<?php
	ob_start();
	session_start();
	include 'session_config.php';
	require('../CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
	$g1 = new Get_mongodb();
	$userId =  $_SESSION['userid'];// $_SESSION['val']['id'];
	$result=$g1->get_mongodb->getUserInfo($userId);
	//var_dump($result);
	$userEmailId =$result[0]['LoginInfo']['EmailId'];
	//echo $userEmailId;
	$reportInfo = $g1->get_mongodb->getReportProblemInfo();//$userId);
	//$reportId = $reportInfo[0]['_id'];
        //var_dump($reportInfo);
	//$defectInfo = $g1->get_mongodb->getReportDetailInfo($reportId);
        //echo $userEmailId;
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Dash-Board</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="bootstrap-dialog/css/bootstrap-dialog.css">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>        
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>        
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="js/dmstree_js/bootstrap-select.js"></script>
        <script type="text/javascript" src="bootstrap-dialog/js/bootstrap-dialog.js"></script>
	        
    </head>
    <body >

        <?php include_once 'header.php'; ?> 
        <div class="row row-margin">
            <div class="col-md-3">
                <!--------- dash board side menu------------------------------------------------>
                <?php include_once'admin_dash_menu.php'?>  
            </div>
<!--            <div class="div-padding-top">
                    <button class="btn" data-toggle="modal" data-target="#myModal"> Report a problem</button>
            </div>			-->
            <div class="col-md-9 div-padding-top">
                <div class="problem">
                    <?php 
                        foreach($reportInfo as $key)
                        {
                            $index = sizeOf($key['DefectLogHistory']);
                            if($key['DefectLogHistory'][$index-1]['DefectStatus'] != 'Closed')
                            {
                                    //var_dump($key);
                    ?>
                    <div class="well">
                        <div class="row" id="report1">
                            <div class="col-md-12 ">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="div-padding">
                                            <a><i>Problem Category:</i></a><?php if(empty($key['IssueCategory'])){ echo 'Not Defined';}else{echo $key['IssueCategory'];} ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3 date colour">
                                        <?php date_default_timezone_set('Asia/Calcutta'); $date = $key['DateRaisedOn']; echo date('d-M-Y h:m:s', $date->sec) ?>
                                    </div>
                                </div>
                                <div class="row  div-padding more-comment">
                                    <div class="col-md-10" >
                                        <a><i>Problem Title:</i></a> <?php echo $key['IssueTitle']; ?>
                                    </div>
                                    <div class="col-md-2" >
                                        <a><i>
                                            <?php 
                                                
                                                echo $key['DefectLogHistory'][$index-1]['DefectStatus']; 
                                            ?>
                                        </i></a> 
                                    </div>
                                </div>
                                <div class="row div-padding more-comment">
                                    <div class=" col-md-10">
                                        <a><i>Description:</i></a><article><?php echo $key['IssueDescription']; ?></article>
                                    </div>
                                    <div class = "col-md-2">
                                        <a class="cursor" onclick = "show_defect_log_history('<?php echo $key['_id']; ?>');"><i>View Details</i></a>
                                    </div>
                                </div>
<!--                                <div class="row div-padding more-comment">
                                    <div class=" col-md-10">
                                    </div>
                                    <div class = "col-md-2">
                                        <input type="button" class="btn btn-default" value="Reply" onclick="">
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                        <?php
                                    }
                                }
                        ?>
               </div>
           </div>
			
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">Report Problem</h4>
                            </div>
                            <div class="modal-body">
                                <form name="formReport" id="form_report" method="post" action="">
                                    <div class="form-group row space">
                                        <label for="sel_problem_category" class="col-md-3 control-label" id="txt_problem_category">Problem Category</label>
                                        <div class="col-md-6 selectContainer">
                                            <select class="form-control selectpicker" id="sel_problem_category" name="problem_category">	
                                                <option value=""></option>
                                                <option value="Creating Template" id="select_std_list1">Creating Template</option>
                                                <option value="Add Tags" id="select_std_list2">Adding Tags</option>
                                                <option value="Uploading Document" id="select_std_list3">Uploading Document </option>
                                                <option value="Profile Update" id="select_std_list4">Profile Update</option>
                                            </select>	
                                        </div>
                                    </div>
                                    <div class="form-group row space">
                                        <label for="txt_report_title" class="col-md-3 control-label" id="lab_description">Problem Title</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" id="txt_report_title" placeholder="Problem Title" name="report_type">
                                        </div>
                                    </div>
                                    <div class="form-group row space">
                                        <label for="txt_area_description" class="col-md-3 control-label" id="lab_description">Description</label>
                                        <div class="col-md-6">
                                            <textarea rows="5" cols="40"  placeholder="Type Your Description" id="txtarea_description" name="txtarea_report"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row space">
                                        <label for="txtarea_comments" class="col-md-3 control-label" id="lab_problem_destiny">Comments</label>
                                        <div class="col-md-6">
                                                <textarea rows="5" cols="40"  placeholder="Type Your Description" id="txtarea_comments" name=""></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group modal-footer">
                                            <input type="button" class="btn btn-success ctrl-btn  btn-space" onclick="send()"  id="btnSubmit" value="Send"/>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <!--<button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="sendProblem();">Send</button>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                      </div>
                    </div>
		</div>
         <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
        <script src="js/dmstree_js/readmore.js"></script>
        <script type="text/javascript" src="js/dmstree_js/admin_problem_managed_page.js"></script>
    </body>
</html>

