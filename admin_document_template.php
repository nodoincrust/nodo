<?php
/*
Page name: Document template
Date Created: 23 July 2014
Created By: Shubhangi Mate
Modify By:
Modified Date:
*/
	ob_start();
	session_start();
        $idletime=1200;//after 20 min the user gets logged out
        if (time()-$_SESSION['timestamp']>$idletime){
            session_destroy();
            session_unset();
            header('Location:login.php');
        }else{
            $_SESSION['timestamp']=time();
        }
	include 'session_config.php';
	require('CodeIgniter-old/external.php');
	$ci =& get_instance();
	$ci->load->library("cimongo/cimongo");
	$ci->load->model('get_mongodb');
        $g1 = new Get_mongodb();
	$tenantId = $_SESSION['usertenant'];
	$standandList = $g1->get_mongodb->getStandardListName($tenantId);
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<title>Document Template</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
	   
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="jqueryui/themes/base/jquery-ui.css" />
		<link href="dist/css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" />
		<link href="css/custom.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="css/stylesheet.css"/>
		<link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<link rel="stylesheet" href="css/template.css">
                
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/tests/vendor/jquery.min.js"></script>
		<script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/dmstree_js/document_template_admin.js"></script>
		<script type="text/javascript" src="js/dmstree_js/doc_temp_valid.js"></script>
		<script type="text/javascript" src="js/dmstree_js/uploader.js"></script>
		<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
		<script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
		<script type="text/javascript" src="js/dmstree_js/bootstrap-select.js"></script>
		<script type="text/javascript" src="bootstrap/js/jquery.js"></script>
	</head>

  <body>
  <?php include_once 'header.php'; ?> 
  <div class="row row-margin">
        <div class="col-md-2  div-padding-top">
            <?php include_once'admin_dash_menu.php'?>  
        </div>
        <div class="col-md-10 div-padding-top">
			<form class="form-horizontal form-action">
				<div class="form-group row ">
					<label for="domain" class="col-md-4  control-label">Domain</label>
					<div class="col-md-6">
						<select id="domain" class="form-control" name="domain" onchange="select_sub_domain();">
							<option value="select">Select Domain</option>
							<?php
							foreach($standandList[0]['List'] as $list)
							{
								if(!$list['AuditData']['DeleteFlag'])
								{
							?>
								<option value="<?php echo $list['Description'];?>"><?php echo $list['Description'];?></option>
							<?php
								}
							}
							?>
						</select>
					</div>
                                        <input type="hidden" value="<?php echo $standandList[0]['_id'];?>" id="domain_id">
				</div>
                                <div class="form-group row ">
					<label for="sub_domain" class="col-md-4  control-label">Select Sub Domain</label>
					<div class="col-md-6">
						<select id="sub_domain" class="form-control " name="domain">
							
						</select>
					</div>	
				</div>
			</form>
			<div class="content">
				<div class="row row-fluid ">
								
					<div class="col-md-3 span3 div-padding-menu" style=""><!-- div declare all drag and drop component -->
						<h4>Drag and Drop Component</h4>
						<hr/>
						
						<!-- label start here-->
						<div class='selectorField draggableField'>
							<div class="labelbox well well-mini"><b></b> Label</div>
							<div class='modele'>
								<div class="col-md-12 span12"><label class="control-label forms_lbl ctrl-label">Label:</label></div>
								<input type="hidden" value="" class="label_font"/>
								<input type="hidden" value="" class="label_id">
								<input type="hidden" value="" class="label_size">
							</div>
						</div>
						<!-- label close here -->
							  
						<!-- multilinelabel start here-->
						<div class='selectorField draggableField'>
							<div class="multilinelabel well well-mini"><b></b>Multi-line Label</div>
							<div class='modele'>
								<label class="col-md-12 span12 control-label forms_lbl ctrl-multilabel" style="width:100%">Multi-line Label:</label>
								<input type="hidden" value="" class="label_font"/>
								<input type="hidden" value="" class="label_id">
								<input type="hidden" value="" class="label_size">
							</div>
						</div>
						<!-- multilinelabel close here -->
									
						<!-- textbox start here -->
						<div class='selectorField draggableField'>
							<div class="textbox well well-mini"><b></b> Textbox</div>
								<div class='modele'>
									<div class="col-md-3 span3"> 
										<div class="row row-fluid"><label class="control-label label_req">Textbox</label><label class="label_req requiredcls">*</label></div>
									</div>
									<div class="col-md-9 span9">
										<input  type="text" placeholder="write text here..." class="ctrl-textbox cntrol_comp" minlength="" maxlength="" onkeyup="display_minmaxlen_err(this)"/><span class="textbox_err_msg"></span>
										<p class="required_msg"></p>
										<p class="control_help"></p>
										<input type="hidden" class="hiddenObligatoire"/>
										<input type="hidden" class="min_length" value="" />
										<input type="hidden" class="max_length" value="" />
									</div>
								</div>
							</div>
							<!-- textbox close here -->
									
							<!-- textarea start here -->
							<div class='selectorField draggableField'>
								<div class="displaytext well well-mini"><b></b> Textarea</div>
								<div class='modele'>
									<div class="col-md-3 span3">
										<label class="control-label label_req">Textarea</label><label class="label_req requiredcls">*</label>
									</div>
									<div class="col-md-9 span9">
										<span class="ctrl-text">
											<textarea class="cntrol_comp template_txtarea" rows="4" class="ctrl-textbox " minlength="" maxlength="" onkeyup="display_minmaxlen_err(this)" /></textarea><span class="textbox_err_msg"></span>
											<p class="required_msg"></p>
											<input type="hidden" class="hiddenObligatoire"/>
											<input type="hidden" class="min_length" value="" />
											<input type="hidden" class="max_length" value="" />
										</span>
									</div>
								</div>
							</div>
							<!-- textarea close here -->

							<!-- combobox start here -->
							<div class='selectorField draggableField'>
								<div class="combobox well well-mini"><b></b> Drop-down list</div>
								<div class='modele'>
									<div class="col-md-3 span3">
										<div class="row"><label class="control-label label_req"> Drop-down list</label><label class="label_req requiredcls">*</label></div>
									</div>
									<div class="col-md-9 span9">
										<select class="ctrl-combobox cntrol_comp" >
											<option value="option1">Option 1</option>
											<option value="option2">Option 2</option>
											<option value="option3">Option 3</option>
										</select>
										<p class="required_msg"></p>    
										<input type="hidden" class="hiddenObligatoire"/>
									</div>
								</div>
							</div>
							<!-- combobox close here -->
									
							<!-- radiogroup start here -->
							<div class='selectorField draggableField'>
								<div class="radiogroup well well-mini"><b></b> Radio buttons</div>
								<div class='modele'>
									<div class="col-md-3 span3">
										<div class="row"><label class="label_req control-label" style="vertical-align:top">Radio buttons</label><label class="label_req requiredcls">*</label></div>
									</div>
									<div style="display:inline-block;" class="ctrl-radiogroup cntrol_comp col-md-9 span9">
										<span style="display:block;"><input type="radio" name="radioField" value="option1" />Option 1</span>
										<span style="display:block;"><input type="radio" name="radioField" value="option2" />Option 2</span>
										<span style="display:block;"><input type="radio" name="radioField" value="option3" />Option 3</span>
										<p class="required_msg"></p>
									</div>
									<input type="hidden" class="hiddenObligatoire"/>
									<input type="hidden" class="rd_display" value="">
								</div>
							</div>
		<!-- radiogroup close here -->

		<!-- checkboxgroup start here -->
                    <div class='selectorField draggableField'>
                    <div class="checkboxgroup well well-mini"><b></b> Multiple Checkbox</div>
                    <div class='modele'>
			<div class="col-md-3 span3">
                            <div class="row"><label class="label_req control-label" style="vertical-align:top">Multiple Checkbox</label><label class="label_req requiredcls">*</label></div>
                        </div>
                        <div style="display:inline-block;" class="ctrl-checkboxgroup cntrol_comp col-md-9 span9">
                            <span style="display:block;"><input type="checkbox" name="checkboxField" value="option1"/>Option 1</span>
                            <span style="display:block;"><input type="checkbox" name="checkboxField" value="option2"/>Option 2</span>
                            <span style="display:block;"><input type="checkbox" name="checkboxField" value="option3"/>Option 3</span>
                            <p class="required_msg"></p>
			</div>
			<input type="hidden" class="hiddenObligatoire"/>
			<input type="hidden" class="chk_display" value="">
                    </div>
                    </div>
		<!-- checkboxgroup close here -->

		<!-- selectmultiple start here -->
                    <div class='selectorField draggableField'>
                    <div class="selectmultiple well well-mini"><b></b> Selection multiple</div>
                    <div class='modele'>
			<div class="col-md-3 span3">
                            <div class="row"><label class="label_req control-label" style="vertical-align:top">Selection multiple</label><label class="label_req requiredcls">*</label></div>
                        </div>
			<div style="display:inline-block;" class="col-md-9 span9">
                            <select multiple="multiple" style="width:150px" class="ctrl-selectmultiplelist cntrol_comp">
				<option value="option1">Option 1</option>
				<option value="option2">Option 2</option>
				<option value="option3">Option 3</option>
                            </select>
                            <p class="required_msg"></p>    
			</div>
			<input type="hidden" class="hiddenObligatoire"/>
                    </div>
                    </div>
		<!-- selectmultiple close here -->

		<!-- imagebox start here -->
                    <div class="selectorField draggableField">
                    <div class="imagebox well well-mini"><b></b>Image</div>
                    <div class="modele">
			<div class="col-md12 span12"><img src="#" alt="Upload Image" class="fimage ctrl-image" id="blah"/></div>
			<input type="hidden" value="" class="image_path">
                    </div>    
                    </div>
                <!-- imagebox close here width="150" height="auto" -->
								
		<!-- Date start here -->
                    <div class='selectorField draggableField'>
                    <div class="displaydate well well-mini"><b></b> Date</div>
                    <div class='modele'>
			<div class="col-md-3 span3">
                            <label class="control-label">Date</label><label class="label_req requiredcls">*</label>
                        </div>
			<div class="col-md-9 span9">
                            <span class="ctrl-date"><input class="cntrol_comp datepicker" type="text" id=""  /></span>
			</div>
			<p class="required_msg"></p>
                    </div>
                    </div>
		<!-- Date close here onclick="display_expiryCal(); expiry-date"-->

		<!-- table start here -->
                    <div class='selectorField draggableField'>
                    <div class="tablebox well well-mini"><b></b>Table</div>
                    <div class="modele">
			<div class="col-md-12 span12">
                            <label class="row row-fluid col-md-12 span12 control-label tbl_label" >Table:</label>
                            <div class="row row-fluid col-md-12 span12 table_div" >
				<table class="ctrl-table form_table" id="" border="1px solid #ccc"></table>  
				<span><input type="hidden" class="table_rows" value=""></span>
                                <span><input type="hidden" class="table_cols" value=""></span>
                                <span><input type="hidden" class="tbl_rows" value=""></span>
				<span><input type="hidden" class="tbl_cols" value=""></span>
                                <span><input type="hidden" class="addstatus" value=""></span>
                            </div>
                            <div class="row row-fluid col-md-12 span12">
				<input type="button" id="add_btn"  class="btn tbl_btn" value="Add Row" onclick="add_rowToTable(this);" />
                            </div>
			</div>
                    </div>
                    </div>
		<!-- table close here -->
		<hr/>
								
									
