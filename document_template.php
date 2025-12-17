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
include 'session_timeout.php';
include 'session_config.php';

$tenantid = '';
$tenantname = '';
if (isset($_SESSION['usertenant'])) {
    $tenantid = $_SESSION['usertenant'];
}
if (isset($_SESSION['tenantname'])) {
    $tenantname = $_SESSION['tenantname'];
    $tenantname = str_replace(" ", "_", $tenantname);
}

require('CodeIgniter-old/external.php');
$ci = &get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();

$path = 'DMSTree_clients/' . $tenantname . '_' . $tenantid;
$ar = getDirectorySize($path);
$tenantspace = sizeFormat($ar['size']);
$tenantspace = (float)$tenantspace;
$filesize = (float)fileSizeInMB($ar['size']);
$activepackspace = $g1->get_mongodb->getActivePackageSize($tenantid);
$activepackspace = (float)$activepackspace;
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
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/stylesheet.css" />

    <script type="text/javascript" src="js/tests/vendor/jquery.min.js"></script>
    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/dmstree_js/document_template.js"></script>
    <script type="text/javascript" src="js/dmstree_js/doc_temp_valid.js"></script>
    <script type="text/javascript" src="js/dmstree_js/uploader.js"></script>
    <script type="text/javascript" src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
    <script type="text/javascript" src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
    <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
    <style id="content-styles">
        /* Styles that are also copied for Preview */
        .control-label {
            display: inline-block !important;
            padding-top: 5px;
            text-align: left;
            vertical-align: baseline;
            padding-right: 10px;
        }

        .droppedField {
            padding-left: 5px;
        }

        .droppedField>input,
        .checkboxgroup,
        .selectmultiple,
        .radiogroup {
            /*button, select, */
            margin-top: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .action-bar .droppedField {
            float: left;
            padding-left: 5px;
        }

        .btn:hover {
            color: #333;
            text-decoration: none;
            background-position: 0 -15px;
        }

        .framebox {
            border: 1px solid rgb(231, 231, 231);
        }

        .row {
            /* margin-left: 0 !important; */
            /* margin-left: -15px !important; */
            /* padding: 9px; */
        }

        div.logo-container {
            margin-top: 30px;
        }

        .row_content {
            margin-left: 15px !important;
            padding: 9px;
        }

        .droppedField {
            margin: 0 0 15px;
        }

        .form_btn .btn {
            float: right;
            margin-right: 10px;
        }

        .boldfont {
            font-weight: bold;
        }

        .italicfont {
            font-weight: normal;
            font-style: italic;
        }

        .inline_radio {
            display: inline-block !important;
            margin-right: 3%;
        }

        .block_radio {
            display: block !important;
        }

        .label_req {
            float: left;
        }

        .textbox_err_msg {
            color: red;
            margin-left: 5px;
        }

        .requiredcls {
            display: none;
            float: left;
            color: red;
        }

        .manditory_fields {
            color: red;
        }

        .bottom_note {
            border: 1px solid #ccc;
            padding: 5px;
            margin-top: 10px;
        }

        .smalltitle {
            font-size: 22px;
        }

        .midtitle {
            font-size: 24px;
        }

        .largetitle {
            font-size: 26px;
        }

        .temp_title {
            margin: 0 !important;
            padding-top: 40px;
        }

        .form_table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            width: auto;
            padding: 0 !important;
        }

        .tbl_td {
            border: none !important;
            box-shadow: none !important;
            transition: 0 !important;
            margin-bottom: 0 !important;
            padding: 4px 6px;
            height: 20px;
            min-height: 20px !important;
            width: 120px;
        }

        .table_div {
            overflow-x: auto;
            overflow-y: auto;
        }

        .tbl_btn {
            display: none;
            margin-top: 10px
        }

        .required_msg {
            color: red;
        }

        .template_txtarea {
            width: 100% !important;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin: 0px !important;
        }

        .template_txtarea {
            width: 100% !important;
        }

        .add_btn {
            display: flex;
            gap: 8px;
            justify-content: end;

        }

        .save_btn_form {
            width: 100px;
            border-radius: 4px;
            padding: 2px;
            padding: 6px 12px;
            border-radius: 4px;
        }

        .content_cls {
            background: #fff !important;
            /* padding-left: 19px !important; */
            padding: 30px !important;
        }

        @font-face {
            font-family: 'Space Grotesk';
            src: url('fonts/SpaceGrotesk-VariableFont_wght.ttf') format('truetype');
            font-weight: 400 700;
            font-style: normal;
        }

        @font-face {
            font-family: 'Inter';
            src: url('fonts/Inter-VariableFont_opsz,wght.ttf') format('truetype');
            font-weight: 100 900;
            font-style: normal;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            overflow: hidden;
        }

        .footer-fixed {
            position: fixed;
            right: 0;
            bottom: 0;
            width: 85%;
            /* z-index: 999; */
            background: #fff;
            /* box-shadow: 0 -1px 6px rgba(0,0,0,0.07); */
        }

        .border_class {
            border: 1px solid #ccc !important;
            background-color: #FAFAFA !important;
        }

        .tempsaveform {
            background: #1B5563;
            color: white;
        }

        .Template-main {
            padding-bottom: 110px !important;
        }

        .tempPopupHead {
            color: #1B5563;
            font-size: 20px;
            font-family: 'Space Grotesk', Arial, sans-serif;
            font-weight: 600;
        }

        .savebuttontemp {
            background: #1B5563;
            color: white;
        }

        .savebuttontemp3 {
            background: #1B5563;
            color: white;
        }

        .Template-main-left {
            background: #F4F4F4;
        }
        
        
    </style>
    <script>
        window.onload = function() {
            value = <?php echo $filesize ?>;
            max = <?php echo $activepackspace * 1000 ?>;
            if (document.getElementById('g1')) {
                showmeter(value, max);
            }
        };
        $(document).ready(function() {
            var directoryspace = <?php echo $tenantspace ?>;
            var tenantspace = <?php echo $activepackspace ?>;
            if (parseFloat(directoryspace) >= parseFloat(tenantspace)) {
                $('input').attr('disabled', 'disabled');
                $('select').attr('disabled', 'disabled');
                $('textarea').attr('disabled', 'disabled');
                $("#datetimepicker").attr('disabled', 'disabled');
                var spacemsg = 'Package Size is full';
                $('.spaceerror').text(spacemsg);
            } else {
                $('.input').removeAttr('disabled');
                $('select').removeAttr('disabled');
                $('textarea').removeAttr('disabled');
                $("#datetimepicker").datepicker("option", "disabled", false);
                $('.spaceerror').text('');
            }
        });
    </script>
