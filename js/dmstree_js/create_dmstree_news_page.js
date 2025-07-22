$(function () {
    
                $('#datetimepicker1').datetimepicker({
                    pickTime: false,
					useCurrent: false
                });
				$('#datetimepicker1').on("dp.show",function (e) {
					var day=new Date();
						d=day.getDate();
						m=day.getMonth()+1;
						y=day.getFullYear();
						var curr_day=m+"/"+d+"/"+y;
					$('#datetimepicker1').data("DateTimePicker").setMinDate(curr_day);//e.date);
				})
}); 

function save_news()
{
	title = $('#new_title').val();
	description = $('#new_description').val();
	date = $('#expiry_date').val();
	$('#news_form').submit();
}

$("#news_form").submit(function(e){
	var formData = new FormData(this);
       	title = $('#new_title').val();
	description = $('#new_description').val();
	img = $('#new_image').val();
	date = $('#expiry_date').val();
       
	 $.ajax({
        	 url: "create_dmstree_news_process.php",
			 type: "POST",
			 data:  formData,
			 mimeType:"multipart/form-data",
			 contentType: false,
                        cache: false,
			 processData:false,
			 success: function(data)
		     {
                               alert("News created successfully");
                               location.reload();
		     }	        
	    });
        e.preventDefault();
        alert("after submit");
});