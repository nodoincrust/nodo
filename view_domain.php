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
    require('CodeIgniter-old/external.php');
    $ci = & get_instance();
    $ci->load->library("cimongo/cimongo");
    $ci->load->model('get_mongodb');
    $g1 = new Get_mongodb();
    $userId = $_SESSION['userid'];
    $tenantId = $_SESSION['usertenant'];
    $result = $g1->get_mongodb->getStandardList($tenantId );
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
        <link rel="stylesheet" href="css/bootstrap-select.css">
		
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="js/dmstree_js/bootstrap-select.js"></script>
   	</head>
    <body>
        <?php include_once 'admin_header.php'; ?> 
        <div class="row row-margin">
			<div class="col-md-2 col-sm-2 div-padding-top" id="body1">
				<?php include_once'admin_dash_menu.php'?>  
			</div>
			<div class="col-md-10 col-sm-10 div-padding-top well" id="domain-contain">
				<div class ="row">
					<div class="col-md-12 form_title">
						<h2 class="text-muted">Domains List</h2>
					</div>
				</div>
				<div class="row">
                                    <div class="panel-group" id="accordion">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion" href="#addDomain"> Add New Domain</a>
                                                    </h4>
                                            </div>
                                            <div id="addDomain" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <form>
                                                        <div class="form-group row ">
                                                            <label for="domain_name" class="col-md-2 control-label">Domain Name</label>
                                                            <div class="col-md-6">
                                                                    <input type="text" class="form-control" id="domain_name" placeholder="Domain Name" value="" name="domain_name">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <input class="btn btn-success ctrl-btn  btn-space" type="button" value="Save" onclick="save_domain()"/>
                                                                <input type="reset" class="btn ctrl-btn btn-space " value="Reset">
                                                            </div>
                                                        </div>
                                                    </form>
                                                 </div>
                                           </div>
                                         </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion" href="#addsubDomain"> Add New Sub Domain</a>
                                                    </h4>
                                            </div>
                                            <div id="addsubDomain" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                         <form method="post" class="form-horizontal col-md-12 form-action" action="">
                                                                    <div class="form-group row ">
                                                                            <label for="domain_type" class="col-md-2 control-label">Select Domain Name</label>
                                                                            <div class="col-md-6">
                                                                                    <select id="domain_sub_type" class="form-control selectpicker " name="domain_type">
                                                                                            <option value=""></option>
                                                                                            <?php
                                                                                                    foreach($result[0]['List'] as $key)
                                                                                                    {
                                                                                                            if(!$key['AuditData']['DeleteFlag'])
                                                                                                            {
                                                                                            ?>
                                                                                                                    <option value="<?php echo $key['Description']?>"><?php echo $key['Description']?></option>
                                                                                            <?php
                                                                                                            }
                                                                                                    }
                                                                                            ?>
                                                                                    </select>
                                                                            </div>
                                                                    </div>
                                                                    <div class="form-group row ">
                                                                            <label for="domain_name" class="col-md-2 control-label">Sub Domain Name</label>
                                                                            <div class="col-md-6">
                                                                                    <input type="text" class="form-control" id="domain_sub_name" placeholder="Sub Domain Name" value="" name="domain_sub_name">
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                            <input class="btn btn-success ctrl-btn  btn-space" type="button" value="Save" onclick="save_sub_domain()"/>
                                                                            <input type="reset" class="btn ctrl-btn btn-space " value="Reset">
                                                                    </div>
                                                                    <input type="hidden" value="<?php echo $result[0]['_id'];?>" name="domain_id" id="domain_id"/>
                                                            </form>
                                                     </div>
                                           </div>
                                         </div>
                                         <div class="panel panel-default">
                                            <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion" href="#deleteDomain"> Delete Domain</a>
                                                    </h4>
                                            </div>
                                            <div id="deleteDomain" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <form method="post" class="form-horizontal col-md-12 form-action" action="">
                                                                <div class="form-group row ">
                                                                        <label for="domain_type" class="col-md-2 control-label">Select Domain Name</label>
                                                                        <div class="col-md-6">
                                                                                <select id="domain_type" class="form-control selectpicker " name="domain_type">
                                                                                        <option value=""></option>
                                                                                        <?php
                                                                                                foreach($result[0]['List'] as $key)
                                                                                                {
                                                                                                        if(!$key['AuditData']['DeleteFlag'])
                                                                                                        {
                                                                                        ?>
                                                                                                                <option value="<?php echo $key['Description']?>"><?php echo $key['Description']?></option>
                                                                                        <?php
                                                                                                        }
                                                                                                }
                                                                                        ?>
                                                                                </select>
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <input type="button" class="btn btn-primary btn-space" value="Delete" onclick="delete_domain();">
                                                                        <input type="reset" class="btn ctrl-btn btn-space " value="Reset">
                                                                </div>
                                                                <input type="hidden" value="<?php echo $result[0]['_id'];?>" name="domain_id" id="domain_id"/>
                                                        </form>
                                                     </div>
                                           </div>
                                         </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#accordion" href="#deleteSubDomain"> Delete Sub Domain</a>
                                                    </h4>
                                            </div>
                                            <div id="deleteSubDomain" class="panel-collapse collapse">
                                                    <div class="panel-body">
                                                        <form method="post" class="form-horizontal col-md-12 form-action" action="">
                                                                <div class="form-group row ">
                                                                        <label for="domain_type" class="col-md-2 control-label">Select Domain Name</label>
                                                                        <div class="col-md-6">
                                                                                <select id="delete_domain_type" class="form-control selectpicker " name="domain_type">
                                                                                        <option value=""></option>
                                                                                        <?php
                                                                                                foreach($result[0]['List'] as $key)
                                                                                                {
                                                                                                        if(!$key['AuditData']['DeleteFlag'])
                                                                                                        {
                                                                                        ?>
                                                                                                                <option value="<?php echo $key['Description']?>"><?php echo $key['Description']?></option>
                                                                                        <?php
                                                                                                        }
                                                                                                }
                                                                                        ?>
                                                                                </select>
                                                                        </div>
                                                                </div>
                                                                <div class="form-group row ">
                                                                        <label for="domain_name" class="col-md-2 control-label">Select Sub Domain Name</label>
                                                                        <div class="col-md-6">
                                                                            <select id="delete_sub_domain" class="form-control selectpicker " name="domain_type">
                                                                                
                                                                            </select>
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                        <input type="button" class="btn btn-primary btn-space" value="Delete" onclick="sub_domain_delete();">
                                                                        <input type="reset" class="btn ctrl-btn btn-space " value="Reset">
                                                                </div>
                                                                <input type="hidden" value="<?php echo $result[0]['_id'];?>" name="domain_id" id="domain_id"/>
                                                        </form>
                                                     </div>
                                           </div>
                                         </div>
                                            
                                    </div>
                                    
				</div>
			</div>
        </div>
        <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?> 
		<script src="js/dmstree_js/view_domain_page.js"></script>
    </body>
</html>