
$(function () {
    $('#datetimepicker').datetimepicker({
        useCurrent: false,
        defaultDate:'2/10/2014'
    });

    $("#datetimepicker").on("dp.show",function (e) {
        var curr= $("#datetimepicker").children(':eq(0)').val();
        var day=new Date();
        d=day.getDate();
        m=day.getMonth()+1;
        y=day.getFullYear();
        if (d.length == 1)
        {
            d = "0" + d;
        }
        if (m.length == 1)
        {
            m = "0" + m;
        }
        var curr_day=m+"/"+d+"/"+y;

        $('#datetimepicker').data("DateTimePicker").setMinDate(curr_day);

        var curr_day=d+"/"+m+"/"+y;
        if(curr >= curr_day)
        {
            alert('You can\'t select the previous date as expire date');
            $("#datetimepicker").children(':eq(0)').val("");
        }
    });
});

function updateRevision(){
    //location.href="document_timeline.php";
}
function makerevision(){
    var q = confirm("Want To Check In Document");
    if(q)
    {
        $('#viewDocumentForm').submit();
    }
}
/*
* Summary : To add comment on click of comment button
*/
$('.btn_comment').click(function() {
    currobj = this;
    comments = $('#txt_comment2').val();//to fetch the value of input box 
    //alert(comments);
    if(comments!='')
    {
        id = $('#temp_id').val();
        var documentname  = $('#doc_name_view').val();
        
       // alert(documentname);
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
                                            //alert(response);
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
                                                
                                            commenthtml1='<a onclick="viewmorecomments(this);">View Comments('+commentslen+')</a>';
                                            for(var index = 0; index < len;index++){
                                                    commenthtml+='<div class="row"><div class="col-md-8 col-md-offset-2 more-comment div-padding">';
                                                    commenthtml+='<a><i>'+commentsnamearray[index]+':</i></a>'+ commentstextarray[index];										 
                                                    commenthtml+='<div class="date colour">'+commentsdatearray[index]+'</div></div></div>';
                                                }
                                            $('#comments').children(':eq(0)').remove();
                                            $('#comments').prepend(commenthtml1); 
                                            $('.comment_text').find('.row').remove();
                                            $('.comment_text').html(commenthtml);
                                             $('#txt_comment2').val('');
                                            }
                                        });
                                
                            }
                    });
            }
            else{
                $('#txt_comment2').val('');
            }
                
    }
    else{
            alert('Please enter comments');
	}
 });
//$('.btn_comment').click(function() {
//    var day=new Date();
//    var hour = day.getHours();
//    var min = day.getMinutes();
//    day=day.toDateString();
//    var name = $('#user_name').val(); 
//    text=day;
//    comments =$(this).parent().parent().children().children().val();//to fetch the value of input box 
//    if(comments!='')
//    {
//        var q = confirm("Do you want to add Tag");
//        if(q)
//        {
//            commenthtml='<div class="col-md-8 col-md-offset-2 more-comment div-padding" >';
//            commenthtml+='<a><i>'+name+':</i></a>'+ comments;										 
//            commenthtml+='<div class="date colour">'+text+'</div></div>';	
//            $(commenthtml).insertBefore($(this).parent().parent().parent().parent().find(".comment_text"));//to insert new div after #comment-more class
//            $(this).parent().parent().children().children().first().val("");
//            var documentname     = $(this).parent().parent().parent().parent().parent().parent().find('.documentname a').text();
//            var id = $('#temp_id').val();
//            $.ajax({
//                type: "POST",
//                data: {
//                        template_id:id,
//                        comments:comments,
//                        documentname:'',
//                         type:'comments'
//                        },
//                url: "document_checkout_process.php",
//                success: function(response){
//                        alert(response); 
//                        //location.reload();
//                        }
//            });
//        }
//    }
//    else{
//        alert('Please enter comments');
//    }
//});

$('#file_show').change(function(){
    if($('#file_show').is(':checked'))
    {
        var id = $('#temp_id').val();
        $.ajax({
                type: "POST",
                data: {
                        template_id:id,
                        type:'file'
                    },
                url: "document_checkout_process.php",
                success: function(response){
                    //alert(response); 
                    $('#doc_preview').attr('src',response);
                    $('iframe').css('display','block');
                    //location.reload();
                }
        });
        //alert('checked');
    }
    else
    {
        $('iframe').css('display','none');
    }
});

function redirectTimeline()
{
    location="document_timeline.php";
}
function viewtimeline()
{
    $('#timeline_form').submit();
}