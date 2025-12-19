<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
require('CodeIgniter-old/external.php');
$ci = &get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();
$userId = $_SESSION['userid'];
$tenantId = $_SESSION['usertenant'];
if (isset($_SESSION['tenantname'])) {
    $tenantname = $_SESSION['tenantname'];
    $actualtenantname = str_replace(" ", "_", $tenantname);
}

$path = 'DMSTree_clients/' . $actualtenantname . '_' . $tenantId;
$ar = getDirectorySize($path);
$tenantspace = sizeFormat($ar['size']);
$tenantspace = (float)$tenantspace;
$filesize = (float)fileSizeInMB($ar['size']);
$activepackspace = $g1->get_mongodb->getActivePackageSize($tenantid);
$activepackspace = (float)$activepackspace;

$result = $g1->get_mongodb->getStandardListName($tenantId);
$tag = $g1->get_mongodb->getTagList($tenantId);
?>
<html>

<head>
    <meta charset="utf-8">
    <title>Dash-Board</title>
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <link rel="stylesheet" href="css/stylesheet.css" />
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css" />
    <link rel="stylesheet" href="chosen_v1.2.0/chosen.min.css" />

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
    <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
    <script type="text/javascript" src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
    <script type="text/javascript" src="js/dmstree_js/jquery.textover.js"></script>
    <script src="chosen_v1.2.0/chosen.jquery.js"></script>
    <style>
        /* .row
            {
                margin-left:  0 !important;
                margin-right: 0 !important;
            } */
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

        .upload_control {
            border: none;
            box-shadow: none;
            background-color: transparent;
        }

        .add_browse_btn {
            width: 16px;
            height: 16px;
            position: absolute;
            z-index: 9999;
            top: 6;
            left: 20;
        }

        .file_delete {
            padding-top: 12px;
        }

        .fileradio {
            margin-left: -20px !important;
        }

        .add_btn {
            display: flex;
            gap: 8px;
            justify-content: end;

        }

        .well_cls {
            padding: 30px
        }

        .well_cls {
            background-color: #fff;
        }

        #uplaod_document {
            background-color: #1B5563;
            color: #fff;
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

        .footer-fixed {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            /* z-index: 999; */
            background: #fff;
            /* box-shadow: 0 -1px 6px rgba(0,0,0,0.07); */
        }

        body {
            /* height: 100vh; */
            overflow: hidden;
        }

        .control-label {
            font-weight: 500;
        }

        .uploadtemp {
            display: flex;
            justify-content: end;
        }

        .uploadtempdata {
            margin-top: 10px;
        }

        .document_tags {
            width: 315px !important;
        }

        /* Ensure datepicker calendar appears above other elements */
        .ui-datepicker {
            z-index: 1051 !important;
        }

        /* .div-padding-top {
            max-height: 80vh;
            overflow-y: auto;
            padding-bottom: 40px;
        } */
        div.div-padding {
            /* max-height: 80vh; */
            /* overflow-y: auto; */
            padding-bottom: 100px;
        }
        .form_btn .btn{
            margin-top:10px;
            margin-right: 19px;
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
        $(function() {
            $('.chosen-select').chosen();
        });
        $(document).ready(function() {
            var directoryspace = <?php echo $tenantspace ?>;
            var tenantspace = <?php echo $activepackspace ?>;
            if (parseFloat(directoryspace) >= parseFloat(tenantspace)) {
                $('select').attr('disabled', 'disabled');
                $('input').attr('disabled', 'disabled');

                $('select').css('opacity', '0.5');
                $('input').css('opacity', '0.5');
                var spacemsg = 'Package Size is full';
                $('.spaceerror').text(spacemsg);
            } else {
                $('select').removeAttr('disabled');
                $('input').removeAttr('disabled');
                $('.spaceerror').text('');
            }
        });
       
    </script>

</head>

<body>

    <!----------- Header page--------------------------------------------->
    <?php include_once 'header.php'; ?>
    <div class="row-margin" style="display:flex">
        <div  style="background-color: #FFFFFF;max-width:250px" id="body1">
            <?php include_once 'dash_menu.php' ?>
        </div>
        <div  style="height: 100vh;overflow-y: scroll;width:100%;padding:0 20px" id="body-content">
            <div class="well div-padding-top" style="margin-bottom: 18px;width: 100%;">
                <h2 class="text-muted upload_doc_cls" style="font-size: 22px; font-weight: bold; margin: 0;font-family: 'Space Grotesk', Arial, sans-serif;">Upload Template</h2>
            </div>
            <div class="well div-padding-top">
                <div class="div-padding">
                    <form id='uploadtemplate' method="post" class="form-horizontal form-action" action="" enctype="multipart/form-data">
                        <input type="hidden" name="count" value="2" id="hin" />
                        <div class="form-group row" id="tag1">
                            <label class="col-md-3 control-label" for="txt_tag">Tags</label>
                            <div class="col-md-6">
                                <select name="colors" class="form-control chosen-select document_tags" multiple data-placeholder="select tags">
                                    <?php
                                    if (isset($_SESSION['usertenant'])) {
                                        $tenantId = $_SESSION['usertenant'];
                                    } else {
                                        $tenantId = '-999';
                                    }
                                    if (isset($_SESSION['userdepartmentid'])) {
                                        $userdepartid = $_SESSION['userdepartmentid'];
                                    } else {
                                        $userdepartid = '';
                                    }
                                    foreach (
                                        $g1->get_mongodb->companytagData($tenantId) as $companytagkey
                                    ) {
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
                        </div>
                        <div class="form-group row space">
                            <label for="txt_template" class="col-md-3 control-label">Template</label>
                            <div class="col-md-6">
                                <?php
                                $templatedata['tempresult'] = $g1->get_mongodb->getTemplateslist($tenantId, $userdepartid);
                                echo '<select id="select_template" name="templatelistbox" class="form-control select_template" style="background:#FAFAFA;border-radius: 8px;width: 315px;" required onchange="display_template(this.value)">';
                                echo '<option value="" disabled selected>-Select Template-</option>';
                                if ($templatedata['tempresult'] != '0') {
                                    foreach ($templatedata['tempresult'] as $tempName) {
                                        $templateid = $tempName['_id'];
                                        $tempPath = $tempName['HtmlFileLocation'];
                                        $filename = $tempName['HtmlFileName'];
                                        echo '<option value="' . $filename . '||' . $templateid . '||' . $tempPath . '||' . $tempName['TemplateHeader'] . '">' . $tempName['TemplateHeader'] . '</option>';
                                    }
                                }
                                echo '</select>';
                                ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12" id="template">
                                <!-- Template content will be loaded here -->
                            </div>
                        </div>
                        <input type="hidden" name="tenantname" class="tenantname" value="<?php echo $tenantname; ?>">
                        <input type="hidden" name="tenantid" class="tenantid" value="<?php echo $tenantId; ?>">
                        <input type="hidden" name="departmentid" class="departmentid" value="<?php echo $userdepartid; ?>">
                        <input type="hidden" name="userid" class="userid" value="<?php echo $userid; ?>">
                        <input type="hidden" name="templateid" class="templateid" value="">
                        <input type="hidden" name="templatename" class="templatename" value="">
                    </form>
                    <div class="row">
                        <div class="col-md-12 uploadDocBtnss" style="margin-top: 16px;display: flex; justify-content: end;">
                            <button class="btn btn-success ctrl-btn btn-space" type="button" id="uplaod_document" onclick="validate_uploaddocument(this)"><i class="icon-ok-sign icon-white"></i> Save</button>
                            <input type="reset" class="btn btn-space" value="Reset" onclick="reset_upload();">
                            <input type="button" class="btn ctrl-btn btn-space" value="Cancel" onclick="reload_page();" style="color: black;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------- dash board footer------------------------------------------------>
    <!-- <div class="footer-fixed"><?php include_once 'footer.php' ?></div> -->
    <script type="text/javascript" src="js/dmstree_js/doc_temp_valid.js"></script>
    <script type="text/javascript" src="js/dmstree_js/upload_template_page.js"></script>
    <script type="text/javascript">
        function reset_upload() {
            location.reload();
        }
    </script>
</body>

</html>