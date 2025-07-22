 var id;
 var panel_id;
 $(document).ready(function(){
	
 });
 $('.panel-title').click(function(){
	$(".show_template").css("border","none");
 });
function view_template(element)
{
	panel_id = $(element).parent().parent().parent().parent().prop('id');
	path = $(element).prop('id');
	id = $(element).parent().prop('id');
	$("#"+panel_id).find('.show_template').prop('id',path);
	$("#"+panel_id).find('.show_template').load(path);
	$(".show_template").css("border","1px solid #ddd");
	$("ul li a").css("color","#428bca")
	$(element).css("color","#b3d4fc");
}
function delete_template(element)
{
	temp_link = $(element).parent().find('.show_template').prop('id');
	if(temp_link)
	{
		var q = confirm('Do You Really Want To Delete The Template ?');
		if(q)
		{
			$.ajax({
				type: "POST",
				data:{
						id:id,
						type:'deleteTemplate'
					 },
				url: "view_domain_process.php",
				success:function(response){
				alert(response);
				}
			});
		}
	}
	else{
	alert('Please Select Template');
	}
}

function showTemplate(currobj)
{
    id = $(currobj).val();
    str='';
    if(id != ''){
           $.ajax({
                type: "POST",
                data:{
                                id:id,
                                type:'getTemplate'
                         },
                url: "view_domain_process.php",
                success:function(response){
                           // alert(response);
                            data = $.parseJSON(response);
                            var name = data.name;
                            var location = data.location;
                            var extension = data.extension;
                            var len = data.name.length;
                            var id = data.id;
                            $('.templateData').empty();
                            if(len > 0){
                                for(index = 0; index < len;index++)
                                {
                                   str += "<li id='"+ id[index] +"'><a id='"+location[index]+"/"+extension[index] +"' onclick='view_template(this);'>"+ name[index]+"</a></li>"
                                }
                                $(currobj).parent().parent().parent().find('.templateData').append(str);
                                $("#"+panel_id).find('.show_template').empty();
                                $(".show_template").css("border","none");
                            }
                            else{
                                $('.show_template').html("<div class='row'> <div class='col-md-offset-1'>Sorry No Template Available </div></div>");
                            }
                        }
        });
    }
}