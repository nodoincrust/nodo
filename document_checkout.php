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

date_default_timezone_set('Asia/Calcutta');

$userdepartid = '';

$userId = '';

$tenantId = '';

$tenantname = '';

if (isset($_SESSION['userdepartmentid'])) {

    $userdepartid = $_SESSION['userdepartmentid'];
}

if (isset($_SESSION['userid'])) {

    $userId = $_SESSION['userid'];
}

if (isset($_SESSION['usertenant'])) {

    $tenantId = $_SESSION['usertenant'];
}

if (isset($_SESSION['tenantname'])) {

    $tenantname = $_SESSION['tenantname'];

    $tenantname = str_replace(" ", "_", $tenantname);
}





$path = 'DMSTree_clients/' . $tenantname . '_' . $tenantid;

$ar = getDirectorySize($path);

$tenantspace = sizeFormat($ar['size']);

$tenantspace = (float)$tenantspace;

$filesize = (float)fileSizeInMB($ar['size']);

$activepackspace = $g1->get_mongodb->getActivePackageSize($tenantid);

$activepackspace = (float)$activepackspace;



$result = $g1->get_mongodb->getDocumentMetadataDetails($tenantId);

$taglist = $g1->get_mongodb->getTagList($tenantId);

$userdepartid = '';

$taglistdata = $g1->get_mongodb->tagData($tenantId, $userdepartid);

$tag = array();

$name = '';







foreach ($taglist[0]['TagList'] as $key) {

    $tag[] = $key['Tag'];
}



?>

<html>

