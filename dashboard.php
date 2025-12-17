<?php
ob_start();
session_start();
include 'session_timeout.php';
include 'session_config.php';
$userdepartid = '';
$tenantid = '';
$tenantuserid = '';
$tenantname = '';
if (isset($_SESSION['tenantuserdata'])) {
    $userarr = $_SESSION['tenantuserdata'];
}
if (isset($_SESSION['userdepartmentid'])) {
    $userdepartid = $_SESSION['userdepartmentid'];
}
if (isset($_SESSION['usertenant'])) {
    $tenantid = $_SESSION['usertenant'];
}
if (isset($_SESSION['userid'])) {
    $tenantuserid = $_SESSION['userid'];
}
if (isset($_SESSION['userrole'])) {
    $userrole = $_SESSION['userrole'];
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
//echo $tenantspace.'dir';
$filesize = (float)fileSizeInMB($ar['size']);
$activepackspace = $g1->get_mongodb->getActivePackageSize($tenantid);
$activepackspace = (float)$activepackspace;
//echo $activepackspace;
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
    <link rel="stylesheet" href="chosen_v1.2.0/chosen.min.css" />
    <link rel="stylesheet" href="facebox-master/src/facebox.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="bootstrap-dialog/css/bootstrap-dialog.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

    <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
    <script type="text/javascript" src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
    <script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
    <script src="facebox-master/src/facebox.js" type="text/javascript"></script>
    <script src="chosen_v1.2.0/chosen.jquery.js"></script>
    <script src="facebox-master/src/facebox.js" type="text/javascript"></script>
    <script src="bootstrap-dialog/js/bootstrap-dialog.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        window.onload = function() {
            if (document.getElementById('g1')) {
                value = <?php echo $filesize ?>;
                max = <?php echo $activepackspace * 1000 ?>;
                showmeter(value, max);
            }
        };
        $(function() {
            $('.chosen-select').chosen();
        });

        $(document).bind('afterClose.facebox', function() {
            $('#facebox').remove();
        });
        $(document).bind('loading.facebox', function() {
            setTimeout('', 1000);
        });

        function dynamicURL(documentName, revisionNo, htmltemp, docid) {
            $.facebox.settings.closeImage = 'img/close_button.png';
            $.facebox.settings.loadingImage = 'img/loading.gif';
            var ajaxpostID = "view_document.php?doc=" + documentName + "&revision=" + revisionNo + "&tempname=" + htmltemp + "&documentid=" + docid; //+"'"; 
            //alert(ajaxpostID);
            jQuery.facebox({
                ajax: ajaxpostID
            });

        }

        var str = '';
        var selectopt;
        $(document).ready(function() {
            $.ajax({
                type: "POST",
                data: {
                    datatype: 'bouquet'
                },
                url: "savedoc_tagscomment.php",
                success: function(response) {
                    str = response;
                }
            });
            var directoryspace = <?php echo $tenantspace ?>;
            console.log(directoryspace);
            var tenantspace = <?php echo $activepackspace ?>;
            //   tenantspace = 999999999;
            console.log(tenantspace);
            if (parseFloat(directoryspace) >= parseFloat(tenantspace)) {
                //alert('dir'+directoryspace);
                $('.revsioncomment').attr('disabled', 'disabled');
                $('.revsiontags').attr('disabled', 'disabled');
                $('.revsionstatus').attr('disabled', 'disabled');
                $('.add_to_bouquet').attr('disabled', 'disabled');
                $('.add_to_archive').attr('disabled', 'disabled');
                $('.btn_comment').attr('disabled', 'disabled');
                $('.btn_tags').attr('disabled', 'disabled');
                $('select').attr('disabled', 'disabled');

                $('.revsioncomment').css('opacity', '0.5');
                $('.revsiontags').css('opacity', '0.5');
                $('.revsionstatus').css('opacity', '0.5');
                $('.add_to_bouquet').css('opacity', '0.5');
                $('.add_to_archive').css('opacity', '0.5');
                $('.btn_comment').css('opacity', '0.5');
                $('.btn_tags').css('opacity', '0.5');
                $('select').css('opacity', '0.5');
                var spacemsg = 'Package Size is full';
                $('.spaceerror').text(spacemsg);
            } else {
                //alert(tenantspace)
                $('.revsioncomment').removeAttr('disabled');
                $('.revsiontags').removeAttr('disabled');
                $('.revsionstatus').removeAttr('disabled');
                $('.add_to_bouquet').removeAttr('disabled');
                $('.add_to_archive').removeAttr('disabled');
                $('.btn_comment').removeAttr('disabled');
                $('.btn_tags').removeAttr('disabled');
                $('select').removeAttr('disabled');
                //$('.add_to_bouquet').removeAttr('disabled');
                $('.spaceerror').text('');
            }
        });

        function makefocusComment(currdoc) {
            $('.hide_div').hide();
            var card = $(currdoc).closest('.dmstree-card');
            card.find('.hide_div').show();
            card.find('.comment-section').show();
            card.find('.tag-section').hide();
            card.find('.document_commentbox').focus();
        }

        function makefocusTag(currtagobj) {
            $('.hide_div').hide();
            var card = $(currtagobj).closest('.dmstree-card');
            card.find('.hide_div').show();
            card.find('.tag-section').show();
            card.find('.comment-section').hide();
            card.find('.chosen-select').focus();
        }

        function addtag_tolist(tagpointer, tagval) {
            //alert(tagval);
            $(tagpointer).parent().parent().find('.tagbox').append(tagval);
            //alert($(tagpointer).parent().parent().html());
        }

        function add_comment(addcommentobj) {
            var usercomment = $(addcommentobj).parent().parent().find('.document_commentbox').val();
            if (usercomment == '') {
                alert("enter the comment");
            } else {
                var actiontype = 'comment';
                var documentname = $(addcommentobj).parent().parent().parent().parent().parent().parent().find('.documentname a').text();
                var documentrevision = $(addcommentobj).parent().parent().parent().parent().parent().parent().find('.documentrev span').text();
                var documentid = $(addcommentobj).parent().parent().parent().parent().parent().parent().find('.documentname .docid').text();
                $.ajax({
                    type: "POST",
                    data: {
                        usercomment: usercomment,
                        documentname: documentname,
                        documentrevision: documentrevision,
                        actiontype: actiontype,
                        documentid: documentid
                    },
                    url: "savedoc_tagscomment.php",
                    success: function(msg) {
                        //alert(msg);
                        $('.document_commentbox').val('');
                        //window.location.reload(true);
                        var actiontext = 'New comment on ' + documentrevision + ' revision of ' + documentname + ' document.';
                        $.ajax({
                            type: "POST",
                            data: {
                                actiontext: actiontext
                            },
                            url: "track_history.php",
                            success: function(response) {
                                window.location.reload(true);
                            }
                        });
                        //$(addcommentobj).parent().parent().parent().parent().parent().css('display','block');
                    }
                });
            }
        }

        function add_tags(addtagobj) {
            var taglistarray = new Array();
            var taglistindex = 0;
            var usertag = $(addtagobj).parent().parent().find('.chosen-container-multi').html();
            $(addtagobj).parent().parent().find('.chosen-container-multi ul li').each(function() {
                if ($(this).find('span').length > 0) {
                    taglistarray[taglistindex] = $(this).find('span').text();
                    taglistindex++;
                }
            });

            if (taglistarray.length == 0) {
                alert("enter the Tags");
            } else {
                var actiontype = 'tag';
                var documentname = $(addtagobj).parent().parent().parent().parent().parent().parent().find('.documentname a').text();
                var documentrevision = $(addtagobj).parent().parent().parent().parent().parent().parent().find('.documentrev span').text();
                var documentid = $(addtagobj).parent().parent().parent().parent().parent().parent().find('.documentname .docid').text();
                var card = $(addtagobj).closest('.dmstree-card');
                var moretags = card.find('.moretags');
                var tagHtml = '';
                // Show the newly added tags immediately for instant feedback
                taglistarray.forEach(function(tag) {
                    tagHtml += '<span class="badge badge-info" style="margin-right:5px;">' + tag + '</span>';
                });
                moretags.html(tagHtml);
                // Update the count in the link
                card.find('#add-tag1 a').text('View More Tags(' + taglistarray.length + ')');
                // Optionally clear the select
                card.find('.chosen-select').val('').trigger('chosen:updated');

                // Continue with the backend save and update as before
                $.ajax({
                    type: "POST",
                    data: {
                        taglistarray: taglistarray,
                        documentname: documentname,
                        documentrevision: documentrevision,
                        actiontype: actiontype,
                        documentid: documentid
                    },
                    url: "savedoc_tagscomment.php",
                    success: function(msg) {
                        // msg is a JSON array of tags
                        try {
                            var tags = msg;
                            if (typeof tags === 'string') tags = JSON.parse(tags);
                            // If backend returns more tags, update the list
                            if (Array.isArray(tags) && tags.length > taglistarray.length) {
                                var tagHtmlBackend = '';
                                tags.forEach(function(tag) {
                                    tagHtmlBackend += '<span class="badge badge-info" style="margin-right:5px;">' + tag + '</span>';
                                });
                                moretags.html(tagHtmlBackend);
                                card.find('#add-tag1 a').text('View More Tags(' + tags.length + ')');
                            }
                        } catch (e) {
                            // fallback: do nothing, keep the instant feedback
                        }
                    }
                });
            }
        }


        function display_hidediv(currobj) {
            var imgdivid = $(currobj).attr('class');
            if (imgdivid.match("img1")) {
                $(currobj).parent().parent().parent().find('.hide_div').css('display', 'block');
                $(currobj).attr('src', 'img/delete.png');
                $(currobj).removeClass("img1");
                $(currobj).addClass("img2");
            }
            if (imgdivid.match("img2")) {
                $(currobj).parent().parent().parent().find('.hide_div').css('display', 'none');
                $(currobj).attr('src', 'img/add-icon.png');
                $(currobj).removeClass("img2");
                $(currobj).addClass("img1");
            }
        }

        // function showDialog(currobj) {
        //     selectopt = '';
        //     var card = $(currobj).closest('.dmstree-card');
        //     var id = card.find('.doccumentid').val();
        //     var documentname = card.find('.documentname a').text();
        //     var revision = card.find('.documentrev span').text();
        //     var docdate = card.find('.dmstree-badge-date span').text();
        //     var filetype = '';
        //     var filetypeElem = card.find('.filetype');
        //     if (filetypeElem.length > 0) {
        //         filetype = filetypeElem.val();
        //     }
        //     console.log('ID:', id);
        //     console.log('Document Name:', documentname);
        //     console.log('Revision:', revision);
        //     console.log('Date:', docdate);
        //     console.log('Filetype:', filetype);
        //     var dialog = BootstrapDialog.show({
        //         type: BootstrapDialog.TYPE_DEFAULT,
        //         title: 'Add to Bouquet',
        //         message: $('<div class="row form-group"><label for="sel_bouquet" class="col-md-3  control-label">Select Bouquet Name</label><div class="col-md-6 col-sm-6"><select class="form-control template col-md-4 col-sm-4" id="sel_bouquet"></select></div></div>'),
        //         draggable: true,
        //         buttons: [{
        //                 label: 'Add to Bouquet',
        //                 cssClass: 'btn-success',
        //                 action: function(dialogRef) {
        //                     selectopt = $('#sel_bouquet option:selected').text();
        //                     if (selectopt != '') {
        //                         var docInfo = documentname + '::' + revision + '::' + docdate + '::' + filetype + '::' + id;
        //                         document.getElementById('docbunch').value = docInfo;
        //                         document.getElementById('docform').value = "1";
        //                         document.getElementById('docrevision').submit();
        //                     } else {
        //                         alert("Please Select Bouquet Name" + selectopt);
        //                     }
        //                 }
        //             },
        //             {
        //                 label: 'Close',
        //                 action: function(dialogRef) {
        //                     dialogRef.close();
        //                 }
        //             }
        //         ],
        //         onshown: function(dialogRef) {
        //             // Fetch bouquet list every time modal opens
        //             $.ajax({
        //                 type: "POST",
        //                 data: { datatype: 'bouquet' },
        //                 url: "savedoc_tagscomment.php",
        //                 success: function(response) {
        //                     $('#sel_bouquet').html(response);
        //                 }
        //             });
        //         }
        //     });
        // }
        function showDialog(currobj) {
            selectopt = '';
            var card = $(currobj).closest('.dmstree-card');
            var id = card.find('.doccumentid').val();
            var documentname = card.find('.documentname a').text();
            var revision = card.find('.documentrev span').text();
            var docdate = card.find('.dmstree-badge-date span').text();
            var filetype = '';
            var filetypeElem = card.find('.filetype');
            if (filetypeElem.length > 0) {
                filetype = filetypeElem.val();
            }
            console.log('ID:', id);
            console.log('Document Name:', documentname);
            console.log('Revision:', revision);
            console.log('Date:', docdate);
            console.log('Filetype:', filetype);
            var dialog = BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DEFAULT,
                title: 'Add to Bouquet',
                message: $(
                    '<div class="row form-group">' +
                    '<label for="sel_bouquet" class="col-md-3 control-label">Select Bouquet Name</label>' +
                    '<div class="col-md-6 col-sm-6">' +
                    '<select class="form-control template col-md-4 col-sm-4" id="sel_bouquet">' +
                    '<option value="' + documentname + '">' + documentname + '</option>' +
                    '</select>' +
                    '</div>' +
                    '</div>'
                ),
                draggable: true,
                buttons: [{
                        label: 'Add to Bouquet',
                        cssClass: 'btn-custom-add',
                        action: function(dialogRef) {
                            selectopt = $('#sel_bouquet option:selected').text();
                            if (selectopt != '') {
                                var docInfo = documentname + '::' + revision + '::' + docdate + '::' + filetype + '::' + id;
                                document.getElementById('docbunch').value = docInfo;
                                document.getElementById('docform').value = "1";
                                document.getElementById('docrevision').submit();
                            } else {
                                alert("Please Select Bouquet Name" + selectopt);
                            }
                        }
                    },
                    {
                        label: 'Close',
                        action: function(dialogRef) {
                            dialogRef.close();
                        }
                    }
                ]
            });
        }

        function savetobouquet(id, selectopt, documentname) {
            var q = confirm("Do you want to add Document to Bouquet");
            if (q) {
                $.ajax({
                    type: "POST",
                    data: {
                        id: id,
                        selectopt: selectopt,
                        datatype: 'bouquetupdate'
                    },
                    url: "savedoc_tagscomment.php",
                    success: function(response) {
                        //alert(response);
                        if (response == '0') {
                            alert("This document already present in '" + selectopt + "' bouquet");
                            $(".close").click();
                        } else {
                            var docrevision = id.split('_');
                            docrevision = docrevision[1];
                            alert("Document added to '" + selectopt + "' bouquet successfully");
                            var actiontext = docrevision + ' Revision of ' + documentname + " Document is added into '" + selectopt + "' bouquet.";
                            $.ajax({
                                type: "POST",
                                data: {
                                    actiontext: actiontext
                                },
                                url: "track_history.php",
                                success: function(response) {
                                    $(".close").click();
                                }
                            });
                        }
                    }
                });
            }
        }


        function redirecttoupload(curstatus) {
            var status = $(curstatus).val();
            var docid = $(curstatus).closest('.dmstree-card').find('.documentname .docid').text();
            var docrev = $(curstatus).closest('.dmstree-card').find('.documentrev span').text();
            var templatename = $(curstatus).closest('.dmstree-card').find('.documenttemp .tempname').text();
            //alert(templatename);
            templatename = templatename.replace(/ /g, "_");
            $('#templatename').val(templatename);
            var docname = $(curstatus).closest('.dmstree-card').find('.documentname a').text();
            $('#docname').val(docname);
            var privateflag = $(curstatus).closest('.dmstree-card').find('.privateflag').val();
            $('#documentprivate').val(privateflag);
            var docinfo = docid + '-' + docrev;
            $('#docinfo').val(docinfo);
            var temppath = $(curstatus).closest('.dmstree-card').find('.documenttemp .temppath').text();
            $('#templocation').val(temppath);
            var actualfileext = $(curstatus).closest('.dmstree-card').find('.filetype').val();
            $('#filename').val(actualfileext);
            var tenantid = '<?php echo $tenantid; ?>';
            var departmentid = '<?php echo $userdepartid; ?>';
            if (status == 'CheckedIn') {
                $.ajax({
                    type: "POST",
                    data: {
                        docid: docid,
                        docrev: docrev,
                        tenantid: tenantid,
                        departmentid: departmentid
                    },
                    url: "update_documentstate.php",
                    success: function(response) {

                    }
                });
                var actiontext = docrev + " Revision of " + docname + " Document is CheckedOut";
                $.ajax({
                    type: "POST",
                    data: {
                        actiontext: actiontext
                    },
                    url: "track_history.php",
                    success: function(response) {
                        document.getElementById('revisionForm').submit();
                    }
                });

            } else {
                alert("Document is in CheckedOut state");
            }
        }


        var lastScrollTop = 0;
        var skipdoc = 0;
        $(window).scroll(function(event) {
            // $('.dashboard_container').lazyload( function(){
            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                var totalwelldiv = 0;
                if (skipdoc == 0) {

                    $('.dashboard_container .well').each(function() {
                        totalwelldiv++;
                    });
                }
                if (totalwelldiv >= 5) {
                    skipdoc = parseInt(skipdoc) + 5;
                    $.ajax({
                        type: "POST",
                        data: {
                            skipdoc: skipdoc
                        },
                        url: "dashboard_process.php",
                        success: function(response) {
                            $(function() {
                                $('.hide_div').css('display', 'none');
                                $('.chosen-select').chosen();
                            });
                            $('.dashboard_container').append(response);
                        }
                    });
                }
            } else {

            }
            lastScrollTop = st;
            //});
        });

        function addToArchive(currobj) {
            var docid = $(currobj).parent().parent().parent().find('.documentname .docid').text();
            var docrev = $(currobj).parent().parent().parent().find('.documentrev span').text();
            var docname = $(currobj).parent().parent().parent().find('.documentname a').text();
            //alert(docname);
            var q = confirm('Do You Want to add Document to Archive');
            if (q) {
                $.ajax({
                    type: "POST",
                    data: {
                        docid: docid,
                        docrev: docrev,
                        type: 'setArchrive'
                    },
                    url: "document_checkout_process.php",
                    success: function(response) {
                        //alert(response);
                    }
                });
                var actiontext = docrev + " Revision of " + docname + " Document is Archived";
                $.ajax({
                    type: "POST",
                    data: {
                        actiontext: actiontext
                    },
                    url: "track_history.php",
                    success: function(response) {
                        window.location.reload(true);
                    }
                });

            }
        }

        function viewmoretags(currobj) {
            var card = $(currobj).closest('.dmstree-card');
            var moretags = card.find('.moretags');
            moretags.toggle(); // Show/hide the tag list
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


        body {
            overflow: hidden;
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
            border: 1px solid #ccc;
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
        }

        .btn_tags {
            background: #c5e86c;
            color: #ffffff;
            border: 1px solid #c5e86c;
        }

        #btn_tag {
            background-color: #1B5563;
            color: #ffffff;
            border: 1px solid #DDE2E4 !important;
            font-family: 'Inter', Arial, sans-serif;
            /* margin-top: 7px !important; */
        }

        .img_icon {
            /* filter: brightness(0) invert(1); */
        }

        .chosen-container-multi {
            width: 100% !important;
        }

        /* .chosen-choices{
                width: 278px !important;
            } */
        /* Modern Card Styles */
        .dmstree-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            margin-bottom: 24px;
            padding: 20px 24px;
            transition: box-shadow 0.2s;
        }

        .dmstree-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }

        .dmstree-card-icon img {
            width: 44px;
            height: 44px;
            padding: 5px;
            gap: 10px;
            /* border: 1px solid #00000024; */
            border-radius: 8px;
            /* margin-right: 12px; */
        }

        .dmstree-card-title {
            font-size: 16px;
            font-weight: 700;
            font-family: 'Space Grotesk', Arial, sans-serif;
            line-height: 140%;
            color: #1B5563 !important;
            margin-left: 5px;
        }

        .dmstree-card-info {
            margin-bottom: 16px;
        }

        .dmstree-badge {
            display: inline-block;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 0.95em;
            margin-right: 8px;
            margin-bottom: 4px;
        }

        .dmstree-badge-template {
            background: #FFFCC2;
            color: #835101;
            font-family: 'Inter', Arial, sans-serif;
        }

        .dmstree-badge-revision {
            background: #FCF0FF;
            color: #7E10E5;
            font-family: 'Inter', Arial, sans-serif;
        }

        .dmstree-badge-date {
            background: #EBF7FF;
            color: #0452C8;
            font-family: 'Inter', Arial, sans-serif;
        }

        .dmstree-card-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .dmstree-card-actions .btn {
            /* border: 1 px solid #DDE2E4; */
            border-radius: 6px;
            padding: 6px 16px;
            font-size: 0.98em;
            display: flex;
            align-items: center;
            gap: 6px;
            background: #FFFFFF;
            color: #333;
            transition: background 0.2s;
            cursor: pointer;
            font-family: 'Inter', Arial, sans-serif;
        }

        .comments_tags {
            border: 1px solid #DDE2E4 !important;
        }

        .btn-comments {
            background-color: #1B5563 !important;
            color: #fff !important;
            font-weight: 600;
        }

        .dmstree-card-actions .btn:hover {
            /* background: #e0e0e0; */
        }

        /* .btn-comments {
            background: #1976d2;
            color: #fff;
        } */

        .btn-tags {
            background: #fbc02d;
            color: #fff;
        }

        .btn-checkin {
            background: #388e3c;
            color: #fff;
        }

        .btn-bouquet {
            background: #7b1fa2;
            color: #fff;
        }

        .btn-archive {
            background: #616161;
            color: #fff;
        }

        .btn-timeline {
            background: #0288d1;
            color: #fff;
        }

        .modern-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            margin-bottom: 24px;
            padding: 10px 0 0 0;
            transition: box-shadow 0.2s;
        }

        .modern-badge-template {
            background: #ffe082;
            color: #6d4c00;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 0.95em;
            margin-right: 8px;
        }

        .modern-badge-revision {
            background: #e1bee7;
            color: #6a1b9a;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 0.95em;
            margin-right: 8px;
        }

        .modern-badge-date {
            background: #bbdefb;
            color: #0d47a1;
            border-radius: 6px;
            padding: 2px 8px;
            font-size: 0.95em;
            margin-right: 8px;
        }

        .modern-btn {
            border: none;
            border-radius: 5px;
            padding: 6px 16px;
            font-size: 0.98em;
            background: #f5f5f5;
            color: #333;
            transition: background 0.2s;
            cursor: pointer;
            margin-bottom: 6px;
        }

        .modern-btn:hover {
            background: #e0e0e0;
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

        #body-content {
            padding-bottom: 75px;
        }

        .btn-custom-add {
            background-color: #1B5563;
            color: #fff;
        }
        .comment-section, .Dash-tag{
            margin-left: -15px;
        }
    </style>
