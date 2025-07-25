<?php
    ob_start();
    session_start();
    include 'session_timeout.php';
    include 'session_config.php';
    require('CodeIgniter-old/external.php');
    $ci =& get_instance();
    $ci->load->library("cimongo/cimongo");
    $ci->load->model('get_mongodb');
    $g1 = new Get_mongodb();
    $result = $g1->get_mongodb->getNews();
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
	<link rel="stylesheet" href="bootstrap-dialog/css/bootstrap-dialog.css">
	<link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen"  type="text/css" />
		
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>        
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
	<script type="text/javascript" src="facebox-master/src/facebox.js" ></script>
	<script>
            window.onload = function(){
                value = <?php echo $filesize ?>;
                max = <?php echo $activepackspace*1000 ?>;
                if (document.getElementById('g1')) {
                    showmeter(value,max);
                }
            };
        </script>        
    </head>
    <body>
        <?php include_once 'header.php'; ?> 
        <div class = "row row-margin">
            <div class = "col-sm-3 div-padding-top">
                <!--------- dash board side menu------------------------------------------------>
                <?php include_once'dash_menu.php'?>  
            </div>
            <div class = "div-padding-top col-md-9 col-sm-9 articles">
            <?php
                $i = 0;
                for($i = 0;$i<count($result);$i += 2 )
                {
            ?>
            <div class = "row">
                <div id="row<?php echo $i?>" class = "col-md-6">
                    <div class="well">
                        <div class = "row">
                            <div class = "col-md-12 ">
                                    <img src="img/<?php echo $result[$i]['NewsImage']?>"/>
                            </div>
                        </div>
                        <div class = "row">
                            <div class = "col-md-8" >
                                    <a><i><h4><?php echo $result[$i]['NewsTitle'] ?></h4></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class = "col-md-12 div-padding " >
                                <article><?php echo $result[$i]['NewsDescription']?></article>
                            </div>
                            <div>
                                <a href="#row<?php echo $i?>" class="cursor" rel="facebox">Read More</a>
                            </div>
                        </div>
                </div>
            </div>
             <?php
                if(!empty($result[$i+1]['NewsImage']))
                {
             ?>
            <div class = "col-md-6" id = "row<?php echo $i+1?>">
                <div class = "well">
                    <div class = "row">
                        <div class = "col-md-12 " >
                            <img src="img/<?php echo $result[$i+1]['NewsImage']?>"/>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-8" >
                            <a><i><h4><?php echo $result[$i+1]['NewsTitle'] ?></h4></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class = "col-md-12 div-padding " >
                            <article><?php echo $result[$i+1]['NewsDescription']?> </article>
                        </div>
                        <div>
                            <a href="#row<?php echo $i+1?>" class="cursor" rel="facebox">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>	
        <?php 
        }
        ?>
        </div>
    </div>
		
        <?php include_once 'footer.php'?>
        <script type="text/javascript" src="bootstrap-dialog/js/bootstrap-dialog.js"></script>
        <script src="js/dmstree_js/whats_new_on_dmstree_page.js"></script>
    </body>
</html>