<head>

    <meta charset="utf-8">

    <title>Dash-Board</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="">

    <meta name="author" content="">



    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" href="dist/css/bootstrap.css" />

    <link rel="stylesheet" href="css/stylesheet.css" />

    <link rel="stylesheet" href="css/bootstrap-select.css">

    <link rel="stylesheet" href="chosen_v1.2.0/chosen.min.css" />

    <link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen" type="text/css" />



    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>

    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>

    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

    <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>

    <script src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>

    <script src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>

    <script type="text/javascript" src="js/dmstree_js/bootstrap-select.js"></script>

    <script src="chosen_v1.2.0/chosen.jquery.js"></script>





    <script type="text/javascript">
        window.onload = function() {

            value = <?php echo $filesize ?>;

            max = <?php echo $activepackspace * 1000 ?>;

            if (document.getElementById('g1')) {

                showmeter(value, max);

            }

        };

        $(function()

            {

                $('.chosen-select').chosen();

            });

        $(document).ready(function() {

            var directoryspace = <?php echo $tenantspace ?>;

            var tenantspace = <?php echo $activepackspace ?>;

            if (parseFloat(directoryspace) >= parseFloat(tenantspace))

            {

                $('input').attr('disabled', 'disabled');

                $('select').attr('disabled', 'disabled');

                $('button').attr('disabled', 'disabled');



                $('input').css('opacity', '0.5');

                $('select').css('opacity', '0.5');

                $('button').css('opacity', '0.5');

                var spacemsg = 'Package Size is full';

                $('.spaceerror').text(spacemsg);

            } else

            {

                $('input').removeAttr('disabled');

                $('select').removeAttr('disabled');

                $('button').removeAttr('disabled');

                $('.spaceerror').text('');

            }

        });

        function makefocusComment(currdoc)

        {

            $(currdoc).parent().parent().parent().parent().find('.hide_div').css('display', 'block');

            $(currdoc).parent().parent().parent().parent().parent().find('.document_commentbox').focus();

            $(currdoc).parent().parent().parent().parent().find('#img1').attr('src', 'img/delete.png');

            $(currdoc).parent().parent().parent().parent().find('#img1').removeClass("img1");

            $(currdoc).parent().parent().parent().parent().find('#img1').addClass("img2");

        }

        function makefocusTag(currtagobj)

        {

            $(currtagobj).parent().parent().parent().parent().find('.hide_div').css('display', 'block');

            $(currtagobj).parent().parent().parent().parent().parent().find('.chosen-container').focus();

            $(currtagobj).parent().parent().parent().parent().find('#img1').attr('src', 'img/delete.png');

            $(currtagobj).parent().parent().parent().parent().find('#img1').removeClass("img1");

            $(currtagobj).parent().parent().parent().parent().find('#img1').addClass("img2");

            $(currtagobj).parent().parent().parent().parent().find('.hide_div').find('.chosen-container').attr('class', 'chosen-container chosen-container-multi chosen-with-drop chosen-container-active');

        }

        function addtag_tolist(tagpointer, tagval)

        {

            alert(tagval);

            $(tagpointer).parent().parent().find('.tagbox').append(tagval);

            alert($(tagpointer).parent().parent().html());

        }



        function add_comment(addcommentobj)

        {

            var usercomment = $(addcommentobj).parent().parent().find('.document_commentbox').val();

            if (usercomment == '')

            {

                alert("enter the comment");

            } else

            {

                var documentname = $(addcommentobj).parent().parent().parent().parent().parent().parent().find('.documentname a').text();

                var documentrevision = $(addcommentobj).parent().parent().parent().parent().parent().parent().find('.documentrev span').text();

                $.ajax({

                    type: "POST",

                    data: {

                        usercomment: usercomment,

                        documentname: documentname,

                        documentrevision: documentrevision,

                        actiontype: 'comment'

                    },

                    url: "savedoc_tagscomment.php",

                    success: function(msg) {

                        alert(msg);

                        alert(msg.match(0));



                    }

                });

            }

        }

        function display_hidediv(currobj)

        {

            var imgdivid = $(currobj).attr('class');

            if (imgdivid.match("img1"))

            {

                $(currobj).parent().parent().parent().find('.hide_div').css('display', 'block');

                $(currobj).attr('src', 'img/delete.png');

                $(currobj).removeClass("img1");

                $(currobj).addClass("img2");

            }

            if (imgdivid.match("img2"))

            {

                $(currobj).parent().parent().parent().find('.hide_div').css('display', 'none');

                $(currobj).attr('src', 'img/add-icon.png');

                $(currobj).removeClass("img2");

                $(currobj).addClass("img1");

            }



        }

        $(document).bind('afterClose.facebox', function() {
            $('#facebox').remove();
        });

        $(document).bind('loading.facebox', function() {
            setTimeout('', 1000);
        });
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

        .docsubsec_title {

            text-decoration: none;

        }

        .add-comment {

            border-top: 1px solid #B8BFBC;

            padding: 9px 0px;

        }

        .tagbox {

            height: 30%;

            width: 100%;

        }

        .tag_selectbox {

            margin: 2% 0;

        }

        .searchtag {

            height: 25px !important;

        }

        #chosenForm .chosen-choices {

            /* border: 1px solid #ccc; */

            border: 1px solid #a6d661;

            border-radius: 4px;

            min-height: 34px;

            padding: 6px 12px;

        }

        #chosenForm .form-control-feedback {

            /* To make the feedback icon visible */

            z-index: 100;

        }

        .chosen-container .chosen-choices {

            width: 100%;

            /* height: 10% !important; */

            overflow: auto;

            /* border: 1px solid #a6d661; */

        }

        .chosen-container {

            width: 100% !important;

        }

        .border_class {

            /* border: 1px solid #a6d661; */

        }

        .documentname {
            border-radius: 6px;
            padding: 5px 1px 5px 1px;

            font-family: 'Space Grotesk', Arial, sans-serif;
        }

        .doc-template {
            border-radius: 6px;
            padding: 5px 1px 5px 1px;
            /* font-family: 'Space Grotesk', Arial, sans-serif; */
        }

        .doc-date {
            border-radius: 6px;
            padding: 5px 1px 5px 1px;
            /* font-family: 'Space Grotesk', Arial, sans-serif; */
        }

        .doccheckin-buttons {
            display: flex;
            gap: 8px;
        }

        .comments_tags1 {
            background-color: #1B5563 !important;
            color: #fff !important;
            font-weight: 600;
            border-radius: 6px;
            padding: 6px 16px;
            font-size: 0.98em;
            display: flex;
            align-items: center;
            gap: 6px;
            background: #FFFFFF;
            color: #333;
            cursor: pointer;
            border: 1px solid #ccc;
            font-family: 'Inter', Arial, sans-serif;
        }

        .comments_tags2 {

            border-radius: 6px;
            padding: 6px 16px;
            font-size: 0.98em;
            display: flex;
            align-items: center;
            gap: 6px;
            color: #333;
            cursor: pointer;
            border: 1px solid #ccc;
            font-family: 'Inter', Arial, sans-serif;
        }

        .comments_tags3 {

            border-radius: 6px;
            padding: 6px 16px;
            font-size: 0.98em;
            display: flex;
            align-items: center;
            gap: 6px;
            color: #333;
            border: 1px solid #ccc;
            cursor: pointer;
            font-family: 'Inter', Arial, sans-serif;
        }

        .img_icon {
            height: 16px;
            width: 16px;
        }

        body {
            overflow: hidden;
        }

        #body-content1 {
            padding-bottom: 85px;
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

        .save-tag-doccheckout {
            background-color: #1B5563;
            color: #fff;
        }
    </style>

    <script src="facebox-master/src/facebox.js" type="text/javascript"></script>