</head>

<body>
    <?php include_once 'header.php'; ?>
    <div class="row-margin" style="display:flex">
 <div style="background-color: #FFFFFF; max-width: 250px;">
            <?php include_once 'dash_menu.php' ?>
        </div>
        <div class="div-padding-left" style="width: 100%;padding:0px 20px " id="body-content">
            <!-- Usage Meter Gauge -->
            <!-- <div id="g1" style="width: 100%; height: 220px; margin-bottom: 20px;"></div> -->
            <!--This page as to be create dynamically.......-->
            <div class="row">
                <p class="spaceerror col-md-12" style="color:red"> </p>
            </div>
            <form name="dashboardform" action="view_document.php" method="post">
                <input type="hidden" name="selected_doc" id="selected_doc" value="">
                <input type="hidden" name="doc" id="doc" value="">
                <input type="hidden" name="revision" id="revision" value="">
                <input type="hidden" name="tempname" id="tempname" value="">
                <input type="hidden" name="temppath" id="temppath" value="">
                <input type="hidden" name="userdepartmentid" id="userdepartmentid" value="<?php echo $userdepartid; ?>">
                <input type="hidden" name="usertenant" id="usertenant" value="<?php echo $tenantid; ?>">
            </form>

            <form action="upload.php" name="revisionForm" id="revisionForm" method="post">
                <input type="hidden" value="" name="docinfo" id="docinfo" />
                <input type="hidden" value="" name="templocation" id="templocation" />
                <input type="hidden" value="" name="docname" id="docname" />
                <input type="hidden" value="" name="filename" id="filename">
                <input type="hidden" value="" name="templatename" id="templatename">
                <input type="hidden" value="" name="documentprivate" id="documentprivate">
            </form>

            <form id="docrevision" method="post" action="document_bouquet.php" style="display:none;">
                <input type="hidden" id="docform" name="docform" value="1">
                <input type="hidden" id="docbunch" name="docbunch" value="">
            </form>


            <div class="dashboard_container">
                <?php
                $companytags = array();
                $usertagdata = $g1->get_mongodb->companytagData($tenantid);
                //print_r($usertagdata);
                if ($usertagdata != 0) {
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
                }

                $dashboarddata = $g1->get_mongodb->filterdashboarddata($tenantid, $userdepartid);
                //var_dump($dashboarddata);
                if ($dashboarddata['result'] != null) {
                    foreach ($dashboarddata['result'] as $dockey) {
                        $templatename = '';
                        $htmltemplate = '';
                        $htmltemppath = '';
                        $isprivate = '';
                        $filetype = '';
                        $documentid        = $dockey['_id'];
                        $doclatestrevision = isset($dockey['LatestRevision']) ? $dockey['LatestRevision'] : '';
                        $documentName      = $dockey['DocumentName'];
                        if (array_key_exists('IsPrivate', $dockey)) {
                            $isprivate         = $dockey['IsPrivate'];
                        }
                        //echo "private".$isprivate;
                        $doctemplate = '';
                        if ($userrole == 'Admin') {
                            if (array_key_exists('TemplateId', $dockey)) {
                                $doctemplate  = $dockey['TemplateId'];
                                $templatename_result = $g1->get_mongodb->templatenameData($tenantid, $userdepartid, $doctemplate);
                                if ($templatename_result != 0) {
                                    foreach ($templatename_result as $tempkey) {
                                        if (array_key_exists('HtmlFileName', $tempkey)) {
                                            $htmltemplate = $tempkey['HtmlFileName'];
                                        }
                                        if (array_key_exists('HtmlFileLocation', $tempkey)) {
                                            $htmltemppath = $tempkey['HtmlFileLocation'];
                                        }
                                        if (array_key_exists('TemplateHeader', $tempkey)) {
                                            $templatename = $tempkey['TemplateHeader'];
                                        }
                                    }
                                }
                            }
                            //echo $doctemplate;
                            $commentcount = 0;
                            $commentdate = '';
                            $totalcomments = 0;
                            $totaltagcount = 0;
                            $taglist = '';
                            $documenttag = array();
                            if (array_key_exists('TagList', $dockey['DocumentInfo'])) {
                                $taglist = $dockey['DocumentInfo']['TagList'];
                                foreach ($taglist as $value) {
                                    $totaltagcount++;
                                }
                            }

                            if (array_key_exists('RevisionNo', $dockey['DocumentInfo'])) {
                                $revisionNo = $dockey['DocumentInfo']['RevisionNo'];
                            } else {
                                $revisionNo = '';
                            }

                            if (array_key_exists('FileName', $dockey['DocumentInfo'])) {
                                $filename = $dockey['DocumentInfo']['FileName'];
                                $filenametype = explode(".", $filename);
                                $filetype     = $filenametype[1];
                            } else {
                                $filetype = '';
                            }

                            if (array_key_exists('UploadDate', $dockey['DocumentInfo'])) {
                                $uploadedDate = $dockey['DocumentInfo']['UploadDate'];
                                $docDate = date('Y-M-d', $uploadedDate->sec);
                            } else {
                                $docDate = '';
                            }

                            if (array_key_exists('CurrentStatus', $dockey['DocumentInfo'])) {
                                $currstatus = $dockey['DocumentInfo']['CurrentStatus'];
                            } else {
                                $currstatus = '';
                            }

                            echo '<div class="dmstree-card">';
                            echo '<div class="dmstree-card-header">';
                            echo '<span class="dmstree-card-icon"><img src="img/Document Icon Frame.svg" style="height: 44px; width: 44px; object-fit:contain; border: 1px #e5e5e5;"></span>';
                            echo '<span class="dmstree-card-title documentname">';
                            if ($documentName != '') {
                                echo '<a onclick=\'dynamicURL("' . $documentName . '","' . $revisionNo . '","' . $htmltemplate . '","' . $documentid . '")\'>' . $documentName . '</a>';
                            }
                            echo '<span class="docid" style="display:none">' . $documentid . '</span>';
                            echo '</span>';
                            echo '</div>';
                            echo '<div class="dmstree-card-info">';
                            echo '<span class="dmstree-badge dmstree-badge-template documenttemp">Template Name: <span class="tempname">' . htmlspecialchars($documentName) . '</span><span class="tempid" style="display:none">' . $doctemplate . '</span><span class="temppath" style="display:none">' . $htmltemppath . '</span></span>';
                            echo '<span class="dmstree-badge dmstree-badge-revision documentrev">Revision Number: <span>' . htmlspecialchars($revisionNo) . '</span></span>';
                            echo '<span class="dmstree-badge dmstree-badge-date">Upload Date: <span>' . htmlspecialchars($docDate) . '</span></span>';
                            echo '<input type="hidden" class="privateflag" value="' . htmlspecialchars($isprivate) . '">';
                            if ($htmltemplate != '' && $htmltemppath != '') {
                                echo '<input type="hidden" class="doctemp" value="' . $htmltemplate . '">';
                                echo '<input type="hidden" class="doctemppath" value="' . $htmltemppath . '">';
                            }
                            echo '</div>';
                            echo '<div class="dmstree-card-actions">';
                            echo '<button class="btn btn-comments revsioncomment comments_tags" type="button" onclick="makefocusComment(this);" value="Comments"><img src="img/Icon.svg" alt="Comments" style="width:16px; height:16px; margin-right:6px;"> Comments</button>';
                            echo '<button class="btn btn-tags revsiontags comments_tags" type="button" onclick="makefocusTag(this);" value="Tags"><img src="img/Icon (6).svg" alt="Tags" style="width:16px; height:16px; margin-right:6px;"> Tags</button>';
                            if ($currstatus == 'CheckedIn') {
                                echo '<button class="btn btn-checkin revsionstatus comments_tags" type="button" onclick="redirecttoupload(this)" value="' . htmlspecialchars($currstatus) . '">';
                                echo '<img src="img/Checkout.svg" alt="" class="img_icon">Check Out</button>';
                                echo '<input type="hidden" class="doccumentid" value="' . $dockey['_id'] . '-' . $revisionNo . '-' . $isprivate . '">';
                                echo '<button class="btn btn-bouquet add_to_bouquet comments_tags" type="button" onclick="showDialog(this)" value="Add to Bouquet"><img src="img/Icon (3).svg" alt="Add to Bouquet" style="width:16px; height:16px; margin-right:6px;"> Add to Bouquet</button>';
                                echo '<button class="btn btn-archive add_to_archive comments_tags" type="button" onclick="addToArchive(this);" value="Add to Archive"><img src="img/Icon (4).svg" alt="Move to Archive" style="width:16px; height:16px; margin-right:6px;"></i> Move to Archive</button>';
                            }
                            echo '</div>';
                            echo '<div class="hide_div" style="display:none;">';
                            echo '  <div class="row comment div-margin">';
                            echo '    <div class="col-md-6 comment-section">';
                            echo '      <div class="div-padding" id="add-comment1">';
                            echo '        <a onclick="viewmorecomments(this);">View More Comments(' . $totalcomments . ')</a>';
                            echo '      </div>';
                            echo '      <div class="morecomments row col-md-12" style="max-height:230px; overflow-y:auto;">';
                            echo '      </div>';
                            echo '      <div class="form-group row add-comment">';
                            echo '        <div class="col-md-7">';
                            echo '          <input type="text" class="form-control txt_comment1 border_class document_commentbox" id="txt_comment1" placeholder="Comment" name="" autofocus/>';
                            echo '        </div>';
                            echo '        <div class="col-md-2">';
                            echo '          <input type="button" id="btn_comment" class="save_btn_bg_cancel btn-success" value="Comment" onclick="add_comment(this)">';
                            echo '        </div>';
                            echo '      </div>';
                            echo '    </div>';
                            echo '    <div class="col-md-6 tag-section" style="display:none;">';
                            echo '      <div class="row Dash-tag">';
                            echo '        <div class="div-padding" id="add-tag1">';
                            echo '          <a href="javascript:void(0);" onclick="viewmoretags(this);">View More Tags(' . $totaltagcount . ')</a>';
                            echo '        </div>';
                            echo '        <div class="moretags row col-md-12" style="max-height:230px; overflow-y:auto; display:none;">';
                            if ($totaltagcount > 0 && is_array($taglist)) {
                                foreach ($taglist as $tag) {
                                    echo '<span class="badge badge-info" style="margin-right:5px;">' . htmlspecialchars($tag) . '</span>';
                                }
                            } else {
                                echo '<span>No tags added yet.</span>';
                            }
                            echo '        </div>';
                            // Restore Add Tags select and button below

                            echo '        <div class="row" style="padding:15px 5px;">';
                            echo '          <div class="col-md-10" id="tag_diaplay" style="max-width:900px; margin:auto">';
                            echo '            <select name="colors" class="form-control chosen-select tag_selection" multiple data-placeholder="select tags">';
                            foreach ($companytags as $comptagvalue) {
                                $flagtag = 0;
                                foreach ($documenttag as $doctagvalue) {
                                    if ($comptagvalue == $doctagvalue) {
                                        $flagtag = 1;
                                    }
                                }
                                if ($flagtag == 1) {
                                    echo '<option value="' . $comptagvalue . '" selected>' . $comptagvalue . '</option>';
                                } else {
                                    echo '<option value="' . $comptagvalue . '">' . $comptagvalue . '</option>';
                                }
                            }
                            echo '            </select>';
                            echo '          </div>';
                            echo '          <div class="col-md-2">';
                            echo '            <input type="button" id="btn_tag btn_tags" class="save_btn_bg_cancel btn-success" value="Save Tags" onclick="add_tags(this)">';
                            echo '          </div>';
                            echo '        </div>';
                            echo '      </div>';
                            echo '    </div>';
                            echo '  </div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                }

                ?>
            </div>

        </div>

    </div>
    <!-- <div class="footer-fixed"><?php include_once 'footer.php' ?></div> -->

    <!--<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>-->
    <script src="jqueryui/ui/minified/jquery-ui.min.js"></script>
    <script src="js/dmstree_js/jquery.tag-editor.js"></script>
    <script type="text/javascript" src="js/dmstree_js/body_dash_page.js"></script>
</body>

</html>