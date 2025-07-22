/*
 * Name: Sign up form
 * Date: 24/7/2014
 * Create by :Mahendra Kadam
 * Summary : To valid the form tag. 
 */



$(document).ready(function() {
    $('#registrationForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
//            valid: 'glyphicon glyphicon-ok',
//            invalid: 'glyphicon glyphicon-remove',
//            validating: 'glyphicon glyphicon-refresh'
        },
//        threshold: 11,
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and can\'t be empty'
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
                        message: 'The campany name is required and can\'t be empty'
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
                        message: 'The admin name is required and can\'t be empty'
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
                        message: 'The user name is required and can\'t be empty'
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
                        message: 'The contact number is required and can\'t be empty'
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
                        message: 'The admin contact number is required and can\'t be empty'
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
                        message: 'The user contact number is required and can\'t be empty'
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
            country: {
                validators: {
                    notEmpty: {
                        message: 'The country is required and can\'t be empty'
                    }
                }
            },
            acceptTerms: {
                validators: {
                    notEmpty: {
                        message: 'You have to accept the terms and policies'
                    }
                }
            },
            adminemail: {
                validators: {
                    notEmpty: {
                        message: 'The admin email address is required and can\'t be empty'
                    },
                    
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
             useremail: {
                validators: {
                    notEmpty: {
                        message: 'The user email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            website: {
                validators: {
                    uri: {
                        allowLocal: true,
                        message: 'The input is not a valid URL'
                    }
                }
            },
            phoneNumberUS: {
                validators: {
                    phone: {
                        message: 'The input is not a valid US phone number'
                    }
                }
            },
            phoneNumberUK: {
            	validators: {
            		phone: {
            			message: 'The input is not a valid UK phone number'
            			
            		}
            	}
            },
            color: {
                validators: {
                    hexColor: {
                        message: 'The input is not a valid hex color'
                    }
                }
            },
            zipCode: {
                validators: {
                    zipCode: {
                        country: 'US',
                        message: 'The input is not a valid US zip code'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and can\'t be empty'
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
                        message: 'The confirm password is required and can\'t be empty'
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
            ages: {
                validators: {
                    lessThan: {
                        value: 100,
                        inclusive: true,
                        message: 'The ages has to be less than 100'
                    },
                    greaterThan: {
                        value: 10,
                        inclusive: false,
                        message: 'The ages has to be greater than or equals to 10'
                    }
                }
            }
        }
    })//;
     .on('success.field.bv', function(e, data) {
            

            var $parent = data.element.parents('.form-group');

  
            $parent.removeClass('has-success');


            $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
        });

});

/*
 * Name: Login form
 * Date: 24/7/2014
 * Create by :Mahendra Kadam
 * Summary : To valid the form tag. 
 */


$(document).ready(function() {
    $('#loginForm').bootstrapValidator({
        message: 'This value is not valid',
        
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and can\'t be empty'
                  }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and can\'t be empty'
                    }
                    
                }
            }
        }
    })//;
     .on('success.field.bv', function(e, data) {


            var $parent = data.element.parents('.form-group');


            $parent.removeClass('has-success');


            $parent.find('.form-control-feedback[data-bv-icon-for="' + data.field + '"]').hide();
        });
});




