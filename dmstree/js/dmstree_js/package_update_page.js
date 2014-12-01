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
    })//;
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
	$("#package_info").css('display','none');
});

$('#duration_or_size').change(function(){
	var selected_val = $('#duration_or_size option:selected').val();
	alert(selected_val);
	if(selected_val == 'duration')
	{
		$('.hide').find('label').text('Duration');
		$(".hide").css('display','block');
	}
	else if(selected_val == 'size')
	{
		$('.hide').find('label').text('Size');
		$(".hide").css('display','block');
	}
});

function update_package()
{
	selected_val = $('#package option:selected').attr('id');
	if(selected_val != '')
	{
		$('#package_form').bootstrapValidator('validate');
		if(flag)
		{
			selected_val = $('#package option:selected').attr('id');
			package_name = $('#package_name').val();
			package_type = $('#package_type option:selected').text();
			duration_or_size = $('#duration_or_size option:selected').text();
			txt_size = $('#txt_size').val();
			package_base_rate = $('#package_base_rate').val();
			package_tax_percentage = $('#package_tax_percentage').val();
			$.ajax({
					type: "POST",
					data:{
							package_name:package_name,
							package_type:package_type,
							duration_or_size:duration_or_size,
							txt_size:txt_size,
							package_base_rate:package_base_rate,
							package_tax_percentage:package_tax_percentage,
							selected_val:selected_val,
							type:'update'
							},

					url: "package_process.php",
					success:function(response){
                                                alert("Package Updated successfully");
                                                location.reload();
					}
			});
			
		}
	}
	else
	{
		alert("Please Select Package Name");
		
	}
}

$('#package').change(function(){
	selected_val = $('#package option:selected').attr('id');
	if(selected_val != '')
	{
			$.ajax({
				type: "POST",
				data:{
						selected_val:selected_val,
						type:'getInfo'
					 },

				url: "package_process.php",
				success:function(response){
							var data = $.parseJSON(response);
							$('#package_name').val(data.PackageName);
							var category = data.PackageType;
							if(category == 'Individual')
							{
								$("#package_type").prop("selectedIndex",1);
							}
							else if(category == 'Corporate')
							{
								$("#package_type").prop("selectedIndex",2);
							}
							
							var type = data.DurationOrSize
							if(type == 'Size')
							{
								$("#duration_or_size").prop("selectedIndex",2);
								size = data.PackageSizeInGB;
								$('.hide').find('label').text('Size In GB');
								$('.hide').css('display','block');
							}
							else if(type == 'Duration')
							{
								$("#duration_or_size").prop("selectedIndex",1);
								size = data.PackageDurationInMonths;
								$('.hide').find('label').text('Duration In Month');
								$('.hide').css('display','block');
							}
							$('#txt_size').val(size);
							$('#package_base_rate').val(data.PackageBaseRate);
							$('#package_tax_percentage').val(data.PackageTaxPercentage);
						}
				});
		$("#package_info").css('display','block');
	}
	else
	{
		$("#package_info").css('display','none');
		
	}
});

function delete_package()
{
	selected_val = $('#package option:selected').attr('id');
	if(selected_val != '')
	{
		$.ajax({
					type: "POST",
					data:{
							selected_val:selected_val,
							type:'delete'
							},

					url: "package_process.php",
					success:function(response){
                                                alert("Package deleted successfully");
                                                location.reload();
					}
			});
	}
	else{
		alert("Please Select Package Name");
	}
}

function reset_package()
{
	$('#package_form').data('bootstrapValidator').resetForm();
	
}