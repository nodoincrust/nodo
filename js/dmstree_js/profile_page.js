/*
 * Summary : This function is used to validate the form of password.
 */
 
 var value1;
 var profile;
 
    $('#profile_info').bootstrapValidator({
        message: 'This value is not valid',
        //threshold: 11,
        fields: {
            name: {
                message: 'The name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The name is required and can\'t be empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z\ ]+$/,
                        message: 'The name can only consist of alphabet.'
                    }
                }
            },
			contact: {
                message: 'The contact number is not valid',
                validators: {
                    notEmpty: {
                        message: 'The contact number is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 10,
                        max: 13,
                        message: 'The contact number must be equale to 10'
                    },
                    regexp: {
                        regexp: /^[\+][0-9]+$/,
                        message: 'The contact number can only consist of  number and start with "+"'
                    }
                }
            },
			address1:{
				validators: {
                    notEmpty: {
                        message: 'The Address is required'
                    }
                }
			},
			address2:{
				validators: {
                    notEmpty: {
                        message: 'The Address is required'
                    }
                }
			},
            city: {
                validators: {
                    notEmpty: {
                        message: 'The city is required and can\'t be empty'
                    },
                    regexp: {
                        regexp:/^[a-zA-Z\ ]+$/,
                        message: 'The city can only consist of  alphabet'
                    }
                }
            },
            state: {
                validators: {
                    notEmpty: {
                        message: 'The state is required and can\'t be empty'
                    },
                    regexp: {
                        regexp:/^[a-zA-Z\ ]+$/,
                        message: 'The state can only consist of  alphabet'
                    }
                }
            },
            country: {
                validators: {
                    notEmpty: {
                        message: 'The country is required and can\'t be empty'
                    },
                    regexp: {
                        regexp:/^[a-zA-Z\ ]+$/,
                        message: 'The country can only consist of  alphabet'
                    }
                }
            },
            pincode: {
                validators: {
                    notEmpty: {
                        message: 'The pincode is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
						max: 6,
                        message: 'The pincode must be equale to 6'
                    },
                    regexp: {
                        regexp:/^[0-9]+$/,
                        message: 'The city can only consist of  alphabet'
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
		profile=true;
		
    }).on('error.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target),
        bootstrapValidator1 = $form.data('bootstrapValidator');
		profile = bootstrapValidator1.isValid();
	});
	
/*
 * Name: 
 * Date: 13/8/2014
 * Create by :Mahendra Kadam
 * Summary : This function is used to show block on condition (for eg : show profile page on click of profile navigate link)
 */

function show(text)
{
     $('#profileBtn').removeClass('active').addClass('inactive');
    $('#passwordBtn').removeClass('active').addClass('inactive');
	switch(text)
	{
		case 'password':$('#profile_timeline').css("display", "none");
						$('#profile_password').css("display", "block");
						$('#profile_profile').css("display", "none");
						$('#profile_notification').css("display", "none");
						 $('#passwordBtn').removeClass('inactive').addClass('active');
						break;
		case 'profile':$('#profile_timeline').css("display", "none");
						$('#profile_password').css("display", "none");
						$('#profile_profile').css("display", "block");
						$('#profile_notification').css("display", "none");
						  $('#profileBtn').removeClass('inactive').addClass('active');
						break;
	}
}
// function show(text) {
//     // Remove 'active-link' class from all navbar links
//     $('.navbar-nav a').removeClass('active-link');

//     // Hide all sections by default
//     $('#profile_timeline').hide();
//     $('#profile_password').hide();
//     $('#profile_profile').hide();
//     $('#profile_notification').hide();

//     switch (text) {
//         case 'password':
//             $('#profile_password').show();
//             $('a[onclick="show(\'password\');"]').addClass('active-link');
//             break;
//         case 'profile':
//             $('#profile_profile').show();
//             $('a[onclick="show(\'profile\');"]').addClass('active-link');
//             break;
//     }
// }

/*
 * Summary : This function is used to hide all page except time-line
 */

$(document).ready(function(){
	$('#profile_password').css("display", "none");
	$('#profile_notification').css("display", "none");
});

/*
 * Summary : This function is used to set the value back (update) on save button of model.
 */

function saveChangesPassword(isProfileOrPassword)
{
		$('#profilePassword').bootstrapValidator('validate');
		if(value1)
		{
			var pass = $('#txt_profile_old_password').val();
			var new_pass =  $('#txt_profile_new_password').val();
			if(pass != new_pass)
			{
                            var q =confirm("Do you really want to change the password");
                            if(q){
				var pass = $('#txt_profile_old_password').val();
				$.ajax({
						type: "POST",
						data:{
							  txt_value:pass,
							  txt_case:'password'
							},
						url: "profile_process.php",
						success:function(response){
							if(response == 1)
							{
								var id = document.getElementById('message');
								$.ajax({
										type: "POST",
										data:{
											  txt_value:new_pass,
											  txt_case:'change'
											},
										url: "profile_process.php",
										success:function(response){
                                                                                    var actiontext = '';
                                                                                    actiontext = "User reset the Password Information successfully.";
                                                                                    $.ajax({
                                                                                            type: "POST",
                                                                                            data: {
                                                                                                    actiontext : actiontext
                                                                                                },
                                                                                            url: "track_history.php",
                                                                                            success: function(response){ 
                                                                                                alert('Password Changed Successfully.');
                                                                                                location.reload();
                                                                                            }   
                                                                                    }); 
                                                                                    
												
										}
									});
							}
							else
							{
								alert('Invalid Password');
							}
						}
				});
                            } 
                            else{
                                    location.reload();
                               }
			}
			else
			{
				alert("New Password Cannot Be Same As Old ");
				$('#txt_profile_old_password').val();
				$('#txt_profile_new_password').val();
				$('#txt_profile_new_confirm_password').val();
			}
		}
}

    $('#profilePassword').bootstrapValidator({
        message: 'This value is not valid',

        threshold: 11,
        fields: {
			password: {
                validators: {
                    notEmpty: {
                        message: 'The old password is required and can\'t be empty'
                    }
                   
                }
            },
            new_password: {
                validators: {
                    notEmpty: {
                        message: 'The new password is required and can\'t be empty'
                    },
                    regexp: {
                        regexp:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/,
                        message: 'The password must contain  at least one lowercase letter, one uppercase letter, one special symbol and a digit'
                    },
                    stringLength: {
                        min: 8,
                        message: 'The password must be 8 character long'
                    }

                }
            },
            confirmPassword: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'new_password',
                        message: 'The password and its confirm are not the same'
                    },
                    regexp: {
                        regexp:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/,
                        message: 'The password must contain  at least one lowercase letter, one uppercase letter, one special symbol and a digit'
                    },
					stringLength: {
                        min: 8,
                        message: 'The password must be 8 character long'
                    }
                }
            }
		}
    })
     .on('success.field.bv', function(e, data) {
            var $parent = data.element.parents('.form-group');
            $parent.removeClass('has-success');
			$parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
			value1 = true;
        })
		.on('error.form.bv', function(e) {
		e.preventDefault();
		var $form = $(e.target),
        bootstrapValidator1 = $form.data('bootstrapValidator');
		value1 = bootstrapValidator1.isValid();
		
	});

