<?php
	ob_start();
	session_start();
        include 'session_timeout.php';
	include 'session_config.php';
	require('../CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
	$g1 = new Get_mongodb();
	$userId = $_SESSION['userid'];
	$tenantId = $_SESSION['usertenant'];
        $tenantname = $_SESSION['tenantname'];
        $userdepartid = '';
        $tenantid = '';
        $tenantname = '';
        if(isset($_SESSION['userdepartmentid'] ))
        {
            $userdepartid = $_SESSION['userdepartmentid'];
        }  
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
        
        
	$result = $g1->get_mongodb->getStandardListName($tenantId);
	$tag = $g1->get_mongodb->getTagList($tenantId);
	$photo = $g1->get_mongodb->getPhotoList($tenantId);
	
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Dash-Board</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
		
        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
        <link rel="stylesheet" href="css/fileinput.min.css"/>
        <link rel="stylesheet" href="css/jquery.tag-editor.css">
        <link rel="stylesheet" href="bxslider-4-master/jquery.bxslider.css">
     
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>        
        <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>         
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <script src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/fileinput.min.js"></script>
        <script type="text/javascript" src="bxslider-4-master/jquery.bxslider.js"></script>
        
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
                      
               $('#photogallery_add').slideUp();  
               $('#photogallery').slideDown();
            });  
            
            function show_photogalleryfor()
            {
                $('#photogallery').slideUp();
                $('#photogallery_add').slideDown();
            }
            
            function close_galleryform()
            {
               $('#photogallery_add').slideUp();  
               $('#photogallery').slideDown();
            }
            
            
            
            function delete_galleryPhoto(curimgobj)
            {
                var name = $(curimgobj).parent().find('.delphoto').attr('alt');
                var type = 'deletePhoto';
                $.ajax({
                                 type: "POST",
                                 data: {
                                           type:type,
                                           name : name
                                       },
                                 url: "data_configuration_process.php",
                                 success: function(msg){
                                     alert(name+" photo deleted successfully");
                                            var actiontext = '';
                                            actiontext = name+" Photo deleted successfully.";
                                            $.ajax({
                                                    type: "POST",
                                                    data: {
                                                        actiontext : actiontext
                                                    },
                                                    url: "track_history.php",
                                                    success: function(response){ 
                                                    }   
                                            });
                                     location.reload();
                                 }
                      });         
            }
            
            function image_tagging(curimgobj)
            {
                    var data1 = $(curimgobj).parent().parent().parent().find('.phototags').val();
                    var tenantname = "<?php echo $tenantname; ?>";
                    var imgsrc = $(curimgobj).parent().find("img").attr("src");
                    //alert(imgsrc);
                    var lastslash = imgsrc.lastIndexOf("/");
                    var loc = imgsrc.substr(0,lastslash+1);
                    var img_name = imgsrc.substr(lastslash+1,imgsrc.length);
                    $("#target").attr("src", loc+img_name);
                    $("#photoloc").val(loc+img_name);
                    if(data1 !='')
                        {
                            var params = { "photoloc": loc,"photoname":img_name,"tenantname":tenantname, "defaulttaglist":data1};
                        }
                    else
                        {
                            var params = { "photoloc": loc,"photoname":img_name,"tenantname":tenantname};
                        }
                    OpenWindowWithPost("Data_configuration_photoTag.php","top=100, left=100,width=550,height=500,resizable=yes,scrollbars=yes","photoform", params);

            }
        </script>    
	<style>
            .delphoto
            {
                float: right;
                margin-right: 15px;
            }

           .tags{
                display: inline-block;
                padding: 4px 8px;
                margin-bottom: 0;
                font-size: 12px;
                font-weight: normal;
                line-height: 1.42857143;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                color: #000;
                background-color: #e0eaf1;
                border-width: 1px;
                border-style:solid;
                border-color: #D2D2D2;/*#000;*/
                border-radius: 5px;
                -o-border-radius:5px;
                -webkit-border-radius: 5px;
            }
        </style>    
    </head>
    <body >
        <!----------- Header page--------------------------------------------->
        <?php include_once 'header.php'; ?> 
        <div class="row row-margin">
            <div class="col-md-3 ">
                <!--------- dash board side menu------------------------------------------------>
                <?php include_once'dash_menu.php'?>  
            </div>
            <div class="col-md-9 col-sm-9 ">
                <div class="row">
                    <p class="spaceerror col-md-12" style="color:red"> </p>
                </div>
                <div class="div-padding-top well">
                <div class="row">
                        <div class="col-md-12 col-sm-12 form_title "><h3 class="text-muted space" ><b>Data Configuration</b></h3></div>
                </div>
                <fieldset>
                    <div class="row form-group">
                        <label for="sel_std_list" class="col-md-3 control-label text-muted">Manage STD List</label>  
                        <!--<div class="col-md-4 col-sm-4">
                                <select class="form-control template col-md-6 col-sm-6" id="sel_std_list">
                                        <option value="select" id="select_std_list">Select STD List</option>
                                            <?php 
                                                    foreach($result as $key)
                                                    {
                                                            if(!$key['AuditData']['DeleteFlag'])
                                                            {
                                            ?>
                                                            <option value="<?php echo $key['ListName']; ?>" id="<?php echo $key['_id']; ?>"><?php echo $key['ListName']; ?></option>
                                            <?php 
                                                            }
                                                    }
                                            ?>
                                </select>
                        </div>-->
                    </div>
                    <!-- Button trigger modal -->
                    <button class="btn btn-info" id ="btn_std_add" data-toggle="modal" data-target="#add_std_list"> Add</button>
                <!-- Modal -->
                <div class="modal fade" id="add_std_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" class="form-horizontal" name="add_std" id="add_std" action="">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Standard List</h4>
                                </div>

                                <div class="modal-body">
                                    <div class="row form-group">
                                        <div class="col-md-3">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="rd_list" value="List">
                                                    <strong>Single-Select</strong>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="radio ">
                                                <label>
                                                    <input type="radio" name="optionsRadios" id="rd_combo" value="Combo">
                                                    <strong>Multi-Select</strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label for="txt_list_name_add" class="col-md-2  control-label">List Name</label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" id="txt_list_name_add" placeholder="List Name" name="listname">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-10" >
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8 div-padding-left">
                                                    <label for="txtarea_listoption" class="col-md-4  control-label div-padding-menu">List Description</label>
                                                    <div class="col-md-8 right-padding">
                                                        <input type = "text" class="form-control" name="" id="list" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-sm-4 div-padding-menu">
                                                    <label for="txtarea_listoption" class="col-md-3  control-label div-padding-menu">List Code</label>
                                                    <div class="col-md-8 right-padding">
                                                        <input type = "text" class="form-control" name="" id="code" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-2">
                                                <input type="button" class="btn" value="Add" onclick="add_to_list();" />
                                        </div>
                                    </div>
                                    <div class="row form-group" id="text_description">
                                        <div class="col-md-12">
