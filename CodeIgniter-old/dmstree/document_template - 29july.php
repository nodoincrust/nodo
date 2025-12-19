<?php
/*
Page name: Document template
Date Created: 23 July 2014
Created By: Shubhangi Mate
Modify By:
Modified Date:
*/
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <title>Document Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
   
    <link rel="stylesheet" href="jqueryui/themes/base/jquery-ui.css" />
    <link href="dist/css/bootstrap.css" rel="stylesheet" media="screen">
    <!--<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">-->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/tests/vendor/jquery.min.js"></script>
    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/dmstree_js/document_template.js"></script>
    <script type="text/javascript" src="js/dmstree_js/document_template_valid.js"></script>
    <script type="text/javascript" src="js/dmstree_js/uploader.js"></script>
    
   
    <style id="content-styles">
        /* Styles that are also copied for Preview */
        .control-label {
        display: inline-block !important;
        padding-top: 5px;
        /*text-align: right;*/
        text-align: left;
        vertical-align: baseline;
        padding-right: 10px;
        }
        .droppedField {
        padding-left:5px;
        }
        .droppedField > input,.checkboxgroup, .selectmultiple, .radiogroup { /*button, select, */ 
        margin-top: 10px;
        margin-right: 10px;
        margin-bottom: 10px;
        }
        .action-bar .droppedField {
        float: left;
        padding-left:5px;
        }
        .btn:hover{
            color: #333;
            text-decoration: none;
            background-position: 0 -15px;
            transition: background-position .1s linear;
            background-color: #e6e6e6;
        }
        .framebox
        {
            border: 1px solid rgb(231, 231, 231);
        }
        .row
        {
            margin-left: 0 !important;
        }
        .droppedField 
        {
            margin: 0 0 15px;
        }
        .form_btn .btn
        {
            float: right;
            margin-right: 10px;
        }
        .boldfont
        {
            font-weight: bold;
        }
        .italicfont
        {
            font-weight: normal;
            font-style: italic; 
        }
        .inline_radio
        {
            display: inline-block !important;
            margin-right: 3%;
        }
        .block_radio
        {
            display: block !important;
        }
        .label_req
        {
            float: left;
        }
        .textbox_err_msg
        {
            color: red;
            margin-left: 5px;
        }
        .requiredcls
        {
            display: none;
            float: left;
            color: red;
        }
        .manditory_fields
        {
            color: red;
        }
        .bottom_note
        {
           
            padding: 5px;
            margin-top: 10px;
        }
        .smalltitle
    {
        font-size: 22px;
    }
    .midtitle
    {
        font-size: 24px;
    }
    .largetitle
    {
        font-size: 26px;
    }
    .temp_title
    {
        margin: 0 !important;
        padding-top: 40px;
    }
    .form_table
    {
        border: 1px solid #ccc;
        border-collapse: collapse;
        width: auto;
        padding: 0 !important;
    }
    .tbl_td
    {
        border:none !important;
        box-shadow: none !important;
        transition:0 !important;
        margin-bottom: 0 !important;
        padding:4px 6px;
        height: 20px;
        min-height: 20px !important;
        width: 120px;
    }
    .table_div
    {
        overflow-x: scroll;
        overflow-y: scroll;
    }
    </style>
  </head>

  <body>
    <div class="header_nav">  
    <div class="container container-fluid header-container">
         <div class="row row-fluid">
             <div class="col-md-4 span4"><img src="img/LOGO-2.PNG" alt="Logo_image" id="dms_logo" width="280" height="75"></div>
             <div class="col-md-8 span8">
                 <nav>
                        <ul class="menu_list">
                            <li class="menu_options"><a href="#">Upload Document Template</a></li>
                            <li class="menu_options"><a href="#">Sharing Document Template</a></li>
                            <li class="menu_options"><a href="#">Document Revision</a></li>
                        </ul>
                 </nav>    
             </div>
         </div>
     </div> 
     </div> 
      
    <div class="container container-fluid content">
    <div class="row row-fluid">
        
         <div class="col-md-3 span3" style="">
              <h4>Drag and Drop Component</h4>
              <hr/>
        
                <div class='selectorField draggableField'>
                <div class="labelbox well well-mini"><b></b> Label</div>
                <div class='modele'>
                    <div class="col-md-12 span12"><label class="control-label forms_lbl ctrl-label">Label:</label></div>
                    <input type="hidden" value="" class="label_font"/>
                    <input type="hidden" value="" class="label_id">
                    <input type="hidden" value="" class="label_size">
                </div>
                </div>
              
                 
                <div class='selectorField draggableField'>
                <div class="multilinelabel well well-mini"><b></b>Multi-line Label</div>
                <div class='modele'>
                    <label class="col-md-12 span12 control-label forms_lbl ctrl-label">Multi-line Label:</label>
                    <input type="hidden" value="" class="label_font"/>
                    <input type="hidden" value="" class="label_id">
                    <input type="hidden" value="" class="label_size">
                    <!--<div class="col-md-1 span1"><input type="hidden" placeholder="write title here..." class="ctrl-label"/></div>-->
                </div>
                </div>
        
                <div class='selectorField draggableField'>
                <div class="textbox well well-mini"><b></b> Textbox</div>
                <div class='modele'>
                <div class="col-md-3 span3"> <div class="row row-fluid"><label class="control-label label_req">Textbox</label><label class="label_req requiredcls">*</label></div></div>
                    <div class="col-md-9 span9"><input type="text" placeholder="write text here..." class="ctrl-textbox" minlength="" maxlength="" onkeyup="display_minmaxlen_err(this)"/><span class="textbox_err_msg"></span>
                    <p class="control_help"></p>
                    <input type="hidden" class="hiddenObligatoire"/>
                    <input type="hidden" class="min_length" value="" />
                    <input type="hidden" class="max_length" value="" />
                    <!--<input type="hidden" class="length_type" value="" />-->
                    </div>
                </div>
                </div>
        
                <div class='selectorField draggableField'>
                <div class="displaytext well well-mini"><b></b> Textarea</div>
                <div class='modele'>
                    <div class="col-md-3 span3"><label class="control-label label_req">Textarea</label><label class="label_req requiredcls">*</label></div>
                    <div class="col-md-9 span9"><span class="ctrl-text">
                            <textarea name="textarea" rows="4" cols="50" class="ctrl-textbox" minlength="" maxlength="" onkeyup="display_minmaxlen_err(this)" /></textarea><span class="textbox_err_msg"></span>
                            <input type="hidden" class="hiddenObligatoire"/>
                            <input type="hidden" class="min_length" value="" />
                            <input type="hidden" class="max_length" value="" />
                        </span></div>
                </div>
                </div>

                <div class='selectorField draggableField'>
                <div class="password well well-mini"><b></b>Password</div>
                <div class='modele'>
                    <div class="col-md-3 span3"><div class="row"><label class="label_req control-label">Password</label><label class="label_req requiredcls">*</label></div></div>
                    <div class="col-md-9 span9"><input type="password" placeholder="Enter Password" class="ctrl-passwordbox"/>
                    <input type="hidden" class="hiddenObligatoire"/></div>
                </div>
                </div>

                <div class='selectorField draggableField'>
                <div class="combobox well well-mini"><b></b> Drop-down list</div>
                <div class='modele'>
                    <div class="col-md-3 span3"><div class="row"><label class="control-label label_req"> Drop-down list</label><label class="label_req requiredcls">*</label></div></div>
                    <div class="col-md-9 span9"><select class="ctrl-combobox">
                    <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option>
                    <option value="option3">Option 3</option>
                    </select>
                    <input type="hidden" class="hiddenObligatoire"/>
                    
                    </div>
                </div>
                </div>

                <div class='selectorField draggableField'>
                <div class="radiogroup well well-mini"><b></b> Radio buttons</div>
                <div class='modele'>
                    <div class="col-md-3 span3"><div class="row"><label class="label_req control-label" style="vertical-align:top">Radio buttons</label><label class="label_req requiredcls">*</label></div></div>
                    <div style="display:inline-block;" class="ctrl-radiogroup col-md-9 span9">
                    <span style="display:block;"><input type="radio" name="radioField" value="option1"/>Option 1</span>
                    <span style="display:block;"><input type="radio" name="radioField" value="option2"/>Option 2</span>
                    <span style="display:block;"><input type="radio" name="radioField" value="option3"/>Option 3</span>
                    </div>
                    <input type="hidden" class="hiddenObligatoire"/>
                    <input type="hidden" class="rd_display" value="">
                </div>
                </div>

                <div class='selectorField draggableField'>
                <div class="checkboxgroup well well-mini"><b></b> Multiple Checkbox</div>
                <div class='modele'>
                    <div class="col-md-3 span3"><div class="row"><label class="label_req control-label" style="vertical-align:top">Multiple Checkbox</label><label class="label_req requiredcls">*</label></div></div>
                    <div style="display:inline-block;" class="ctrl-checkboxgroup col-md-9 span9">
                    <span style="display:block;"><input type="checkbox" name="checkboxField" value="option1"/>Option 1</span>
                    <span style="display:block;"><input type="checkbox" name="checkboxField" value="option2"/>Option 2</span>
                    <span style="display:block;"><input type="checkbox" name="checkboxField" value="option3"/>Option 3</span>
                    </div>
                    <input type="hidden" class="hiddenObligatoire"/>
                    <input type="hidden" class="chk_display" value="">
                </div>
                </div>

                <div class='selectorField draggableField'>
                <div class="selectmultiple well well-mini"><b></b> Selection multiple</div>
                <div class='modele'>
                    <div class="col-md-3 span3"><div class="row"><label class="label_req control-label" style="vertical-align:top">Selection multiple</label><label class="label_req requiredcls">*</label></div></div>
                    <div style="display:inline-block;" class="col-md-9 span9">
                    <select multiple="multiple" style="width:150px" class="ctrl-selectmultiplelist">
                        <option value="option1">Option 1</option>
                        <option value="option2">Option 2</option>
                        <option value="option3">Option 3</option>
                    </select>
                    </div>
                    <input type="hidden" class="hiddenObligatoire"/>
                </div>
                </div>

                <!-- <b>Champs Auto</b><br />-->
                
                <div class="selectorField draggableField">
                    <div class="imagebox well well-mini"><b></b>Image</div>
                    <div class="modele">
                        <div class="col-md12 span12"><img src="#" alt="Upload Image" width="150" height="auto" class="fimage control-label ctrl-image" id="blah"/></div>
                        <input type="hidden" value="" class="image_path">
                    </div>    
                </div>
                
                <div class='selectorField draggableField'>
                <div class="displaydate well well-mini"><b></b> Date</div>
                <div class='modele'>
                    <div class="col-md-3 span3"><label class="control-label">Date</label></div>
                    <div class="col-md-9 span9">
                        <span class="ctrl-date"><input type="text" name="expirydate" class="expirydate" id="expiry-date" onclick="display_expiryCal();" /></span>
                    </div>
                </div>
                </div>

                <div class='selectorField draggableField'>
                    <div class="upload well well-mini"><b></b> File Upload</div>
                    <div class='modele'>
                        <div class="col-md-3 span3"><label class="control-label">File upload</label></div>
                        <div class="col-md-9 span9"><span class="upload_btn"><input type="file" name="file_up" class="file_up ctrl-date"  disabled = "disabled"/></span>
                        </div>
                    </div>
                </div>  
                
                <div class='selectorField draggableField'>
                    <div class="tablebox well well-mini"><b></b>Table</div>
                    <div class="modele">
                        <div class="col-md-12 span12">
                            <label class="row row-fluid col-md-12 span12 control-label" >Table Parameters:</label>
                            <div class="row row-fluid col-md-12 span12 table_div" >
                                <table class="ctrl-table form_table" border="1px solid #ccc">
                                </table>  
                            <input type="hidden" class="table_rows" value="">
                            <input type="hidden" class="table_cols" value="">
                            </div>
                        </div>
                    </div>
                </div>    
                   
                
      </div>


      <div class="col-md-9 span9">
        
        <!-- 
          Below we have the columns to drop controls
            -- Removed the TABLE based implementations from earlier code
            -- Grid system used for rendering columns 
            -- Columns can be simply added by defining a div with droppedFields class onclick="val_click()"
        -->
        <h4>Form Fields:</h4>
        <hr/>
        <div style="border:1px solid #e7e7e7; padding: 25px 5px 5px; float: left; width:100%; z-index:0 !important;">
            
            <div class="row row-fluid" id="form-title-div">
                <div class="col-md-2 span2" onclick="open_logoimage_popup()">
                    <image src="" alt="logo-image" class="logo_image" id="logo_image" width="120px" heigth="75px" />
                </div>
                <div class="col-md-10 span10" onclick="open_title_popup()">
                    <input type="text" class="input-large col-md-12 span12" placeholder="Type form title here" id="form-title" />
                    <input type="hidden" value="" class="titlelabel_font"/>
                    <input type="hidden" value="" class="titlelabel_size">
                </div>
            </div>
            
            <div class="row row-fluid" id="form-description_div">
                <textarea class="input-large col-md-12 span12" placeholder="Type form description here" id="form-description"></textarea>
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
      </div>
        
        
    </div>
    </div>
  


  <!-- Preview button -->
  <!--  <div class="container-fluid">-->
  <!--  </div>    -->

  <div class="tabbable"> 
  <!-- List of controls rendered into Bootstrap Tabs -->
  </div>

 
    <script type="text/javascript" src="bootstrap/js/jquery.js"></script>	
    <script type="text/javascript" src="dist/js/bootstrap.js"></script>
    <script type="text/javascript" src="jqueryui/ui/minified/jquery-ui.min.js"></script>
    <script type="text/javascript" src="handlebars/handlebars.js"></script>
    <!-- 
    Starting templates declaration
    DEV-NOTE: Keeping the templates and code simple here for demo  -- use some better template inheritance for multiple controls 
    ---> 

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
        <button class="btn btn-primary" data-dismiss="modal" onclick='save_customize_changes();apply_font(); create_table();'>Save Changes</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick='delete_ctrl()'>Delete</button>
    </div>
    </script>
    
    <script id="label-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="60"></textarea></p>
        <p id="pfonts"><label class="control-label" for="fonts-textbox">Select Font:</label>
                <span class="fontbox" onclick="change_font('bold');"><i class="fa fa-bold"></i></span>
                <span class="fontbox" onclick="change_font('italic');"><i class="fa fa-italic"></i></span>
                <span class="fontbox" onclick="change_font('normal');">R</span>
                <span class="fontbox" onclick="change_size('12');"><b class="smallletter">A</b></span>
                <span class="fontbox" onclick="change_size('14');"><b class="mediumletter">A</b></span>
                <span class="fontbox" onclick="change_size('16');"><b class="largeletter">A</b></span>
        </p>
    </script>    
    
    
    <script id="logoimage-template" type="text/x-handlebars-template">
        <p id="pimage"> <label class="control-label" for="form-textbox">Select Image:</label>
            <span>
                <input type='file' name="logo_image" class="logo_image" onchange="readURLlogo(this);" />
            </span>
        </p>
    </script>  
    
    
    <script id="image-template" type="text/x-handlebars-template">
        <p id="pimage"> <label class="control-label" for="form-textbox">Select Image:</label>
            <span>
                <input type='file' name="form_image" class="form_image" onchange="readURL(this);" />
            </span>
        </p>
    </script>
    
    <script id="table-template" type="text/x-handlebars-template">
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
    </script>

    <script id="textbox-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="60"></textarea></p>
        <p><label class="control-label ctrl-imagebox">Placeholder</label> <input type="text" name="placeholder" value="" class="ctrl-imagebox"/></p>
        <p id="plength">
            <label class="control-label">Length limit</label>
                <input type="text" value="0" class="length_limitbox" /><label class="subcontrol-label" for="minlen-textbox">Min</label>
                <input type="text" value="0" class="length_limitbox" /><label class="subcontrol-label" for="maxlen-textbox">Max</label>
        </p>
    </script>

    <script id="combobox-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="60"></textarea></p>
        <p><label class="control-label">Options</label> <textarea name="options" rows="5"></textarea></p>
    </script>
    
    <script id="optionbox-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="60"></textarea></p>
        <p><label class="control-label">Options</label> <textarea name="options" rows="5"></textarea></p>
        <p><label class="control-label">Display Type:</label>
            <input type="radio" name="chkdisplay" value="horizontal_display" />Horizontal Display
            <input type="radio" name="chkdisplay" value="vertical_display" />Vertical Display
        </p>
    </script>     

    <script id="text-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" id="handlebars-textbox-label"/></p>
        <p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="60"></textarea></p>
        <p id="plength">
        <label class="control-label">Length limit</label>
                <input type="text" value="0" class="length_limitbox" /><label class="subcontrol-label" for="minlen-textbox">Min</label>
                <input type="text" value="0" class="length_limitbox" /><label class="subcontrol-label" for="maxlen-textbox">Max</label>
        </p>
    </script>

    <script id="date-template" type="text/x-handlebars-template">
    <p>
        <label class="control-label" for="handlebars-textbox-formatdate" style="padding-top:16px;">Label:</label>
        <input type="text" name="label" value="" id="handlebars-textbox-label"/>
    </p>
    </script>

    <!-- End of templates -->
    
    <!-- Form-logoheader --->
    <div id="customization_logo_modal" name="customization_logo_modal" class="modal hide fade in logopopup" aria-hidden="false" style="display: none;">
    <div class="modal-header">
        <h3>Logo Image</h3>
    </div>
    <div class="modal-body">
        <form id="headerForm" class="form-horizontal">
        <p id="pimage"> <label class="control-label" for="form-textbox">Select Image:</label>
            <span>
                <input type="file" name="form_image" class="form_image" onchange="readURLlogo(this);">
            </span>
        </p>
    
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" onclick="save_logochanges()">Save & Close</button>
        <button class="btn" onclick="cancel_formlogo()">Cancel</button>
    </div>
    </div>
    <!-- end of form-logoheader -->
    
    <!--From title-->
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
    <!--end of form title -->
    
    
    <!-- Table Dialogbox -->
            <div id="table_modelbox" style="display:none"></div>
    <!-- end of Dialog -->
    

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
  </body>
</html>
