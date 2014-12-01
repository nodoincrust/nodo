
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
	var category = $('#list').val();
	var title = $('#txt_notice_title').val();
	var description = $('#txt_notice_description').val();
	var img = $('#notice_image').attr('src');
	var expiry_date = $('#expiry_date').val();
	 var file_selected = document.getElementById('txt_notice_image');
	 var files = file_selected.files;
	 $('#form_notice').bootstrapValidator('validate');
	 if(img != '')
	 {	

			 if (!files[0].type.match('image.*'))
			 {
				 alert('invalid');
				 file_selected.value = "";
				 $('#myModal img').attr('src','');
			 }
			 else{
				 if(flag)
				 {
//					 alert("hi1");
					 $('#form_notice').submit(function(e){
                                         var formData = new FormData(this);
                                         $.ajax({
                                                url: "notice_board_process.php",
                                                type: "POST",
                                                data:  formData,
                                                mimeType:"multipart/form-data",
                                                contentType: false,
                                                cache: false,
                                                processData:false,
                                                success: function(data)
                                            {
                                                var actiontext = '';
                                                actiontext = "New Notice create and send successfully.";
                                                    $.ajax({
                                                        type: "POST",
                                                        data: {
                                                            actiontext : actiontext
                                                        },
                                                        url: "track_history.php",
                                                        success: function(response){ 
                                                            alert('Notice create and save Successfully.');
                                                        }   
                                                    });
					 //alert("hi2");			
					 $('#sub').prop('data-dismiss','modal');
					 $('#list').val("");
					 $('#txt_notice_title').val("");
					 $('#txt_notice_description').val("");
					 $('#txt_notice_image').val("");
					 $('#notice_image').attr('src','');
					 $('#myModal').modal('hide');
				
				 }
                                         });
                                         e.preventDefault();
                                         });
                                         }
		}
	 }
	 else if(img == '')
	 {
		 if(flag)
		 {
                     var type= 'no_img';
			 $.ajax({
			 type: "POST",
			 data:{
					 category:category,
					 title:title,
					 description:description,
					 img:img,
                                         date:expiry_date,
                                         type:type 
                              },
				 //dataType: "json",
				 url: "notice_board_process.php",
				 success:function(response){
					 alert(response);
                                         var actiontext = '';
                                         actiontext = "New Notice create and send successfully.";
                                            $.ajax({
                                                type: "POST",
                                                data: {
                                                    actiontext : actiontext
                                                },
                                                url: "track_history.php",
                                                success: function(response){ 
                                                    alert('Notice create and save Successfully.');
                                                }   
                                            });
					 location.reload();
				 }
			 });
			 $('#sub').prop('data-dismiss','modal');
			 $('#list').val("");
			 $('#txt_notice_title').val("");
			 $('#txt_notice_description').val("");
			 $('#txt_notice_image').val("");
			 $('#notice_image').attr('src','');
			 $('#myModal').modal('hide');
				
                }
	 }

}


$("#form_notice").submit(function(e)
{
	var formObj = $(this);
		var formData = new FormData(formObj);
		$.ajax({
        	url: "notice_board_process.php",
			type: "POST",
			data:  formData,
			mimeType:"multipart/form-data",
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {
				alert(data);
		    }	        
	   });
        e.preventDefault();
});

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