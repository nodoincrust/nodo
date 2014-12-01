<html>
    <head>
        <meta charset="utf-8">
        <title>Dash-Board</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="discription" content="">
        <meta name="author" content="">
        
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="js/dmstree_js/jquery.textover.min.js"></script>
        
        <!------- Bootstrap validation jquery --------------------------------------->
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <!-------Bootstrap css--------------------------------------->
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
        
        <!------ Jquery css ---------------------------------->
        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <!------ Custom css --------------------------------------->
        <link rel="stylesheet" href="css/stylesheet.css"/>
         <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <!------ Date css --------------------------------------->
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
        <!------- Bootstrap validation css --------------------------------------->
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
        <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
         
         <!-------Bootstrap validation javascript--------------------------------------->
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <!------ Used for just Gage user meter-------------------------------------------------------------------->
        <script src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
	<script src="js/dmstree_js/jquery.textover.js"></script>
        <script src="newjs/uploader.js" type="text/javascript"></script>
        <script type="text/javascript" src="jqueryui/ui/minified/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/jquery.tag.js"></script>
        <link media="screen" rel="stylesheet" href="css/jquery.tag.css" type="text/css">
        <link media="screen" rel="stylesheet" href="css/jquery-ui.custom.css" type="text/css">
        <link type="text/css" href="css/uploader.css" rel="stylesheet" />
        <style>
            .row
            {
                margin-left:  0 !important;
                margin-right: 0 !important;
            }
            .demo-box {
                    text-align: left;
                    margin: 2em auto;
                    background: white;
                    border: 1px #bbb solid;
                    -webkit-border-radius: 4px;
                    -moz-border-radius: 4px;
                    border-radius: 4px;
                    -webkit-box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.25);
                    -moz-box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.25);
                    box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.25);
                    padding: 0 2em 2em;
               }
        </style>
    </head>
    <body >
        
<!--        <div class="container">-->
        <!----------- Header page--------------------------------------------->
       <?php include_once 'header.php'; ?> 
<!--        </div>-->
<!--        <div class="container">-->
        <div class="row row-margin">
            <div class="col-md-3" id="body1">
                <!--------- dash board side menu------------------------------------------------>
                <?php include_once'dash_menu.php'?>  
            </div>
            <div class="col-md-9 div-padding-left" id="body-content">
                <!--------- dash board body------------------------------------------------> 
				
                <?php include_once'upload_document.php'?>
            </div>
            
        </div>
<!--        </div>-->
<!--        <div class="container">-->
         <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
<!--        </div>-->
        <script type="text/javascript" src="js/dmstree_js/sign_validation.js"></script>
        <script type="text/javascript" src="js/dmstree_js/formvalidation.js"></script>
        <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
        <script type="text/javascript" src="js/dmstree_js/menu.js"></script>
        <script type="text/javascript" src="js/dmstree_js/uplaod_page.js"></script>
<!--        <script>
                         $(document).ready(function(){
				$("#targetdiv").tag();
			});
        </script>-->
<!--        <script type="text/javascript">
        $(document).ready(function()
        {
                new multiple_file_uploader
                ({
                        form_id: "fileUpload", 
                        autoSubmit: true,
                        server_url: "uploader.php" // PHP file for uploading the browsed files
                });
                 
        });
        </script>-->
        
        
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="../jquery.textover.min.js"></script>
<script type="text/javascript">
  jQuery(function($){

    var textover_api;

    // How easy is this??
    $('#targetnew').TextOver({}, function() {
      textover_api = this;
    });

  });

</script>
<link rel="stylesheet" href="media/demos.css" type="text/css" />


        <div class="demo-box">
            <img src="media/vagamon.jpg" id="targetnew" alt="[Text Over Example]" />
        </div>
        -->

    </body>
</html>