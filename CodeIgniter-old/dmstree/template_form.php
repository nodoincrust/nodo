<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title>Template Form</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
        <link  rel="stylesheet" href="bootstrap/css/bootstrap.min.css" media="screen">
<!--        <script src="//code.jquery.com/jquery-1.9.1.js"></script>-->
        <script src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/doc_temp_valid.js"></script>
		<script>
				$( document ).ready(function() {
					
					$('#doc_template .droppedField').each(function(){
						if(($(this).find('.table_div').length) != 0)
						{
							if(($(this).find('.addstatus').val()) == "cols"){
								$(this).find('.tbl_btn').css('display','block');
							}
						}
					})
				});
		</script>
    </head> 
    <body>
            <?php
                    header("X-XSS-Protection: 0");
                    $phid = $_POST["template_fromdata"];  
                    echo $phid;
            ?>
    </body>
</html>    
