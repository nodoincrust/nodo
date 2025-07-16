<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
require('../CodeIgniter-old/external.php');
$ci = &get_instance();
$ci->load->library("cimongo/cimongo");
$ci->load->model('get_mongodb');
$g1 = new Get_mongodb();
date_default_timezone_set('Asia/Calcutta');
$tenantid = '';
$departmentid = '';
$tenantname = '';
if (isset($_SESSION['usertenant'])) {
    $tenantid = $_SESSION['usertenant'];
}
if (isset($_SESSION['userdepartmentid'])) {
    $departmentid = $_SESSION['userdepartmentid'];
}
if (isset($_SESSION['tenantname'])) {
    $tenantname = $_SESSION['tenantname'];
    $actualtenantnm = str_replace(" ", "_", $tenantname);
}
$bouquetdocuments = '';
$bouquet_docname = '';
$bouquet_desc = '';
if (isset($_POST['docform'])) {
    if ($_POST['docform'] == '1') {
        if (isset($_POST['docbunch'])) {
            $bouquet_documents = $_POST['docbunch'];

            if (!(isset($_SESSION['new_documents']))) {
                $_SESSION['new_documents'] = $bouquet_documents;
            } else {
                $documentbunch = $_SESSION['new_documents'];
                $totdocuments = $documentbunch . '||' . $bouquet_documents;
                $_SESSION['new_documents'] = $totdocuments;
            }
            if (isset($_SESSION['bouquetnm'])) {
                $bouquet_docname = $_SESSION['bouquetnm'];
            }
            if (isset($_SESSION['bouquetdesc'])) {
                $bouquet_desc =  $_SESSION['bouquetdesc'];
            }
        }
    }
}

