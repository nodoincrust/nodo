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
	$standandList = $g1->get_mongodb->getStandardListName($tenantId);
	$result = $g1->get_mongodb->getTemplateslist_new($tenantId );
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
						<?php
						foreach($standandList[0]['List'] as $list)
						{
							if(!$list['AuditData']['DeleteFlag'])
							{
						?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $list['Description']; ?>">
											<?php echo $list['Description']; ?>
										</a>
									</h4>
								</div>
								<div id="<?php echo $list['Description']; ?>" class="panel-collapse collapse">
									<div class="panel-body">
                                                                            <div class="row form-group">
                                                                                <label for="sub_domain" class="col-md-2  control-label">Select Sub Domain</label>
                                                                                <div class="col-md-6 col-sm-6">
                                                                                    <select class="form-control template col-md-4 col-sm-4" class="sub_domain" readonly onchange="showTemplate(this);">
                                                                                        <option value=""></option>
                                                                                        <?php 
                                                                                            foreach ($list['SubDomain'] as $subdomain){
                                                                                                if(!$subdomain['AuditData']['DeleteFlag'])
                                                                                                {
                                                                                         ?>
                                                                                        <option value="<?php echo $subdomain['DomainName']."::".$list['Description'];?>" ><?php echo $subdomain['DomainName'];?></option>
                                                                                        <?php
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                             </div>
										<ul class ="templateData">
																					</ul>
										<div class="show_template form-group row" id="">
										</div>
										<div class = "form-group row" >
                                                                                    <div class="col-md-12 col-sm-12">
											<input type="button" value="Delete" class="btn btn-danger" onclick="delete_template(this);">
                                                                                    </div>
										</div>
									</div>
								</div>
							</div>
						<?php
							}
						}
						?>
						
					</div>
				</div>
        </div>
        <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?> 
		<script src="js/dmstree_js/view_template_page.js"></script>
    </body>
</html>