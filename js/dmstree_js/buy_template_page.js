            
function buyTemplate(currobj)
{
    var temp_path = $(currobj).parent().children(":eq(0)").prop("id");
    alert(temp_path);
    $.ajax({
        type:"POST",
        data:{
                tempPath:temp_path,
                type:'purchaseTemplate'

        },
         url: "view_domain_process.php",
         success:function(response)
         {
             alert("Template downloaded successfully");
         }
    });
}

function showTemplate(currobj)
{
    panel_id = $(currobj).parent().parent().parent().parent().prop('id');
    id = $(currobj).val();
    str='';
    if(id != ''){
    $.ajax({
                type: "POST",
                data:{
                        id:id,
                        type:'buyTemplate'
                     },
                url: "view_domain_process.php",
                success:function(response){
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
                           str += "<li id='"+ id[index] +"'><a id='"+location[index]+"/"+extension[index] +"' onclick='view_template(this);'>"+ name[index]+"</a><a class='col-md-offset-4' onclick='buyTemplate(this)'>Buy Now</a></li>"
                        }
                        $(currobj).parent().parent().parent().find('.templateData').append(str);
                        $("#"+panel_id).find('.show_template').empty();
                        $(".show_template").css("border","none");
                    }
                    else{
                        $('.show_template').html("<div class='row'> <div class='col-md-offset-1'>Sorry No Template Available </div></div>");
                        $(".show_template").css("border","none");
                    }
                }
        });
    }
    else{
        $("#"+panel_id).find('.show_template').empty();
        $('.templateData').empty();
        $(".show_template").css("border","none");
    }
}
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
$( "a[data-toggle]" ).click(function(){
    $('.templateData').empty();
    $(".show_template").empty();
    $(".show_template").css("border","none");
});