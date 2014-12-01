<?php
ob_start();
session_start();
include 'session_config.php';
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
        <link rel="stylesheet" href="jQuery-File-Upload-9.7.1/css/jquery.fileupload.css">
	<link rel="stylesheet" href="jQuery-File-Upload-9.7.1/css/jquery.fileupload-ui.css">
        <link rel="stylesheet" href="chosen_v1.2.0/chosen.min.css" />
        
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
        <script src="js/dmstree_js/jquery.textover.js"></script>
        <script src="chosen_v1.2.0/chosen.jquery.js"></script>
<!--        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js" type="text/javascript"></script>-->
       
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
			    .upload_control
				{
					border: none;
					box-shadow: none;
					background-color: transparent;
				}
				.add_browse_btn
				{
					width: 16px;
					height: 16px;
					position: absolute;
					z-index: 9999;
					top: 6;
					left: 20;
				}
                                .file_delete
                                {
                                    padding-top: 12px;
                                }
                                .fileradio
                                {
                                    margin-left: -20px !important;
                                }
        </style>
        <script>
            $(function()
            {
                $('.chosen-select').chosen();
            });
            
        </script>    
    </head>
    <body>
        

        <?php include_once 'header.php'; ?> 
        <div class="row row-margin">
        <div class="col-md-3 col-sm-3" id="body1">
                <?php include_once'dash_menu.php'?>  
        </div>
        <div class="col-md-9 col-sm-9 div-padding-left" id="body-content">
             <div class="well div-padding-top">
                <div class="row">
                     <div class="col-md-12 col-sm-12 form_title "><h2 class="text-muted"><b>Upload Document</b></h2></div>
                </div>
                <div class="div-padding">
                     <div class="row">
                     <form id="uploadDocumentForm" name="uploadDocumentForm" method="post" class="form-horizontal  form-action" action="uploaddocument.php" enctype="multipart/form-data">
                     <div class="form-group row">
                         <div class="col-md-3">
                             <div class="radio">
                                 <label>
                                     <input type="radio" class="fileradio" name="optionsRadiosPackage" id="rd_single_upload" value="single_upload" onchange="refresh_filediv('Single')" checked style="margin-left: -20px !important;">
                                     Single Upload
                                 </label>
                             </div>
                         </div>
                         <div class="col-md-4">
                             <div class="radio">
                                 <label>
                                     <input type="radio" class="fileradio" name="optionsRadiosPackage" id="rd_multiple_upload" value="mulitiple_upload" onchange="refresh_filediv('Multiple')" style="margin-left: -20px !important;">
                                     Multiple Upload
                                 </label>
                             </div>
                         </div>
                     </div>
                     <div class="form-group row" id="single_add">
                         <label class="col-md-3" for="txt_tag">Browse Files</label>
                         <div class="input-group col-md-9 col-md" id="browse_file_group">
                             <div class="row" id="file_record1">
                                     <span class="col-md-10"><input type="file" name="sfile1" id="doc_file1" class="form-control upload_control " /></span><!--<span class="col-md-2"><img src="file_icons/ico_cancel.png" class="cancel_file1" onclick="delete_filerecord(this)"></span>-->
                             </div>	
                         </div>
                     </div>
                     <div class="form-group row" id="mulitiple_add" style="display:none">
                         <div class=" col-md-9 col-md-offset-3">
                             <span><img src="img/add-icon.png" alt="add-icon" onclick="add_browse_control()" class="add_browse_btn"></span><input type="button" onclick="add_browse_control()" value="    Add Document">
                                                                                                    
                         </div>
                     </div>
                     
                    <input type="hidden" name="count" value="2" id="hin" />
                    <div class="control-group form-group row" id="tag1">
                        <label class="col-md-3" for="txt_tag">Tags</label><!--control-label-->
                        <div class="col-md-6"> <!--controls-->
                            <select name="colors" class="form-control chosen-select" multiple data-placeholder="select tags">
                            <?php
                                require('../CodeIgniter-old/external.php');
                                $ci = & get_instance();
                                $ci->load->library("cimongo/cimongo");
                                $ci->load->model('get_mongodb');
                                $g1 = new Get_mongodb();
                                
                                if(isset($_SESSION['usertenant']))
                                {
                                    $tenantid = $_SESSION['usertenant'];
                                }
                                else
                                {
                                $tenantid = ''; 
                                }
                                if(isset($_SESSION['userdepartmentid'] ))
                                {
                                    $userdepartid = $_SESSION['userdepartmentid'];
                                }  
                                else {
                                    $userdepartid = '';
                                }
                                $usertagdata = $g1->get_mongodb->companytagData($tenantid);
                                foreach ($usertagdata as $companytagkey)
                                {
                                    if(array_key_exists('DepartmentId',$companytagkey))
                                    {
                                        if($companytagkey['DepartmentId'] == $userdepartid){
                                            if(array_key_exists('TagList',$companytagkey))
                                            {
                                                foreach ($companytagkey['TagList'] as $cmptagval) {
                                                    echo '<option value="'.$cmptagval['Tag'].'" >'.$cmptagval['Tag'].'</option>';
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if(array_key_exists('TagList',$companytagkey))
                                            {
                                            foreach ($companytagkey['TagList'] as $cmptagval) {
                                                    echo '<option value="'.$cmptagval['Tag'].'" >'.$cmptagval['Tag'].'</option>';
                                                }
                                        }
                                    }
                                }
                                
                            ?>
                            </select>    
                        </div>
                    </div>

                    <div class="form-group row space">
                         <label for="txt_template" class="col-md-3 col-sm-3">Template</label>
                         <div class="col-md-6 col-sm-6">	
                         <!--<select size="3" name="templatelistbox" class="template col-md-6 col-sm-6"> form-control 								-->
                             <?php
                                            
                             $templatedata['tempresult'] = $g1->get_mongodb->getTemplateslist($tenantid,$userdepartid);
                             if ($templatedata['tempresult'] != '0') {

                                 echo '<select size="3" name="templatelistbox" class="template col-md-6 col-sm-6" onchange="display_template(this.value)">';
                                 echo '<option value= "">None</option>';
                                 foreach ($templatedata['tempresult'] as $tempName) {
                                     $templateid = $tempName['_id'];
                                     $tempPath = $tempName['HtmlFileLocation'];
                                     $filename = $tempName['HtmlFileName'];
                                     //$test = encode_filepath($tempPath);
                                     //echo '<option value="' . $filename . '||' . $templateid . '||' . $tempName['TemplateHeader'] . '">' . $tempName['TemplateHeader'] . '</option>';
                                     echo '<option value="' . $filename . '||' . $templateid . '||' . $tempPath . '">' . $tempName['TemplateHeader'] . '</option>';
                                 }
                             }

                             /*function encode_filepath($a) {
                                 $file = str_replace('\\', '/', $a);
                                 return $file;
                             }*/
                             ?>
                                        </select>
                         </div>
                    </div>           
                                    
                    <div class="form-group row space" >
                        <div class="col-md-12 col-sm-12" id="template"></div>
                        <input type="hidden" name="templateid" class="templateid" value="">
                        <input type="hidden" name="templatename" class="templatename" value="">
                    </div>

                    
                    <div class="row">
                        <div class="form-group">
                            <label class="col-md-3 col-sm-3 control-label mar-left ">
                                <strong>Expiry Date</strong>
                            </label>
                                                
                            <div class='col-md-6 col-sm-6' id='date9'>
                                <div class='input-group date' id='datetimepicker' data-date-format="DD/MM/YYYY">
                                    <input type='text' class="form-control date1 docexpirydate" name="date" readonly/>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
												
                                    <div class="form-group row">
					<div class="col-md-12 col-sm-12">
                                            <div class="radio row">
                                                <label>
                                                    <input type="checkbox" name="optionsRadios" id="chk_physical_loc" value="physical_loc" id="physical_loc">
                                                    <strong>Physical Location</strong>
                                                </label>
                                            </div>
                                            <div class="col-md-12 col-sm-12" id="div_pic">
						<div class="row div-border">
                                                    
                                                    <div class="col-md-6 col-sm-6 col-md-offset-2 col-sm-offset-2">
                                                        <input type="file" name="file" accept="image/*" style="visibility:hidden;" id="txt_pic" />
                                                        <div class="input-group mar-bot">
                                                            <input type="text" name="" id="txt_picture" class="form-control">
                                                            <span class="input-group-btn ">
                                                                <input type="button" class="btn ctrl-btn" value="Browse" onclick="$('#txt_pic').click();">
                                                            </span>
                                                                                                                                                            
                                                        </div>
                                                                                                                                            
                                                        <div class="mar-bot">
                                                            <img id="target" src="" alt="your image" style=" height: 300px; width: 400px;"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       </div> 
                                        <div class="form-group row">
                                            <div class="col-md-12 col-sm-12">
                                                <input type="button" class="btn btn-success ctrl-btn btn-space" value="Save" onclick="validate_uploaddocument(this);">
<!--                                                <button class="btn btn-success ctrl-btn  btn-space" type="submit"><i class="icon-ok-sign icon-white "></i>Save</button>-->
                                                <input type="reset" class="btn btn-primary btn-space" value="Reset" onclick="reset_upload();">
                                                <input type="button" class="btn ctrl-btn btn-space " value="Cancel">
                                                                                                                    
                                            </div>
                                        </div>
                                        <input type="hidden" name="tenantname" class="tenantname" value="<?php echo $tenantname;?>">
                                        <input type="hidden" name="tenantid" class="tenantid" value="<?php echo $tenantid;?>" >
                                        <input type="hidden" name="departmentid" class="departmentid" value="<?php echo $userdepartid;?>">
                                        <input type="hidden" name="userid" class="userid" value="<?php echo $userid; ?>">
				</form>
				</div>
				</div>
				</div>
                                </div>
            
        </div>
        
<!--        </div>-->
<!--        <div class="container">-->
         <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
<!--        </div>-->
<!--        <script src="jQuery-File-Upload-9.7.1/js/vendor/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
	<script type="text/javascript" src="jQuery-File-Upload-9.7.1/js/jquery.fileupload.js"></script>
	<script type="text/javascript" src="jQuery-File-Upload-9.7.1/js/jquery.fileupload-process.js"></script>
	<script type="text/javascript" src="jQuery-File-Upload-9.7.1/js/jquery.fileupload-angular.js"></script>
	<script type="text/javascript" src="jQuery-File-Upload-9.7.1/js/app.js"></script>-->
        
        <script type="text/javascript" src="js/dmstree_js/sign_validation.js"></script>
        <script type="text/javascript" src="js/dmstree_js/formvalidation.js"></script>
        <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
        <script type="text/javascript" src="js/dmstree_js/menu.js"></script>
        <script type="text/javascript" src="js/dmstree_js/doc_temp_valid.js"></script>
        <script type="text/javascript" src="js/dmstree_js/uplaod_page.js"></script>
       <!-- <script type="text/javascript">
        
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