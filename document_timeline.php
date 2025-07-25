<?php 
    ob_start();
    session_start();
    //include 'session_config.php';
    require('CodeIgniter-old/external.php');
    $ci =& get_instance();
    $ci->load->library("cimongo/cimongo");
    $ci->load->model('get_mongodb');
    $g1 = new Get_mongodb();
    $userId = $_SESSION['userid'];
    $userInfo = $g1->get_mongodb->getUserInfo($userId);
    $name = $userInfo[0]['Name'];
    $docId = $_POST['docid'];
    $docRevision = $_POST['docrevision'];
    $currDate = date('Y-m-d h:i:s');
    $currDate = new MongoDate(strtotime($currDate));
    $docInfo = $g1->get_mongodb->getDocumentMetadataById($docId);
    $arrayIndex = 0;
    $templatename = '';
    $htmltemplate = '';
    $htmltemppath = '';
    if(array_key_exists('TemplateId', $docInfo[0]))
    {
        $tempid = $docInfo[0]['TemplateId'];
        $tempInfo = $g1->get_mongodb->templatenameData_new($tempid);
        $templatename = $tempInfo[0]['TemplateHeader'];
        $htmltemplate = $tempInfo[0]['HtmlFileName'];
        $htmltemppath = $tempInfo[0]['HtmlFileLocation'];
    }
    //echo $htmltemplate;
    foreach($docInfo[0]['DocumentInfo'] as $key )
     {
        if($key['RevisionNo'] == $docRevision)
        { break;}
        $arrayIndex++;
     }
     if (array_key_exists('FileName', $docInfo[0]['DocumentInfo'][$arrayIndex])) {
        $filename = $docInfo[0]['DocumentInfo'][$arrayIndex]['FileName'];
        $filenametype = explode(".",$filename);
        $filetype     = $filenametype[1]; 
        if($filetype == 'xlsx'){$filetype = "xls";}
        if($filetype == 'docx'){$filetype = "doc";}
        } else {
        $filename = '';
        $filetype = 'jpg';
    }
    $dates = array();
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
<!--        <link rel="stylesheet" href="css/data_configuration.css"/>-->
        <link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen"  type="text/css" />
        <link rel="stylesheet" href="VerticalTimeline/css/component.css"/>
        
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>     
        <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>         
        <script type="text/javascript" src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
        <script src="facebox-master/src/facebox.js" type="text/javascript"></script>
        <script type="text/javascript" src="VerticalTimeline/js/modernizr.custom.js"></script>
        <script>
            
            
            function dynamicURL(documentName,revisionNo,htmltemp,docid)
            {
                $.facebox.settings.closeImage = 'img/close_button.png';
                $.facebox.settings.loadingImage = 'img/loading.gif';
                var ajaxpostID = "view_document.php?doc="+documentName+"&revision="+revisionNo+"&tempname="+htmltemp+"&documentid="+docid;//+"'"; 
                //alert(ajaxpostID);
                jQuery.facebox({ajax: ajaxpostID});

            }
            $(document).bind('afterClose.facebox', function() { $('#facebox').remove();});
            $(document).bind('loading.facebox', function() { setTimeout('',1000);});
        </script>
        <style>
            .cbp_tmtimeline > li .cbp_tmlabel {
            color: #0A0A0A !important;
            }
        </style>    
    </head>
    <body >

    <?php include_once 'header.php'; ?> 
    <div class="row row-margin">
        <div class="col-md-3 div-padding-top">
            <!---------  Side Menu     ------------------------------------------>
            <?php include_once'dash_menu.php'?>  
        </div>
        <div class="col-md-9 div-padding-left div-padding-top" id="">
            <div class="main">
                 <ul class="cbp_tmtimeline">
            <?php
            $docInfo[0] =array_reverse($docInfo[0]);
             foreach($docInfo as $key ) 
                {
                    $commentcount = 0;
                    $totalcomments = 0;
                    $tagcount = 0;
                    $totaltagcount = 0;
                    $commentdate = '';
                    $templatename = '';
                    $htmltemplate = '';
                    $htmltemppath = '';
                    $documentName = $key['DocumentName'];
                    
                    if(array_key_exists('TemplateId', $key))
                    {
                        $tempid = $key['TemplateId'];
                        $tempInfo = $g1->get_mongodb->templatenameData_new($tempid);
                        $templatename = $tempInfo[0]['TemplateHeader'];
                        $htmltemplate = $tempInfo[0]['HtmlFileName'];
                        $htmltemppath = $tempInfo[0]['HtmlFileLocation'];
                    }
                    foreach($key['DocumentInfo'] as $doc)
                    {
                        
                            $documenttag = array();
                            if (array_key_exists('RevisionNo', $doc)) {
                                $revisionNo = $doc['RevisionNo'];
                            } else {
                                $revisionNo = '';
                            }
                            if (array_key_exists('FileName', $doc)) {
                                $filename = $doc['FileName'];
                                $filenametype = explode(".",$filename);
                                $filetype     = $filenametype[1]; 
                                if($filetype == 'xlsx'){$filetype = "xls";}
                                if($filetype == 'docx'){$filetype = "doc";}
                            } else {
                                $filename = '';
                                $filetype = 'jpg';
                            }
                            if (array_key_exists('UploadDate', $doc)) {
                                $uploadedDate = $doc['UploadDate'];
                                //$uploadedDate = $dockey['DocumentInfo']['UploadDate'];
                                $docDate = date('y-M-d', $uploadedDate->sec);
                            } else {
                                $docDate = '';
                            }
                            if (array_key_exists('CurrentStatus', $doc)) {
                                $currstatus = $doc['CurrentStatus'];
                            } else {
                                $currstatus = '';
                            }    
            
            ?>
            
                     <li> <time class="cbp_tmtime" datetime="2013-04-10 18:30"><span><?php echo date('Y-M-d',$doc['UploadDate']->sec);?></span><span><?php echo date('h:i',$doc['UploadDate']->sec);?></span> </time>
                <div class="well cbp_tmlabel" >
                    <div class="row">
                        <div class="col-md-2">
                            <img src="img/file_icons/<?php echo $filetype; ?>.png" style=" height: 100px; object-fit: contain;width: 120px; border: 1px #e5e5e5;" class="">
                        </div>
                        <div class="col-md-10">
                            <p class="documentname">Document Name : <a onclick=dynamicURL("<?php echo $documentName.'","'.$revisionNo.'","'.$htmltemplate.'","'.$key['_id'].'")>'.$documentName;?></a></p>
                            <p class="documentrevision">Document Revision : <?php echo $revisionNo;?></p>
                            <?php if($templatename != ''){ echo '<p>Document Template:<span class ="tempname">'.$templatename.'</span></p>'; }?>
                            <p class="documentuploaddate">Date : <?php echo $docDate;?></p>
                            <?php if(array_key_exists('TagList',$doc)) {?>
                            <p class="">Tags :<?php $tags = $doc['TagList']; 
                                                        for($index=0; $index < sizeOf($tags); $index++)
                                                        {
                                                            ?>
                                                                <label class="tags">  <?php echo $tags[$index];?>  </label>
                                                            <?php
                                                        }
                                                    ?></p><?php }?>
                       </div>
                  </div>
                        <div class="panel-group" id="accordion">
                            <?php
                            $dates = '';
                            foreach($key['DocumentInfo'] as $key1 )
                             {
                                if($key1['RevisionNo'] == $revisionNo)
                                {
                                   $uploadDate = date('Y-m-d',$doc['UploadDate']->sec);
                                   $currDate = date('Y-m-d');
                                    $start    = new DateTime($uploadDate);
                                    $start->modify('first day of this month');
                                    $end      = new DateTime($currDate);
                                    $end->modify('first day of next month');
                                    $interval = DateInterval::createFromDateString('1 month');
                                    $period   = new DatePeriod($start, $interval, $end);
                                    foreach ($period as $dt) {
                                        $dates[] = $dt->format("Y-m");// . "<br>\n";
                                    }
                                   // print_r($dates);
                                }
                             }
                             
                            // echo sizeOf($dates);
                             for($index = sizeOf($dates)-1; $index >=0; $index--)
                             {
                                 if(!empty($doc['Comments']))
                                 {
                                 $commentsDate = $doc['Comments'];
                                 $days = explode("-",$dates[$index]);
                                 $startDate = date('Y-m-d',mktime(0,0,0,(int)$days[1],1,(int)$days[0]));
                                 $num = cal_days_in_month(CAL_GREGORIAN, (int)$days[1], (int)$days[0]);
                                 $endDate = date('Y-m-d',mktime(0,0,0,(int)$days[1],$num,(int)$days[0]));
                                 //echo $startDate."<br>".$endDate;
                                 
                             
                            ?>
                               <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $days[0].'_'.$days[1].'_'.$revisionNo;?>"><?php echo $dates[$index];?>
                                            </a>
                                        </h4>
                                    </div>
                                   <div id="<?php echo $days[0].'_'.$days[1].'_'.$revisionNo;?>" class="panel-collapse collapse">
                                        <div class="panel-body">
                                           <p>Comments</p>
                                            <p><?php
                                                     asort($commentsDate);
                                                    foreach ($commentsDate as $value) {
                                                        $docCommentDay = date('Y-m-d',$value['CommentDate']->sec);
                                                        if($docCommentDay >= $startDate && $docCommentDay <= $endDate)
                                                        {
                                                            $name = $g1->get_mongodb->getUserInfo($value['UserId']);
                                                            ?>
                                                            <div class="more-comment div-padding">
                                                                <a><i><?php echo $name[0]['Name'];?>:</i></a> <?php echo $value['CommentText'];?>
                                                                <div class="date colour"><?php echo date('M d Y h:m',$value['CommentDate']->sec);?> </div>
                                                            </div>
                                                           
                                                            <?php
                                                        }
                                                    }
                                                ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                             }
                             }
                            ?>
                        </div>
                    </div>
                         <li>
                     
                    <?php
                    
                    }
                }
                    ?>
                             </ul>
            </div>
                </div> 
       </div>
    </div>
    <!---      Footer      ----------------->
    <?php include_once 'footer.php'?>

    <script src="jqueryui/ui/minified/jquery-ui.min.js"></script>
    </body>
</html>

