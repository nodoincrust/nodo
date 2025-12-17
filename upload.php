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

$tenantid = '';
$userdepartid = "";
$tenantname = '';
$userid = '';
$userrole = '';
if (isset($_SESSION['usertenant'])) {
    $tenantid = $_SESSION['usertenant'];
}
if (isset($_SESSION['userdepartmentid'])) {
    $userdepartid = $_SESSION['userdepartmentid'];
}
if (isset($_SESSION['tenantname'])) {
    $tenantname = $_SESSION['tenantname'];
    $actualtenantnm = str_replace(" ", "_", $tenantname);
}
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
if (isset($_SESSION['userrole'])) {
    $userrole = $_SESSION['userrole'];
}

$docid = "";
$docrevision = "";
$docinfo = '';
$docName = '';
$temploc = '';
$tempnm = '';
$templatename = '';
$fileext = '';
$documentprivate = '';

if (isset($_POST['docinfo'])) {
    $docinfo = $_POST['docinfo'];
    $docinfo = explode("-", $docinfo);
    $docid = $docinfo[0];
    $docrevision = $docinfo[1];
}
if (isset($_POST['documentprivate'])) {
    $documentprivate = $_POST['documentprivate'];
}


if (isset($_POST['docname'])) {
    $docName = $_POST['docname'];
}

if (isset($_POST['filename'])) {
    $fileext = '.' . $_POST['filename'];
}

if (isset($_POST['templocation'])) {
    $temploc = $_POST['templocation'];
}
if (isset($_POST['templatename'])) {
    $tempnm = $_POST['templatename'];
    $templatename = $tempnm . '.html';
}
if ($templatename != '' && $temploc != '') {
    $temploc = $temploc . '/' . $templatename;
}
//echo $tenantid.'  '.$userdepartid.' '.$tenantname.' '.$docid.' '.$docrevision.' '.$docName.' '.$temploc;

$path = 'DMSTree_clients/' . $actualtenantnm . '_' . $tenantid;
$ar = getDirectorySize($path);
$tenantspace = sizeFormat($ar['size']);
// var_dump($tenantspace);
$tenantspace = (float)$tenantspace;
$filesize = (float)fileSizeInMB($ar['size']);
// var_dump($filesize);
$activepackspace = $g1->get_mongodb->getActivePackageSize($tenantid);
$activepackspace = (float)$activepackspace;
//  var_dump($activepackspace);
//  die();

$companytags = array();
$usertagdata = $g1->get_mongodb->companytagData($tenantid);
foreach ($usertagdata as $companytagkey) {
    if (array_key_exists('DepartmentId', $companytagkey)) {
        if ($companytagkey['DepartmentId'] == $userdepartid) {
            if (array_key_exists('TagList', $companytagkey)) {
                foreach ($companytagkey['TagList'] as $cmptagval) {
                    $companytags[] = $cmptagval['Tag'];
                }
            }
        }
    } else {
        if (array_key_exists('TagList', $companytagkey)) {
            foreach ($companytagkey['TagList'] as $cmptagval) {
                $companytags[] = $cmptagval['Tag'];
            }
        }
    }
}
//var_dump($companytags);
?>
<html>

