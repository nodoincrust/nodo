<?php 
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
$tenantid = '';
$departmentid = '';
$userdepartid = '';
$tenantname ='';
if(isset($_SESSION['usertenant']))
{
    $tenantid = $_SESSION['usertenant'];
}
if(isset($_SESSION['userdepartmentid']))
{
    $departmentid = $_SESSION['userdepartmentid'];
    $userdepartid = $_SESSION['userdepartmentid'];
}
if(isset($_SESSION['tenantname']))
{
    $tenantname = $_SESSION['tenantname'];
    $tenantname = str_replace(" ","_",$tenantname);
}


require('../CodeIgniter-old/external.php');
$ci = & get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();

$path='DMSTree_clients/'.$tenantname.'_'.$tenantid; 
$ar=getDirectorySize($path);
$tenantspace = sizeFormat($ar['size']);
$tenantspace = (float)$tenantspace;
$filesize = (float)fileSizeInMB($ar['size']);
$activepackspace = $g1->get_mongodb->getActivePackageSize($tenantid);
$activepackspace = (float)$activepackspace;

$bouquetarr = array();
$docarr     = array();
$temparr   = '';
$count = 0;

$templatedata['tempresult'] = $g1->get_mongodb->getTemplateslist($tenantid, $userdepartid);
if ($templatedata['tempresult'] != 0) {
    foreach ($templatedata['tempresult'] as $tempName) {
        $templateid = $tempName['_id'];
        $filename = $tempName['TemplateHeader'];
        $templatename = $tempName['HtmlFileName'];
        if($count == 0)
        {
            $temparr .= $filename . '||' . $templateid .'||'.$templatename;
        }
        else 
        {
            $temparr .= '::'.$filename . '||' . $templateid.'||'.$templatename ;
        }
        $count++;
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Dash-Board</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="discription" content="">
        <meta name="author" content="">
        
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
        <link rel="stylesheet" href="chosen_v1.2.0/chosen.min.css" />
        <link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen"  type="text/css" />
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <script src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
        <script src="chosen_v1.2.0/chosen.jquery.js"></script>
        <script src="facebox-master/src/facebox.js" type="text/javascript"></script>
        
	<style>
            #filter{display:none;}
            .smartsearch{ padding: 4px 12px ;}
            .error_msg{ display :none;}
            .red{ color: #FF0000;}
            .datefilteropt { padding-left: 3%;}
            .searchchk_all_lbl{ margin-top: 0 !important;}
            .andoropt { padding-right: 15px; float: right;}
            .filterbox { display: none;}
            .tag_txtbox .chosen-container, .bouquetnm_txtbox .chosen-container{ width: 210px !important; }
            .chosen-container .chosen-choices{ height: 30px !important; margin-top: 1.8%;}
            .predefinefiletype_txtbox .chosen-container{ width: 100% !important;}
            .filter_andor1
            {
               display: none;
               float: left;
            }
            .filter_andor2
            {
               display: block !important;
               float: left !important;
            }
            .add_btn{
                display:flex;
                gap:8px;
                justify-content:end;
                
            }
        </style>
        <script>
            window.onload = function(){
                value = <?php echo $filesize ?>;
                max = <?php echo $activepackspace*1000 ?>;
                showmeter(value,max);
            };
            $(function()
            {
                $('.chosen-select').chosen();
            });
            
            $(document).ready(function(){
                var directoryspace = <?php echo $tenantspace?>;
                var tenantspace    = <?php echo $activepackspace?>;
                if(parseFloat(directoryspace) >= parseFloat(tenantspace))
                {
                          $('input[type="button"]').attr('disabled','disabled');
                          var spacemsg = 'Package Size is full';
                          $('.spaceerror').text(spacemsg);    
                 }
                 else
                 {
                          $('.input[type="button"]').removeAttr('disabled');
                          $('.spaceerror').text(''); 
                 }    
            });
            
            function display_template(optvalue)
            {
                if(optvalue == '')
                {
                    $("#template").html('');
                    $("#template").css("border","none");
                }   
                else
                {
                    var filedata = optvalue.split('||');
                    var filename = filedata[0];
                    var tempid = filedata[1];
                    var temppath = filedata[2];
                    var newpath = temppath+'/'+filename;
                    $("#template").css("border","1px solid gainsboro");
                    $("#template").load(newpath); 
                }    
            }
 
            function redirecttobouquetPage()
            {
                if(($('#search_result_container .well').length) > 0)
                {
                   var docarr      = new Array();
                   var count = 0;
                   var documentInfo = '';
                   $('#search_result_container .well div .col-md-1 input').each(function(){
                           if($(this).is(':checked'))
                              {
                                var document    = new Array(); 
                                docarr[count]= new Array();
                                document['Name']     = $(this).parent().parent().find('.documentname a').text();
                                docarr[count]['Name']=document['Name'];
                                document['Revision'] = $(this).parent().parent().find('.documentrev span').text();
                                docarr[count]['Revision']=document['Revision'];
                                document['Docdate']  = $(this).parent().parent().find('.documentdate span').text();
                                docarr[count]['Docdate']=document['Docdate'];
                                var fileext = $(this).parent().parent().find('.fileextension').attr('src');
                                fileext = fileext.split('/');
                                var filetype = fileext[1].split('.');
                                document['FileType'] = filetype[0];
                                docarr[count]['FileType']=document['FileType'];
                                document['Docid'] = $(this).parent().parent().find('.documentname span').text();
                               
                               if(count == 0)
                                   {
                                       documentInfo +=document['Name']+'::'+document['Revision']+'::'+document['Docdate']+'::'+document['FileType']+'::'+document['Docid'];
                                   }
                               else
                                   {
                                       documentInfo +='||'+document['Name']+'::'+document['Revision']+'::'+document['Docdate']+'::'+document['FileType']+'::'+document['Docid'];
                                   }
                               count++;
                              } 
                              
                   });
                 
                   if(docarr.length > 0)
                    {
                        document.getElementById('docbunch').value=documentInfo;
                        document.getElementById('docrevision').submit();
                    } 
                    else
                    {
                        alert("Please select the documents");
                    }
                }   
                else
                {
                     alert("Please select the documents");
                }   
            }
           $(document).bind('afterClose.facebox', function() { $('#facebox').remove();});
           $(document).bind('loading.facebox', function() { setTimeout('',1000);}); 
            
        </script>
    </head>
    <body >
        
    <?php include_once 'header.php'; ?> 
    <div class="row row-margin">
    <div class="col-md-3" id="side-menu">
       <?php include_once'dash_menu.php'?>  
    </div>
    <div class="col-md-9" id="body-content">
        <!-- <div class="row row-fluid">
                <p class="spaceerror col-md-12 span12" style="color:red"> </p>
        </div> 
         -->
        <form id="docrevision" method="post" action="document_bouquet.php"> <!--document_bouquet_searchresult-->
        <input type="hidden" id="docform" name="docform" class="docform" value="1">
        <input type="hidden" id="docbunch" name ="docbunch" value="" class="docbunch">
        </form>
          
        <input type="hidden" value="<?php echo $temparr?>" class="templatenamearr">
       <div class="row">
        <!-- <div class="search_doc div-padding-top col-md-12"> -->
            <div class="search_doc col-md-12">
             <div class="row">
               <div class="col-md-12 form_title "><h2  class="hr-margin text-muted upload_doc_cls"><b>Search Document</b></h2></div>
           </div>
        </div>
       <div class=" well div-padding-top col-md-12">
           <!-- <div class="row">
               <div class="col-md-12 form_title "><h2  class="hr-margin text-muted upload_doc_cls"><b>Search Document</b></h2></div>
           </div> -->
           <div class="row">
               <div class="col-md-2"><label>File Name</label></div>
               <div class="col-md-5">
                   <div class="input-group">
                       <input type="text" class="form-control" id="search_string" style="border:1px solid #c5e86c !important;">
                       <span class="input-group-btn">
                       <!-- <button class="btn btn-default smartsearch save_btn_bg" type="button" onclick="var tenantid = '<?php echo $tenantid; ?>'; var departid ='<?php echo $departmentid; ?>';display_search_result(tenantid,departid);">Search</button> -->
                         <button class="btn btn-default smartsearch save_btn_bg_cancel" type="button" onclick="var tenantid = '<?php echo $tenantid; ?>'; var departid ='<?php echo $departmentid; ?>';display_search_result(tenantid,departid);">Search</button>

                       </span>
                   </div>
               </div>
               <div class="col-md-2">
                   <select name="rd_databasetype" id="datatypes_select" style="height:27px;border:1px solid #c5e86c !important;color: #666666;
    background: #a6d661;">
                       <option value="live_data"> Live Data</option>
                       <option value="archived_data"> Archived Data</option>
                   </select>    
               </div>
               <div class="col-md-3"><a id="modal" onclick="display_filter();">More Search Filters</a></div>
           </div>
           <div class="row div-padding-top">
               <div class="col-md-3"><label> Select Documents As:</label></div>
               <div class="col-md-9">
                   <input type="radio" name="documentlimit" class="rd_documentlimit" value="latest_revision"> Latest Document
                   <input type="radio" name="documentlimit" class="rd_documentlimit" value="all_revision" checked> All Documents
               </div>
           </div>    

           <div class="row" id="filter">
           <form id="registrationForm" method="post" class="form-horizontal col-md-12 form-action" action="">  

               <fieldset>
                   <legend>Find By Date </legend>
                   <div class="row"><input type="checkbox" name="all_datopt" id="datecheck" value="all_dateopt" style="margin-left:10px;">Cancel</div>
                   <div class="row">
                       <div class="form-group">
                           <label class="col-md-2 control-label datefilteropt" >
                               <input type="radio" name="rd_date" id="rd_on_date" value="on_date" >On Date
                           </label>
                           <label class="col-md-2 control-label datefilteropt" >
                               <input type="radio" name="rd_date" id="rd_before_date" value="before_date"> Before Date
                           </label>
                           <label class="col-md-2 control-label datefilteropt" >
                               <input type="radio" name="rd_date" id="rd_after_date" value="after_date"> After Date
                           </label>
                           <label class="col-md-2 control-label datefilteropt" >
                               <input type="radio" name="rd_date" id="rd_between_date" value="between_date"> Between Date
                           </label>
                           <label class="col-md-2 control-label datefilteropt" >
                               <input type="radio" name="rd_date" id="rd_in_week" value="in_week"> In This Week
                           </label>
                           <label class="col-md-2 control-label datefilteropt" >
                               <input type="radio" name="rd_date" id="rd_in_month" value="in_month"> In This Month
                           </label>
                       </div>
                   </div>
                       
                   <div class="row">
                       <div class='col-md-3' id='date1'>
                           <div class='input-group date' id='datetimepicker1' data-date-format="DD/MM/YYYY">
                               <input type='text' class="form-control" name="date" readonly />
                               <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                               </span>
                           </div>
                       </div>
                       <div class='col-md-3' id='date2'>
                           <div class='input-group date' id='datetimepicker2' data-date-format="DD/MM/YYYY">
                               <input type='text' class="form-control" name="date" readonly />
                               <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                               </span>
                           </div>
                       </div>
                       <div class='col-md-3' id='date3'>
                           <div class='input-group date' id='datetimepicker3' data-date-format="DD/MM/YYYY">
                               <input type='text' class="form-control" name="date" readonly />
                               <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                               </span>
                           </div>
                       </div>
                       <div id="date4">
                           <div class='col-md-3' id='date5'>
                               <div class='input-group date' id='datetimepicker4' data-date-format="DD/MM/YYYY">
                                   <input type='text' class="form-control" name="date" readonly />
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                   </span>
                               </div>
                           </div>
                           <label class="col-md-1 control-label mar-left " >
                               <strong>To</strong>
                           </label>
                           <div class='col-md-3' id='date6'>
                               <div class='input-group date' id='datetimepicker5' data-date-format="DD/MM/YYYY">
                                   <input type='text' class="form-control" name="date" readonly />
                                   <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                   </span>
                               </div>
                           </div>
                       </div>
                   </div>
               </fieldset>
               
               
               <fieldset>
                   <legend>Find In </legend>
                   <table style="width:100%" id="findin_chk_tbl">
                       
                   <tr>
                       <td style="width:8%">
                           <label class="checkbox">
                                <input type="checkbox" class="findin_chk" name="chk_all" value="all" id="all" > All <!--onclick="change_findinoption(this)"-->
                           </label>
                       </td> 
                       <td style="width:25%">
                           <label class="checkbox">
                                 <input type="checkbox" class="findin_chk" name="chk_comments" value="comments" id="comments">Comments
                           </label>
                       </td>
                       <td style="width:25%">
                            <div class="findinfilter_andor andoropt" style="float:left; font-size: 13px;">
                              <input type="radio" class="filter_andor" name ="findinfilter_andor_opt1" value="and" >AND
                              <input type="radio" class="filter_andor" name ="findinfilter_andor_opt1" value="or" checked>OR
                            </div>
                       </td> 
                       <td style="width:25%">
                           <label class="checkbox">
                               <input type="checkbox" class="findin_chk" name="chk_tags" value="tags" id="tags"> Tags
                           </label>
                       </td>
                 </tr>
                 
                 <tr>
                       <td></td>
                       <td><input type="text" class="comment_txtbox filterbox" style="margin-top:2%"></td>
                       <td></td>
                       <td>
                           <div class="tag_txtbox filterbox" style="width:23%"> 
                            <select name="colors" class="form-control chosen-select" multiple data-placeholder="select tags">
                                <?php
                                       $usertagdata = $g1->get_mongodb->companytagData($tenantid);
                                foreach ($usertagdata as $companytagkey) {
                                    if (array_key_exists('DepartmentId', $companytagkey)) {
                                        if ($companytagkey['DepartmentId'] == $userdepartid) {
                                            if (array_key_exists('TagList', $companytagkey)) {
                                                foreach ($companytagkey['TagList'] as $cmptagval) {
                                                    echo '<option value="' . $cmptagval['Tag'] . '" >' . $cmptagval['Tag'] . '</option>';
                                                }
                                            }
                                        }
                                    } else {
                                        if (array_key_exists('TagList', $companytagkey)) {
                                            foreach ($companytagkey['TagList'] as $cmptagval) {
                                                echo '<option value="' . $cmptagval['Tag'] . '" >' . $cmptagval['Tag'] . '</option>';
                                            }
                                        }
                                    }
                                }
                                ?>
                          </select>
                          </div>    
                     </td>    
               </tr>     
               
               <tr>
                     <td style="width:25%">
                          <div class="findinfilter_andor andoropt" style="float:left;font-size: 13px;">
                            <input type="radio" class="filter_andor" name ="findinfilter_andor_opt2" value="and" >AND
                            <input type="radio" class="filter_andor" name ="findinfilter_andor_opt2" value="or" checked>OR
                          </div>
                     </td>    
                     <td style="width:25%">
                         <label class="checkbox">
                             <input type="checkbox" class="findin_chk" name="chk_file_name" value="file_name" id="file_name">Bouquet Name
                         </label>
                     </td>
                     <td style="width:25%">
                         <div class="findinfilter_andor andoropt" style="float:left;font-size: 13px;">
                             <input type="radio" class="filter_andor" name ="findinfilter_andor_opt3" value="and" >AND
                             <input type="radio" class="filter_andor" name ="findinfilter_andor_opt3" value="or" checked>OR
                         </div>
                     </td>
                     <td style="width:25%">
                         <label class="checkbox">
                             <input type="checkbox" class="findin_chk" name="chk_template_date" value="template_data" id="template_data"> Template Data
                         </label>
                     </td>    
               </tr>  
                           
               <tr>
                     <td></td>
                     <td>
                         <div class="bouquetnm_txtbox filterbox" style="width:22%"> 
                         <select name="colors" class="form-control chosen-select" multiple data-placeholder="select bouquet name">
                            <?php
                            $departmentbouquet = $g1->get_mongodb->getBouquetName($tenantid, $userdepartid);
                            foreach ($departmentbouquet as $bouquetvalue) {
                                echo '<option value="' . $bouquetvalue["BouquetName"] . '">' . $bouquetvalue["BouquetName"] . '</option>';
                            }
                            ?>
                         </select>
                         </div>    
                    </td>
                    <td></td>
                    <td>
                        <div>
                        <select name="searchtemplate" class="tempdata_txtbox" data-placeholder="select template" onchange="display_template(this.value)" style="display:none; font-size: 14px;">
                            <option value="">Select Template</option>
                            <?php
                            $templatedata['tempresult'] = $g1->get_mongodb->getTemplateslist($tenantid, $userdepartid);
                            if ($templatedata['tempresult'] != 0) {
                                foreach ($templatedata['tempresult'] as $tempName) {
                                    $templateid = $tempName['_id'];
                                    $tempPath = $tempName['HtmlFileLocation'];
                                    $filename = $tempName['HtmlFileName'];
                                    echo '<option value="' . $filename . '||' . $templateid . '||' . $tempPath . '">' . $tempName['TemplateHeader'] . '</option>';
                                }
                            }
                            ?>
                        </select>    
                        </div>    
                   </td>
             </tr>    
             </table>
            </fieldset>
               
               
            <fieldset>
                <legend>File Type </legend>
                <div class="form-group row space">
                    <label for="txt_company_name" class="col-md-1 control-label">Select Type</label>
                    <div class="col-md-5 predefinefiletype_txtbox">
                        <select name="colors" class="form-control chosen-select" multiple data-placeholder="select filetype" style="width:100%">
                            <option value=".txt">Normal Text File</option>
                            <option value=".jpg,.jpeg,.png">JPG/PNG File</option>
                        </select>
                    </div>    
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="txt__file_type" placeholder="Type should be seperated by comma like .txt,.png .." style="margin-top:1%;">
                    </div>
                </div>
            </fieldset>
             <div><div id="template"></div></div>               
                <input type="hidden" value="0" id="hin"/>
	</form>
                        
                   
	</div>
             <div class="row add_btn" > 
                     <!-- <input type="button" class="btn btn-success" value="Add To Bouquet" onclick="redirecttobouquetPage();">
                    <input type="button" class="btn btn-success" value="Add To Archive" onclick="addSelectedToArchive();">  -->
                     <input type="button" class="save_btn_bg_cancel btn-success" value="Add To Bouquet" onclick="redirecttobouquetPage();">
                    <input type="button" class="save_btn_bg_cancel btn-success" value="Add To Archive" onclick="addSelectedToArchive();">
                </div> 
       </div>
      </div>
                  
                <div class="row" id="search_error"><p class="error_msg red"></p></div>
                <div class="row testresult"></div>
                <div class="row" >
                    <div class="col-md-12" id="search_result_container"></div>
                </div>
                <!-- <div class="row add_btn" >
                     <input type="button" class="btn btn-success" value="Add To Bouquet" onclick="redirecttobouquetPage();">
                    <input type="button" class="btn btn-success" value="Add To Archive" onclick="addSelectedToArchive();">
                <input type="button" class="save_btn_bg_cancel" value="Add To Bouquet" onclick="redirecttobouquetPage();">
                    <input type="button" class="save_btn_bg_cancel" value="Add To Archive" onclick="addSelectedToArchive();">
                </div> -->
      </div>

         <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
         
        <script type="text/javascript" src="js/dmstree_js/search_page.js"></script>
        
        
    </body>
</html>
<script type="text/javascript">
function addSelectedToArchive() {
    // Collect all checked documents in the search results
    var selectedDocs = [];
    $('#search_result_container input[type="checkbox"]:checked').each(function() {
        var docRow = $(this).closest('.well');
        var docid = docRow.find('.documentname span').text();
        var docrev = docRow.find('.documentrev span').text();
        var docname = docRow.find('.documentname a').text();
        if(docid && docrev) {
            selectedDocs.push({docid: docid, docrev: docrev, docname: docname});
        }
    });
    if(selectedDocs.length === 0) {
        alert('Please select at least one document to archive.');
        return;
    }
    var q = confirm('Do you want to add the selected document(s) to Archive?');
    if(!q) return;
    var archivedCount = 0;
    selectedDocs.forEach(function(doc) {
        $.ajax({
            type: "POST",
            data: {
                docid: doc.docid,
                docrev: doc.docrev,
                type: 'setArchrive'
            },
            url: "document_checkout_process.php",
            success: function(response) {
                archivedCount++;
                // Optionally, handle response or errors here
                if(archivedCount === selectedDocs.length) {
                    // All done, update UI or reload
                    var actiontext = doc.docrev+" Revision of "+doc.docname+" Document is Archived";
                    $.ajax({
                        type: "POST",
                        data: { actiontext: actiontext },
                        url: "track_history.php",
                        complete: function() {
                            window.location.reload(true);
                        }
                    });
                }
            }
        });
    });
}
</script>