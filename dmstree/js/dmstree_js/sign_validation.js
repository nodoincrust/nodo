/*
 * Name: Sign up form
 * Date: 24/7/2014
 * Create by :Mahendra Kadam
 * Summary : To valid the form tags. 
 */

var bootstrapValidator;
var value1 = true;
$('#registrationForm').bootstrapValidator({
    message: 'This value is not valid',
    feedbackIcons: {
    },
    threshold: 11,
    fields: {
        username: {
            message: 'The username is not valid',
            validators: {
                notEmpty: {
                    message: 'The username is required'
                },
                stringLength: {
                    min: 6,
                    max: 30,
                    message: 'The username must be more than 6 and less than 30 characters long'
                },
                regexp: {
                    regexp: /^[a-zA-Z0-9_\.]+$/,
                    message: 'The username can only consist of alphabetical, number, dot and underscore'
                }
            }
        },
        companyname: {
            message: 'The company name is not valid',
            validators: {
                notEmpty: {
                    message: 'The company name is required'
                },
                stringLength: {
                    min: 6,
                    max: 30,
                    message: 'The campany name must be more than 6 and less than 30 characters long'
                }
            }
        },

        adminname: {
            message: 'The admin name is not valid',
            validators: {
                notEmpty: {
                    message: 'The admin name is required'
                },
                stringLength: {
                    min: 5,
                    max: 20,
                    message: 'The admin name must be more than 6 and less than 30 characters long'
                },
                regexp: {
                    regexp: /^[a-zA-Z\ ]+$/,
                    message: 'The admin name can only consist of alphabet.'
                }
            }
        },
        individualname: {
            message: 'The user name is not valid',
            validators: {
                notEmpty: {
                    message: 'The user name is required'
                },
                stringLength: {
                    min: 6,
                    max: 30,
                    message: 'The user name must be more than 6 and less than 30 characters long'
                },
                regexp: {
                    regexp: /^[a-zA-Z\ ]+$/,
                    message: 'The user name can only consist of alphabet.'
                }
            }
        },
        phonenumber: {
            message: 'The contact number is not valid',
            validators: {
                notEmpty: {
                    message: 'The contact number is required'
                },
                stringLength: {
                    min: 10,
                    max: 10,
                    message: 'The contact number must be equale to 10'
                },
                regexp: {
                    regexp: /^[0-9]+$/,
                    message: 'The contact number can only consist of  number'
                }
            }
        },
        admincontact: {
            message: 'The admin contact number is not valid',
            validators: {
                notEmpty: {
                    message: 'The admin contact number is required'
                },
                stringLength: {
                    min: 10,
                    max: 10,
                    message: 'The admin contact number must be equale to 10'
                },
                regexp: {
                    regexp: /^[0-9]+$/,
                    message: 'The admin contact number can only consist of  number'
                }
            }
        },
        usercontact: {
            message: 'The user contact number is not valid',
            validators: {
                notEmpty: {
                    message: 'The user contact number is required'
                },
                stringLength: {
                    min: 10,
                    max: 10,
                    message: 'The user contact number must be equale to 10'
                },
                regexp: {
                    regexp: /^[0-9]+$/,
                    message: 'The user contact number can only consist of  number'
                }
            }
        },
        adminemail: {
            validators: {
                notEmpty: {
                    message: 'The admin email address is required'
                },

                emailAddress: {
                    message: 'The input is not a valid email address'
                }
            }
        },
        useremail: {
            validators: {
                notEmpty: {
                    message: 'The user email address is required'
                },
                emailAddress: {
                    message: 'The input is not a valid email address'
                }
            }
        },
        password: {
            validators: {
                notEmpty: {
                    message: 'The password is required'
                },
                identical: {
                    field: 'confirmPassword',
                    message: 'The password and its confirm are not the same'
                }
            }
        },
        confirmPassword: {
            validators: {
                notEmpty: {
                    message: 'The confirm password is required'
                },
                identical: {
                    field: 'password',
                    message: 'The password and its confirm are not the same'
                }
            }
        },
        corporateoptionsRadiosPackage: {
            validators: {
                notEmpty: {
                    message: 'The Package is required'
                }
            }
        },
        individualoptionsRadiosPackage: {
            validators: {
                notEmpty: {
                    message: 'The Package is required'
                }
            }
        },
        security_question: {
            validators: {
                notEmpty: {
                    message: 'The Security Question is required'
                }
            }
        },
        security_answer: {
            validators: {
                notEmpty: {
                    message: 'The Security Answer is required'
                }
            }
        },
        'listbox_size[]': {
            validators: {
                notEmpty: {
                    message: 'The Package in Size is required'
                }
            }
        },
        'listbox_month[]': {
            validators: {
                notEmpty: {
                    message: 'The Package in Month is required',
                    enabled: function($field, validator) {
                        return $('input[name="optionsRadios"]:checked').val() === 'Individual';
                    }
                }
            }
        },
        'optionsRadios': {
            validators: {
                notEmpty: {
                    message: 'Please select a package type (Individual or Corporate)'
                }
            }
        },
        address1: {
            validators: {
                notEmpty: {
                    message: 'The Address is required'
                }
            }
        },
        address2: {
            validators: {
                notEmpty: {
                    message: 'The Address is required'
                }
            }
        },
        city: {

            validators: {
                notEmpty: {
                    message: 'The city is required'
                },
                regexp: {
                    regexp: /^[a-zA-Z\ ]+$/,
                    message: 'The city can only consist of  alphabet'
                }
            }
        },
        state: {
            validators: {
                notEmpty: {
                    message: 'The state is required'
                },
                regexp: {
                    regexp: /^[a-zA-Z\ ]+$/,
                    message: 'The state can only consist of  alphabet'
                }
            }
        },
        country: {
            validators: {
                notEmpty: {
                    message: 'The country is required'
                },
                regexp: {
                    regexp: /^[a-zA-Z\ ]+$/,
                    message: 'The country can only consist of  alphabet'
                }
            }
        },
        recaptcha_response_field: {
            validators: {
                notEmpty: {
                    message: 'The captcha is required'
                }
            }

        },
        pincode: {
            validators: {
                notEmpty: {
                    message: 'The pincode is required'
                },
                stringLength: {
                    min: 6,
                    max: 6,
                    message: 'The pincode must be equale to 6'
                },
                regexp: {
                    regexp: /^[0-9]+$/,
                    message: 'The city can only consist of  alphabet'
                }
            }
        }
    }
})
    .on('success.field.bv', function (e, data) {
        e.preventDefault();
        var $parent = data.element.parents('.form-group');
        $parent.removeClass('has-success');
        $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
    })
    .on('error.form.bv', function (e) {
        e.preventDefault();
        var $form = $(e.target),
            bootstrapValidator1 = $form.data('bootstrapValidator');
        value1 = bootstrapValidator1.isValid();
    });