<head>
    <meta charset="utf-8">
    <title>Dash-Board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="discription" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="dist/css/bootstrap.css" />
    <link rel="stylesheet" href="css/stylesheet.css" />
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css" />
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

    <style>
        /* .row
            {
                margin-left:  0 !important;
                margin-right: 0 !important;
            } */
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

        .tag_border {
            border: 1px solid #c5e86c !important;
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

        .imgtags {
            border: 2px solid yellow;
            text-align: center;
        }

        .imgtags span {
            display: inline-block;
            vertical-align: middle;

            line-height: normal;
        }

        #locationcontainer {
            padding-left: 0 !important;
            padding-right: 0 !important;
            /* margin-left: 15px;
                        margin-right: 15px;*/
        }

        .tags {
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
            background-color: #FFFFFF;
            border-width: 1px;
            border-style: solid;
            border-color: #D2D2D2;
            /*#000;*/
            border-radius: 5px;
            -o-border-radius: 5px;
            -webkit-border-radius: 5px;
        }

        .uploadsave {
            background-color: #1B5563;
            color: #ffffff;
        }

        .upload-main-cont {
            /* display: grid;
            justify-content: center; */
        }

        .upload_temp {
            /* width: 80%; */
        }

        .div-padding-top {
            /* width: 80%; */
        }

        #chk_physical_loc {
            margin-left: -18px !important;
        }

        .control-label {
            font-weight: 500;
        }

        .space {
            margin-top: 0px;
        }

        .chosen-choices {
            /* height: 33px !important; */
            width: 310px !important;
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

        .uploadDocBtnss {
            display: flex;
            justify-content: end;
        }

        /* Ensure datetimepicker calendar appears above other elements */
        .bootstrap-datetimepicker-widget {
            z-index: 1051 !important;
        }

        /* If using jQuery UI datepicker as well */
        .ui-datepicker {
            z-index: 1051 !important;
        }

        div.uploadDocView {
            /* max-height: 80vh; */
            /* overflow-y: auto; */
            padding-bottom: 100px;
        }
        .form_title h2 {
            font-size: 22px;
        }
        /* Force form rows to align horizontally */
.form-group.row,
.row {
    display: flex;
    align-items: center;
}

/* Fix label alignment */
.control-label,
.form-group label {
    text-align: right;
    padding-right: 10px;
    white-space: nowrap;
}

/* Standard label width (important) */
.col-md-3.control-label,
.form-group .col-md-3 {
    flex: 0 0 25%;
    max-width: 25%;
}

/* Input container alignment */
.form-group .col-md-6,
.form-group .col-md-9,
.form-group .col-md-12 {
    flex: 1;
}

/* Radio & checkbox alignment */
.radio label {
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Prevent label jumping */
label {
    margin-bottom: 0;
}

/* Fix select + input vertical alignment */
.form-control,
.input-group {
    width: 100%;
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
            $('#div_pic').hide();
            var documentid = "<?php echo $docid; ?>";
            var tenantid = "<?php echo $tenantid; ?>";
            var departmentid = "<?php echo $userdepartid; ?>";
            var templatelocation = "<?php echo $temploc; ?>";
            var docname = "<?php echo $docName; ?>";
            var docrevison = "<?php echo $docrevision; ?>"
            var isprivate = "<?php echo $documentprivate; ?>"
            if (docname != '' && templatelocation != '') {
                $("#template").load(templatelocation);
                $("#template").css("border", "1px solid gainsboro");
                setTimeout(function() {
                    getDocumentValues(documentid, docname, docrevison, tenantid, departmentid)
                }, 1000);
            } else if (docname != '' && templatelocation == '') {
                //$("#template").load('');
                setTimeout(function() {
                    getDocumentValues(documentid, docname, docrevison, tenantid, departmentid)
                }, 1000);
            }
            if (isprivate == 1) {
                $('#makeprivate').attr('checked', 'checked');
            }
            var directoryspace = <?php echo $tenantspace ?>;
            var tenantspace = <?php echo $activepackspace ?>;
            // Always allow uploads by setting a very large tenant space
            // tenantspace = 999999999;
            if (parseFloat(directoryspace) >= parseFloat(tenantspace)) {
                $('input').attr('disabled', 'disabled');
                $('select').attr('disabled', 'disabled');
                $("#datetimepicker").attr('disabled', 'disabled');
                var spacemsg = 'Package Size is full';
                $('.spaceerror').text(spacemsg);
            } else {
                $('.input').removeAttr('disabled');
                $('select').removeAttr('disabled');
                $("#datetimepicker").datepicker("option", "disabled", false);
                $('.spaceerror').text('');
            }
        });

        function getDocumentValues(documentid, docname, docrevison, tenantid, departmentid) {
            $.ajax({
                type: "POST",
                async: false,
                data: {
                    documentid: documentid,
                    docname: docname,
                    docrevison: docrevison,
                    tenantid: tenantid,
                    departmentid: departmentid
                },
                //dataType: "json",
                url: "getdocumentmetadata.php",
                success: function(response) {
                    //alert("response"+response);
                    var data = $.parseJSON(response);
                    if ("TagList" in data) {
                        var compnytags = <?php echo json_encode($companytags); ?>;
                        var taglistArr = data.TagList;
                        var taglistLen = data.TagList.length;
                        var cmptagsLen = compnytags.length;
                        var taglistIndex = 0;
                        var comptagIndex = 0;
                        //alert(taglistArr);
                        for (comptagIndex = 0; comptagIndex < cmptagsLen; comptagIndex++) {
                            var flagtag = 0;
                            for (taglistIndex = 0; taglistIndex < taglistLen; taglistIndex++) {
                                var taglistItem = taglistArr[taglistIndex];
                                if (compnytags[comptagIndex] == taglistItem) {
                                    flagtag = 1;
                                }
                            }
                            if (flagtag == 1) {
                                var tagselectopt = '<option value="' + compnytags[comptagIndex] + '" selected>' + compnytags[comptagIndex] + '</option>';
                                $('.document_tags').append(tagselectopt);
                            } else {
                                var tagselectopt = '<option value="' + compnytags[comptagIndex] + '">' + compnytags[comptagIndex] + '</option>';
                                $('.document_tags').append(tagselectopt);
                            }

                        }
                    }
                    if ("ExpiryDate" in data) {
                        var t = new Date(1970, 0, 1);
                        t.setSeconds(data.ExpiryDate['sec']);
                        var dt = t;
                        var expirydate = moment(dt).format('DD/MM/YYYY');
                        $('.docexpirydate').val(expirydate);
                        $('#datetimepicker').datetimepicker({
                            defaultDate: expirydate
                        });
                        //alert(data.ExpiryDate);
                    }
                    if ('Date' in data) {
                        var tempdate = data.Date;
                        var tempdatelen = data.Date.length;
                        for (var tempdateindex = 0; tempdateindex < tempdatelen; tempdateindex++) {
                            var datename = tempdate[tempdateindex].Name;
                            var datetime = tempdate[tempdateindex].Value['sec'];
                            var dat = new Date(1970, 0, 1);
                            dat.setSeconds(datetime);
                            var dtt = dat;
                            var cntrldate = moment(dtt).format('DD/MM/YYYY');
                            $('#doc_template').find('input[name="' + datename + '"]').val(cntrldate);
                            $('#doc_template').find('input[name="' + datename + '"]').attr('readonly', true);

                        }
                    }
                    if ("textboxctrl" in data) {
                        var textboxArr = data.textboxctrl;
                        var texboxLen = data.textboxctrl.length;
                        for (var textboxIndex = 0; textboxIndex < texboxLen; textboxIndex++) {
                            var textboxName = textboxArr[textboxIndex].Name;
                            var textboxValue = textboxArr[textboxIndex].Value;
                            $('#doc_template').find('input[name="' + textboxName + '"]').val(textboxValue);
                            //alert($('#doc_template').find('input[name="'+textboxName+'"]').attr('name'));
                            //alert(textboxName+" "+textboxValue);
                        }
                    }
                    if ("textareactrl" in data) {
                        var textareaArr = data.textareactrl;
                        var textareaLen = data.textareactrl.length;
                        for (var textareaIndex = 0; textareaIndex < textareaLen; textareaIndex++) {
                            var textareaName = textareaArr[textareaIndex].Name;
                            var textareaValue = textareaArr[textareaIndex].Value;
                            $('#doc_template').find('textarea[name="' + textareaName + '"]').val(textareaValue);
                        }
                    }
                    if ("custlistctrl" in data) {
                        var custlistArr = data.custlistctrl;
                        var custlistLen = data.custlistctrl.length;
                        for (var custlistIndex = 0; custlistIndex < custlistLen; custlistIndex++) {
                            var custlistName = custlistArr[custlistIndex].Name;
                            var custlistValue = custlistArr[custlistIndex].SelectedValue;
                            $('#doc_template').find('select[name="' + custlistName + '"]').val(custlistValue);

                        }
                    }
                    if ("radioctrl" in data) {
                        var radioArr = data.radioctrl;
                        var radioLen = data.radioctrl.length;
                        for (var radioIndex = 0; radioIndex < radioLen; radioIndex++) {
                            var radioName = radioArr[radioIndex].Name;
                            var radioValue = radioArr[radioIndex].SelectedOption;
                            $('#doc_template').find('input[name="' + radioName + '"][value="' + radioValue + '"]').prop('checked', true);
                        }
                    }
                    if ("checkboxctrl" in data) {
                        var checkboxArr = data.checkboxctrl;
                        var checkboxLen = data.checkboxctrl.length;
                        for (var checkboxIndex = 0; checkboxIndex < checkboxLen; checkboxIndex++) {
                            var checkboxName = checkboxArr[checkboxIndex].Name;
                            var checkboxValue = checkboxArr[checkboxIndex].SelectedOption;
                            $('#doc_template').find('input[name="' + checkboxName + '"][value="' + checkboxValue + '"]').prop('checked', true);
                        }
                    }
                    if ("tablectrl" in data) {
                        var tableArr = data.tablectrl;
                        var tableLen = data.tablectrl.length;
                        for (var tableIndex = 0; tableIndex < tableLen; tableIndex++) {
                            var tableId = tableArr[tableIndex].TableId;
                            var tblIdArr = tableArr[tableIndex].Values;
                            var tblarrlen = tblIdArr.length;
                            for (var subtableIndex = 0; subtableIndex < tblarrlen; subtableIndex++) {
                                var cols = tblIdArr[subtableIndex].Column;
                                var row = tblIdArr[subtableIndex].Row;
                                var tbltdval = tblIdArr[subtableIndex].Value;
                                var tdinputLen = $('#' + tableId).find('tr:eq(' + row + ') td:eq(' + cols + ') .tbl_td').length;
                                if (tdinputLen > 0) {
                                    $('#' + tableId).find('tr:eq(' + row + ') td:eq(' + cols + ') .tbl_td').val(tbltdval);
                                }
                            }
                        }
                    }

                    if ("PhysicalLocation" in data) {
                        var locationinfo = data.PhysicalLocation;
                        var locationimage = locationinfo['LocationPath'];
                        if (locationimage != '') {
                            //$('#locationcontainer').css("background-image","url('"+locationimage+"')");
                            //$('#locationcontainer').css('background-size','400px 400px');
                            //$('#locationcontainer').css('background-repeat','no-repeat');
                            $('.physicallocationimg').attr("src", locationimage);
                        }

                        var locationtags = locationinfo['LocationTags'];
                        var taginfolen = locationtags.length;
                        var tagcount = 1;
                        var tagdata = '';
                        var withoutsessiontags = '';
                        for (var imagetag = 0; imagetag < taginfolen; imagetag++) {
                            var divdata = '';
                            var divtags = '';
                            var tagname = locationtags[imagetag].TagName;
                            var tagposition = locationtags[imagetag].TagPosition;
                            var positions = tagposition.split(',');
                            divtags += '<a class="physicaltags"><label class="tags">' + tagname + '</label></a>';
                            divdata += '<div class="imgtags ' + tagname + '" style="width:' + positions[0] + '; height:' + positions[1] + '; top:' + positions[2] + '; left:' + positions[3] + '; opacity:1; position:absolute; "><span>' + tagname + '<span></div>';
                            $('#locationcontainer').append(divdata);
                            $('.locationtags').append(divtags);
                            if (tagcount == 1) {
                                withoutsessiontags += tagname + '::' + positions[0] + ',' + positions[1] + ',' + positions[2] + ',' + positions[3];
                            } else {
                                withoutsessiontags += '||' + tagname + '::' + positions[0] + ',' + positions[1] + ',' + positions[2] + ',' + positions[3];
                            }
                            var widthpos = positions[0].split('px');
                            var heightpos = positions[1].split('px');
                            var toppos = positions[2].split('px');
                            var leftpos = positions[3].split('px');
                            if (tagcount == 1) {
                                tagdata += "{'id':" + tagcount + ",'label':'" + tagname + "','width':" + widthpos[0] + ",'height':" + heightpos[0] + ",'top':" + toppos[0] + ",'left':" + leftpos[0] + "}";
                            } else {
                                tagdata += "||{'id':" + tagcount + ",'label':'" + tagname + "','width':" + widthpos[0] + ",'height':" + heightpos[0] + ",'top':" + toppos[0] + ",'left':" + leftpos[0] + "}";
                            }
                            tagcount++;
                        }
                        $('.revimgtags').val(tagdata);
                        $('.revwithoutsess').val(withoutsessiontags);
                    } else {
                        $('#locationcontainer').css('display', 'none');
                    }
                    $(".document_tags").trigger("chosen:updated");
                }
            });
        }

        function display_imagetagging(cuurobj) {
            var documentid = '';
            var taginfo = $('.revimgtags').val();
            var locationpath = $(cuurobj).attr('src');
            var locationpathlen = locationpath.length;
            var lastindex = locationpath.lastIndexOf('/');
            var loc = locationpath.substring(0, lastindex + 1);
            var img_name = locationpath.substring(lastindex + 1, locationpathlen);

            if (loc != '') {

                $('#target').attr('src', loc + img_name);
                var docid = $('.tenantname').val();
                $("#photoloc").val(loc + img_name); //+img_name
                if (taginfo != '') {
                    var params = {
                        'photoloc': loc,
                        'photoname': img_name,
                        'tenantname': docid,
                        'defaulttaglist': taginfo
                    };
                } else {
                    var params = {
                        'photoloc': loc,
                        'photoname': img_name,
                        'tenantname': docid
                    };
                }
                OpenWindowWithPost("photoTag.php", "top=100, left=100,width=550,height=500,resizable=yes,scrollbars=yes", "photoform", params);
            } else {
                var defaultval = 1;
                $.ajax({
                    type: "POST",
                    data: {
                        defaultval: defaultval
                    },
                    url: "setImagetagsession.php",
                    success: function(msg) {
                        //alert(msg);
                    }
                });
            }

        }

        function OpenWindowWithPost(url, windowoption, name, params) {
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", url);
            form.setAttribute("target", name);
            for (var i in params) {
                if (params.hasOwnProperty(i)) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = i;
                    input.value = params[i];
                    form.appendChild(input);
                }
            }

            document.body.appendChild(form);
            window.open("", name, windowoption);
            form.submit();
            document.body.removeChild(form);
        }


        function phototaging() {
            var locinfo = $('#gallary option:selected').val();
            locinfo = locinfo.split('::');
            var loc = locinfo[0];
            var taginfo = locinfo[1];
            var img_name = $('#gallary option:selected').text();
            if (loc != '') {
                $('#target').attr('src', loc + img_name);
                var docid = $('.tenantname').val();
                $("#photoloc").val(loc + img_name);
                if (taginfo != '') {
                    var params = {
                        'photoloc': loc,
                        'photoname': img_name,
                        'tenantname': docid,
                        'defaulttaglist': taginfo
                    };
                } else {
                    var params = {
                        'photoloc': loc,
                        'photoname': img_name,
                        'tenantname': docid
                    };
                }
                OpenWindowWithPost("photoTag.php", "top=100, left=100,width=550,height=500,resizable=yes,scrollbars=yes", "photoform", params);
            } else {
                var defaultval = 1;
                $.ajax({
                    type: "POST",
                    data: {
                        defaultval: defaultval
                    },
                    url: "setImagetagsession.php",
                    success: function(msg) {
                        //alert(msg);
                    }
                });
            }
        }

        function canel_operation() {
            var q = confirm('Do You Really Want To Cancel this operation');
            if (q) {
                window.location.reload(true);
            }
        }
    </script>
