$(document).ready(function() {
    $('#uploadDocumentForm').bootstrapValidator({
        message: 'This value is not valid',
        
        fields: {
            subfile: {

                validators: {
                    notEmpty: {
                        message: 'The browse filed is required and can\'t be empty'
                  }
                }
            },
            date: {
                validators: {
                    date: {
                        message: 'The date is not valid',
                        format: 'YYYY/MM/DD'
                    },
                    callback: {
                        message: 'The date is not in the range',
                        callback: function(value, validator) {
                            var m = new moment(value, 'YYYY/MM/DD', true);
                            if (!m.isValid()) {
                                return false;
                            }
                            // Check if the date in our range
                            return m.isAfter(new Date());
                            alert(new Date());
                        }
                    }
                }
            },
            sfile: {

                validators: {
                    notEmpty: {
                        message: 'The browse filed is required and can\'t be empty'
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

jQuery(function($){

var textover_api;

$('#target').TextOver({}, function() {
textover_api = this;
});

$('#show').click(function () {
html = '';
$.each(textover_api.getData(), function() {
html +=  this.text + '<br />'; //'Text &raquo; ' +' Left &raquo; ' + this.left + ' Top &raquo; ' + this.top +
});
$('#data').html(html).show();
});

});

function display_temp(d)
{
   $("#"+d).css("display", "block");
}
function display_temp1(d)
{
     $("#"+d).css("display", "none");
}

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                $('#target').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#txt_pic").change(function(){
        readURL(this);
    });
    
    
    function readnewURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
                $('#targetdiv').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            apply_taging();
        }
    }
    
    function apply_taging()
    {
        alert("in taging");
        $("#targetdiv").tag();
    }
    
    $("#browse_loc_img").change(function(){
        readnewURL(this);
    });
/*----------------------------------- new js for Physical upload by Shubhangi ----------------------------------------*/
function display_physicalblock()
{
    if($('#chk_physicalloc').is(':checked'))
        {
            $('.physical_loc_div').show();
        }
    else
        {
            $('.physical_loc_div').hide();
        }
}