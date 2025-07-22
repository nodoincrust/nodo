<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
$userdepartid = '';
$tenantid = '';
$tenantuserid = '';
$tenantname = '';
date_default_timezone_set('Asia/Calcutta');
if(isset($_SESSION['tenantuserdata']))
{
    $userarr = $_SESSION['tenantuserdata'];
}
if(isset($_SESSION['userdepartmentid'] ))
{
    $userdepartid = $_SESSION['userdepartmentid'];
}  
if(isset($_SESSION['usertenant']))
{
    $tenantid = $_SESSION['usertenant'];
} 
if(isset($_SESSION['userid']))
{
    $tenantuserid = $_SESSION['userid'];
}
if(isset($_SESSION['tenantname']))
{
    $tenantname = $_SESSION['tenantname'];
    $tenantname = str_replace(" ","_",$tenantname);
}
require('../CodeIgniter-old/external.php');
$ci =& get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();
            
$path='DMSTree_clients/'.$tenantname.'_'.$tenantid; 
$ar=getDirectorySize($path);
$tenantspace = sizeFormat($ar['size']);
$tenantspace = (float)$tenantspace;
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
        <link rel="stylesheet" href="chosen_v1.2.0/chosen.min.css" />
        <link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen"  type="text/css" />
        <link rel="stylesheet" href="bootstrap-dialog/css/bootstrap-dialog.min.css" type="text/css" />

        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
        <script src="facebox-master/src/facebox.js" type="text/javascript"></script>
        <script src="chosen_v1.2.0/chosen.jquery.js"></script>
        <script src="facebox-master/src/facebox.js" type="text/javascript"></script>
        <script src="bootstrap-dialog/js/bootstrap-dialog.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function()
            {
                $('.chosen-select').chosen();
            });

            //$(document).bind('afterClose.facebox', function() { $('#facebox').remove(); $('.bootstrap-datetimepicker-widget').remove(); $('.tag_selectbox').children(':eq(2)').remove();});
            //$(document).bind('loading.facebox', function() { setTimeout('',1000);});
            $(".close").click(function(){
                $('#facebox').remove(); 
                $('.bootstrap-datetimepicker-widget').remove(); 
                $('.tag_selectbox').children(':eq(2)').remove();
            });
            function dynamicURL(documentName,revisionNo,htmltemp,docid)
            {
                $.facebox.settings.closeImage = 'img/close_button.png';
                $.facebox.settings.loadingImage = 'img/loading.gif'; 
                var ajaxpostID = "view_document.php?doc="+documentName+"&revision="+revisionNo+"&tempname="+htmltemp+"&documentid="+docid;//+"'"; 
                jQuery.facebox({ajax: ajaxpostID});
            }

            var str = '';
            var selectopt;
            $(document).ready(function(){
                    $.ajax({
                            type: "POST",
                            data: {
                                    datatype:'bouquet'
                                  },
                            url: "savedoc_tagscomment.php",
                            success: function(response){
                                    str = response;
                            }
                    });
                  var directoryspace = <?php echo $tenantspace?>;
                  var tenantspace    = <?php echo $activepackspace?>;
                  if(parseFloat(directoryspace) >= parseFloat(tenantspace))
                      {
                          $('.revsioncomment').attr('disabled','disabled');
                          $('.revsiontags').attr('disabled','disabled');
                          $('.revsionstatus').attr('disabled','disabled');
                          $('.add_to_bouquet').attr('disabled','disabled');
                          $('.add_to_archive').attr('disabled','disabled');
                          $('.btn_comment').attr('disabled','disabled');
                          $('.btn_tags').attr('disabled','disabled');
                          $('select').attr('disabled','disabled');

                          $('.revsioncomment').css('opacity','0.5');
                          $('.revsiontags').css('opacity','0.5');
                          $('.revsionstatus').css('opacity','0.5');
                          $('.add_to_bouquet').css('opacity','0.5');
                          $('.add_to_archive').css('opacity','0.5');
                          $('.btn_comment').css('opacity','0.5');
                          $('.btn_tags').css('opacity','0.5');
                          $('select').css('opacity','0.5');
                          var spacemsg = 'Package Size is full';
                          $('.spaceerror').text(spacemsg);    
                      }
                  else
                      {
                          $('.revsioncomment').removeAttr('disabled');
                          $('.revsiontags').removeAttr('disabled');
                          $('.revsionstatus').removeAttr('disabled');
                          $('.add_to_bouquet').removeAttr('disabled');
                          $('.add_to_archive').removeAttr('disabled');
                          $('.btn_comment').removeAttr('disabled');
                          $('.btn_tags').removeAttr('disabled');
                          $('select').removeAttr('disabled');
                          $('.spaceerror').text(''); 
                      }
            });  


            function view_document(currentobj)
            {

            }
            function makefocusComment(currdoc)
            {
                $(currdoc).parent().parent().parent().parent().find('.hide_div').css('display','block');
                $(currdoc).parent().parent().parent().parent().parent().find('.document_commentbox').focus();
                $(currdoc).parent().parent().parent().parent().find('#img1').attr('src','img/delete.png');
                $(currdoc).parent().parent().parent().parent().find('#img1').removeClass("img1");
                $(currdoc).parent().parent().parent().parent().find('#img1').addClass("img2");
            }
            function makefocusTag(currtagobj)
            {
                $(currtagobj).parent().parent().parent().parent().find('.hide_div').css('display','block');
                $(currtagobj).parent().parent().parent().parent().parent().find('.chosen-container').focus();
                $(currtagobj).parent().parent().parent().parent().find('#img1').attr('src','img/delete.png');
                $(currtagobj).parent().parent().parent().parent().find('#img1').removeClass("img1");
                $(currtagobj).parent().parent().parent().parent().find('#img1').addClass("img2");
            }
            function addtag_tolist(tagpointer,tagval)
            {
                $(tagpointer).parent().parent().find('.tagbox').append(tagval);
            }

            function add_comment(addcommentobj)
            {
                var usercomment =$(addcommentobj).parent().parent().find('.document_commentbox').val();
                if(usercomment == '')
                    {
                        alert("enter the comment");
                    }
                else
                    {
                        var actiontype = 'comment';
                        var documentname     = $(addcommentobj).parent().parent().parent().parent().parent().parent().find('.documentname a').text();
                        var documentrevision = $(addcommentobj).parent().parent().parent().parent().parent().parent().find('.documentrev span').text();
                        var documentid       = $(addcommentobj).parent().parent().parent().parent().parent().parent().find('.documentname .docid').text();
                       $.ajax({
                        type: "POST",
                        data: {
                            usercomment      : usercomment,
                            documentname     : documentname,
                            documentrevision : documentrevision,
                            actiontype       : actiontype,
                            documentid       : documentid
                        },
                        url: "savedoc_tagscomment.php",
                        success: function(msg){
                            $('.document_commentbox').val('');
                            var actiontext = 'New comment on '+documentrevision+' revision of '+documentname+' document.';
                            $.ajax({
                                       type: "POST",
                                       data: {
                                                 actiontext : actiontext
                                             },
                                       url: "track_history.php",
                                       success: function(response){ 
                                            //window.location.reload(true);    
                                       }   
                                   });
                           $.ajax({
                                        type: "POST",
                                        data: {
                                                   template_id:documentid+'-'+documentrevision,  /* template_id contain DocumentId and Revision eg:   54507fe19fb5d3547f6526aa-1 */
                                                   documentname:documentname,  /* documentname conatin DocumentName eg:Demo */
                                                   type:'getCommments'
                                                },
                                        url: "document_checkout_process.php",
                                        success: function(response){
                                            //alert(response);
                                            commenthtml='';
                                            var data =$.parseJSON(response);
                                            var commentstextarray = data.Text;
                                            var commentsnamearray = data.User;
                                            var commentsdatearray = data.Date;
                                            var commentslen = data.Text.length;
                                            if(commentslen < 6)
                                            {
                                                len = commentslen;
                                            }
                                            else{
                                                len = 5;
                                            }
                                                
                                            commenthtml1='<div class="div-padding" id="add-comment1"><a onclick="viewmorecomments(this);">View More Comments('+commentslen+') </a></div>';
                                            for(var index = 0; index < len;index++){
                                                    commenthtml+='<div class="row"><div class="more-comment div-padding" >';
                                                    commenthtml+='<a><i>'+commentsnamearray[index]+':</i></a>'+ commentstextarray[index];										 
                                                    commenthtml+='<div class="date colour">'+commentsdatearray[index]+'</div></div></div>';
                                                }
                                            $(addcommentobj).parent().parent().parent().children(':eq(0)').remove();
                                            $(addcommentobj).parent().parent().parent().prepend(commenthtml1); 
                                            $(addcommentobj).parent().parent().parent().children(':eq(1)').children().remove();
                                            $(addcommentobj).parent().parent().parent().find('.morecomments').html(commenthtml);
//                                            $(addcommentobj).parent().parent().children(':eq(1)').children().val('');
                                            }
                                        });        
                        }
                        });
                    }
            }
            function viewmorecomments(currobj)
            {
                var documentid       = $(currobj).parent().parent().parent().parent().parent().find('.documentname .docid').text();
                var documentrevision = $(currobj).parent().parent().parent().parent().parent().find('.documentrev span').text();
                var documentname     = $(currobj).parent().parent().parent().parent().parent().find('.documentname a').text();
                $.ajax({
                            type: "POST",
                            data: {
                                       template_id:documentid+'-'+documentrevision,  /* template_id contain DocumentId and Revision eg:   54507fe19fb5d3547f6526aa-1 */
                                       documentname:documentname,  /* documentname conatin DocumentName eg:Demo */
                                       type:'getCommments'
                                    },
                            url: "document_checkout_process.php",
                            success: function(response){
                                commenthtml='';
                                var data =$.parseJSON(response);
                                var commentstextarray = data.Text;
                                var commentsnamearray = data.User;
                                var commentsdatearray = data.Date;
                                var len = data.Text.length;

                                for(var index = 0; index < len;index++){
                                        commenthtml+='<div class="row"><div class="more-comment div-padding" >';
                                        commenthtml+='<a><i>'+commentsnamearray[index]+':</i></a>'+ commentstextarray[index];										 
                                        commenthtml+='<div class="date colour">'+commentsdatearray[index]+'</div></div></div>';
                                    }
                                $(currobj).parent().parent().children(':eq(1)').find('.row').remove();
                                $(currobj).parent().parent().find('.morecomments').html(commenthtml);
                                }
                            });
            }

            function add_tags(addtagobj)
            {
                var taglistarray = new Array();
                var taglistindex = 0;
                var usertag =$(addtagobj).parent().parent().find('.chosen-container-multi').html();
                $(addtagobj).parent().parent().find('.chosen-container-multi ul li').each(function(){
                    if($(this).find('span').length > 0)
                        {
                            taglistarray[taglistindex] = $(this).find('span').text();
                            taglistindex++;
                        }
                });

                if(taglistarray.length == 0)
                    {
                        alert("enter the Tags");
                    }
                else
                    {
                        var actiontype = 'tag';
                        var documentname     = $(addtagobj).parent().parent().parent().parent().parent().parent().find('.documentname a').text();
                        var documentrevision = $(addtagobj).parent().parent().parent().parent().parent().parent().find('.documentrev span').text();
                        var documentid       = $(addtagobj).parent().parent().parent().parent().parent().parent().find('.documentname .docid').text();

                        $.ajax({
                        type: "POST",
                        data: {
                            taglistarray      : taglistarray,
                            documentname      : documentname,
                            documentrevision  : documentrevision,
                            actiontype        : actiontype,
                            documentid        : documentid
                        },
                        url: "savedoc_tagscomment.php",
                        success: function(msg){
                            var actiontext = 'New tag is added in '+documentrevision+' revision of '+documentname+' document.';
                            $.ajax({
                                       type: "POST",
                                       data: {
                                                 actiontext : actiontext
                                             },
                                       url: "track_history.php",
                                       success: function(response){ 
                                            window.location.reload(true);    
                                       }   
                                   });
                        }
                        });
                    }
            }


            function display_hidediv(currobj)
            {
                var imgdivid = $(currobj).attr('class');
                if(imgdivid.match("img1"))
                    {
                        $(currobj).parent().parent().parent().find('.hide_div').css('display','block');
                        $(currobj).attr('src','img/delete.png');
                        $(currobj).removeClass("img1");
                        $(currobj).addClass("img2");
                    }
                if(imgdivid.match("img2"))
                    {
                        $(currobj).parent().parent().parent().find('.hide_div').css('display','none');
                        $(currobj).attr('src','img/add-icon.png');
                        $(currobj).removeClass("img2");
                        $(currobj).addClass("img1");
                    }

            }


            function showDialog(currobj){
                 selectopt='';
                 BootstrapDialog.show({
                                        type:BootstrapDialog.TYPE_DEFAULT,
                                        title: 'Add to Bouquet',
                                        message: $(
                                                    '<div class="row form-group"><label for="sel_bouquet" class="col-md-3  control-label">Select Bouquet Name</label><div class="col-md-6 col-sm-6"><select class="form-control template col-md-4 col-sm-4" id="sel_bouquet" readonly> '+str+'</select></div></div>'
                                                   ),
                                        draggable: true,
                                        buttons: [{
                                                      label: 'Add to Bouquet',
                                                      cssClass: 'btn-success',
                                                      action: function(dialogRef){
                                                                                    id = $(currobj).parent().parent().find('.doccumentid').val();
                                                                                    documentname = $(currobj).parent().parent().parent().find('.documentname a').text();
                                                                                    selectopt = $('#sel_bouquet option:selected').text();

                                                                                    if(selectopt !=''){
                                                                                        savetobouquet(id,selectopt,documentname); 
                                                                                    }else{
                                                                                        alert("Please Select Bouquet Name"+selectopt);
                                                                                    }

                                                                                 }
                                                  }, 
                                                  {
                                                      label: 'Close',
                                                      action: function(dialogRef){
                                                                                    dialogRef.close();
                                                                                  }
                                                  }]
                                            });
             }

             function savetobouquet(id,selectopt,documentname)
            {
                var q = confirm("Do you want to add Document to Bouquet");
                if(q){
                        $.ajax({
                                    type: "POST",
                                    data: {
                                              id:id,
                                              selectopt:selectopt,
                                              datatype:'bouquetupdate'
                                          },
                                    url: "savedoc_tagscomment.php",
                                    success: function(response){
                                         if(response == '0')
                                         {
                                             alert("This document already present in '"+selectopt+ "' bouquet");
                                             $( ".close" ).click();
                                         }
                                         else
                                         {
                                             var docrevision = id.split('_');
                                             docrevision = docrevision[1];
                                             alert("Document added to '"+selectopt+"' bouquet successfully");
                                             var actiontext = docrevision+' Revision of '+documentname+" Document is added into '"+selectopt+"' bouquet.";
                                             $.ajax({
                                                    type: "POST",
                                                    data: {
                                                                actiontext : actiontext
                                                            },
                                                    url: "track_history.php",
                                                    success: function(response){ 
                                                            $( ".close" ).click();    
                                                    }   
                                                });

                                         }
                                    }
                               });
                    }
            }


            function redirecttoupload(curstatus)
            {
                var status = $(curstatus).val();
                var docid  = $(curstatus).parent().parent().parent().find('.documentname .docid').text();
                var docrev = $(curstatus).parent().parent().parent().find('.documentrev span').text();
                var templatename = $(curstatus).parent().parent().parent().find('.documenttemp .tempname').text();
                templatename = templatename.replace(/ /g,"_");
                $('#templatename').val(templatename);
                var docname = $(curstatus).parent().parent().parent().find('.documentname a').text();
                $('#docname').val(docname);
                var docinfo = docid+'-'+docrev;
                $('#docinfo').val(docinfo);
                var temppath = $(curstatus).parent().parent().parent().find('.documenttemp .temppath').text();
                $('#templocation').val(temppath);
                var filenmext = $(curstatus).parent().parent().parent().find('.fileextension img').attr('src');
                filenmext = filenmext.split('/');
                var extindex = parseInt(filenmext.length) - 1;
                var actualfileext = filenmext[extindex].split('.');
                actualfileext = actualfileext[0];
                $('#filename').val(actualfileext);
                var tenantid = '<?php  echo $tenantid;?>';
                var departmentid = '<?php echo $userdepartid; ?>';
                var q = confirm('Do You Want to CheckOut Document');
                if(q){
                    if(status == 'CheckedIn')
                        {
                              $.ajax({
                                        type: "POST",
                                        data: {
                                                  docid        : docid,
                                                  docrev       : docrev,
                                                  tenantid     : tenantid,
                                                  departmentid : departmentid
                                              },
                                        url: "update_documentstate.php",
                                        success: function(response){

                                        }
                                  });
                                  var actiontext = docrev+" Revision of "+docname+" Document is CheckedOut";
                                  $.ajax({
                                            type: "POST",
                                            data: {
                                                actiontext : actiontext
                                            },
                                            url: "track_history.php",
                                            success: function(response){ 
                                                document.getElementById('revisionForm').submit();    
                                            }   
                                        });

                        }
                    else
                        {
                            alert("Document is in CheckedOut state");
                        }
                }    
            }
            function addToArchive(currobj){
                var docid  = $(currobj).parent().parent().parent().find('.documentname .docid').text();
                var docrev = $(currobj).parent().parent().parent().find('.documentrev span').text();
                var docname = $(currobj).parent().parent().parent().find('.documentname a').text();
                //alert(docname);
                var q = confirm('Do You Want to add Document to Archive');
                if(q){
                      $.ajax({
                                type: "POST",
                                data: {
                                          docid        : docid,
                                          docrev       : docrev,
                                          type         :'setArchrive'
                                      },
                                url: "document_checkout_process.php",
                                success: function(response){
                                    //alert(response);
                                }
                          });
                          var actiontext = docrev+" Revision of "+docname+" Document is Archived";
                          $.ajax({
                                    type: "POST",
                                    data: {
                                        actiontext : actiontext
                                    },
                                    url: "track_history.php",
                                    success: function(response){ 
                                        window.location.reload(true);
                                    }   
                                });

                        }
          }
            
        </script>
        <style>
            .docsubsec_title
            {
                text-decoration: none;
            }
            .add-comment
            {
                border-top: 1px solid #B8BFBC;
                padding: 9px 0px;   
            }
            .tagbox
            {
                height:30%;
                width: 100%;
            }
            .tag_selectbox
            {
                margin: 2% 0;
            }
            .searchtag
            {
                height: 25px !important;
            }
            #chosenForm .chosen-choices {
                border: 1px solid #ccc;
                border-radius: 4px;
                min-height: 34px;
                padding: 6px 12px;
            }
            #chosenForm .form-control-feedback {
                /* To make the feedback icon visible */
                z-index: 100;
            }
            .chosen-container .chosen-choices
            {
                width: 100% !important;
                height: 10% !important;
                overflow: auto;
            }
            #btn_tag
            {
                margin-top:7px!important;
            }
            .chosen-container{
                width:100% !important;
            }
        </style>
    </head>
    <body >


    <!----------- Header page--------------------------------------------->
    <?php include_once 'header.php'; ?> 
    <div class="row row-margin">
        <div class="col-md-3">
        <!--------- dash board side menu------------------------------------------------>
            <?php include_once'dash_menu.php' ?>  
        </div>
        <div class="col-md-9 div-padding-left" id="body-content">
        <!--This page as to be create dynamically.......-->
        <div class="row">
            <p class="spaceerror col-md-12" style="color:red"> </p>
        </div>
            <form name="dashboardform" action="view_document.php" method="post">
                <input type="hidden" name="selected_doc" id="selected_doc" value="">
                <input type="hidden" name="doc"  id="doc" value="">
                <input type="hidden" name="revision" id="revision" value="">
                <input type="hidden" name="tempname" id="tempname" value="">
                <input type="hidden" name="temppath" id="temppath" value="">
                <input type="hidden" name="userdepartmentid" id="userdepartmentid" value="<?php echo $userdepartid;?>">
                <input type="hidden" name="usertenant" id="usertenant" value="<?php echo $tenantid;?>">
            </form> 
        
           <form action="upload.php" name="revisionForm" id="revisionForm" method="post">
                <input type="hidden" value="" name="docinfo" id="docinfo"/>
                <input type="hidden" value="" name="templocation" id="templocation"/>
                <input type="hidden" value="" name="docname" id="docname"/>
                <input type="hidden" value="" name="filename" id="filename">
                <input type="hidden" value="" name="templatename" id="templatename">
           </form>    
        
                
    <div class="dashboard_container">
    <?php
        
            
            $companytags = array();
            $usertagdata = $g1->get_mongodb->companytagData($tenantid);
            if($usertagdata != 0){
            foreach ($usertagdata as $companytagkey)
            {
                if(array_key_exists('DepartmentId',$companytagkey))
                {
                    if($companytagkey['DepartmentId'] == $userdepartid){
                        if(array_key_exists('TagList',$companytagkey))
                        {
                            foreach ($companytagkey['TagList'] as $cmptagval) {
                                $companytags[] = $cmptagval['Tag'];
                            }
                        }
                    }
                }
                else
                {
                    if(array_key_exists('TagList',$companytagkey))
                        {
                        foreach ($companytagkey['TagList'] as $cmptagval) {
                                $companytags[] = $cmptagval['Tag'];
                            }
                    }
                }
            }
            }
            
            $dashboarddata= $g1->get_mongodb->dashboardData($tenantid,$userdepartid);
            if($dashboarddata != '0')
            {    
                
                foreach ($dashboarddata as $dockey)
                {
                    if(array_key_exists('DocumentName',$dockey)){
                    $templatename = '';
                    $htmltemplate = '';
                    $htmltemppath = '';
                    $documentid   =$dockey['_id'] ;
                    $latestrevsion = $g1->get_mongodb->getlatestDocumentrevision($tenantid,$userdepartid,$documentid);
                    $doclatestrevision = $latestrevsion['RevisionNo'];
                    $documentName = $dockey['DocumentName'];
                    
                    if(array_key_exists('TemplateId',$dockey)){
                       $doctemplate  = $dockey['TemplateId'];
                       $templatename['tempresult'] = $g1->get_mongodb->templatenameData($tenantid,$userdepartid,$doctemplate);
                       if($templatename['tempresult'] != 0)
                       {
                           foreach ($templatename['tempresult'] as $tempkey) {
                                if(array_key_exists('HtmlFileName',$tempkey))
                                {
                                        $htmltemplate = $tempkey['HtmlFileName'];
                                }
                                if(array_key_exists('HtmlFileLocation',$tempkey))
                                {
                                        $htmltemppath = $tempkey['HtmlFileLocation'];
                                }
                                if(array_key_exists('TemplateHeader',$tempkey))
                                {
                                    $templatename = $tempkey['TemplateHeader'];
                                }
                            }
                       }    
                    }
                    
                    
                    foreach($dockey['DocumentInfo'] as $docInfoValue)
                    {
                         $isarchived = '';
                        if(array_key_exists('IsArchived',$docInfoValue)){
                            $isarchived = $docInfoValue['IsArchived'];
                        }
                       
                        if(!$isarchived)
                        { 
                            $commentcount = 0;
                            $commentdate = '';
                            $totalcomments = 0;
                            $totaltagcount = 0;
                            $taglist = '';
                            $documenttag = array();
                            if (array_key_exists('TagList', $docInfoValue)) {
                                $taglist = $docInfoValue['TagList'];
                                    foreach ($taglist as $value) {
                                        $totaltagcount++;
                                    }
                            }

                            if (array_key_exists('RevisionNo', $docInfoValue)) {
                                $revisionNo = $docInfoValue['RevisionNo'];
                            } else {
                                $revisionNo = '';
                            }
                            if (array_key_exists('FileName', $docInfoValue)) {
                                $filename = $docInfoValue['FileName'];
                                $filenametype = explode(".",$filename);
                                $filetype     = $filenametype[1]; 
//                                if($filetype == 'xlsx'){$filetype = "xls";}
//                                if($filetype == 'docx'){$filetype = "doc";}
                            } else {
                                $filetype = ''; //jpg
                            }
                            if (array_key_exists('UploadDate', $docInfoValue)) {
                                $uploadedDate = $docInfoValue['UploadDate'];
                                $docDate = date('Y-M-d', $uploadedDate->sec);
                            } else {
                                $docDate = '';
                            }
                            if (array_key_exists('CurrentStatus', $docInfoValue)) {
                                $currstatus = $docInfoValue['CurrentStatus'];
                            } else {
                                $currstatus = '';
                            }

                            echo '<div class="well div-padding-top">';
                            echo '<div class="row">';
                            echo '<div class="col-md-2">';
                            echo '<div class="div-padding fileextension"><img src="img/file_icons/'.$filetype.'.png" style=" height: 60px; width: 80px;object-fit:contain; border: 1px #e5e5e5;">';
                            echo '</div></div>';
                            echo '<div class="col-md-8">';
                            if($documentName != ''){ echo '<p class="documentname">Document Name:<a onclick=\'dynamicURL("'.$documentName.'","'.$revisionNo.'","'.$htmltemplate.'","'.$documentid.'")\'>'.$documentName.'</a><span class="docid" style="display:none">'.$documentid.'</span></p>'; }
                            echo '<p class="documentrev">Document latest revision:<span>'.$revisionNo.'</span></p>';
                            if($templatename != ''){ echo '<p class="documenttemp">Document Template:<span class="tempname">'.$templatename.'</span><span class="tempid" style="display:none">'.$doctemplate.'</span><span class="temppath" style="display:none">'.$htmltemppath.'</span></p>'; }
                            if($docDate != '') { echo '<p>Date:<span>'.$docDate.'</span></p>'; }
                            if($htmltemplate !='' && $htmltemppath != ''){echo '<p><input type="hidden" class="doctemp" value="'.$htmltemplate.'">
                                                                                        <input type="hidden" class="doctemppath" value="'.$htmltemppath.'"></p>';}
                            echo '</div>';
                            echo '<div class="col-md-2">';
                            echo '<p><button type="button" class="revsioncomment" onclick="makefocusComment(this);" value="Comments"><span class="glyphicon glyphicon-comment"> </span> Comments</button></p>
                                  <p><button type="button" class="revsiontags" onclick="makefocusTag(this);" value="Tags"><span class="glyphicon glyphicon-tag"> </span> Tags</button></p>';
                            if($currstatus == 'CheckedIn')
                            {
                            //echo '<p><button type="button" class="revsionstatus" onclick="redirecttoupload(this)" value="'.$currstatus.'"><span class="glyphicon glyphicon-bookmark"> </span> '.$currstatus.'</button></p>';
                            echo '<p><button type="button" class="revsionstatus" onclick="redirecttoupload(this)" value="'.$currstatus.'"><span class="glyphicon glyphicon-bookmark"> </span>Check Out</button></p>';
                            echo '<input type="hidden" class="doccumentid" value="'.$dockey['_id'].'-'.$revisionNo.'">';

                            echo '<p><button type="button" class="add_to_bouquet" value="Add to Bouquet" onclick="showDialog(this)"><span class="glyphicon glyphicon-cloud-upload" style="float:left"> </span> Add to Bouquet</button></p>
                                  <p><button type="button" class="add_to_archive" value="Add to Archive" onclick="addToArchive(this);"><span class="glyphicon glyphicon-briefcase"> </span> Add to Archive</button></p>';
                            }
                            else
                            {
                            echo '<p>Latest Revision: <a href="view_document.php?doc='.$documentName.'&revision='.$doclatestrevision.'&tempname='.$htmltemplate.'&documentid='.$documentid.'" rel="facebox">'.$doclatestrevision.'</a></p>';
                            }
                            echo '</div>';
                            echo '</div>'; 
                            echo '<div class="row">
                                  <div class="col-md-1 col-md-offset-11" >';
                            echo  '<img src="img/add-icon.png" id="img1" class="img1" style="width:20px;height:20px;" onclick="display_hidediv(this)">
                                  </div>
                                  </div>';
                            echo '<div class="hide_div">'; 
                            if(array_key_exists('Comments', $docInfoValue))
                            { foreach ($docInfoValue['Comments'] as $commentValue) {
                                    $totalcomments++;}
                            }        
                            echo '<div class="row comment div-margin">
                                  <div class="col-md-6">
                                  <div class="row-fluid"><a class="docsubsec_title" onclick="viewmorecomments(this);">View More Comments('.$totalcomments.')</a></div>
                                  <div class="morecomments row col-md-12" style ="max-height:230px; overflow-y :auto;">';

                            if(array_key_exists('Comments', $docInfoValue))
                            {
                                 $docInfoValue['Comments'] = array_reverse($docInfoValue['Comments']);
                                foreach ($docInfoValue['Comments'] as $commentValue) {
                                    if(array_key_exists('CommentText', $commentValue))
                                    {
                                        $commentText = $commentValue['CommentText'];
                                    }
                                    else
                                    {
                                        $commentText = '';
                                    }
                                    if(array_key_exists('CommentDate', $commentValue))
                                    {
                                        $commentDate = $commentValue['CommentDate'];
                                        $commentdate = date('d-M-Y h:i:s', $commentDate->sec);
                                    }
                                    else
                                    {
                                        $commentdate = '';
                                    }
                                    if(array_key_exists('UserId', $commentValue))
                                    {
                                        $userobjId = $commentValue['UserId'];
                                        foreach ($userarr as $userarrvalue) {
                                            if ($userarrvalue['_id'] == $userobjId) {
                                                $userId = $userarrvalue['Name'];
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $userId = '';
                                    }
                                     if($commentcount < 5){     
                           echo   '          
                                   <div class="row-fluid more-comment div-padding">
                                       <i style="color:#2a6496">'.$userId.'</i> :'.$commentText.'
                                       <div class="date colour">'.$commentdate.'</div>    
                                   </div>';
                                   $commentcount++;
                                           }

                                  }
                             }
                             else
                            {
                                $commentText = '';
                                $commentDate = '';
                                $userId = '';
                            }
                           echo  '</div>
                                    <div class="form-group row-fluid add-comment">
                                    <div class="col-md-9 ">
                                    <input type="text" class="form-control txt_comment1 document_commentbox document_border"  id="txt_comment1" placeholder="Comment" name="" autofocus/>
                                    </div>
                                    <div class="col-md-2">
                                    <input type="button" id="btn_comment" class="btn ctrl-btn btn_comment" value="Comment" onclick="add_comment(this)">
                                    </div>
                                 </div> ';
                           echo   '</div>
                                    <div class="col-md-6">
                                    <div class="row-fluid"><a class="docsubsec_title">View More Tags('.$totaltagcount.') </a></div>
                                    <div class="row-fluid" style="padding:5px 0px;border-top: 1px solid #B8BFBC;">
                                        <div class="tag_selectbox col-md-9">
                                        <select name="colors" class="form-control chosen-select" multiple data-placeholder="select tags">';
                                        foreach ($taglist as $depttagvalue) {
                                            $documenttag[] = $depttagvalue;
                                        }
                                     foreach ($companytags as $comptagvalue) {
                                         $flagtag = 0;
                                         foreach ($documenttag as $doctagvalue) {
                                             if($comptagvalue == $doctagvalue)
                                             { $flagtag = 1;}
                                         }
                                         if($flagtag == 1)
                                         {
                                             echo '<option value="'.$comptagvalue.'" selected>'.$comptagvalue.'</option>';
                                         }
                                         else
                                         {
                                             echo '<option value="'.$comptagvalue.'">'.$comptagvalue.'</option>';
                                         }
                                     }

                           echo   ' </select>
                                    </div>
                                    <div class="col-md-2">
                                    <input type="button" id="btn_tag" class="btn ctrl-btn" value="Save Tags" onclick="add_tags(this)">
                                    </div>';
                           echo    '</div>
                                    </div>
                                    </div>';
                           echo    '</div>';
                           echo    '</div>';
                       }
                    }
                }              
          }
     }  
                           
                    ?>
                </div>    
            </div>

        </div>

        <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php' ?>
        <script src="jqueryui/ui/minified/jquery-ui.min.js"></script>
        <script src="js/dmstree_js/jquery.tag-editor.js"></script>
        <script type="text/javascript" src="js/dmstree_js/body_dash_page.js"></script>
    </body>
</html>