$path = 'DMSTree_clients/' . $actualtenantnm . '_' . $tenantid;
$ar = getDirectorySize($path);
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

    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <link rel="stylesheet" href="css/stylesheet.css" />
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css" />
    <link rel="stylesheet" href="css/jquery.tag-editor.css">
    <link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen" type="text/css" />

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
                var spacemsg = 'Package Size is full';
                $('.spaceerror').text(spacemsg);
            } else {
                $('.input').removeAttr('disabled');
                $('select').removeAttr('disabled');
                $('textarea').removeAttr('disabled');
                $('.spaceerror').text('');
            }
        });

        function dynamicURL(documentName, revisionNo, htmltemp, docid) {
            $.facebox.settings.closeImage = 'img/close_button.png';
            $.facebox.settings.loadingImage = 'img/loading.gif';
            var ajaxpostID = "view_document.php?doc=" + documentName + "&revision=" + revisionNo + "&tempname=" + htmltemp + "&documentid=" + docid;
            jQuery.facebox({
                ajax: ajaxpostID
            });

        }

        $(window).unload(function() {
            reset_seesion();
        });

        function redirect_tosearchPage() {
            var bouquetname = $('#txt_bouquet_name').val();
            var bouquetdesc = $('.bouquet_desp').val();
            $.ajax({
                type: "POST",
                data: {
                    bouquetname: bouquetname,
                    bouquetdesc: bouquetdesc
                },
                url: "setbouquet_data.php",
                success: function(response) {}
            });
            location.replace("search.php")
        }

        function save_bouquet() {
            var bouquetname = $('#txt_bouquet_name').val();
            if (bouquetname == '') {
                alert("Empty Bouquet name");
            } else {
                var docidindex = 0;
                var docrevindex = 0;
                var docidarr = new Array();
                var docrevarr = new Array();
                var bouquetdesc = $('.bouquet_desp').val();
                var docidval = '';
                var docrevval = '';
                var tenantid = <?php echo $tenantid; ?>;
                var departid = '<?php if ($departmentid != '') {
                                    echo $departmentid;
                                } ?>';
                $('.bouquet_document_container .well').each(function() {
                    docidval = $(this).children().find('.documentname span').text();
                    docrevval = $(this).children().find('.docrevision span').text();
                    if (docidval != '' && docrevval != '') {
                        docidarr[docidindex] = docidval;
                        docrevarr[docrevindex] = docrevval;
                        docidindex++;
                        docrevindex++;
                    }

                });
                if (docidarr.length > 0 && docrevarr.length > 0) {
                    $.ajax({
                        type: "POST",
                        data: {
                            bouquetname: bouquetname,
                            tenantid: tenantid,
                            departid: departid,
                            bouquetdesc: bouquetdesc,
                            docidarr: docidarr,
                            docrevarr: docrevarr

                        },
                        url: "savebouquetdata.php",
                        success: function(response) {
                            var actiontext = bouquetname + ' document bouquet created.';
                            $.ajax({
                                type: "POST",
                                data: {
                                    actiontext: actiontext
                                },
                                url: "track_history.php",
                                success: function(response) {
                                    alert("Bouquet created sucessfully");
                                    reset_seesion();
                                    window.location.reload();
                                }
                            });

                        }
                    });
                } else {
                    alert("Please select the bouquet documents");
                }
            }
        }

        function reset_seesion() {
            var bouquetname = 1;
            $.ajax({
                type: "GET",
                data: {
                    bouquetname: bouquetname
                },
                url: "setsession_variable.php",
                success: function(response) {
                    location.reload();
                }
            });
        }

        function clear_page() {
            reset_seesion();
            window.location.reload();
        }
    </script>
    <style>
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

        .add_btn {
            display: flex;
            gap: 8px;
            justify-content: end;
            margin-top: 12px;
            margin-left: 15px;

        }

        .well_cls {
            padding: 24px;
            margin-top: 15px;
            width: 70%;
        }

        .bouquet-desc {
            display: grid;
            font-weight: 500;
        }

        .txt_comment1 {
            width: 80%;
            height: 40px;
            background-color: #F6F8F9;
        }

        .bouquet-desc-2 {
            width: 80%;
            height: 40px;
            background-color: #F6F8F9;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .bouquet-add-doc {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .main-bouquet {
            display: flex;
            justify-content: center;
        }

        .bouquet-save {
            background-color: #1B5563;
            color: #ffffff;
        }

        .bouquet-addDoc {
            background-color: #1B5563;
            color: #ffffff;
            /* margin-right: 15px; */
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            pointer-events: none;
            z-index: 2;
        }

        .input-wrapper input {
            padding-left: 40px;
            /* adjust based on icon size */
        }

        .control-label {
            font-weight: 500;
        }

        .bouquets-list {
            font-size: 16px;
            font-weight: 500;
        }

        /* .upload_doc_cls {
            border-bottom: 1px solid #1B5563;
        } */
        .documentname {
            font-size: 16px;
            font-weight: 700;
            font-family: 'Space Grotesk', Arial, sans-serif;
            line-height: 140%;
            color: #1B5563 !important;
            margin-left: 5px;
        }

        .tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            margin-right: 8px;
        }

        .tag-revision {
            background: #f3d1fa;
            color: #6c3483;
        }

        .tag-date {
            background: #d1eaff;
            color: #21618c;
        }

        .docrevision {
            background: #FFFCC2;
            color: #835101;
            border-radius: 6px;
            padding: 5px 1px 5px 1px;
            font-family: 'Inter', Arial, sans-serif;
        }

        .docdate {
            background: #EBF7FF;
            color: #0452C8;
            border-radius: 6px;
            padding: 5px 1px 5px 1px;
            font-family: 'Inter', Arial, sans-serif;
        }

        body {
            overflow: hidden;
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

        /* #bouquetForm , .bouquet-add-doc{
            border-top: 1px solid #B8BFBC;
        } */
    </style>
</head>

<body>

    <!----------- Header page--------------------------------------------->
    <?php include_once 'header.php'; ?>

    <div class="row row-margin">
        <div class="col-md-3 col-sm-3" style="background-color: #FFFFFF;">
            <!--------- dash board side menu------------------------------------------------>
            <?php include_once 'dash_menu.php' ?>
        </div>

        <div class="col-md-9 col-sm-9 main-bouquet div-padding-left">
            <!-- <div class="col-md-9 col-sm-9 div-padding-left"> -->
            <!-- <div class="row">
                <p class="spaceerror col-md-12" style="color:red"> </p>
            </div> -->
            <!-- <div class="well div-padding-top div-padding-well">
                <div class="row">
                    <div class="col-md-12 col-sm-12 form_title">
                        <h3 class="hr-margin text-muted upload_doc_cls"><b>Create Document Bouquet</b></h3>
                    </div>
                </div>
            </div> -->
            <!-- <div class="well div-padding-top div-padding-well">  -->
            <div class="well div-padding-well well_cls">
                <!-- <div class="row">
		<div class="col-md-12 col-sm-12 form_title"><h3 class="hr-margin text-muted upload_doc_cls"><b>Create Document Bouquet</b></h3></div>
            </div> -->
                <div class="row">
                    <div class=" form_title">
                        <h3 class="hr-margin text-muted upload_doc_cls"><b>Create Document Bouquet</b></h3>
                        <hr>
                    </div>
                    <div class="">
                        <form name="bouquetnameForm" id="bouquetnameForm" method="post" action="search.php">
                            <input type="hidden" id="bouquetname" name="bouquetname" value="" style="border:1px solid #c5e86c !important;">
                        </form>
                        <form name="bouquetForm" id="bouquetForm" action="" method="post">
                            <div class="form-group row add-comment">
                                <label for="txt_bouquet_name" class="control-label">Bouquet Name</label>
                                <div class="input-wrapper">
                                    <img src="img/folder-open.svg" alt="Bouquet Icon" class="input-icon">
                                    <input type="text" class="form-control txt_comment1" id="txt_bouquet_name" placeholder="Enter Bouquet Name" name="" value="<?php if (isset($bouquet_docname)) echo $bouquet_docname; ?>">
                                </div>
                            </div>
                            <div class="form-group row add-comment"></div>
                        </form>
                        <div class="row">
                            <label class="bouquet-desc">Bouquet Description</label>
                            <div class="input-wrapper">
                                <img src="img/sms.svg" alt="Desc Icon" class="input-icon">
                                <input type="text" class="bouquet-desc-2" placeholder="Master Document Description" value=""><?php if (isset($bouquet_desc)) echo $bouquet_desc; ?>
                            </div>
                        </div>
                        <div class="bouquet-add-doc">
                            <label class="bouquets-list">Documents In This Bouquet</label>
                            <hr>
                            <input type="button" class="save_btn_bg_cancel bouquet-addDoc" value="Add Document" onclick="redirect_tosearchPage();" />
                        </div>

                        <?php
                        if (isset($_SESSION['new_documents'])) {
                            $docbunch = $_SESSION['new_documents'];;
                            $documents = explode("||", $docbunch);
                            $documentlength = count($documents);
                            $bouquetdocument = '';
                            if ($documentlength > 0) {
                                $docnamearr = array();
                                $i = 1;
                                $bouquetdocument .= '<div class="bouquet_document_container">';
                                foreach ($documents as $docvalue) {

                                    $documentvalues = explode("::", $docvalue);
                                    $docinfo = $documentvalues[0] . '::' . $documentvalues[1];
                                    if (!(in_array($docinfo, $docnamearr))) {
                                        $docnamearr[] = $docinfo;
                                        if ($documentvalues[0] != '') {
                                            $filename = $documentvalues[0];
                                        }
                                        if ($documentvalues[1] != '') {
                                            $docrevision = $documentvalues[1];
                                        }
                                        if ($documentvalues[2] != '') {
                                            $docdate = $documentvalues[2];
                                        }

                                        if ($documentvalues[3]) {
                                            $fileext = $documentvalues[3];
                                            if ($fileext == 'xlsx') {
                                                $fileext = 'xls';
                                            } else if ($fileext == 'docx') {
                                                $fileext = 'doc';
                                            } else {
                                                $fileext = 'jpg';
                                            }
                                        }

                                        $docid = $documentvalues[4];
                                        $templatfilename = '';

                                        $bouquetdocument .= '<div class="well div-padding-top div-padding-well" id="bouquetsubdoc_' . $i . '">';

                                        // Start Row with 3 Columns
                                        $bouquetdocument .= '<div class="row div-margin" style="padding: 5px;">';

                                        // Left icon column
                                        $bouquetdocument .= '<div class="col-md-1">';
                                        $bouquetdocument .= '<img src="img/Document Icon Frame.svg" style="height: 35px; width: 35px; object-fit:contain; border: 1px #e5e5e5;">';
                                        $bouquetdocument .= '</div>';

                                        // Middle content column
                                        $bouquetdocument .= '<div class="col-md-10" style="margin-top: 5px;">';
                                        $bouquetdocument .= '<p class="documentname"><a onclick="dynamicURL(\'' . $filename . '\',\'' . $docrevision . '\',\'' . $templatfilename . '\',\'' . $docid . '\');" rel="facebox">' . $filename . '</a><span class="documentid" style="display:none">' . $docid . '</span></p>';
                                        $bouquetdocument .= '</div>';

                                        // Right delete icon column
                                        $bouquetdocument .= '<div class="col-md-1" style="margin-top: 5px;">';
                                        $bouquetdocument .= '<img src="img/Delete Button.svg" style="height:26px; width:26px;" onclick="removeDiv(this)"/>';
                                        $bouquetdocument .= '</div>';

                                        // End .row
                                        $bouquetdocument .= '</div>';

                                        // Place doc-meta outside the row
                                        $bouquetdocument .= '<div class="doc-meta" style="display: flex; gap: 20px;margin-left: 20px;margin-top: 10px;">';
                                        $bouquetdocument .= '<p class="docrevision">Document latest revision: <span>' . $docrevision . '</span></p>';
                                        $bouquetdocument .= '<p class="docdate">Document Date: <span>' . $docdate . '</span></p>';
                                        $bouquetdocument .= '</div>';

                                        // End outer container
                                        $bouquetdocument .= '</div>';
                                    }
                                }
                            }
                            echo $bouquetdocument;
                            echo '</div>';
                        }
                        ?>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 add_btn">
                                <!-- <input type="button" value="Save" class="btn btn-success save_btn_bg" onclick="save_bouquet();"/>
			<input type="button" value="Cancel" class="btn ctrl-btn save_btn_bg_cancel" onclick="clear_page();"/> -->
                                <input type="button" value="Save" class="save_btn_bg_cancel bouquet-save" onclick="save_bouquet();" />
                                <input type="button" value="Cancel" class="save_btn_bg_cancel" onclick="clear_page();" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
    <div class="footer-fixed"><?php include_once 'footer.php' ?></div>
    <script src="jqueryui/ui/minified/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/dmstree_js/document_bouquet_page.js"></script>
</body>

</html>