</head>

<body>
    <?php include_once 'header.php'; ?>
    <div class="row-margin bottom_cls" style="padding:9px; display:flex">
        <div class=" div-padding-menu" style="max-width:250px">
            <!--------- dash board side menu------------------------------------------------>
            <?php include_once 'dash_menu.php' ?>
        </div>
        <div class="div-padding-menu div-padding-left" style="width:100%;padding:0 20px">
            <div class="checkout_doc">
                <div class="row">
                    <div class="col-md-12 col-sm-12 form_title ">
                        <h2 class="text-muted hr-margin upload_doc_cls"><b>Create Custom Template</b></h2>
                    </div>
                </div>
            </div>
            <!----------end menu----------------->
            <!-- Main Container Start here -->
            <div class="content content_cls Template-main">
                <!-- <div class="row row-fluid">
                <p class="spaceerror col-md-12 span12" style="color:red"> </p>
            </div>  -->
                <div class="row row-fluid ">

                    <div class="col-md-3 span3 div-padding-menu Template-main-left"><!-- div declare all drag and drop component -->
                        <h4 style="font-family: 'Inter', Arial, sans-serif;">Drag and Drop Component</h4>
                        <hr />

                        <!-- label start here-->
                        <div class='selectorField draggableField'>
                            <!-- <div class="labelbox well well-mini"><b></b> Label</div> -->
                            <div class="labelbox create_custom_template"><b></b> Label</div>
                            <div class='modele'>
                                <div class="col-md-12 span12"><label class="control-label forms_lbl ctrl-label">Label:</label></div>
                                <input type="hidden" value="" class="label_font" />
                                <input type="hidden" value="" class="label_id">
                                <input type="hidden" value="" class="label_size">
                            </div>
                        </div>
                        <!-- label close here -->

                        <!-- multilinelabel start here-->
                        <div class='selectorField draggableField'>
                            <!-- <div class="multilinelabel well well-mini"><b></b>Multi-line Label</div> -->
                            <div class="multilinelabel create_custom_template"><b></b>Multi-line Label</div>
                            <div class='modele'>
                                <label class="col-md-12 span12 control-label forms_lbl ctrl-multilabel" style="width:100%">Multi-line Label:</label>
                                <input type="hidden" value="" class="label_font" />
                                <input type="hidden" value="" class="label_id">
                                <input type="hidden" value="" class="label_size">
                            </div>
                        </div>
                        <!-- multilinelabel close here -->

                        <!-- textbox start here -->
                        <div class='selectorField draggableField'>
                            <!-- <div class="textbox well well-mini create_custom_template"><b></b> Textbox</div> -->
                            <div class="textbox  create_custom_template"><b></b> Textbox</div>
                            <div class='modele'>
                                <div class="col-md-3 span3">
                                    <div class="row row-fluid"><label class="control-label label_req">Textbox</label><label class="label_req requiredcls">*</label></div>
                                </div>
                                <div class="col-md-9 span9">
                                    <input type="text" placeholder="write text here..." class="ctrl-textbox cntrol_comp" minlength="" maxlength="" onkeyup="display_minmaxlen_err(this)" /><span class="textbox_err_msg"></span>
                                    <p class="required_msg"></p>
                                    <p class="control_help"></p>
                                    <input type="hidden" class="hiddenObligatoire" />
                                    <input type="hidden" class="min_length" value="" />
                                    <input type="hidden" class="max_length" value="" />
                                </div>
                            </div>
                        </div>
                        <!-- textbox close here -->

                        <!-- textarea start here -->
                        <div class='selectorField draggableField'>
                            <!-- <div class="displaytext well well-mini create_custom_template"><b></b> Textarea</div> -->
                            <div class="displaytext create_custom_template"><b></b> Textarea</div>
                            <div class='modele'>
                                <div class="col-md-3 span3">
                                    <label class="control-label label_req">Textarea</label><label class="label_req requiredcls">*</label>
                                </div>
                                <div class="col-md-9 span9">
                                    <span class="ctrl-text">
                                        <textarea class="cntrol_comp template_txtarea" rows="4" class="ctrl-textbox " minlength="" maxlength="" onkeyup="display_minmaxlen_err(this)" /></textarea><span class="textbox_err_msg"></span>
                                        <p class="required_msg"></p>
                                        <input type="hidden" class="hiddenObligatoire" />
                                        <input type="hidden" class="min_length" value="" />
                                        <input type="hidden" class="max_length" value="" />
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- textarea close here -->

                        <!-- combobox start here Drop-down list-->
                        <div class='selectorField draggableField'>
                            <!-- <div class="combobox well well-mini create_custom_template"><b></b> Custom Combobox </div> -->
                            <div class="combobox create_custom_template" style="white-space: nowrap;"><b></b> Custom Combobox </div>
                            <div class='modele'>
                                <div class="col-md-3 span3">
                                    <div class="row"><label class="control-label label_req">Custom Combobox</label><label class="label_req requiredcls">*</label></div>
                                </div>
                                <div class="col-md-9 span9">
                                    <select class="ctrl-combobox cntrol_comp">
                                        <option value="option1">Option 1</option>
                                        <option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option>
                                    </select>
                                    <p class="required_msg"></p>
                                    <input type="hidden" class="hiddenObligatoire" />
                                </div>
                            </div>
                        </div>
                        <!-- combobox close here -->

                        <!-- radiogroup start here -->
                        <div class='selectorField draggableField'>
                            <!-- <div class="radiogroup well well-mini create_custom_template"><b></b> Radio buttons</div> -->
                            <div class="radiogroup create_custom_template"><b></b> Radio buttons</div>
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
                                <input type="hidden" class="hiddenObligatoire" />
                                <input type="hidden" class="rd_display" value="">
                            </div>
                        </div>
                        <!-- radiogroup close here -->

                        <!-- checkboxgroup start here -->
                        <div class='selectorField draggableField'>
                            <!-- <div class="checkboxgroup well well-mini create_custom_template"><b></b> Multiple Checkbox</div> -->
                            <div class="checkboxgroup create_custom_template" style="white-space: nowrap;"><b></b> Multiple Checkbox</div>
                            <div class='modele'>
                                <div class="col-md-3 span3">
                                    <div class="row"><label class="label_req control-label" style="vertical-align:top">Multiple Checkbox</label><label class="label_req requiredcls">*</label></div>
                                </div>
                                <div style="display:inline-block;" class="ctrl-checkboxgroup cntrol_comp col-md-9 span9">
                                    <span style="display:block;"><input type="checkbox" name="checkboxField" value="option1" />Option 1</span>
                                    <span style="display:block;"><input type="checkbox" name="checkboxField" value="option2" />Option 2</span>
                                    <span style="display:block;"><input type="checkbox" name="checkboxField" value="option3" />Option 3</span>
                                    <p class="required_msg"></p>
                                </div>
                                <input type="hidden" class="hiddenObligatoire" />
                                <input type="hidden" class="chk_display" value="">
                            </div>
                        </div>
                        <!-- checkboxgroup close here -->

                        <!-- selectmultiple start here Selection multiple -->
                        <div class='selectorField draggableField'>
                            <!-- <div class="selectmultiple well well-mini create_custom_template"><b></b> Custom Listbox</div> -->
                            <div class="selectmultiple create_custom_template"><b></b> Custom Listbox</div>
                            <div class='modele'>
                                <div class="col-md-3 span3">
                                    <div class="row"><label class="label_req control-label" style="vertical-align:top">Custom Listbox</label><label class="label_req requiredcls">*</label></div>
                                </div>
                                <div style="display:inline-block;" class="col-md-9 span9">
                                    <select multiple="multiple" style="width:150px" class="ctrl-selectmultiplelist cntrol_comp">
                                        <option value="option1">Option 1</option>
                                        <option value="option2">Option 2</option>
                                        <option value="option3">Option 3</option>
                                    </select>
                                    <p class="required_msg"></p>
                                </div>
                                <input type="hidden" class="hiddenObligatoire" />
                            </div>
                        </div>
                        <!-- selectmultiple close here -->

                        <!-- imagebox start here -->
                        <div class="selectorField draggableField">
                            <!-- <div class="imagebox well well-mini create_custom_template"><b></b>Image</div> -->
                            <div class="imagebox create_custom_template"><b></b>Image</div>
                            <div class="modele">
                                <div class="col-md12 span12"><img src="#" alt="Upload Image" class="fimage ctrl-image" id="blah" /></div>
                                <input type="hidden" value="" class="image_path">
                            </div>
                        </div>
                        <!-- imagebox close here width="150" height="auto" -->

                        <!-- Date start here -->
                        <div class='selectorField draggableField'>
                            <!-- <div class="displaydate well well-mini create_custom_template"><b></b> Date</div> -->
                            <div class="displaydate  create_custom_template"><b></b> Date</div>
                            <div class='modele'>
                                <div class="col-md-3 span3">
                                    <label class="control-label">Date</label><label class="label_req requiredcls">*</label>
                                </div>
                                <div class="col-md-9 span9">
                                    <span class="ctrl-date"><input class="cntrol_comp datepicker" type="text" id="" /></span>
                                </div>
                                <p class="required_msg"></p>
                            </div>
                        </div>
                        <!-- Date close here onclick="display_expiryCal(); expiry-date"-->

                        <!-- table start here -->
                        <div class='selectorField draggableField'>
                            <!-- <div class="tablebox well well-mini create_custom_template"><b></b>Table</div> -->
                            <div class="tablebox create_custom_template"><b></b>Table</div>
                            <div class="modele">
                                <div class="col-md-12 span12">
                                    <label class="row row-fluid col-md-12 span12 control-label tbl_label">Table:</label>
                                    <div class="row row-fluid col-md-12 span12 table_div">
                                        <table class="ctrl-table form_table" id="" border="1px solid #ccc"></table>
                                        <span><input type="hidden" class="table_rows" value=""></span>
                                        <span><input type="hidden" class="table_cols" value=""></span>
                                        <span><input type="hidden" class="tbl_rows" value=""></span>
                                        <span><input type="hidden" class="tbl_cols" value=""></span>
                                        <span><input type="hidden" class="addstatus" value=""></span>
                                    </div>
                                    <div class="row row-fluid col-md-12 span12">
                                        <input type="button" id="add_btn" class="btn tbl_btn" value="Add Row" onclick="add_rowToTable(this);" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- table close here -->
                        <hr />


                        <h4>Standered Listbox and Combobox</h4><br />
                        <!-- stdcombobox start here -->
                        <div class='selectorField draggableField'>
                            <!-- <div class="stdcombobox well well-mini create_custom_template"><b></b> Std. Combobox</div> -->
                            <div class="stdcombobox create_custom_template"><b></b> Std. Combobox</div>
                            <div class='modele'>
                                <div class="col-md-3 span3">
                                    <div class="row"><label class="control-label label_req"> Std. Combobox</label><label class="label_req requiredcls">*</label></div>
                                </div>
                                <div class="col-md-9 span9">
                                    <select class="ctrl-stdcombobox cntrol_comp"></select>
                                    <p class="required_msg"></p>
                                    <input type="hidden" class="hiddenObligatoire" />
                                </div>
                            </div>
                        </div>
                        <!-- stdcombobox close here -->

                        <!-- stdlistbox start here -->
                        <div class='selectorField draggableField'>
                            <!-- <div class="stdlistbox well well-mini create_custom_template"><b></b> Std. Listbox</div> -->
                            <div class="stdlistbox create_custom_template"><b></b> Std. Listbox</div>
                            <div class='modele'>
                                <div class="col-md-3 span3">
                                    <div class="row"><label class="label_req control-label" style="vertical-align:top">Std. Listbox</label><label class="label_req requiredcls">*</label></div>
                                </div>
                                <div style="display:inline-block;" class="col-md-9 span9">
                                    <select multiple="multiple" style="width:150px" class="ctrl-stdlistbox cntrol_comp"></select>
                                    <p class="required_msg"></p>
                                </div>
                                <input type="hidden" class="hiddenObligatoire" />
                            </div>
                        </div>
                        <!-- stdlistbox close here -->
                    </div>


                    <!-- 
                        Below we have the columns to drop controls
                        -- Removed the TABLE based implementations from earlier code
                        -- Grid system used for rendering columns 
                        -- Columns can be simply added by defining a div with droppedFields class onclick="val_click()"
                -->


                    <div class="col-md-9 span9 div-padding-menu"><!--form container start here -->
                        <h4>Form Fields:</h4>

                        <div style="border:1px solid #e7e7e7; padding: 10px 5px 5px; float: left; width:100%; z-index:0 !important;">

                            <!-- first row with form logo and title 120px 75px-->
                            <div class="row row-fluid" id="form-title-div">
                                <div class="col-md-10 span10" onclick="open_title_popup()">
                                    <input type="text" class="input-large col-md-12 span12 border_class" style="margin-left:10px;" placeholder="Type form title here" value="" id="form-title" />
                                    <input type="hidden" value="" class="titlelabel_font" />
                                    <input type="hidden" value="" class="titlelabel_size">
                                </div>
                                <div class="col-md-10 span10 ">
                                    <textarea class="input-large col-md-12 span12" style="width:100%;border: 1px solid #ccc !important;background-color: #FAFAFA !important;margin-left: 10px;" placeholder="Type form description here" name="form_description" id="form-description"></textarea>
                                </div>
                                <div class="col-md-2 span2" onclick="open_logoimage_popup()">
                                    <img src="img/Document Icon Frame.svg" alt="logo-image" class="logo_image" id="logo_image" width="100%" heigth="100%" />
                                </div>
                            </div>
                            <!-- Form title description -->
                            <!-- <div class="row row-fluid" id="form-description_div">
                        <textarea class="input-large col-md-12 span12" style="width:100%" placeholder="Type form description here" name="form_description" id="form-description"></textarea>
                    </div> -->
                            <div class="row row-fluid row_content" id="selected-content">
                                <div class="row row-fluid">
                                    <div class="col-md-6 span6 well droppedFields" style="background-color: #FAFAFA;border: 1px solid #E0E0E0;"></div>
                                    <div class="col-md-6 span6 well droppedFields" style="background-color: #FAFAFA;border: 1px solid #E0E0E0;"></div>
                                </div>
                                <!-- Action bar - Suited for buttons on form -->
                                <div class="row row-fluid">
                                    <div class="col-md-12 span12 well action-bar droppedFields border_class" style="min-height:80px;background-color: #FAFAFA;border: 1px solid #E0E0E0cdcdc;"></div>
                                </div>
                            </div>

                        </div>

                        <div class="row row-fluid">
                            <div class="col-md-12 span12  add_btn" style="margin-top:10px;">
                                <input type="button" class="btn_class save_btn_form tempsaveform" value="Save Form" onclick="preview();" />
                                <input type="button" class="btn_class save_btn_form tempaddtable" value="Add table" onclick="$('#dialog-form-nombre-colonne').modal('show'); $('#dialog-form-nombre-colonne').css('z-index', '1500');" />
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
            <!-- <button class="btn btn-primary" data-dismiss="modal" onclick='save_customize_changes();apply_font(); create_table();set_imageSize();'>Save Changes</button>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" onclick='delete_ctrl()'>Delete</button> -->
             <button class="save_btn_bg_cancel savebuttontemp3" data-dismiss="modal" onclick='save_customize_changes();apply_font(); create_table();set_imageSize();'>Save Changes</button>
            <button class="save_btn_bg_cancel" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button class="save_btn_bg_cancel" data-dismiss="modal" aria-hidden="true" onclick='delete_ctrl()'>Delete</button>
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
             <input type="radio" name="img_ctrl" value="small"><img src="img/Document Icon Frame.svg" alt="small image" />
             <input type="radio" name="img_ctrl" value="medium"><img src="img/Document Icon Frame.svg" alt="medium image" />
             <input type="radio" name="img_ctrl" value="large"><img src="img/Document Icon Frame.svg" alt="large image" />
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


    <!-- content for stdcombobox modal name="stdcomboselect" -->
    <script id="stdcombobox-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label" >Select List</label> <select  id="scombo" onchange="display_combooptions(this.options[this.selectedIndex].value,'combo');"></select><input type="text" name="label" value="" class="stdcomboname" id="handlebars-textbox-label" style="display:none;"/></p>
        <!--<p id="pObligatoire"><label class="control-label" for="checkbox-obligatoire-textbox">Required</label> <input type="checkbox" name="obligatoire" value="" id="checkbox-obligatoire-textbox"/></p>
        <p id="phelp"><label class="control-label" for="help-textbox">Help</label><textarea value="" name="help" id="handlebars-textbox-help" cols="60"></textarea></p>
        </p>-->
        <p id="std_seletedcombo"><label class="control-label">Options</label> <textarea name="options" rows="5" readonly></textarea></p>
        </script>


    <!-- content for stdcombobox modal name="stdcomboselect" -->
    <script id="stdlistbox-template" type="text/x-handlebars-template">
        <p id="pLibelle"><label class="control-label" for="handlebars-textbox-label" >Select List</label> <select  id="slist" onchange="display_combooptions(this.options[this.selectedIndex].value,'list');"></select><input type="text" name="label" value="" class="stdlistname" id="handlebars-textbox-label" style="display:none;"/></p>
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
        <div class="modal-header">
            <h3>Logo Image</h3>
        </div>
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
        <div class="modal-header tempPopupHead">
            <h3>Form Title</h3>
        </div>
        <div class="modal-body">
            <form id="headertitleForm" class="form-horizontal">
                <p id="pLibelle" class="row"><label class="control-label col-md-3" for="handlebars-textbox-label">Label</label> <input type="text" name="label" value="" class="col-md-9" id="handlebars-title-label" width="60%" /></p>
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
            <!-- <button class="btn btn-primary" onclick="save_titlechanges();">Save Changes</button>
            <button class="btn" onclick="cancel_formtitle()">Cancel</button> -->
            <button class="save_btn_bg_cancel savebuttontemp" onclick="save_titlechanges();">Save Changes</button>
            <button class="save_btn_bg_cancel btn-secondary" style="color: black;" onclick="cancel_formtitle()">Cancel</button>
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
                <br />
                <input type="checkbox" name="framebox" value="framebox" id="framebox"> Frame
            </form>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-success" onclick='ajouterTableau();'>Add table</a>
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        </div>
    </div>

    <span style="position:absolute; padding-right:6px; height:10px;" id="divDeleteTableau">
        <a href="#" onclick="supprimerTableau();"><img src="img/delete.png" alt="" /></a>
    </span>
    <hr />


    <!-- data to generate template form -->
    <form id="template_form" name="template_form" method="post" action="template_form.php">
        <input type="hidden" id="template_fromdata" name="template_fromdata" value="">
        <input type="hidden" value="" name="form_title" value="" class="template_name">
        <input type="hidden" value="" name="ftitle_description" class="template_desc">
    </form>
    <!-- end of template form -->

</body>

</html>
<!------ div-padding-menu  class is used to remove all padding by Mahendra---------------------------------------------------------->