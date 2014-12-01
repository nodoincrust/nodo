
    $(document).ready(function(){
    $( "#expiry-date" ).datepicker({ dateFormat: "yy-mm-dd" });
    
});


//function display_expiryCal()
//{
//    $('#expiry-date').datepicker();
//}


function display_minmaxlen_err(lenobj)
{
//	alert("in function");
        var flag1 =0;
        var inputval = $(lenobj).val();
        var parentid = $(lenobj).closest("div").parent(".droppedField").attr("id");
        var minlen = $(lenobj).closest("div").find(".min_length").val();
//        alert(minlen);
        var maxlen = $(lenobj).closest("div").find(".max_length").val();
//        alert(maxlen);
        if((minlen == '' && maxlen == '') || (minlen == '0' && maxlen =='0'))
            {
                flag1 = 1;
            }
        else
            {
                if( minlen == '0')
                    {
                        minlen = '';
                    }
                if( maxlen == '0')
                    {
                        maxlen == '';
                    }
                var inputlen = inputval.length;
                if( minlen != '' && maxlen != '' && inputlen < minlen  && minlen < maxlen)
                    {
                       $('#'+parentid).find('.textbox_err_msg').text('This field required min '+minlen+' and max '+maxlen+' characters');
                    }
                else if(minlen != '' && inputlen < minlen  && maxlen == '')
                    {
                        $('#'+parentid).find('.textbox_err_msg').text('This field required min '+minlen+' characters');
                    }
                else if(minlen == '' && inputlen < maxlen && maxlen != '')
                    {
                        $('#'+parentid).find('.textbox_err_msg').text('This field required max '+maxlen+' characters');
                    }
                    else
                        {
                           $('#'+parentid).find('.textbox_err_msg').text(''); 
                        }
            }
}