$('#news').change(function(){
    selected_val = $('#news option:selected').attr('id');
	if(selected_val != '')
	{
		//alert(selected_val);
			$.ajax({
				type: "POST",
				data:{
					id:selected_val,
                                        type:"select"
                                        },

				url: "update_dmstree_news_process.php",
				success:function(response){
					//alert(response);
                                        var data = $.parseJSON(response);
                                        $('#new_title').val(data.NewsTitle);
                                        $('#new_description').val(data.NewsDescription);
                                        $('#expiry_date').val(data.ExpiryDate);
						}
				});
		$("#newinfo").css('display','block');
	}
	else
	{
		$("#newinfo").css('display','none');
		
	}
});

function delete_news()
{
    var q = confirm('Do You Really Want To Delete?');
    selected_val = $('#news option:selected').attr('id');
        if (q)
            {
                $.ajax({
                            type: "POST",
                            data:{
                                    id:selected_val,
                                    type:"delete"
                                    },

                            url: "update_dmstree_news_process.php",
                            success:function(response){
                                    //alert(response);
                                    alert("News Deleted successfully");
                                    location.reload();
                                    }
                            });
            }
}