/*
 * Summary : This function is used to reset the password form
 */
 
function edit_form()
{
	$( "form input:text" ).css({
		background: "white",
		// border: "1px solid #ccc"
        border:"1px solid #c5e86c"
	});
	$( "form input:text" ).removeAttr("readonly");
	$(".btn-hide").css("display","inline-block");
}
function save_changes()
{
	$('#profile_info').bootstrapValidator('validate');
	if(profile)
	{
            var q = confirm("Do you really want to change the profile data");
            if(q){
		var txt_name=$('#txt_profile_name').val();
		var txt_contact=$('#txt_profile_contact').val();
		var txt_add1=$('#txt_profile_add1').val();
		var txt_add2=$('#txt_profile_add2').val();
		var txt_city=$('#txt_profile_city').val();
		var txt_pincode=$('#txt_profile_pincode').val();
		var txt_state=$('#txt_profile_state').val();
		var txt_country=$('#txt_profile_country').val();
                $.ajax({
                                type: "POST",
                                data:{
                                        txt_name:txt_name,
                                        txt_contact:txt_contact,
                                        txt_add1:txt_add1,
                                        txt_add2:txt_add2,
                                        txt_city:txt_city,
                                        txt_pincode:txt_pincode,
                                        txt_state:txt_state,
                                        txt_country:txt_country,
                                        txt_case:'profile'
                                        },
                                url: "profile_process.php",
                                success:function(response){
                                        var actiontext = '';
                                        actiontext = "User Profile Information Updated successfully.";
                                        $.ajax({
                                                type: "POST",
                                                data: {
                                                        actiontext : actiontext
                                                    },
                                                url: "track_history.php",
                                                success: function(response){ 
                                                    $( "form input:text" ).css({
                                                        background: "transparent",
                                                        border: "none"
                                                });
                                                $(".btn-hide").css("display","none");
                                                $( "form input:text" ).attr("readonly",true);
                                                alert("User Profile Information Updated successfully.");
                                                location.reload();
                                                }   
                                        }); 

                                }
                     });
            }
            else{
                 location.reload();
            }
	}
}
function cancel_changes(){
    location.reload();
}
function reset_profile_password()
{
     $('#profilePassword').data('bootstrapValidator').resetForm();
}