</head>

<body>

    <?php include_once 'header.php'; ?>

    <div class="row-margin" style="display:flex">

        <div class style="background-color: #FFFFFF; max-width 250px;" id="body1">

            <!-- <div class="col-md-3 col-sm-3 div-padding-top" id="body1"> -->

            <?php include_once 'dash_menu.php' ?>

        </div>

        <div class="div-padding-left" id="body-content1" style="width:100%;padding:0 20px ;overflow: auto;
height: calc(100vh - 57px);">

            <!-- <div class="row">

                    <p class="spaceerror col-md-12" style="color:red"> </p>

                </div> -->

            <div class="checkout_doc div-padding-top">

                <!-- <div class="well div-padding-top"> -->

                <div class="row">

                    <div class="col-md-12 col-sm-12 form_title ">
                        <h2 class="text-muted hr-margin upload_doc_cls"><b>Checkout Document</b></h2>
                    </div>

                </div>

                <form action="upload.php" name="revisionForm" id="revisionForm" method="post">

                    <input type="hidden" value="" name="docinfo" id="docinfo">

                    <input type="hidden" value="" name="templocation" id="templocation">

                    <input type="hidden" value="" name="docname" id="docname">

                    <input type="hidden" value="" name="filename" id="filename">

                    <input type="hidden" value="" name="templatename" id="templatename">

                    <input type="hidden" value="" name="documentprivate" id="documentprivate">

                </form>

            </div>

            <?php

            foreach ($result as $key) {

                $commentcount = 0;

                $totalcomments = 0;

                $tagcount = 0;

                $totaltagcount = 0;

                $commentdate = '';

                $templatename = '';

                $htmltemplate = '';

                $htmltemppath = '';

                $documentName = $key['DocumentName'];

                $isprivate = $key['IsPrivate'];

                if (array_key_exists('TemplateId', $key)) {

                    $tempid = $key['TemplateId'];

                    $tempInfo = $g1->get_mongodb->templatenameData_new($tempid);

                    $templatename = $tempInfo[0]['TemplateHeader'];

                    $htmltemplate = $tempInfo[0]['HtmlFileName'];

                    $htmltemppath = $tempInfo[0]['HtmlFileLocation'];
                }

                foreach ($key['DocumentInfo'] as $doc) {

                    if (($doc['UserId'] == $userId) && ($doc['CurrentStatus'] == 'CheckedOut') && (!$doc['RevisionBlock'])) {

                        $documenttag = array();

                        if (array_key_exists('RevisionNo', $doc)) {

                            $revisionNo = $doc['RevisionNo'];
                        } else {

                            $revisionNo = '';
                        }

                        if (array_key_exists('FileName', $doc)) {

                            $filename = $doc['FileName'];

                            $filenametype = explode(".", $filename);

                            $filetype     = $filenametype[1];

                            //                                if($filetype == 'xlsx'){$filetype = "xls";}

                            //                                if($filetype == 'docx'){$filetype = "doc";}

                        } else {

                            $filename = '';

                            //$filetype = 'jpg';

                        }

                        if (array_key_exists('UploadDate', $doc)) {

                            $uploadedDate = $doc['UploadDate'];

                            $docDate = date('Y-M-d', $uploadedDate->sec);
                        } else {

                            $docDate = '';
                        }

                        if (array_key_exists('CurrentStatus', $doc)) {

                            $currstatus = $doc['CurrentStatus'];
                        } else {

                            $currstatus = '';
                        }

            ?>

                        <div class="well div-padding-top">

                            <div class="row">

                                <div class="div-margin" id="<?php echo $key['_id'] . '-' . $doc['RevisionNo']; ?>">

                                    <div class="">
                                        <div class="file-and-name" style="display: flex; align-items: center; gap: 15px;">
                                            <!-- File Icon -->
                                            <div class="fileextension">
                                                <img src="img/Document Icon Frame.svg" style="height: 44px; width: 44px; object-fit: contain;">
                                            </div>

                                            <!-- Document Name -->
                                            <?php
                                            if ($documentName != '') {
                                                echo '<p class="documentname" style="color:#1B5563; font-size:17px; margin: 0;font-weight: 700;">
                    <a onclick=\'dynamicURL("' . $documentName . '","' . $revisionNo . '","' . $htmltemplate . '","' . $key['_id'] . '")\'>' . $documentName . '</a>
                  </p>';
                                            }
                                            ?>
                                        </div>

                                        <?php
                                        // Document details in a flex row
                                        echo '<div class="doc-details" style="display: flex; gap: 20px; margin-top: 10px;">';

                                        echo '<p class="documentrev" style="color:#835101; font-size:14px; background: #FFFCC2; padding: 5px;border-radius: 6px">
            Document latest revision:<span>' . $revisionNo . '</span>
          </p>';

                                        if ($templatename != '') {
                                            echo '<p class="doc-template" style="color:#7E10E5; font-size:14px; background: #FCF0FF; padding: 5px;">
                Document Template:<span class="tempname"> ' . $templatename . '</span>
              </p>';
                                        }

                                        if ($docDate != '') {
                                            echo '<p class="doc-date" style="color:#0452C8; font-size:14px; background: #EBF7FF; padding: 5px;">
                Date:<span> ' . $docDate . '</span>
              </p>';
                                        }

                                        echo '</div>'; // Close doc-details

                                        if ($htmltemplate != '' && $htmltemppath != '') {
                                            echo '<p>
                <input type="hidden" class="doctemp" value="' . $htmltemplate . '">
                <input type="hidden" class="doctemppath" value="' . $htmltemppath . '">
              </p>';
                                        }
                                        ?>
                                    </div>



                                    <div class="doccheckin-buttons"><!--checkin-->

                                        <!-- <p><button type="button" class="comments_tags"  onclick="makefocusComment(this);" value="Comments"><span class="glyphicon glyphicon-comment"> </span> Comments</button></p>

                                            <p><button type="button" class="comments_tags"  onclick="makefocusTag(this);" value="Tags"><span class="glyphicon glyphicon-tag"> </span> Tags</button></p> -->

                                        <p><button type="button" class="comments_tags1" onclick="makefocusComment(this);" value="Comments"> <img src="img/Icon.svg" alt="" class="img_icon">Comments</button></p>

                                        <p><button type="button" class="comments_tags2" onclick="makefocusTag(this);" value="Tags"> <img src="img/Icon (6).svg" alt="" class="img_icon"> Tags</button></p>

                                        <p><button type="button" class="comments_tags3" onclick="makerevision(this);"><img src="img/Icon (8).svg" alt="" class="img_icon"> Check In <!--'.$currstatus.'onclick="makerevision(this);"--></button></p>

                                    </div>

                                </div>

                                <!-- <div class="row">

                                        <div class="col-md-1 col-md-offset-11" >

                                            <img src="img/add-icon.png" id="img1" class="img1 " style="width:20px;height:20px;" onclick="display_hidediv(this)">

                                        </div>

                                    </div> -->

                                <div class="hide_div">

                                    <div class="row comment div-margin">

                                        <div class="col-md-6">

                                            <div class="div-padding" id="add-comment1">

                                                <a onclick="viewmorecomments(this);">View More Comments(<?php if (array_key_exists('Comments', $doc)) {
                                                                                                            echo sizeof($doc['Comments']);
                                                                                                        } else echo 0; ?>) </a>

                                            </div>

                                            <div class="morecomments row col-md-12" style="max-height:230px; overflow-y :auto;">



                                                <?php

                                                if (array_key_exists('Comments', $doc)) {

                                                    //asort($doc['Comments']);

                                                    $doc['Comments'] = array_reverse($doc['Comments']);

                                                    $count = 0;

                                                    foreach ($doc['Comments'] as $comments) {

                                                        if ($count < 5) {

                                                            $id = $comments['UserId'];

                                                            $userInfo = $g1->get_mongodb->getUserInfo($id);

                                                            $name = $userInfo[0]['Name'];

                                                ?>

                                                            <div class="row">

                                                                <div class="more-comment div-padding">

                                                                    <a><i><?php echo $name; ?>:</i></a> <?php echo $comments['CommentText']; ?>

                                                                    <div class="date colour"><?php echo date(' d-M-Y H:s', $comments['CommentDate']->sec) ?></div>

                                                                </div>

                                                            </div>

                                                <?php

                                                            $count++;
                                                        } else {
                                                            break;
                                                        }
                                                    }
                                                }

                                                ?> <!--                                                              </div>-->

                                            </div>

                                            <div class="form-group row add-comment">

                                                <div class="col-md-7 ">

                                                    <input type="text" class="form-control txt_comment1 border_class" id="txt_comment1" placeholder="Comment" name="" autofocus />

                                                </div>

                                                <div class="col-md-2">

                                                    <!-- <input type="button" id="btn_comment" class="btn ctrl-btn btn_comment" value="Comment"> -->

                                                    <input type="button" id="btn_comment" class="save_btn_bg_cancel" value="Comment">

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="row col-md-12">

                                                <div class="div-padding" id="add-tag1">

                                                    <a>View More Tags(<?php if (array_key_exists('TagList', $doc)) {
                                                                            echo sizeof($doc['TagList']);
                                                                        } else {
                                                                            echo 0;
                                                                        } ?>) </a>

                                                </div>

                                                <div class="row" style="padding:15px 5px;">

                                                    <div class="col-md-10" id="tag_diaplay" style=" max-width:900px ;margin:auto">

                                                        <select name="colors" id="" class="form-control chosen-select tag_selection" multiple data-placeholder="select tags">

                                                            <?php

                                                            $companytags = '';

                                                            foreach ($doc['TagList'] as $cmptagval) {

                                                                $companytags[] = $cmptagval;
                                                            }

                                                            $documenttag = '';

                                                            foreach ($taglistdata as $depttagvalue) {

                                                                foreach ($depttagvalue['TagList'] as $tagvalue) {

                                                                    $documenttag[] = $tagvalue['Tag'];
                                                                }
                                                            }

                                                            foreach ($documenttag as $doctagvalue) {

                                                                $flagtag = 0;

                                                                foreach ($companytags as $comptagvalue) {



                                                                    if ($comptagvalue == $doctagvalue) {
                                                                        $flagtag = 1;
                                                                    }
                                                                }

                                                                if ($flagtag == 1) {

                                                                    echo '<option value="' . $comptagvalue . '" selected>' . $doctagvalue . '</option>';
                                                                } else {

                                                                    echo '<option value="' . $comptagvalue . '">' . $doctagvalue . '</option>';
                                                                }
                                                            }

                                                            ?>

                                                        </select>

                                                    </div>

                                                    <div class="col-md-2">

                                                        <!-- <input type="button" id="btn_tag btn_tags" class="btn ctrl-btn btn_tags" value="Save Tags" onclick="add_tags(this)"> -->

                                                        <input type="button" id="btn_tag btn_tags" class="save_btn_bg_cancel save-tag-doccheckout" value="Save Tags" onclick="add_tags(this)">

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>



                        </div>





            <?php

                    }
                }
            }

            ?>

            <input type="hidden" value="<?php echo $name; ?>" id="user_name">

        </div>

    </div>

    <!--------- dash board footer------------------------------------------------>

    
    <script type="text/javascript" src="js/dmstree_js/document_checkout_page.js"></script>



</body>

</html>