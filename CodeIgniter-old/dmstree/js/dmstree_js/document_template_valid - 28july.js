$(document).ready(function(){
//    alert("load function");
    $( "#expiry-date" ).datepicker({ dateFormat: "yy-mm-dd" });
});

function display_expiryCal()
{
    $( "#expiry-date" ).datepicker({ dateFormat: "yy-mm-dd" });
}

function readURL(input) {
    
                        var formValues = {};
                        var val=null;
                        var cntrl_id = '';
                        $("#theForm").find("input, textarea, select").each(function(i,o) {
                            if(o.name=='forCtrl')
                                    {
                                        cntrl_id = o.value;
                                    }
                            if(o.name=="form_image")
                                    {
                                       
                                        if (input.files && input.files[0]) {
                                                var reader = new FileReader();

                                            reader.onload = function (e) {
                                                $('#'+cntrl_id).find('.fimage')
                                                    .attr('src', e.target.result)
                                                    .width(120)
                                                    .height('auto');
                                            };

                                                 reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                        });
        
    }
    
    
    function open_logoimage_popup()
    {
        $('#customization_logo_modal').css('display','block');
    }
    
    function readURLlogo(input1) {
       
        if (input1.files && input1.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#logo_image')
                    .attr('src', e.target.result)
                    .width(120)
                    .height('auto');
            };

            reader.readAsDataURL(input1.files[0]);
        }
    }
    
    function save_logochanges()
    {
//        save_changes.common();
         $('#headerForm').val('');   
         $('#customization_logo_modal').css('display','none');
        
    }
    
    function cancel_formlogo()
    {
        $('#customization_logo_modal').css('display','none');
    }
    
    function open_title_popup()
    {
       $('#customization_title_modal').css('display','block'); 
    }
    function save_titlechanges()
    {
        var formtitle = $('#handlebars-title-label').val();
        $('#form-title').val(formtitle);
        var titlefont =$('#form-title').closest('div').find('.titlelabel_font').val();
        $('#form-title').addClass(titlefont);
         var titlesize =$('#form-title').closest('div').find('.titlelabel_size').val();
         alert(($('#form-title').attr('class')).split(" "));
         $('#form-title').addClass(titlesize);
        $('#customization_title_modal').css('display','none'); 
    }
    function cancel_formtitle()
    {
        $('#customization_title_modal').css('display','none'); 
    }
    function change_titlefont(titlefont)
    {
        if(titlefont == 'bold')
            {
                $('#form-title').removeClass('italicfont');
                $('#handlebars-title-label').css("font-style","normal");
                $('#handlebars-title-label').css("font-weight","bold");
                $('#form-title').closest('div').find('.titlelabel_font').val('boldfont');
            }
       else if(titlefont == 'italic')
            {
                $('#form-title').removeClass('boldfont');
                $('#handlebars-title-label').css("font-weight","normal");
                $('#handlebars-title-label').css("font-style","italic");
                $('#form-title').closest('div').find('.titlelabel_font').val('italicfont');
            } 
       else if(titlefont == 'normal')
            {
                $('#form-title').removeClass('italicfont');
                $('#form-title').removeClass('boldfont');
                $('#handlebars-title-label').css("font-weight","normal");
                $('#handlebars-title-label').css("font-style","normal");
                $('#form-title').closest('div').find('.titlelabel_font').val('');
            }     
    }
    
    function change_titlesize(titlesize)
    {
                        if(titlesize == '22')
                        {
                            $('#form-title').removeClass('midtitle');
                            $('#form-title').removeClass('largetitle');
                            $('#handlebars-title-label').css("font-size","22px");
                            $('#form-title').closest('div').find('.titlelabel_size').val('smalltitle');
                        } 
                        else if(titlesize == '24')
                        {
                            $('#form-title').removeClass('smalltitle');
                            $('#form-title').removeClass('largetitle');
                            $('#handlebars-title-label').css("font-size","24px");
                            $('#form-title').closest('div').find('.titlelabel_size').val('midtitle');    
                        }
                        else if(titlesize == '26')
                        {
                            $('#form-title').removeClass('smalltitle');
                            $('#form-title').removeClass('midtitle');
                            $('#handlebars-title-label').css("font-size","26px");
                            $('#form-title').closest('div').find('.titlelabel_size').val('largetitle');
                        }   
    }