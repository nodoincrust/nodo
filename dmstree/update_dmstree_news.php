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
    $result = $g1->get_mongodb->getNews();
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
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
		
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="js/dmstree_js/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/moment.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
		
    </head>
    <body>
        <?php include_once 'admin_header.php'; ?> 
        <div class="row row-margin">
            <div class="col-md-2 col-sm-2 div-padding-top" id="body1">
                    <?php include_once'admin_dash_menu.php'?>  
            </div>
            <div class="col-md-10 col-sm-10 div-padding-top well" id="domain-contain">
                <div class ="row">
                    <div class="col-md-12 form_title ">
                        <h2 class="text-muted">News</h2>
                    </div>
                </div>
                <div class="row">
                    <form id="news_form" method="post" class="form-horizontal col-md-12 form-action" action="" enctype="multipart/form-data">
                        <div class="form-group row ">
                            <label for="news" class="col-md-2 control-label">Select News Title</label>
                            <div class="col-md-6">
                                <select id="news" class="form-control selectpicker col-md-6" name="package" readonly>
                                    <option id='' value=""></option>
                                    <?php foreach($result as $key)
                                            {
                                                    if(!$key['AuditData']['DeleteFlag'])
                                                    {
                                    ?>
                                                            <option value="<?php echo $key['NewsTitle']?>" id="<?php echo $key['_id']?>"><?php echo $key['NewsTitle']?></option>
                                    <?php 	} 
                                            }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="newinfo">
                            <div class="form-group row ">
                                <label for="new_title" class="col-md-2 control-label">News Title</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="new_title" placeholder="News Title" value="" name="new_title" readonly>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label for="new_description" class="col-md-2 control-label">News Description</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="new_description" placeholder="News Description" value="" name="new_description" rows="5" readonly></textarea>
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label for="" class="col-md-2 control-label">News Valid Till</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="expiry_date" placeholder="" value="" name="" rows="5" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="button" class="btn btn-success" value="Delete" onclick="delete_news();">
                            <input type="reset" class="btn ctrl-btn" value="Cancel">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?> 
		<script src="js/dmstree_js/update_dmstree_news_page.js"></script>
    </body>
</html>
