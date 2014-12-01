<?php 
    ob_start();
    session_start();
    include 'session_timeout.php';
    require('../CodeIgniter-old/external.php');
    $ci =& get_instance();
    $ci->load->library("cimongo/cimongo");
    $ci->load->model('get_mongodb');
    $g1 = new Get_mongodb();
    $userId = $_SESSION['userid'];
    $documentid = '';
    if(isset($_GET['documentid']))
    {
        $documentid = $_GET['documentid'];
    }
    $userInfo = $g1->get_mongodb->getUserInfo($userId);
    $name = $userInfo[0]['Name'];
    $docname = '';
    $docrevison = '';
    $tempname = '';
    $temppath = '';
    $userdepartid = '';
    $documentid = '';

    $tenantid = $_SESSION['usertenant'];
    $userid = $_SESSION['userid'];
    if(isset($_GET['doc']))
    {
        $docname = $_GET['doc'];
    }
    if(isset($_GET['revision']))
    {
        $docrevison = $_GET['revision'];
    }
    if(isset($_GET['tempname']))
    {
        $tempname = $_GET['tempname'];
    }
    if(!empty($tempname)){
        $temppath = $g1->get_mongodb->getTemplatelocation($tenantid,$tempname);
        $temppath = $temppath[0]['HtmlFileLocation'];
    }
    if(isset($_GET['documentid']))
    {
        $documentid = $_GET['documentid'];
    }
    $companytags = array();
    $tenantid = intval($tenantid);
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
            //print_r($companytags);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
        <link rel="stylesheet" href="chosen_v1.2.0/chosen.min.css" />
	<link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen"  type="text/css" />
        
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/jquery.textover.js"></script>
	<script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
        <script src="chosen_v1.2.0/chosen.jquery.js"></script>
        <script src="facebox-master/src/facebox.js" type="text/javascript"></script>
        <style>
               .imgtags
                    {
                        border: 2px solid yellow;
                        text-align: center;
                     }
                    .imgtags span {
                            display: inline-block;
                            vertical-align: middle;
                            line-height: normal;
                            }
                    #locationcontainer
                    {
                        padding-left: 0 !important;
                        padding-right: 0 !important;
                    } 
           </style> 
       <script>
            var str = '';
           var selectopt;
           $(document).ready(function(){
               imgSrc='/facebox/closelabel.png';
               $('img').each(function(i,ele){
                if ($(this).attr("src") == imgSrc) { $(this).css("display","none"); }
              });

			  
              var documentid = "<?php echo $documentid;?>";
               var docname = "<?php echo $docname;?>";
               var docrevison =<?php echo $docrevison;?>;
               var tempname = "<?php echo $tempname;?>";
               var templatepath = "<?php echo $temppath;?>";
               var tenantid = <?php echo $tenantid; ?>;
               var departmentid = "<?php echo $userdepartid; ?>";
               if(docname != ''  && tempname != '')
               {
                   $('.document_template').load(templatepath+'/'+tempname);
                   setTimeout(function(){getDocumentValues(documentid,docname,docrevison,tenantid,departmentid,templatepath,tempname)}, 1000);
               }    
               else if(docname != ''  && tempname == '')
               {
                   $('.document_template').css('display','none');
                   setTimeout(function(){getDocumentValues(documentid,docname,docrevison,tenantid,departmentid,templatepath,tempname)}, 1000);
               }
               //$(".chosen-select").chosen().change();
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
           });
           
           
           function getDocumentValues(documentid,docname,docrevison,tenantid,departmentid)
           {
               $.ajax({
                        type: "POST",
                        async: false,
                        data:{
                            documentid:documentid,
                            docname : docname,
                            docrevison: docrevison,
                            tenantid : tenantid,
                            departmentid : departmentid
                        },
                        url: "getdocumentmetadata.php",
                        success: function(response){
                            var data = $.parseJSON(response);
                            if( "TagList" in data ) {
                            var compnytags = <?php echo json_encode($companytags);?>;
                            var taglistArr   =  data.TagList;
                            var taglistLen    =  data.TagList.length;
                            var cmptagsLen    =  compnytags.length; 
                            var taglistIndex = 0;
                            var comptagIndex = 0;
                            if(taglistLen>0){
                                for(comptagIndex= 0;comptagIndex < cmptagsLen;comptagIndex++)
                                    {
                                        var flagtag = 0;
                                        for(taglistIndex = 0; taglistIndex < taglistLen; taglistIndex++)
                                            {
                                                var taglistItem  = taglistArr[taglistIndex];
                                                if(compnytags[comptagIndex] == taglistItem)
                                                    {flagtag = 1;}
                                            }
                                        if(flagtag == 1)
                                        {    
                                            var tagselectopt = '<option value="'+compnytags[comptagIndex]+'" selected>'+compnytags[comptagIndex]+'</option>';
                                            $('.document_tags').append(tagselectopt);
                                        }
                                        else
                                        {
                                           var tagselectopt = '<option value="'+compnytags[comptagIndex]+'">'+compnytags[comptagIndex]+'</option>';
                                            $('.document_tags').append(tagselectopt); 
                                        }

                                    }
                            }
                            else {
                                for(comptagIndex= 0;comptagIndex < cmptagsLen;comptagIndex++)
                                    {
                                        var tagselectopt = '<option value="'+compnytags[comptagIndex]+'">'+compnytags[comptagIndex]+'</option>';
                                            $('.document_tags').append(tagselectopt); 
                                    }
                            }
                               
                            }
                            setTimeout(function(){$('.chosen-select').chosen();}, 500);
                            if( "ExpiryDate" in data ) {
                                    var t = new Date(1970,0,1);
                                     t.setSeconds(data.ExpiryDate['sec']);
                                     var dt = t;
                                     var expirydate = moment(dt).format('DD/MM/YYYY');
                                    $('.doc_expirydate').val(expirydate);
                                    $('#datetimepicker').datetimepicker({defaultDate:expirydate});
                            }
                            if('Date' in data)
                                {
                                    var tempdate = data.Date;
                                    var tempdatelen    =  data.Date.length;
                                    
                                    for(var tempdateindex = 0; tempdateindex < tempdatelen; tempdateindex++)
                                        {
                                            var datename = tempdate[tempdateindex].Name;
                                            var datetime = tempdate[tempdateindex].Value['sec'];
                                            var dat = new Date(1970,0,1);
                                            dat.setSeconds(datetime);
                                            var dtt = dat;
                                            var cntrldate = moment(dtt).format('DD/MM/YYYY');
                                            $('#doc_template').find('input[name="'+datename+'"]').val(cntrldate);
                                            $('#doc_template').find('input[name="'+datename+'"]').attr('readonly',true);
                                            
                                        }
                                }
                            if( "CurrentStatus" in data ) {
                                    $('.doc_status').text(data.CurrentStatus);
                                    //alert(data.CurrentStatus);
                                    if(data.CurrentStatus == 'CheckedOut'){
                                        $('#status').val('Check In');
                                        $('.btnstatus').css('display','none');
                                    }
                                    else if(data.CurrentStatus == 'CheckedIn'){
                                        $('#status').val('Check Out');
                                        $('.btnstatus').css('display','inline-block');
                                        
                                    }
                                        
                            }
                            if( "textboxctrl" in data ) {
                            var textboxArr   =  data.textboxctrl;
                            var texboxLen    =  data.textboxctrl.length;
                            for(var textboxIndex = 0; textboxIndex < texboxLen; textboxIndex++)
                                {
                                    var textboxName  = textboxArr[textboxIndex].Name;
                                    var textboxValue = textboxArr[textboxIndex].Value;
                                    $('#doc_template').find('input[name="'+textboxName+'"]').val(textboxValue);
                                    $('#doc_template').find('input[name="'+textboxName+'"]').attr('readonly',true);
                                }
                            }
                           
                            if( "textareactrl" in data ) {
                            var textareaArr  =  data.textareactrl;
                            var textareaLen  =  data.textareactrl.length;
                            for(var textareaIndex = 0; textareaIndex < textareaLen; textareaIndex++)
                                {
                                    var textareaName  = textareaArr[textareaIndex].Name;
                                    var textareaValue = textareaArr[textareaIndex].Value;
                                    $('#doc_template').find('textarea[name="'+textareaName+'"]').val(textareaValue);
                                    $('#doc_template').find('textarea[name="'+textareaName+'"]').attr('readonly',true);
                                }
                            }
                            if( "custlistctrl" in data ) {
                            var custlistArr  =  data.custlistctrl;
                            var custlistLen  =  data.custlistctrl.length;
                            for(var custlistIndex = 0; custlistIndex < custlistLen; custlistIndex++)
                                {
                                    var custlistName  = custlistArr[custlistIndex].Name;
                                    var custlistValue = custlistArr[custlistIndex].SelectedValue;
                                    $('#doc_template').find('select[name="'+custlistName+'"]').val(custlistValue);
                                    $('#doc_template').find('select[name="'+custlistName+'"]').attr('readonly',true);
                                }
                            }
                            if("radioctrl" in data){
                            var radioArr     =  data.radioctrl;
                            var radioLen     =  data.radioctrl.length;
                            for( var radioIndex = 0; radioIndex < radioLen; radioIndex++)
                                {
                                    var radioName  = radioArr[radioIndex].Name;
                                    var radioValue = radioArr[radioIndex].SelectedOption;
                                    $('#doc_template').find('input[name="'+radioName+'"][value="'+radioValue+'"]').prop('checked', true);
                                    $('#doc_template').find('input[name="'+radioName+'"][value="'+radioValue+'"]').prop('disabled', true);
                                }
                            }
                            if("checkboxctrl" in data){
                            var checkboxArr  =  data.checkboxctrl;
                            var checkboxLen  =  data.checkboxctrl.length;
                            for(var checkboxIndex = 0; checkboxIndex < checkboxLen; checkboxIndex++)
                                {
                                    var checkboxName  = checkboxArr[checkboxIndex].Name;
                                    var checkboxValue = checkboxArr[checkboxIndex].SelectedOption;
                                    $('#doc_template').find('input[name="'+checkboxName+'"][value="'+checkboxValue+'"]').prop('checked', true);
                                    $('#doc_template').find('input[name="'+checkboxName+'"][value="'+checkboxValue+'"]').prop('disabled', true);
                                }
                            }
                            if("tablectrl" in data){
                            var tableArr     =  data.tablectrl;
                            var tableLen     =  data.tablectrl.length;
                            for(var tableIndex = 0; tableIndex < tableLen; tableIndex++)
                                {
                                    var tableId = tableArr[tableIndex].TableId;
                                    var tblIdArr  = tableArr[tableIndex].Values;
                                    var tblarrlen = tblIdArr.length;
                                    for(var subtableIndex = 0; subtableIndex < tblarrlen; subtableIndex++)
                                        {
                                            var cols   = tblIdArr[subtableIndex].Column;
                                            var row    = tblIdArr[subtableIndex].Row;
                                            var tbltdval = tblIdArr[subtableIndex].Value;
                                            var tdinputLen = $('#'+tableId).find('tr:eq('+row+') td:eq('+cols+') .tbl_td').length;
                                            if(tdinputLen > 0)
                                            {
                                                $('#'+tableId).find('tr:eq('+row+') td:eq('+cols+') .tbl_td').val(tbltdval);
                                                $('#'+tableId).find('tr:eq('+row+') td:eq('+cols+') .tbl_td').attr('readonly',true);
                                            }    
                                        }
                             }
                            }
                            if( "Comments" in data ) { 
                            var commentsArr   =  data.Comments;
                            var commentsLen    =  data.Comments.length;
                            var commentdata = '';
                            if(commentsLen < 5)
                                    commentsLen=data.Comments.length;
                            else 
                                    commentsLen=5;
                            for(var commentIndex = 0; commentIndex < commentsLen; commentIndex++)  // condition change from commentsLen -to 5
                                {
                                    
                                    var commentText  = commentsArr[commentIndex].CommentText;
									//alert(commentText);
                                    var commentsec   = commentsArr[commentIndex].CommentDate;
                                    var name = commentsArr[commentIndex].Name;
                                   commentdata +=' <div class="row"><div class="col-md-8 col-md-offset-2 more-comment div-padding">';
                                   commentdata +=' <i style="color:#2a6496">'+name+'</i> :'+commentText;
                                   commentdata += '    <div class="date colour">'+commentsec+'</div>  '; 
                                   commentdata += '</div></div> ' ;        
 
                                }
                                commentsanchour = '<a onclick="viewmorecomments(this);">View More Comments('+ commentsLen+')</a>'
                                $('#comments').append(commentsanchour)
                                $('.comment_text').append(commentdata);
                            }
                            else{
                                 commentsanchour = '<a onclick="viewmorecomments(this);">View More Comments(0)</a>'
                                $('#comments').append(commentsanchour)
                            }
                            
                           $('#doc_template').find('input').attr('readonly',true);
                             if("PhysicalLocation" in data)
                             {
                                 var locationinfo = data.PhysicalLocation;
                                 var locationimage = locationinfo['LocationPath'];
                                 if(locationimage != '')
                                     {
                                        $('.physicallocationimg').attr("src",locationimage);
                                     }
									 
                                 var locationtags = locationinfo['LocationTags']; 
                                 var taginfolen = locationtags.length;
                                 for(var imagetag = 0; imagetag < taginfolen; imagetag++)
                                     {
                                         var divdata = '';
                                         var divtags = '';
                                         var tagname = locationtags[imagetag].TagName;
                                         var tagposition = locationtags[imagetag].TagPosition;
                                         var positions = tagposition.split(',');
                                         divtags += '<a class="physicaltags"><label class="tags">'+tagname+'</label></a>';
                                         divdata += '<div class="imgtags '+tagname+'" style="width:'+positions[0]+'; height:'+positions[1]+'; top:'+positions[2]+'; left:'+positions[3]+'; opacity:1; position:absolute; "><span>'+tagname+'<span></div>';
                                         $('#locationcontainer').append(divdata);
                                         $('.locationtags').append(divtags);
                                     }
                             }
			else{
                                $('#physical').css('display','none');
                            }
                            
                        }
                    });
           }
            function viewmorecomments(currobj)
            {
               alert("this");
            }

            function add_tags_view(addtagobj)
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
                        str =$('#temp_id').val();
                        id = str.split("-");
                        var documentname     = $('#doc_name_view').val();
                        var documentrevision = $('#revision').val();
                        var documentid       = id[0];
                        //alert(documentname+' '+documentrevision+' '+documentid);

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
            function viewmorecomments(currobj){
                 id = $('#temp_id').val();
                var documentname  = $('#doc_name_view').val();
                $.ajax({
                            type: "POST",
                            data: {
                                       template_id:id,  /* template_id contain DocumentId and Revision eg:   54507fe19fb5d3547f6526aa-1 */
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
                                        commenthtml+='<div class="row"><div class="col-md-8 col-md-offset-2 more-comment div-padding" >';
                                        commenthtml+='<a><i>'+commentsnamearray[index]+':</i></a>'+ commentstextarray[index];										 
                                        commenthtml+='<div class="date colour">'+commentsdatearray[index]+'</div></div></div>';
                                    }
                                $('.comment_text').find('.row').remove();
                                $('.comment_text').html(commenthtml);
                                }
                            });
            }
            function reload_page(){
                 jQuery(document).trigger('close.facebox');
                 $('#facebox').remove();
            }
           $('.close').click(function(){
               $('#facebox').remove();
			   $('.bootstrap-datetimepicker-widget').remove(); 
			   $('.tag_selectbox').children(':eq(2)').remove();
			   
           });
           
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
                                                                                    id = "<?php echo $documentid;?>";
                                                                                    documentname = "<?php echo $docname;?>";
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
                                            //alert(response);
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
             
             function addToArchive(currobj){
                var docid  = $('#docid').val();
                var docrev = $('#docrevision').val();
                var docname = $('#doc_name_view').val();
                //alert(docid+' '+docname+' '+docrev);
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
                                    alert(response);
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
           $(".close").click(function(){
                $('#facebox').remove(); 
                $('.bootstrap-datetimepicker-widget').remove(); 
                $('.tag_selectbox').each(function(){
                    $(this).children(':eq(2)').remove();
                });
                
                $('.tag_txtbox').children(':eq(2)').remove();
                $('.bouquetnm_txtbox').children(':eq(2)').remove();
                $('.predefinefiletype_txtbox').children(':eq(2)').remove();
                $('#ui-datepicker-div').remove();
            });
          </script>
    </head>
    <body>
     
        <div class="row row-margin">
            <div class="col-md-12 col-sm-12 div-padding-left" id="body-content">
            <!--------- dash board body------------------------------------------------> 

                <div class="well div-padding-top">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 form_title"><h3 class="text-muted"><b>View Document</b></h3></div>
                    </div>
                    <div class="div-padding">
                        <form id="viewDocumentForm" name="viewDocumentForm" method="post" class="form-horizontal  form-action" action="upload.php">
                            <div class="form-group row">
                                <div class ="col-md-12">
                                    <div class=" row">
                                        <label>
                                            <input type="checkbox" name="optionsRadios" id="file_show" value="physical_loc"/>
                                            <strong> Show File</strong>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 "> 
                                    <iframe src="" style="width: 100%; height: 100%; margin-left: 12px; border: 1px ridge black;" id="doc_preview"></iframe>
                                </div>
                            </div>

                            <div class="control-group form-group row" id="tag1">
                                <label class="control-label col-md-1 col-sm-1" for="txt_tag">Tags</label>
                                <div class="col-md-6 col-sm-6" id="tag_diaplay">
                                    <select name="colors" class="form-control chosen-select document_tags" multiple data-placeholder="select tags">
                                    </select>    
                                </div>
                                <div class="col-md-2 col-sm-2" >
                                    <input type="button" id="btn_tag" class="btn ctrl-btn" value="Save Tags" onclick="add_tags_view(this)"/>
                                </div>
                                <div class="col-md-2 checkin">
                                    <span>Status:</span><span class="doc_status"></span>
                                </div>
                            </div>

                            <div class="form-group row space">
                                <div class="col-md-12 col-sm-12">	
                                    <div class="row">
                                        <div class="document_template" style="border:1px solid gainsboro">
                                        </div>    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-2 col-sm-2 control-label mar-left " ><strong>Expiry Date</strong></label>
                                    <div class='col-md-6 col-sm-6' id='date9'>
                                        <div class='input-group date' id='datetimepicker' data-date-format="DD/MM/YYYY">
                                            <input type='text' class="form-control doc_expirydate date1" name="date" readonly/>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row" id="physical">
                                <div class="col-md-12 col-sm-12">
                                    <label><strong>Physical Location</strong></label>
                                    <div class="col-md-12 col-sm-12" id="div_pic">
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2 mar-bot" id="locationcontainer">
                                                    <img class=" physicallocationimg" src="" width="400px" height="400px">
                                            </div>
                                       </div>
                                       <div class="row"> 
                                                <label class="col-md-1 col-md-offset-2 col-sm-offset-2">Tags:</label>
                                                <div class="col-md-8 locationtags"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <label class="col-md-2 col-sm-2 control-label mar-left " ><strong>Comments:</strong></label>
                                    <div class='col-md-6 col-sm-6' id='comments'>
                                    </div>
                                </div> 

                                <div class="comment_text row" style="max-height: 260px; overflow-y: auto; overflow-x: hidden;">
                                </div>    

                                <div class="form-group row">
                                    <div class="col-md-8 col-md-offset-2 add-comment">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control txt_comment2" id="txt_comment2" placeholder="Comment" value="" name=""/>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="button" id="btn_comment" class="btn ctrl-btn btn_comment" value="Comment"/>
                                        </div>
                                    </div>    
                                </div>
                                <input type="hidden" value="<?php echo $documentid.'-'.$docrevison;?>" name="tempid" id="temp_id" />
                                <input type="hidden" value="<?php echo $docname;?>" name="docname" id="doc_name_view" />
                                <input type="hidden" value="<?php echo $temppath."/".$tempname;?>" name="templocation" id="temp_location" />
                                <input type="hidden" value="<?php echo $docrevison;?>" name="revision" id="revision"/>
                            </div>    
                            <div class="form-group row">
                                <div class="col-md-12 col-sm-12">
                                    <input type="button" class="btn ctrl-btn btn-space " value="Cancel" onclick="reload_page();"/>
                                    <input type="button" class="btn btn-danger btn-space btnstatus" id="status" value="" onclick="makerevision();"/>
                                    <input type="button" class="btn btn-info" value="Timeline" id="time_line" onclick="viewtimeline();"/>
                                    <input type="button" class="btn btn-info btnstatus" value="Add to Bouquet" id="" onclick="showDialog(this);"/>
                                    <input type="button" class="btn btn-info btnstatus" value="Add to Archive" id="" onclick="addToArchive(this)"/>
                                </div>
                            </div>
                        </form>
                        <form action="document_timeline.php" method="post" target="_blank" id="timeline_form">
                            <input type="hidden" value="<?php echo $documentid;?>" name="docid" id="docid" />
                            <input type="hidden" value="<?php echo $docrevison;?>" name="docrevision" id="docrevision" />
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!--------- dash board footer------------------------------------------------>

        <script src="jqueryui/ui/minified/jquery-ui.min.js"></script>
        <script src="js/dmstree_js/jquery.tag-editor.js"></script>
        <script type="text/javascript" src="js/dmstree_js/view_document_page.js"></script>

    </body>
</html>