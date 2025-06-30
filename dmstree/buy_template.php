<?php
	ob_start();
	session_start();
        include 'session_timeout.php';
	include 'session_config.php';
	require('../CodeIgniter-old/external.php');
        $ci = & get_instance();
        
        $ci->load->library("cimongo/cimongo");
        $ci->load->model('get_mongodb');
        $g1 = new Get_mongodb();
        
        $tenantId = '';
        $tenantname = '';
        if(isset($_SESSION['usertenant']))
        {
            $tenantId = $_SESSION['usertenant'];
        } 
        if(isset($_SESSION['tenantname']))
        {
            $tenantname = $_SESSION['tenantname'];
            $tenantname = str_replace(" ","_",$tenantname);
        }
        
        $path='DMSTree_clients/'.$tenantname.'_'.$tenantId; 
        $ar=getDirectorySize($path);
        $tenantspace = sizeFormat($ar['size']);
        $tenantspace = (float)$tenantspace;
        $filesize = (float)fileSizeInMB($ar['size']);
        $activepackspace = $g1->get_mongodb->getActivePackageSize($tenantId);
        $activepackspace = (float)$activepackspace;
        
	$userId = $_SESSION['userid'];
	$result = $g1->get_mongodb->getDocumentMetadataDetails($tenantId);
        $taglist = $g1->get_mongodb->getTagList($tenantId);
        $userdepartid = '';
        $taglistdata = $g1->get_mongodb->tagData($tenantId,$userdepartid);
        $tag = array();
        $name = '';
        
        if(isset($_SESSION['userdepartmentid'] ))
        {
            $userdepartid = $_SESSION['userdepartmentid'];
        }  
         else {
            $userdepartid = '';
         }
         if(isset($_SESSION['userdepartmentid'] ))
        {
            $userdepartid = $_SESSION['userdepartmentid'];
        }  
         else {
            $userdepartid = '';
         }
        foreach ($taglist[0]['TagList'] as $key)
        {
                $tag[] = $key['Tag'];
        }
        $standandList = $g1->get_mongodb->getStandardListName(-999);
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
        <link rel="stylesheet" href="css/bootstrap-select.css">
        <link rel="stylesheet" href="chosen_v1.2.0/chosen.min.css" />
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
        <script src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/bootstrap-select.js"></script>
        <script src="chosen_v1.2.0/chosen.jquery.js"></script>
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
   <body>
        <?php include_once 'header.php'; ?> 
        <div class="row row-margin">
            <div class="col-md-3 col-sm-3 div-padding-top" id="body1">
                <?php include_once'dash_menu.php'?>  
            </div>
            <div class="col-md-9 col-sm-9 div-padding-left" id="body-content">
                <div class="row">
                            <p class="spaceerror col-md-12" style="color:red"> </p>
                </div>
                <div class="well div-padding-top">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 form_title "><h2 class="text-muted hr-margin"><b style="color: #9AD94B;"> Template List</b></h2></div>
                    </div>
                </div>
                <div class="well" >
                    <div class="row">
                        <div class="panel-group" id="accordion">
                        <?php
                        if($standandList != null)
                        {   
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
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        }
                        ?>
                        </div>
                    </div>
                </div>     
                <form action="" name="" id="" method="post">
                    <input type="hidden" value="" name="tempid" id="tempid"/>
                    <input type="hidden" value="" name="templocation" id="templocation"/>
                    <input type="hidden" value="" name="docname" id="docname"/>
                </form>
            </div>
        </div>
        <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
        <script type="text/javascript" src="js/dmstree_js/buy_template_page.js"></script>
    </body>
</html>