</head>

<body>


    <?php include_once 'header.php'; ?>
    <div class="row-margin" style="display:flex">
        <!-- <div class="col-md-3 col-sm-3 div-padding-top" id="body1"> -->
        <div class style="background-color: #FFFFFF;max-width:250px">
            <?php include_once 'dash_menu.php' ?>
        </div>
        <div class="div-padding-left upload-main-cont" id="body-content" style="width:100%; padding:0 20px">
            <!-- <div class="row">
                <p class="spaceerror col-md-12 " style="color:red"> </p>
            </div>  -->
            <div class="test" style="width: 100%;">
                <div class="upload_temp div-padding-top">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 form_title " style="margin-left:12px">
                            <h2 class="text-muted upload_doc_cls"><b>Upload Document</b></h2>
                        </div>
                    </div>
                </div>
                <div class="well div-padding-top uploadDocView" style="background-color: #ffffff;">
                    <!-- <div class="row">
                     <div class="col-md-12 col-sm-12 form_title "><h2 class="text-muted upload_doc_cls"><b>Upload Document</b></h2></div>
                </div> -->

                    <div class="div-padding">
                        <?php if ($docName != '') {
                            $orgfilename = str_replace(" ", "_", $docName);
                            if ($docrevision != '') {
                                $actualfile = $orgfilename . '_' . $docrevision . $fileext;
                            } else {
                                $actualfile = $orgfilename . $fileext;
                            }
                            //echo $actualfilehref="download.php?filenm=<?php echo $actualfile; &revision=<?php echo $docrevision;";
                        ?>
                            <div class="form-group row">
                                <label class="col-md-12">File Name : <b><a href="download.php?filenm=<?php if ($docName != '') {
                                                                                                            echo $actualfile;
                                                                                                        } ?>"><?php echo $docName; ?></a></b></label>
                            </div>
                        <?php } ?>
                        <form id="uploadDocumentForm" name="uploadDocumentForm" method="post" class="form-horizontal  form-action" action="uploaddocument.php" enctype="multipart/form-data">
                            <?php if ($docName == '') { ?>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" class="fileradio" name="optionsRadiosPackage" id="rd_single_upload" value="single_upload" onchange="refresh_filediv('Single')" checked style="margin-left: -20px !important;">
                                                Single Upload
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" class="fileradio" name="optionsRadiosPackage" id="rd_multiple_upload" value="mulitiple_upload" onchange="refresh_filediv('Multiple')" style="margin-left: -20px !important;">
                                                Multiple Upload
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            <?php } ?>
                            <?php if ($userrole == 'Admin') { ?>
                                <div class="form-group row" id="single_add">
                                    <div class="col-md-3"><label class="" for="txt_tag">Browse Files</label></div>
                                    
                                    <div class="input-group col-md-9 col-md" id="browse_file_group">
                                        <div class="row" id="file_record1">
                                            <span class="col-md-10"><input type="file" name="sfile1" id="doc_file1" class="upload_control " /></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="radio row mark_checkbox">
                                        <label>
                                            <input for="text" class="control-label" type="checkbox" name="" id="makeprivate" value="" onchange="">
                                            Mark As Private
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group " id="mulitiple_add" style="display:none">
                                <div class=" col-md-9 col-md-offset-3">
                                    <span><img src="img/add-icon.png" alt="add-icon" onclick="add_browse_control()" class="add_browse_btn"></span><input type="button" onclick="add_browse_control()" value="    Add Document">

                                </div>
                            </div>

                            <input type="hidden" name="count" value="2" id="hin" />
                            <div class="control-group form-group row" id="tag1">
                                <label class="col-md-3 control-label" for="txt_tag">Tags</label><!--control-label-->
                                <div class="col-md-6"> <!--controls-->
                                    <select name="colors" class="form-control chosen-select document_tags" multiple data-placeholder="select tags">
                                        <?php
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
                            </div>

                            <div class="row space">
                                <label for="txt_template" class="col-md-3 col-sm-3 control-label">Template</label>
                                <div class="col-md-6 col-sm-6">
                                    <?php
                                    $templatedata['tempresult'] = $g1->get_mongodb->getTemplateslist($tenantid, $userdepartid);
                                    echo '<select name="templatelistbox" class="form-control select_template" style="background:#FAFAFA;border-radius: 8px;width: 315px;" required onchange="display_template(this.value)">';
                                    echo '<option value="" disabled selected>-Select Template-</option>';
                                    if ($templatedata['tempresult'] != '0') {
                                        foreach ($templatedata['tempresult'] as $tempName) {
                                            $templateid = $tempName['_id'];
                                            $tempPath = $tempName['HtmlFileLocation'];
                                            $filename = $tempName['HtmlFileName'];
                                            echo '<option value="' . $filename . '||' . $templateid . '||' . $tempPath . '">' . $tempName['TemplateHeader'] . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 col-sm-12">
                                    <div id="template" class="template-wrapper"></div>
                                </div>
                                <input type="hidden" name="templateid" class="templateid" value="">
                                <input type="hidden" name="documentname" id="documentname" class="documentname" value="<?php echo $docName; ?>">
                                <input type="hidden" name="documentid" id="documentid" class="documentid" value="<?php if ($docid != '') {
                                                                                                                        echo $docid;
                                                                                                                    } ?>">
                            </div>


                            <div class="row">
                                <div class="">
                                    <label class="col-md-3 col-sm-3 control-label mar-left ">
                                        Expiry Date
                                    </label>

                                    <div class='col-md-6 col-sm-6' id='date9'>
                                        <div class='input-group date' id='datetimepicker' data-date-format="DD/MM/YYYY">
                                            <input type='text' class="form-control date1 docexpirydate" name="date" readonly />
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
                                            <input type="checkbox" name="optionsRadios" class="control-label" id="chk_physical_loc" value="physical_loc">
                                            Physical Location
                                        </label>
                                    </div>
                                    <div class="col-md-12 col-sm-12" id="div_pic">
                                        <div class="row div-border">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-md-offset-2 col-sm-offset-2">
                                                        <?php
                                                        $photo = $g1->get_mongodb->getPhotoList($tenantid);
                                                        ?>
                                                        <select class="form-control selectpicker" id="gallary" onchange="phototaging();" style="border:1px solid #c5e86c !important">
                                                            <option value=""></option>
                                                            <?php
                                                            if ($photo != 0) {
                                                                foreach ($photo[0]['Photo'] as $key) {
                                                                    if (!$key['AuditData']['DeleteFlag']) {
                                                                        $data1 = "";
                                                                        if (array_key_exists('ImageTags', $key)) {
                                                                            $taglist = $key['ImageTags'];
                                                                            $tagid = 1;
                                                                            $tagcount = 0;
                                                                            foreach ($taglist as $tagvalue) {
                                                                                if ($tagvalue['AuditData']['DeleteFlag'] == false) {
                                                                                    $tagstyle = explode(',', $tagvalue['TagPosition']);
                                                                                    $widthpos = explode("px", $tagstyle[0]);
                                                                                    $heightpos = explode("px", $tagstyle[1]);
                                                                                    $toppos = explode("px", $tagstyle[2]);
                                                                                    $leftpos = explode("px", $tagstyle[3]);
                                                                                    if ($tagcount == 0) {
                                                                                        $data1 .= "{'id':" . $tagid . ", 'label':'" . $tagvalue['TagName'] . "', 'width':" . $widthpos[0] . ", 'height':" . $heightpos[0] . ", 'top':" . $toppos[0] . ", 'left':" . $leftpos[0] . "}";
                                                                                    } else {
                                                                                        $data1 .= "||{'id':" . $tagid . ", 'label':'" . $tagvalue['TagName'] . "', 'width':" . $widthpos[0] . ", 'height':" . $heightpos[0] . ", 'top':" . $toppos[0] . ", 'left':" . $leftpos[0] . "}";
                                                                                    }
                                                                                    $tagid++;
                                                                                    $tagcount++;
                                                                                }
                                                                            }
                                                                        }
                                                            ?>
                                                                        <option value="<?php echo $key['FileLocation'] . '::' . $data1; ?>"><?php echo $key['FileName']; ?></option>
                                                            <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php if ($docrevision != '') { ?>
                                                    <div class="row">
                                                        <div class="col-md-10 col-md-offset-2" id="locationcontainer" style="margin-top: 10px">
                                                            <img class=" physicallocationimg" src="" width="400px" height="400px" onclick="display_imagetagging(this);">
                                                            <input type="hidden" class="revimgtags" value="">
                                                            <input type="hidden" class="revwithoutsess" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-10 col-md-offset-2" style="margin-top: 7px">
                                                            <div class="row">
                                                                <label class="col-md-2">Image Tags</label>
                                                                <div class="col-md-10 locationtags"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 uploadDocBtnss">
                                <input type="button" class="btn btn-success ctrl-btn btn-space uploadsave" value="Save" onclick="validate_uploaddocument(this);">
                                <input type="reset" class="btn btn-space" value="Reset" onclick="reset_upload();">
                                <input type="button" class="btn ctrl-btn btn-space " value="Cancel" onclick="canel_operation();">

                            </div>
                        </div>
                        <input type="hidden" name="tenantname" class="tenantname" value="<?php echo $tenantname; ?>">
                        <input type="hidden" name="tenantid" class="tenantid" value="<?php echo $tenantid; ?>">
                        <input type="hidden" name="departmentid" class="departmentid" value="<?php echo $userdepartid; ?>">
                        <?php
                        //$docrevisiondata = $g1->get_mongodb->documentrevisionData($tenantid,$userdepartid);
                        ?>
                        <input type="hidden" name="revision" class="revision" value="<?php echo $docrevision; ?>">
                        <input type="hidden" name="userid" class="userid" vlue="<?php echo $userid; ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!--------- dash board footer------------------------------------------------>
    <!-- <div class="footer-fixed"><?php include_once 'footer.php' ?></div> -->
    <script type="text/javascript" src="js/dmstree_js/doc_temp_valid.js"></script>
    <script type="text/javascript" src="js/dmstree_js/uplaod_page.js"></script>
    <script type="text/javascript">
        function reset_upload() {
            location.reload();
        }
    </script>
</body>

</html>