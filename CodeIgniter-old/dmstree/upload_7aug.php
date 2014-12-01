<html>
    <head>
        <meta charset="utf-8">
        <title>Dash-Board</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="discription" content="">
        <meta name="author" content="">
        
                <link rel="stylesheet" href="dist/css/bootstrap.css"/>
                <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
                <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
                <link rel="stylesheet" href="css/stylesheet.css"/>
        
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
                <!--<script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>-->
                <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
                <script src="js/dmstree_js/jquery.textover.min.js"></script>
                <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
                <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
                <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
                <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
                <script src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
                <script src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
                <script type="text/javascript" src="js/dmstree_js/sign_validation.js"></script>
                <script type="text/javascript" src="js/dmstree_js/formvalidation.js"></script>
                <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
                <script type="text/javascript" src="js/dmstree_js/menu.js"></script>
                <script type="text/javascript" src="js/dmstree_js/uplaod_page.js"></script>
		<link type="text/css" href="css/uploader.css" rel="stylesheet" />
<!--		<script src="js/dmstree_js/jquery.textover.js"></script>-->
                <script type="text/javascript" src="js/dmstree_js/uploader.js"></script>
                <script type="text/javascript">
                $(document).ready(function()
                {
                        new multiple_file_uploader
                        ({
                                form_id: "fileUpload", 
                                autoSubmit: true,
                                server_url: "uploader.php" // PHP file for uploading the browsed files
                        });
                });
                </script>
    </head>
    <body >
        
       <?php include_once 'header.php'; ?> 
        <div class="row row-margin">
            <div class="col-md-3" id="body1">
                <?php include_once'dash_menu.php'?>  
            </div>
            <div class="col-md-9 div-padding-left" id="body-content">
                <div id="row test_load"> </div>
                <?php include_once'upload_document.php'?>
            </div>
            
        </div>
        <?php include_once 'footer.php'?>
        
        
    </body>
</html>