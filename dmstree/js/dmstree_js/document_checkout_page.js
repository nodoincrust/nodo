$(document).ready(function(){
	//$('.hide_div').css('display','none');
});
function change_status(tag)
{
    var temp_id = $(tag).parent().parent().attr('id');
    temp = temp_id.split('-');
    temp_id = temp[0];
    temp_version = temp[1];
	$.ajax({
			type: "POST",
			data: {
					temp_id:temp_id,
					temp_version:temp_version
				},
				url: "document_checkout_process.php",
				success: function(response){
						alert(response); 
						location.reload();
					}
		});
}

function viewmorecomments(currobj)
{
    id = $(currobj).parent().parent().parent().parent().parent().children().attr('id');
    var documentname  = $(currobj).parent().parent().parent().parent().parent().find('.documentname a').text();
    $.ajax({
                type: "POST",
                data: {
                           template_id:id,  /* template_id contain DocumentId and Revision eg:   54507fe19fb5d3547f6526aa-1 */
                           documentname:documentname,  /* documentname conatin DocumentName eg:Demo */
                           type:'getCommments'
                        },
                url: "document_checkout_process.php",
                success: function(response){
                    commenthtml='';
                    var data =$.parseJSON(response);
                    var commentstextarray = data.Text;
                    var commentsnamearray = data.User;
                    var commentsdatearray = data.Date;
                    var len = data.Text.length;
                   
                    for(var index = 0; index < len;index++){
                            commenthtml+='<div class="row"><div class="more-comment div-padding" >';
                            commenthtml+='<a><i>'+commentsnamearray[index]+':</i></a>'+ commentstextarray[index];										 
                            commenthtml+='<div class="date colour">'+commentsdatearray[index]+'</div></div></div>';
                        }
                    $(currobj).parent().parent().children(':eq(1)').find('.row').remove();
                    $(currobj).parent().parent().find('.morecomments').html(commenthtml);
                    }
                });
}


/*
 * Summary : To add comment on click of comment button
 */
$('.btn_comment').click(function() {
    currobj = this;
    comments = $(currobj).parent().parent().children().children().val();//to fetch the value of input box 
    if(comments!='')
    {
        id = $(currobj).parent().parent().parent().parent().parent().parent().children().attr('id');
        var documentname  = $(currobj).parent().parent().parent().parent().parent().parent().find('.documentname a').text();
        
        //alert(documentname);
        var q = confirm("Do You Want To Add Comment");
        if(q)
            {
            
            $.ajax({
                    type: "POST",
                    data: {
                               template_id:id,   /* template_id contain DocumentId and Revision eg:   54507fe19fb5d3547f6526aa-1 */
                               comments:comments,
                               documentname:documentname,
                               type:'comments'
                            },
                   url: "document_checkout_process.php",
                    success: function(response){
                               // alert(response); 
                                $.ajax({
                                        type: "POST",
                                        data: {
                                                   template_id:id,  /* template_id contain DocumentId and Revision eg:   54507fe19fb5d3547f6526aa-1 */
                                                   documentname:documentname,  /* documentname conatin DocumentName eg:Demo */
                                                   type:'getCommments'
                                                },
                                        url: "document_checkout_process.php",
                                        success: function(response){
                                            commenthtml='';
                                            var data =$.parseJSON(response);
                                            var commentstextarray = data.Text;
                                            var commentsnamearray = data.User;
                                            var commentsdatearray = data.Date;
                                            var commentslen = data.Text.length;
                                            if(commentslen < 6)
                                            {
                                                len = commentslen;
                                            }
                                            else{
                                                len = 5;
                                            }
                                                
                                            commenthtml1='<div class="div-padding" id="add-comment1"><a onclick="viewmorecomments(this);">View More Comments('+commentslen+') </a></div>';
                                            for(var index = 0; index < len;index++){
                                                    commenthtml+='<div class="row"><div class="more-comment div-padding" >';
                                                    commenthtml+='<a><i>'+commentsnamearray[index]+':</i></a>'+ commentstextarray[index];										 
                                                    commenthtml+='<div class="date colour">'+commentsdatearray[index]+'</div></div></div>';
                                                }
                                            $(currobj).parent().parent().parent().children(':eq(0)').remove();
                                            $(currobj).parent().parent().parent().prepend(commenthtml1); 
                                            $(currobj).parent().parent().parent().children(':eq(1)').find('.row').remove();
                                            $(currobj).parent().parent().parent().find('.morecomments').html(commenthtml);
                                            $(currobj).parent().parent().children(':eq(0)').children().val('');
                                            }
                                        });
                                
                            }
                    });
            }
                
    }
    else{
            alert('Please enter comments');
	}
       
});

function makerevision(currobject)
{
    var id = $(currobject).parent().parent().parent().attr('id');
    $('#docinfo').val(id);
    var temploc = $(currobject).parent().parent().parent().find('.doctemppath').val();
    if(temploc != undefined)
    {
        $('#templocation').val(temploc);
    }
    var privateflag = $(currobject).parent().parent().parent().find('.privateflag').val();
    $('#documentprivate').val(privateflag);
    var tempname = $(currobject).parent().parent().parent().find('.doctemp').val();
    if(tempname != undefined)
    {
       tempname = tempname.split('.');
       $('#templatename').val(tempname[0]); 
    }
    var docname = $(currobject).parent().parent().parent().find('.documentname a').text();
    $('#docname').val(docname);
    var filenmext = $(currobject).parent().parent().parent().find('.fileextension img').attr('src');
    filenmext = filenmext.split('/');
    var extindex = parseInt(filenmext.length) - 1;
    var actualfileext = filenmext[extindex].split('.');
    actualfileext = actualfileext[0];
    $('#filename').val(actualfileext);
   var q = confirm("Do you want to Check In the Document");
   if(q){
     $('#revisionForm').submit();
   }

}

function add_tags(addtagobj)
{
    var taglistarray = new Array();
    var taglistindex = 0;
    var usertag =$(addtagobj).parent().parent().find('.chosen-container-multi').html();
    $(addtagobj).parent().parent().find('.chosen-container-multi ul li').each(function(){
        if($(this).find('span').length > 0)
            {
                taglistarray[taglistindex] = $(this).find('span').text();
                taglistindex++;
            }
    });

    if(taglistarray.length == 0)
        {
            alert("enter the Tags");
        }
    else
        {
            var actiontype = 'tag';
            var documentname     = $(addtagobj).parent().parent().parent().parent().parent().parent().parent().find('.documentname a').text();
            var documentrevision = $(addtagobj).parent().parent().parent().parent().parent().parent().parent().find('.documentrev span').text();
            alert(taglistarray+" "+documentname+" "+documentrevision+" "+actiontype);

            $.ajax({
            type: "POST",
            data: {
                taglistarray      : taglistarray,
                documentname      : documentname,
                documentrevision  : documentrevision,
                actiontype        : actiontype  
            },
            url: "savedoc_tagscomment.php",
            success: function(msg){
            }
            });
        }
}

function dynamicURL(documentName,revisionNo,htmltemp,docid)
{
    $.facebox.settings.closeImage = 'img/close_button.png';
    $.facebox.settings.loadingImage = 'img/loading.gif'; 
    var ajaxpostID = "view_document.php?doc="+documentName+"&revision="+revisionNo+"&tempname="+htmltemp+"&documentid="+docid;//+"'"; 
    jQuery.facebox({ajax: ajaxpostID});
      
}