<!--                                            <textarea id="txtarea_add_std" class="form-control" cols = "5" rows="4"></textarea>-->
                                            <select id="list_std" class="form-control template col-md-4 col-sm-4" name="" size="3" readonly></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick = "refresh_std_list();">Close</button>
                                    <button type="button" id="btn_std_add_model" class="btn btn-primary " onclick="save_std_list();">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
								
                <button class="btn btn-primary" id="btn_std_update" data-toggle="modal" data-target="#update_std_list">Update</button>
                <!-- Modal -->
                <div class="modal fade" id="update_std_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Standard List</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row form-group">
                                    <label for="txt_list_name_update" class="col-md-3  control-label">List Name</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control template col-md-4 col-sm-4" id="sel_std_list_update" readonly>
                                            <option value="select" id="select_std_list_update">Select STD List</option>
                                            <?php 
                                                    foreach($result as $key)
                                                    {
                                                            if(!$key['AuditData']['DeleteFlag'])
                                                            {
                                            ?>
                                                            <option value="<?php echo $key['ListName']; ?>" id="<?php echo $key['_id']; ?>"><?php echo $key['ListName']; ?></option>
                                            <?php 
                                                            }
                                                    }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="txt_edit_name" class="col-md-3  control-label">Edit List Name</label>
                                    <div class="col-md-6 right-padding">
                                        <input type = "text" class="form-control" name="txt_edit_name" id="txt_edit_name" value="">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="txt_list_name_update" class="col-md-3  control-label">List Description</label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control template col-md-4 col-sm-4" id="sel_std_list_description_update" readonly>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-12" >
                                        <div class="row">
                                            <div class="col-md-7 col-sm-7 div-padding-left">
                                                <label for="editlist" class="col-md-4  control-label">Edit Description</label>
                                                <div class="col-md-8 right-padding">
                                                    <input type = "text" class="form-control" name="editlist" id="editlist" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-sm-5 div-padding-menu">
                                                <label for="editcode" class="col-md-3  control-label div-padding-menu">Edit Code</label>
                                                <div class="col-md-8 right-padding">
                                                    <input type = "text" class="form-control" name="editcode" id="editcode" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-2 col-sm-2">
                                        <input type="button" class="btn" value="Add" onclick="add_option_std_list();" />
                                    </div>
                                    <div class="col-md-2 col-sm-2">
                                        <input type="button" class="btn" value="Remove" onclick="remove_list_description();" />
                                    </div>
                                </div>
                                <div class="row form-group" id="text_description">
                                    <div class="col-md-12">
                                        <select id="list_std_update" class="form-control template col-md-4 col-sm-4" name="" size="3" readonly></select>
