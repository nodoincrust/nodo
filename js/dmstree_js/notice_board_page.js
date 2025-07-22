/*
 * Name: 
 * Date: 3/9/2014
 * Create by :Mahendra Kadam
 * Summary : This function is used to display image on change('type:file').
 */
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                $('#notice_image').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#txt_notice_image").change(function(){
        readURL(this);
    });
	
/*
 * Summary : To validate notice form
 */

var flag;

$(document).ready(function() {
    $('#form_notice').find('[name="notice_category"]')
					 .selectpicker()
					 .change(function(e) {
                                         // revalidate the problem_category when it is changed
                                         $('#form_notice').bootstrapValidator('revalidateField', 'notice_category');
                                          })
                                         .end()
                                        .bootstrapValidator({
                                            excluded: ':disabled',
                                        message: 'This value is not valid',

//        threshold: 11,
            fields: {
                    notice_title: {
                            validators: {
                                    notEmpty: {
                                            message: 'The notice title is required and can\'t be empty'
                                    }

                            }
                    },            
                    notice_description:{
                            validators: {
                                    notEmpty: {
                                            message: 'The description is required and can\'t be empty'
                                    }

                            }
                    },
                    notice_category:{
                            validators: {
                                    notEmpty: {
                                            message: 'The notice category is required and can\'t be empty'
                                    }

                            }
                    }	
            }
    })
    .on('success.field.bv', function(e, data) {
            var $parent = data.element.parents('.form-group');
            $parent.removeClass('has-success');
            $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
			flag = true;
        })
	.on('error.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target),
        bootstrapValidator1 = $form.data('bootstrapValidator');
		flag = bootstrapValidator1.isValid();
	});

});
	
/*
 * Summary : This function is used to set all to blank in model.
 */	
function clearForm(){
	$('#list').val("");
	$('#txt_notice_title').val("");
	$('#txt_notice_description').val("");
	$('#txt_notice_image').val("");
	$('#notice_image').attr('src','');
}

function saveNotice()
{
	console.log('saveNotice function called');
	var category = $('#list').val();
	var title = $('#txt_notice_title').val();
	var description = $('#txt_notice_description').val();
	var img = $('#notice_image').attr('src');
	var expiry_date = $('#expiry_date').val();
	var file_selected = document.getElementById('txt_notice_image');
	var files = file_selected.files;
	
	console.log('Form values:', {category, title, description, img, expiry_date});
	
	// Validate the form
	$('#form_notice').bootstrapValidator('validate');
	
	// Check if validation passed
	if(flag)
	{
		console.log('Validation passed, proceeding with submission');
		if(img != '')
		{	
			console.log('Processing with image');
			// Check if file is selected and is an image
			if (files.length > 0) {
				if (!files[0].type.match('image.*'))
				{
					alert('Please select a valid image file');
					file_selected.value = "";
					$('#notice_image').attr('src','');
					return;
				}
			}
			
			// Submit form with image
			var formData = new FormData($('#form_notice')[0]);
			console.log('Submitting form with image via AJAX');
			$.ajax({
				url: "notice_board_process.php",
				type: "POST",
				data: formData,
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
				success: function(data)
				{
					console.log('Success response:', data);
					var actiontext = "New Notice create and send successfully.";
					$.ajax({
						type: "POST",
						data: {
							actiontext : actiontext
						},
						url: "track_history.php",
						success: function(response){ 
							alert('Notice create and save Successfully.');
							clearForm();
							$('#myModal').modal('hide');
							location.reload();
						}   
					});
				},
				error: function(xhr, status, error) {
					console.error('AJAX error:', error);
					alert('Error saving notice: ' + error);
				}
			});
		}
		else if(img == '')
		{
			console.log('Processing without image');
			// Submit form without image
			var type = 'no_img';
			$.ajax({
				type: "POST",
				data:{
					category: category,
					title: title,
					description: description,
					img: img,
					date: expiry_date,
					type: type 
				},
				url: "notice_board_process.php",
				success: function(response){
					console.log('Success response:', response);
					var actiontext = "New Notice create and send successfully.";
					$.ajax({
						type: "POST",
						data: {
							actiontext : actiontext
						},
						url: "track_history.php",
						success: function(response){ 
							alert('Notice create and save Successfully.');
							clearForm();
							$('#myModal').modal('hide');
							location.reload();
						}   
					});
				},
				error: function(xhr, status, error) {
					console.error('AJAX error:', error);
					alert('Error saving notice: ' + error);
				}
			});
		}
	}
	else
	{
		console.log('Validation failed');
		alert('Please fill all required fields correctly');
	}
}


/*
 * Summary : To show read more on click 
 */
$('article').readmore({
	maxHeight: 50,
	speed: 100, 
	moreLink: '<a href="#">Read More</a>',
	lessLink: '<a href="#">Close</a>',
	embedCSS: true,
	sectionCSS: 'display: block; width: 100%;',
	startOpen: false,
	expandedClass: 'readmore-js-expanded',
	collapsedClass: 'readmore-js-collapsed',
	 
	// callbacks
	beforeToggle: function(){},
	afterToggle: function(){}
});		

function call_readmore()
{
	$('article').readmore({
		maxHeight: 50,
		speed: 100, 
		moreLink: '<a href="#">Read More</a>',
		lessLink: '<a href="#">Close</a>',
		embedCSS: true,
		sectionCSS: 'display: block; width: 100%;',
		startOpen: false,
		expandedClass: 'readmore-js-expanded',
		collapsedClass: 'readmore-js-collapsed',
		 
		// callbacks
		beforeToggle: function(){},
		afterToggle: function(){}
	});		
}
$(function () {
        $('#datetimepicker').datetimepicker({
			useCurrent: false
        });
		$("#datetimepicker").on("dp.show",function (e) {
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
			$('#datetimepicker').data("DateTimePicker").setMinDate(curr_day);//e.date);

		});
});