<!--		<b>Standered List and combo</b><br />-->
		<!-- stdcombobox start here -->
<!--                    <div class='selectorField draggableField'>
                    <div class="stdcombobox well well-mini"><b></b> Std. list</div>
                    <div class='modele'>
			<div class="col-md-3 span3">
                            <div class="row"><label class="control-label label_req"> Std. list</label><label class="label_req requiredcls">*</label></div>
                        </div>
			<div class="col-md-9 span9">
                            <select class="ctrl-stdcombobox cntrol_comp"></select>
                            <p class="required_msg"></p>    
                            <input type="hidden" class="hiddenObligatoire"/>
			</div>
                    </div>
                    </div>-->
		<!-- stdcombobox close here -->
		</div>


                <!-- 
                        Below we have the columns to drop controls
                        -- Removed the TABLE based implementations from earlier code
                        -- Grid system used for rendering columns 
                        -- Columns can be simply added by defining a div with droppedFields class onclick="val_click()"
                -->
						
						
		<div class="col-md-9 span9 div-padding-menu"><!--form container start here -->
		<h4>Form Fields:</h4>
		<hr/>
		<div style="border:1px solid #e7e7e7; padding: 25px 5px 5px; float: left; width:100%; z-index:0 !important;">
									
                    <!-- first row with form logo and title 120px 75px-->
                    <div class="row row-fluid" id="form-title-div"> 
			<div class="col-md-2 span2" onclick="open_logoimage_popup()">
                            <img src="" alt="logo-image" class="logo_image" id="logo_image" width="100%" heigth="100%" />
			</div>
			<div class="col-md-10 span10" onclick="open_title_popup()">
                            <input type="text" class="input-large col-md-12 span12" placeholder="Type form title here"  value="" id="form-title" />
                            <input type="hidden" value="" class="titlelabel_font"/>
                            <input type="hidden" value="" class="titlelabel_size">
			</div>
                    </div>
                    <!-- Form title description -->
                    <div class="row row-fluid" id="form-description_div">
                        <textarea class="input-large col-md-12 span12" style="width:100%" placeholder="Type form description here" name="form_description" id="form-description"></textarea>
                    </div>
                    <div class="row row-fluid" id="selected-content">
                    <div class="row row-fluid">
                        <div class="col-md-6 span6 well droppedFields "></div>
			<div class="col-md-6 span6 well droppedFields "></div>
                    </div>
                    <!-- Action bar - Suited for buttons on form -->
                    <div class="row row-fluid">
			<div class="col-md-12 span12 well action-bar droppedFields " style="min-height:80px;"></div>
                    </div>
                    </div>
							
                </div>
						
		<div class="row row-fluid">	
                    <div class="col-md-12 span12" style="margin-top:10px;">
                    <input type="button" class="btn btn-primary" value="Save Form" onclick="preview();"/>
                    <input type="button" class="btn btn-primary" value="Add table" onclick="$('#dialog-form-nombre-colonne').modal('show'); $('#dialog-form-nombre-colonne').css('z-index', '1500');"/>
                    </div>
		</div>  
                </div><!--form container close here -->
						
        </div>
	</div><!-- main container close here -->
  

	<div class="tabbable"> 
	<!-- List of controls rendered into Bootstrap Tabs -->
	</div>
        <!------- change to menu------------------>
    </div>
    </div>
    <!----------end menu----------------->
 
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>	
    <script type="text/javascript" src="dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="jqueryui/ui/minified/jquery-ui.min.js"></script>
    <script type="text/javascript" src="handlebars/handlebars.js"></script>
    
    
    
    
    
    
    <!-- 
    Starting templates declaration
    DEV-NOTE: Keeping the templates and code simple here for demo  -- use some better template inheritance for multiple controls 
    ---> 
    
        <!-- comman modal for all control loaded while dropping any element -->
        <script id="control-customize-template" type="text/x-handlebars-template">
        <div class="modal-header">
            <h3>{{header}}</h3>
        </div>
        <div class="modal-body">
            <form id="theForm" class="form-horizontal">
            <input type="hidden" value="{{type}}" name="type"/>
            <input type="hidden" value="{{forCtrl}}" name="forCtrl"/>
                {{{content}}}
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" onclick='save_customize_changes();apply_font(); create_table();set_imageSize();'>Save Changes</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick='delete_ctrl()'>Delete</button>
        </div>
        </script>
        <!-- common modal close here -->
    
    
        <!-- content for label modal -->
        <script id="label-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="50"></textarea></p>
        <p id="pfonts"><label class="control-label" for="fonts-textbox">Select Font:</label>
                <span class="fontbox" onclick="change_font('bold');"><i class="fa fa-bold"></i></span>
                <span class="fontbox" onclick="change_font('italic');"><i class="fa fa-italic"></i></span>
                <span class="fontbox" onclick="change_font('normal');">R</span>
                <span class="fontbox" onclick="change_size('12');"><b class="smallletter">A</b></span>
                <span class="fontbox" onclick="change_size('14');"><b class="mediumletter">A</b></span>
                <span class="fontbox" onclick="change_size('16');"><b class="largeletter">A</b></span>
        </p>
        </script>    
    
    
        <script id="multilabel-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Multiline Label</label> <textarea rows="3" cols="50" name="multilinelabel" value="" id="handlebars-textbox-label"></textarea></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="50"></textarea></p>
        <p id="pfonts"><label class="control-label" for="fonts-textbox">Select Font:</label>
                <span class="fontbox" onclick="change_font('bold');"><i class="fa fa-bold"></i></span>
                <span class="fontbox" onclick="change_font('italic');"><i class="fa fa-italic"></i></span>
                <span class="fontbox" onclick="change_font('normal');">R</span>
                <span class="fontbox" onclick="change_size('12');"><b class="smallletter">A</b></span>
                <span class="fontbox" onclick="change_size('14');"><b class="mediumletter">A</b></span>
                <span class="fontbox" onclick="change_size('16');"><b class="largeletter">A</b></span>
        </p>
        </script>	
    
    
        <!-- content for logoimage modal -->
        <script id="logoimage-template" type="text/x-handlebars-template">
        <p id="pimage"> <label class="control-label" for="form-textbox">Select Image:</label>
            <span>
                <input type='file' name="logo_image" class="logo_image" onchange="readURLlogo(this);" />
            </span>
        </p>
        </script>  
    
    
        <!-- content for image modal -->
        <script id="image-template" type="text/x-handlebars-template">
        <p id="pimage"> <label class="control-label" for="form-textbox">Select Image:</label>
            <span>
                <input type='file' name="form_image" class="form_image" onchange="readURL(this);" />
            </span>
        </p>
        <p id="pimag_size"><label class="control-label" for="form-textbox">Image Size:</label>
             <input type="radio" name="img_ctrl" value="small"><img src="img/img_icon3.png" alt="small image" />
             <input type="radio" name="img_ctrl" value="medium"><img src="img/img_icon2.png" alt="medium image" />
             <input type="radio" name="img_ctrl" value="large"><img src="img/img_icon1.png" alt="large image" />
         </p>
        </script>
    
    
        <!-- content for table modal -->
        <script id="table-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p><label class="control-label" for="form-textbox">No of Rows:</label>
            <span id="tablerows">
                <select name="table_rows">
                    <option value="">--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select></span>
        </p>
        <p><label class="control-label" for="form-textbox">No of Column:</label>
            <span id="tablecols">
                <select name="table_cols">
                    <option value="">--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select></span>
        </p>     
        <p><label class="control-label" for="form-textbox">Label To:</label>
			<input type="checkbox" name="tbl_row_header" id ="tbl_row_header" value="tblrow"/>Rows
			<input type="checkbox" name="tbl_col_header" id ="tbl_col_header" value="tblcols"/>Columns
        </p>	
        </script>

    
        <!-- content for textbox modal -->
        <script id="textbox-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="50"></textarea></p>
        <p><label class="control-label ctrl-imagebox">Placeholder</label> <input type="text" name="placeholder" value="" class="ctrl-imagebox"/></p>
        <p id="plength">
            <label class="control-label">Length limit</label>
                <input type="text" value="0" class="length_limitbox" /><label class="subcontrol-label" for="minlen-textbox">Min</label>
                <input type="text" value="0" class="length_limitbox" /><label class="subcontrol-label" for="maxlen-textbox">Max</label>
        </p>
        </script>

    
        <!-- content for combobox modal -->
        <script id="combobox-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="50"></textarea></p>
        <p><label class="control-label">Options</label> <textarea name="options" rows="5"></textarea></p>
        </script>
    
    
        <!-- content for stdcombobox modal -->
        <script id="stdcombobox-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label" >Select List</label> <span id="slist"></span></p>
        <!--<p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="60"></textarea></p>
        </p>-->
        <p id="std_seletedlist"><label class="control-label">Options</label> <textarea name="options" rows="5" readonly></textarea></p>
        </script>
    
    
        <!-- content for optionbox modal -->
        <script id="optionbox-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="50"></textarea></p>
        <p><label class="control-label">Options</label> <textarea name="options" rows="5"></textarea></p>
        <p><label class="control-label">Display Type:</label>
            <input type="radio" name="chkdisplay" value="horizontal_display" />Horizontal Display
            <input type="radio" name="chkdisplay" value="vertical_display" />Vertical Display
        </p>
        </script>     

    
        <!-- content for text modal -->
        <script id="text-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="50"></textarea></p>
        <p id="plength">
        <label class="control-label">Length limit</label>
                <input type="text" value="0" class="length_limitbox" /><label class="subcontrol-label" for="minlen-textbox">Min</label>
                <input type="text" value="0" class="length_limitbox" /><label class="subcontrol-label" for="maxlen-textbox">Max</label>
        </p>
        </script>

    
        <!-- content for date modal -->
        <script id="date-template" type="text/x-handlebars-template">
        <p>
            <label class="control-label" for="handlebars-textbox-formatdate" style="padding-top:16px;">Label:</label>
            <input type="text" name="label" value="" id="handlebars-textbox-label"/>
        </p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        </script>

   
        <!-- content for Logo Image modal -->
        <div id="customization_logo_modal" name="customization_logo_modal" class="modal hide fade in logopopup" aria-hidden="false" style="display: none;">
        <div class="modal-header"><h3>Logo Image</h3></div>
        <div class="modal-body">
            <form id="headerForm" class="form-horizontal">
                <p id="pimage"> <label class="control-label" for="form-textbox">Select Image:</label>
                <span><input type="file" name="form_image" class="form_image" onchange="readURLlogo(this);"></span>
                </p>
               
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="save_logochanges()">Save & Close</button>
            <button class="btn" onclick="cancel_formlogo()">Cancel</button>
        </div>
        </div>
    
    
        <!-- content for Form title modal -->
        <div id="customization_title_modal" name="customization_title_modal" class="modal hide fade in titlepopup" aria-hidden="false" style="display: none;">
        <div class="modal-header">
            <h3>Form Title</h3>
        </div>
        <div class="modal-body">
            <form id="headertitleForm" class="form-horizontal">
                <p id="pLibelle" class="row"><label class="control-label col-md-3" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" class="col-md-9" id="handlebars-title-label" width="60%"/></p>
                <p id="pfonts"><label class="control-label" for="fonts-textbox">Select Font:</label>
                <span class="fontbox" onclick="change_titlefont('bold');"><i class="fa fa-bold"></i></span>
                <span class="fontbox" onclick="change_titlefont('italic');"><i class="fa fa-italic"></i></span>
                <span class="fontbox" onclick="change_titlefont('normal');">R</span>
                <span class="fontbox" onclick="change_titlesize('22');"><b class="smallletter">A</b></span>
                <span class="fontbox" onclick="change_titlesize('24');"><b class="mediumletter">A</b></span>
                <span class="fontbox" onclick="change_titlesize('26');"><b class="largeletter">A</b></span>
        </p>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="save_titlechanges();">Save Changes</button>
            <button class="btn" onclick="cancel_formtitle()">Cancel</button>
        </div>
        </div>
    
    
        <!-- Table Dialogbox -->
            <div id="table_modelbox" style="display:none"></div>
        <!-- end of Dialog -->
    

        <!-- create table container -->
            <div id="dialog-form-nombre-colonne" class="modal hide fade" style="display: none; ">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">x</a>
                <h3>Create Table</h3>
            </div>
            <div class="modal-body" style="padding:10px 40px 0 40px; min-height:150px;">
            <form>
                <label for="nbColonne">Number of columns : <span id="nbColonne">1</span></label>
                <div id="sliderNbColonne"></div>
                <br/>
                <input type="checkbox" name="framebox" value="framebox" id="framebox"> Frame
            </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-success" onclick='ajouterTableau();'>Add table</a>
                <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            </div>
            </div>
    
            <span style="position:absolute; padding-right:6px; height:10px;" id="divDeleteTableau">
                <a href="#" onclick="supprimerTableau();"><img src="img/delete.png"  alt="" /></a>
             </span>
            <hr/>
    
    
            <!-- data to generate template form -->
            <form id="template_form" name="admin_template_form" method="post" action="admin_template_form.php">
                <input type="hidden" id="template_fromdata" name="template_fromdata" value="">
                <input type="hidden" value="" name="form_title" value="" class="template_name">
                <input type="hidden" value="" name="ftitle_description" class="template_desc">
                <input type="hidden" value="" name="domain_temp" class="domain_temp">
                <input type="hidden" value="" name="subdomain" class="subdomain">
				
            </form> 
            <!-- end of template form -->
    
    </body>
</html>
<!------ div-padding-menu  class is used to remove all padding by Mahendra---------------------------------------------------------->