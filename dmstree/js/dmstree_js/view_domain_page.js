function save_domain()
{
	name = $('#domain_name').val()
    id = $('#domain_id').val();
	if(name != '')
	{
            var q = confirm("Do You Really Want to Add Domain");
            if(q)
            {
		$.ajax({
                            type: "POST",
                            data:{
                                    id:id,
                                    name:name,
                                    type:'insert'
                                   },

                            url: "view_domain_process.php",
                            success:function(response){
                                    alert(name+" Domain created successfully");
                                    location.reload();
                            }
			});
            }
	}
	else
	{
		alert("Please Enter The Domain Name");
	}
}
function save_sub_domain()
{
    selected_domain = $('#domain_sub_type option:selected').val();
	id = $('#domain_id').val();
	if(selected_domain != "")
	{
            name = $("#domain_sub_name").val();
            if(name != '')
            {
                var q = confirm("Do You Really Want to Add Sub Domain");
                    if(q)
                    {
                        $.ajax({
                                    type: "POST",
                                    data:{
                                            id:id,
                                            name:name,
                                            domainName:selected_domain,
                                            type:'subInsert'
                                           },

                                    url: "view_domain_process.php",
                                    success:function(response){
                                            $('#domain_sub_name').val('');
                                            alert(name+" Sub-domain created successfully");
                                            location.reload();
                                    }
                                });
                    }
              }
              else
              {
                  alert("Please Enter The Sub Domain Name");
              }
        }
        else
        {
            alert("Please Select The Domain Name");
        }
    
}

function delete_domain()
{
	selected_domain = $('#domain_type option:selected').val();
	id = $('#domain_id').val();
	if(selected_domain != "")
	{
            var q = confirm("Do You Want to delete Domain");
            if(q){
		$.ajax({
                            type: "POST",
                            data:{
                                    id:id,
                                    name:selected_domain,
                                    type:'delete'
                                   },

                            url: "view_domain_process.php",
                            success:function(response){
                                    alert(name+" Domain deleted successfully");
                                    location.reload();
                            }
			});
            }      
	}
	else{
		alert("Please Select The Domain Name");
	}
	
}

$('#delete_domain_type').change(function(){
    var domain = $('#delete_domain_type option:selected').val();
    id = $('#domain_id').val();
    str = '<option value=""></option>';
    if(domain != '')
    {
            $.ajax({
                    type:"POST",
                    data:{
                        id:id,
                        domain:domain,
                        type:"getsubdomain"
                    },
                    url:"view_domain_process.php",
                    success:function(response){
                        data = $.parseJSON(response);
                        var subdomain = data.subDomain;
                        var len = data.subDomain.length;
                        for(index = 0; index < len; index++){
                            str +='<option value="'+ subdomain[index]+'">'+subdomain[index]+'</option>';
                        }
                        $('#delete_sub_domain').empty();
                        $('#delete_sub_domain').append(str);
                         $('.selectpicker').selectpicker('refresh');
                    }
            });
    }
});

function sub_domain_delete()
{
    id = $('#domain_id').val();
    domain = $('#delete_domain_type option:selected').val();
    if(domain != ''){
        subdomain = $('#delete_sub_domain option:selected').val();
        if(subdomain != ''){
            var q = confirm("Do You Want to delete Sub Domain");
            if(q){
                $.ajax({
                    type:"POST",
                    data:{
                            id:id,
                            domain:domain,
                            subdomain:subdomain,
                            type:"deletesubdomain"
                    },
                    url:"view_domain_process.php",
                    success:function(response){
                        alert(subdomain+" subdomain deleted from "+domain+" domain successfully");
                        location.reload();
                    }
                });
            }
        }else{
            alert("Please select the Sub Domain Name");
        }
    }else{
        alert("Please select Domain Name ");
    }
}