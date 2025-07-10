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
date_default_timezone_set('Asia/Calcutta');   
$tenantid = '';
$departmentid = '';
$tenantname= '';
if(isset($_SESSION['usertenant']))
{
    $tenantid = $_SESSION['usertenant'];
}
if(isset($_SESSION['userdepartmentid']))
{
    $departmentid = $_SESSION['userdepartmentid'];
}
if(isset($_SESSION['tenantname']))
{
    $tenantname = $_SESSION['tenantname'];
    $actualtenantnm = str_replace(" ","_",$tenantname);
}
$bouquetdocuments = '';
$bouquet_docname = '';
$bouquet_desc = '';
if(isset($_POST['docform']))
{
    if($_POST['docform'] == '1')
    {
        if(isset($_POST['docbunch']))
        {
            $bouquet_documents = $_POST['docbunch'];
            
            if(!(isset($_SESSION['new_documents'])))
            {
                 $_SESSION['new_documents'] = $bouquet_documents;
            }
            else
            {
                $documentbunch = $_SESSION['new_documents'];
                $totdocuments = $documentbunch.'||'.$bouquet_documents;
                $_SESSION['new_documents'] = $totdocuments;
                
            }
            if(isset($_SESSION['bouquetnm']))
            {
                $bouquet_docname = $_SESSION['bouquetnm'];
            }
            if(isset($_SESSION['bouquetdesc']))
            {
                $bouquet_desc =  $_SESSION['bouquetdesc'];
            }
            
        }
    }
}

    $path='DMSTree_clients/'.$actualtenantnm.'_'.$tenantid; 
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
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
        <link rel="stylesheet" href="css/jquery.tag-editor.css">
		<link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen"  type="text/css" />
        
	<script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
		<script src="facebox-master/src/facebox.js" type="text/javascript"></script>
		
        <script>
            window.onload = function(){
                value = <?php echo $filesize ?>;
                max = <?php echo $activepackspace*1000 ?>;
                if (document.getElementById('g1')) {
                    showmeter(value,max);
                }
            };
            $(document).ready(function(){
                var directoryspace = <?php echo $tenantspace?>;
                var tenantspace    = <?php echo $activepackspace?>;
                if(parseFloat(directoryspace) >= parseFloat(tenantspace))
                {
                          $('input').attr('disabled','disabled');
                          $('select').attr('disabled','disabled');
                          $('textarea').attr('disabled','disabled');
                          var spacemsg = 'Package Size is full';
                          $('.spaceerror').text(spacemsg);    
                 }
                 else
                 {
                          $('.input').removeAttr('disabled');
                          $('select').removeAttr('disabled');
                          $('textarea').removeAttr('disabled');
                          $('.spaceerror').text(''); 
                 }    
            });
            
            function dynamicURL(documentName,revisionNo,htmltemp,docid)
            {
                $.facebox.settings.closeImage = 'img/close_button.png';
                $.facebox.settings.loadingImage = 'img/loading.gif'; 
                var ajaxpostID = "view_document.php?doc="+documentName+"&revision="+revisionNo+"&tempname="+htmltemp+"&documentid="+docid; 
                jQuery.facebox({ajax: ajaxpostID});

            }
            
            $(window).unload(function() {
                   reset_seesion();
            }); 
            function redirect_tosearchPage()
            {
                var bouquetname = $('#txt_bouquet_name').val();
                var bouquetdesc = $('.bouquet_desp').val();
                $.ajax({
                                type: "POST",
                                data:{
                                        bouquetname          : bouquetname,
                                        bouquetdesc          : bouquetdesc
                                    },
                                url: "setbouquet_data.php",
                                success: function(response){
                                }
                        });
                location.replace("search.php")
            }
            
            function save_bouquet()
            {
                var bouquetname = $('#txt_bouquet_name').val();
                if(bouquetname == '')
                    {
                        alert("Empty Bouquet name");
                    }
                else
                    {
                        var docidindex  = 0;
                        var docrevindex = 0;
                        var docidarr  = new Array();
                        var docrevarr = new Array();
                        var bouquetdesc = $('.bouquet_desp').val();
                        var docidval = '';
                        var docrevval = '';
                        var tenantid = <?php echo $tenantid; ?>;
                        var departid = '<?php if($departmentid != '') {echo $departmentid;} ?>';
                        $('.bouquet_document_container .well').each(function(){
                             docidval  = $(this).children().find('.documentname span').text();
                             docrevval = $(this).children().find('.docrevision span').text();
                             if(docidval != '' && docrevval != '')
                                 {
                                    docidarr[docidindex]   = docidval;
                                    docrevarr[docrevindex] = docrevval;
                                    docidindex++;
                                    docrevindex++;
                                 }
                             
                        });
                        if(docidarr.length > 0 && docrevarr.length > 0)
                        {
                            $.ajax({
                                type: "POST",
                                data:{
                                        bouquetname          : bouquetname,
                                        tenantid             : tenantid,
                                        departid             : departid,
                                        bouquetdesc          : bouquetdesc,
                                        docidarr             : docidarr,
                                        docrevarr            : docrevarr
                                       
                                    },
                                url: "savebouquetdata.php",
                                success: function(response){
                                    var actiontext = bouquetname+' document bouquet created.';
                                    $.ajax({
                                       type: "POST",
                                       data: {
                                                 actiontext : actiontext
                                             },
                                       url: "track_history.php",
                                       success: function(response){ 
                                            alert("Bouquet created sucessfully");
                                            reset_seesion();
                                            window.location.reload();    
                                       }   
                                   });
                                    
                                }
                        });
                        }    
                        else
                        {
                            alert("Please select the bouquet documents");
                        }
                    }
            }
            
            function reset_seesion()
            {
                var bouquetname = 1;
                $.ajax({
                                type: "GET",
                                data:{
                                        bouquetname          : bouquetname
                                    },
                                url: "setsession_variable.php",
                                success: function(response){
                                    location.reload();
                                }
                        });
            }
            
            function clear_page()
            {
                reset_seesion();
                window.location.reload();
            }
        </script>
        <style>
             .add_btn{
                display:flex;
                gap:8px;
                justify-content:end;
                margin-top: 20px;
                
            }
            .well_cls{
                padding:24px
            }
            </style>
    </head>
    <body >

    <!----------- Header page--------------------------------------------->
    <?php include_once 'header.php'; ?> 

    <div class="row row-margin">
    <div class="col-md-3 col-sm-3">
    <!--------- dash board side menu------------------------------------------------>
    <?php include_once'dash_menu.php'?>  
    </div>
 
	<div class="col-md-9 col-sm-9">
        <!-- <div class="col-md-9 col-sm-9 div-padding-left"> -->
            <!-- <div class="row">
                <p class="spaceerror col-md-12" style="color:red"> </p>
            </div> -->
            <div class="well div-padding-top div-padding-well"> 
            <div class="row">
		<div class="col-md-12 col-sm-12 form_title"><h3 class="hr-margin text-muted upload_doc_cls"><b>Create Document Bouquet</b></h3></div>
            </div>
        </div>
            <!-- <div class="well div-padding-top div-padding-well">  -->
                  <div class="well div-padding-well well_cls"> 
            <!-- <div class="row">
		<div class="col-md-12 col-sm-12 form_title"><h3 class="hr-margin text-muted upload_doc_cls"><b>Create Document Bouquet</b></h3></div>
            </div> -->
            <div class="row">
		<div class="col-md-12 col-sm-12">
                <form name="bouquetnameForm" id="bouquetnameForm" method="post" action="search.php">
                    <input type="hidden" id="bouquetname" name="bouquetname" value="" style="border:1px solid #c5e86c !important;">
                </form>    
		<form name="bouquetForm" id="bouquetForm" action="" method="post">
                    <div class="form-group row add-comment">
			<label for="txt_bouquet_name" class="col-md-3 col-sm-3 control-label">Bouquet Name</label>
			<div class="col-md-6 col-sm-6 ">
                            <input type="text" class="form-control txt_comment1" style="border:1px solid #c5e86c !important;" id="txt_bouquet_name" placeholder="Bouquet Name" name="" value="<?php if(isset($bouquet_docname)) echo $bouquet_docname;?>">
			</div>
			<div class="col-md-2 col-sm-2">
                            <!-- <input type="button" class="btn ctrl-btn save_btn_bg" value ="Add Document" onclick="redirect_tosearchPage();" /> -->
                             <input type="button" class="save_btn_bg_cancel btn-success" value ="Add Document" onclick="redirect_tosearchPage();" />
			</div>
                    </div>
                    <div class="form-group row add-comment"></div>
		</form>
                    <div class="row">
                    <label class="col-md-3">Bouquet Description</label>
                    <textarea style="border:1px solid #c5e86c !important;" class="col-md-8 bouquet_desp"rows="3" cols="50" placeholder="Master Document Description" value=""><?php if(isset($bouquet_desc)) echo $bouquet_desc;?></textarea>
                    </div>
                    <div class="row">
            <div class="col-md-12 col-sm-12 add_btn">
			<!-- <input type="button" value="Save" class="btn btn-success save_btn_bg" onclick="save_bouquet();"/>
			<input type="button" value="Cancel" class="btn ctrl-btn save_btn_bg_cancel" onclick="clear_page();"/> -->
            <input type="button" value="Save" class="save_btn_bg_cancel btn-success" onclick="save_bouquet();"/>
			<input type="button" value="Cancel" class="save_btn_bg_cancel" onclick="clear_page();"/>
            </div>
            </div>  
		</div>
            </div>
            </div>
            
            <?php
                if(isset( $_SESSION['new_documents']))
                {
                $docbunch = $_SESSION['new_documents'];; 
                $documents = explode("||",$docbunch);
                $documentlength = count($documents);
                $bouquetdocument = '';
                 if($documentlength > 0)
                {
                    $docnamearr = array();
                    $i = 1;
                    $bouquetdocument .= '<div class="bouquet_document_container">';
                    foreach ($documents as $docvalue) {
                        
                        $documentvalues = explode("::",$docvalue);
                        $docinfo = $documentvalues[0].'::'.$documentvalues[1];
                        if(!(in_array($docinfo,$docnamearr)))
                        {      
                            $docnamearr[]= $docinfo;
                            if($documentvalues[0] != '')
                            {
                                $filename = $documentvalues[0];
                            }
                            if($documentvalues[1] != '')
                            {
                                $docrevision = $documentvalues[1];
                            }
                            if($documentvalues[2] != '')
                            {
                                $docdate = $documentvalues[2];
                            }

                            if($documentvalues[3])
                            {
                                $fileext = $documentvalues[3];
                                if($fileext == 'xlsx')
                                {
                                    $fileext = 'xls';
                                }
                                else if($fileext == 'docx'){
                                    $fileext = 'doc';
                                }
                                else
                                {
                                    $fileext = 'jpg';
                                }
                            }

                        $docid = $documentvalues[4];
                        $templatfilename = '';
                        $bouquetdocument .= '<div class=" well div-padding-top div-padding-well" id="bouquetsubdoc_'.$i.'">';
                        $bouquetdocument .= '<div class="row div-margin">';
                        $bouquetdocument .= '<div class="col-md-2">';
                        $bouquetdocument .= '<img src="img/file_icons/'.$fileext.'.png" style=" height: 60px; width: 90px; border: 1px #e5e5e5;">';
                        $bouquetdocument .= '</div>';
                        $bouquetdocument .= '<div class="col-md-9">';
                        $bouquetdocument .= '<p class="documentname">Document name : <a onclick="dynamicURL(\''.$filename.'\',\''.$docrevision.'\',\''.$templatfilename.'\',\''.$docid.'\');" rel="facebox">'.$filename.'</a><span class="documentid" style="display:none">'.$docid.'</span></p>';
                        $bouquetdocument .= '<p class="docrevision">Document latest revision: <span>'.$docrevision.'</span></p>';
                        $bouquetdocument .= '<p class="docdate">Document Date:<span>'.$docdate.'</span></p>';
                        $bouquetdocument .= '</div>';
                        $bouquetdocument .= '<div class="col-md-1">';
                        $bouquetdocument .= '<img src="img/delete.png" style="margin-top:10px;" onclick="removeDiv(this)"/>';
                        $bouquetdocument .= '</div>';
                        $bouquetdocument .= '</div>';
                        $bouquetdocument .= '</div>';
                        
                        }
                        } 
                    }
                    echo $bouquetdocument;
                    echo '</div>';
                
            }
            ?>
            <!-- <div class="row">
            <div class="col-md-12 col-sm-12 add_btn"> -->
			<!-- <input type="button" value="Save" class="btn btn-success save_btn_bg" onclick="save_bouquet();"/>
			<input type="button" value="Cancel" class="btn ctrl-btn save_btn_bg_cancel" onclick="clear_page();"/> -->
            <!-- <input type="button" value="Save" class="save_btn_bg_cancel" onclick="save_bouquet();"/>
			<input type="button" value="Cancel" class="save_btn_bg_cancel" onclick="clear_page();"/>
            </div>
            </div>     -->
			
           </div> 
        </div>
         <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
		<script src="jqueryui/ui/minified/jquery-ui.min.js"></script>
		<script type="text/javascript" src="js/dmstree_js/document_bouquet_page.js"></script>
    </body>
</html>