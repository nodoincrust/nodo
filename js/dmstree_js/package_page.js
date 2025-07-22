var flag = true;
var bootstrapValidator;
$(document).ready(function(){
	$('#package_form').bootstrapValidator({
				   excluded: ':disabled',
        message: 'This value is not valid',
        feedbackIcons: {
		},
        threshold: 11,
        fields: {
            package_name: {
                validators: {
                    notEmpty: {
                        message: 'The Package Name is required'
                    }
                }
            },
			package_type:{
				validators: {
                    notEmpty: {
                        message: 'The Package Type is required'
                    }
                }
			},
			duration_or_size:{
				validators: {
                    notEmpty: {
                        message: 'The Duration Or Size is required'
                    }
                }
			},
			package_base_rate:{
				validators: {
                    notEmpty: {
                        message: 'The Package Base Rate is required'
                    }
                }
			},
			size:{
				validators: {
                    notEmpty: {
                        message: 'The Field is required'
                    }
                }
			},
			package_tax_percentage:{
				validators: {
                    notEmpty: {
                        message: 'The Package Tax Percentage is required'
                    }
                }
			}
        }
    })
     .on('success.field.bv', function(e, data) {
			e.preventDefault();
            var $parent = data.element.parents('.form-group');
            $parent.removeClass('has-success');
            $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
        })
	.on('error.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target),
        bootstrapValidator1 = $form.data('bootstrapValidator');
		flag = bootstrapValidator1.isValid();
	});
});
$(document).ready(function(){
	$(".hide").css('display','none');
});

var type_txt;
var category_txt;

$('#package_type').change(function(){
	category_txt = $('#package_type option:selected').text();
});
$('#duration_or_size').change(function(){
	var selected_val = $('#duration_or_size option:selected').val();
	type_txt = $('#duration_or_size option:selected').text();
	if(selected_val == 'duration')
	{
		$('.hide').find('label').text('Duration In Month');
		$(".hide").css('display','block');
	}
	else if(selected_val == 'size')
	{
		$('.hide').find('label').text('Size In GB');
		$(".hide").css('display','block');
	}
});

function save_package()
{
	$('#package_form').bootstrapValidator('validate');
	if(flag)
	{
		package_name = $('#txt_package_name').val();
		txt_size = $('#txt_size').val();
		package_base_rate = $('#package_base_rate').val();
		package_tax_percentage = $('#package_tax_percentage').val();
		selected_val = $('#duration_or_size option:selected').text();
				$.ajax({
				type: "POST",
				data:{
						package_name:package_name,
						package_type:category_txt,
						duration_or_size:type_txt,
						txt_size:txt_size,
						package_base_rate:package_base_rate,
						package_tax_percentage:package_tax_percentage,
						selected_val:selected_val,
						type:'insert'
					 	},

				url: "package_process.php",
				success:function(response){
					alert("Package save successfully");
                                        $('input').val('');
                                        location.reload();
				}
				});
	}
}
function reset_package()
{
	$('#package_form').data('bootstrapValidator').resetForm();
	
}