<!--                                        <textarea id="update_add_std" name="update_add_std" class="form-control" cols = "5" rows="4"></textarea>-->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" id="btn_update" class="btn btn-primary" onclick="update_std();">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-danger" id="btn_std_delete" data-toggle="modal" data-target="#delete_std_list">Delete</button>
                <!-- Modal -->
                    <div class="modal fade" id="delete_std_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Standard List</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row form-group">
                                        <label for="sel_std_list" class="col-md-3 control-label text-muted"> STD List</label>  
                                        <div class="col-md-5 col-sm-5">
                                            <select class="form-control template col-md-6 col-sm-6" id="sel_std_list">
                                                <option value="select" id="select_std_list">Select STD List</option>
                                                <?php 
                                                        foreach($result as $key)
                                                        {
                                                                if(!$key['AuditData']['DeleteFlag'])
                                                                {
                                                ?>
                                                                <option value="<?php echo $key['ListName']; ?>" id="<?php echo $key['_id']; ?>"><?php echo $key['ListName']; ?></option>
                                                <?php 
                                                                }
                                                        }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                   </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger" onclick="delete_std_list();">Confirm Delete</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                    </fieldset>	
							

							
                    <fieldset class="fieldset-none">	
                        <div class="row form-group">
                            <label for="sel_tags" class="col-md-3 control-label text-muted">Manage Tags</label>  
                        </div>
                        <div class="row" style="padding:15px 5px;">
                            <div class="col-md-12" id="tag_diaplay" style="background-color:#f5f5f5; max-width:900px;margin:auto">
                                <textarea id="hero-demo" >
                                <?php
                                    $str = array();

                                        foreach($tag[0]['TagList'] as $key)
                                        {
                                                if(!$key['AuditData']['DeleteFlag'])
                                                {
                                                        $str[] = $key['Tag'];
                                                }

                                        }
                                        $strTag = implode(",", $str);
                                        echo $strTag;

                                ?>
                                </textarea>
                            </div>
                        </div>
							<!-- Modal -->
                        <div class="modal fade" id="add_tag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Tags</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row form-group">
                                            <label for="txt_tag_add" class="col-md-3  control-label">Tag Name</label>
                                            <div class="col-md-6">
                                                    <textarea id="txtarea_tags" class="form-control" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    
                    
         <fieldset class="fieldset-none">	
            <div class="row form-group">
            <label for="sel_photo_gallary" class="col-md-3 control-label text-muted">Manage Photo Gallary</label>  
            </div>
            <div class="row"> 
                <button class="btn btn-info" id ="btn_add" style="margin-left:2%" onclick="show_photogalleryfor();">Add Photo</button>
            </div>
            <div class=" row manage_photo_gallery" style="padding:2%">
                <div class ="col-md-12">
                    <div class="row" id="photogallery_add">
                    <form id="add_photo_form" method="post">
                        <div class="row" style="margin:7px 0; border-bottom:"><h4 class="modal-title" id="myModalLabel" >Photo Gallary</h4></div>
                        <div class="row" id="add_photo_gallary">
                        <label for="txt_gallery_name" class="col-md-3  control-label">Select Image</label>
                        <div class="form-group col-md-6">
                            <input type="file" class="form-control" id="txt_gallery_photo" name="galleryphoto">
                        </div>
                        </div>
                        <div class="row">
                            <button type="button" class="btn btn-default" style="margin-left:2%;" onclick="close_galleryform();">Close</button>
                            <input type="button" class="btn-success btn" id="addPhoto" value="Save" onclick=""/>
                        </div> 
                    </form> 
                    </div>
                    
                    <div class="row" id="photogallery">
                    <?php
                        $photogallery = $g1->get_mongodb->getGalleryPhotos($tenantid,$tenantname);
                        if($photogallery != 0)
                        {
                            echo '<div class="col-md-12">';
                            foreach ($photogallery as $photogalleryvalue) {
                                if(array_key_exists("Photo",$photogalleryvalue))
                                {
                                    $count = 0;
                                    $flag = 0;
                                    $statusflag = 0;
                                    foreach ($photogalleryvalue['Photo'] as $photovalue) {
                                        $filename = $photovalue['FileName'];
                                        $fileloc = $photovalue['FileLocation'];
                                        $photostatus = $photovalue['AuditData'];
                                        $imgtag = array();
                                        $imgtagposition = array();
                                        $data1 = "";
                                        $tagid = 1;
                                        if(array_key_exists('ImageTags',$photovalue))
                                        {
                                            $taglist = $photovalue['ImageTags'];
                                            $tagcount = 0;
                                            foreach ($taglist as $tagvalue) {
                                                if($tagvalue['AuditData']['DeleteFlag'] == false){
                                               $imgtag[] = $tagvalue['TagName'];
                                               $imgtagposition[] = $tagvalue['TagPosition'];
                                               $tagstyle = explode(',',$tagvalue['TagPosition']);
                                               $widthpos = explode("px",$tagstyle[0]);
                                               $heightpos = explode("px",$tagstyle[1]);
                                               $toppos = explode("px",$tagstyle[2]);
                                               $leftpos = explode("px",$tagstyle[3]);
                                               if($tagcount == 0)
                                               {
                                                  $data1 .= "{'id':".$tagid.",'label':'".$tagvalue['TagName']."','width':".$widthpos[0].",'height':".$heightpos[0].",'top':".$toppos[0].",'left':".$leftpos[0]."}"; 
                                               }    
                                                else 
                                               {
                                                    $data1 .= "||{'id':".$tagid.",'label':'".$tagvalue['TagName']."','width':".$widthpos[0].",'height':".$heightpos[0].",'top':".$toppos[0].",'left':".$leftpos[0]."}";
                                               }
                                               $tagid++;
                                              $tagcount++;
                                                }
                                            }
                                            
                                        }
                                        $imgstatus = $photostatus['DeleteFlag'];
                                        if($imgstatus){$statusflag =1;}
                                        if($filename != '' && $fileloc != '' && !($imgstatus))
                                        {
                                            if($count == 0)
                                            {
                                                echo '<div class="row" style="margin-bottom:3%">';
                                            }  
                                            echo '<div class="col-md-3 photodiv" height="150px" width="100%">
                                                  <div class="row">
                                                    <p><img src="img/cross-button.png" alt="'.$filename.'" class="delphoto" onclick="delete_galleryPhoto(this);"></p>
                                                    <p><a href="#" onclick="image_tagging(this);"><img name="'.$filename.'" src="'.$fileloc.$filename.'" height="150px" class="galleryimg"></a></p>';
                                            
                                            echo '</div>
                                                  <div class="row">';
                                                  if(isset($imgtag) && $imgtag != null)
                                                  {
                                                      echo '<input type="hidden" class="phototags" value="'.$data1.'">';
                                                      echo '<div class="tag-editor-tag" >';
                                                      foreach ($imgtag as $val) {
                                                          echo '<label class="tags">'.$val.'</label>';
                                                      }
                                                      echo '</div>';
                                                  }  
                                            
                                            echo  '</div>
                                                  </div>';
                                            if($count == 3)
                                            {
                                                echo '</div>';
                                                $flag = 1;
                                            }
                                        }
                                        if($flag == 1)
                                        {
                                           $count = 0;
                                           $flag = 0;
                                        }  
                                        elseif ($statusflag == 1){}
                                        else { $count++; }
                                        $statusflag = 0;
                                    }
                                }
                            }
                            echo '</div>';
                    
                        }    
                    ?>
                    </div>    
                </div>  
                
            </div>    
                      </fieldset>	
                    
                    
                    </div>
                </div>
            </div>
            <input type="hidden" id="tenantid" value="<?php echo $tenantId;?>">
            <input type="hidden" id="tenantname" value="<?php echo $tenantname;?>">
         <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
		<script src="jqueryui/ui/minified/jquery-ui.min.js"></script>
		<script src="js/dmstree_js/jquery.tag-editor.js"></script>
        <script type="text/javascript" src="js/dmstree_js/data_configuration.js"></script>
    </body>
</html>