/*
 * Summary : To select individual or corporate and then package, depending on package display the infornation.  
 */


$("input[type='radio']").on("click", function () {
    var check = $(this).val();
    var rate1 = 100;
    var rate2 = 200;
    var rate3 = 300;
    var tax_rate = 0.10;
    var recharge_one_month = 1;
    var recharge_six_month = 3;
    var recharge_nine_month = 9;
    var today = new Date().toString('M/d/yyyy');

    switch (check) {
        case "Corporate":


            $(".individual1").prop("checked", false);
            $(".individual1").prop("disabled", true);
            $(".corporate1").prop("disabled", false);
            $("#txt_package").val("");
            $("#txt_recharge_date").val("");
            $("#txt_package_price").val("");
            $("#txt_taxes").val("");
            $("#txt_total_amount").val("");
            $(".individual").hide();
            break;
        case "Individual":


            $(".corporate1").prop("checked", false);
            $(".corporate1").prop("disabled", true);
            $(".individual1").prop("disabled", false);
            $("#txt_package").val("");
            $("#txt_recharge_date").val("");
            $("#txt_package_price").val("");
            $("#txt_taxes").val("");
            $("#txt_total_amount").val("");
            $(".individual").show();
            break;
        case "individual_package1":
            $("#txt_package").val("Package-1");
            $("#txt_recharge_date").val(recharge_one_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
            $("#txt_package_price").val(rate1);
            tax = rate1 * tax_rate;
            $("#txt_taxes").val(tax);
            price = rate1 + tax;
            $("#txt_total_amount").val(price);
            break;
        case "individual_package2":
            $("#txt_package").val("Package-2");
            $("#txt_recharge_date").val(recharge_six_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
            $("#txt_package_price").val(rate2);
            tax = rate2 * tax_rate;
            $("#txt_taxes").val(tax);
            price = rate2 + tax;
            $("#txt_total_amount").val(price);
            break;
        case "individual_package3":
            $("#txt_package").val("Package-3");
            $("#txt_recharge_date").val(recharge_nine_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
            $("#txt_package_price").val(rate3);
            tax = rate3 * tax_rate;
            $("#txt_taxes").val(tax);
            price = rate3 + tax;
            $("#txt_total_amount").val(price);
            break;
        case "corporate_package1":
            $("#txt_package").val("Package-1");
            $("#txt_recharge_date").val(recharge_one_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
            $("#txt_package_price").val(rate1);
            tax = rate1 * tax_rate;
            $("#txt_taxes").val(tax);
            price = rate1 + tax;
            $("#txt_total_amount").val(price);
            break;
        case "corporate_package2":
            $("#txt_package").val("Package-2");
            $("#txt_recharge_date").val(recharge_six_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
            $("#txt_package_price").val(rate2);
            tax = rate2 * tax_rate;
            $("#txt_taxes").val(tax);
            price = rate2 + tax;
            $("#txt_total_amount").val(price);
            break;
        case "corporate_package3":
            $("#txt_package").val("Package-3");
            $("#txt_recharge_date").val(recharge_nine_month.months().fromNow().addDays(-1).toString('M/d/yyyy'));
            $("#txt_package_price").val(rate3);
            tax = rate3 * tax_rate;
            $("#txt_taxes").val(tax);
            price = rate3 + tax;
            $("#txt_total_amount").val(price);
            break;
    }
});

$("input[type='radio']").click(function () {
    packagetype = $(this).val();

    $.ajax({
        type: "POST",
        data: {
            package_type: packagetype
        },
        url: "sign_up_process.php",
        success: function (response) {
            var data = $.parseJSON(response);
            var packagename = data.name;
            var packageis = data.is;
            $('.select_size').empty();
            $('.select_month').empty();
            for (i = 0; i < packageis.length; i++) {
                if (packageis[i] == 'Size') {

                    $htmlentity = '<option value="' + packagename[i] + '" id="">' + packagename[i] + ' </option>';
                    $('.select_size').append($htmlentity);
                }
                if (packageis[i] == 'Duration') {

                    $htmlentity = '<option value="' + packagename[i] + '" id="">' + packagename[i] + ' </option>';
                    $('.select_month').append($htmlentity);
                }
            }
        }
    });

});
function validCaptcha() {
    recaptcha_challenge = $('#recaptcha_challenge_field').val();
    recaptcha_response = $('#recaptcha_response_field').val();
}

function sumitForm() {
    document.getElementById("formDemo").submit();
}

function valdationForm() {
    $('#registrationForm').bootstrapValidator('validate');

    if (value1) {
        document.getElementById("registrationForm").submit();
    }
}
// function valdationForm()
// {
//   $('#registrationForm').bootstrapValidator('validate');
// 	//alert(value1);
// 	if(value1)
// 	{
//             recaptcha_challenge=$('#recaptcha_challenge_field').val();
//             recaptcha_response=$('#recaptcha_response_field').val();
// 		$.ajax({
// 				type: "POST",
// 				data:{
//                                         recaptcha_challenge_field:recaptcha_challenge,
//                                         recaptcha_response_field:recaptcha_response
//                                         },
// 				url: "sign_up_captcha.php",
// 				success:function(response){
//                                     //alert(response);
// 					if(response == "success"){
//                                             document.getElementById("registrationForm").submit();
//                                         }
//                                          else if(response == "fail")
//                                          {
//                                                 Recaptcha.reload();
//                                                 alert('Invalid Captcha Please Re-Enter ..');
//                                          }
// 				}
//                         });

//     }
// // if (value1) {
// //     document.getElementById("registrationForm").submit();
// // }
// }
$("select").change(function () {
    var str = "";
    var str1 = "";
    var cnt = 0;
    var cnt1 = 0;
    list_name = $(this).attr('name');
    if (list_name == 'listbox_size[]') {
        $(".select_size option:selected").each(function () {
            str += $(this).text() + " ";
            cnt++;
        });
        if (cnt > 2) {
            alert('Sorry You Cannot Select More Than Two');
            $(".select_size option:selected").each(function () {
                $(this).prop('selected', false);
            });
        }
    }
    if (list_name == 'listbox_month[]') {
        $(".select_month option:selected").each(function () {
            str1 += $(this).text() + " ";

            cnt1++;
        });
        if (cnt1 > 2) {
            alert('Sorry You Cannot Select More Than Two');
            $(".select_month option:selected").each(function () {
                $(this).prop('selected', false);
            });
        }
    }
    string = str + " " + str1;
    $("#txt_package").val(string);
})

/*
 * Summary : To reset the sign up form 
 */

function reset_registrationform() {
    $('#registrationForm').data('bootstrapValidator').resetForm();
}


/*
 * Summary : To reset the login form 
 */
function reset_loginform() {
    $('#loginForm').data('bootstrapValidator').resetForm();

}
// jQuery(document).ready(function($) {
//     $('a[rel*=facebox]').facebox({
//         loadingImage : 'facebox-master/src/loading.gif',
//         closeImage   : 'facebox-master/src/closelabel.png'
//     })
// })    





















