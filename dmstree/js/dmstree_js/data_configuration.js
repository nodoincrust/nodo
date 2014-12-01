var slider;
/* 
 * Summary : This code is for tags 
 */
$('#hero-demo').tagEditor({
	placeholder: 'Enter tags ...',
	forceLowercase:true,
	onChange: function(field, editor, tags) {
	        // $('#response').prepend(
            // 'Tags changed to: ' + (tags.length ? tags.join(', ') : '----') + '<hr>'
        // );
    },
    beforeTagSave: function(field, editor, tags, tag, val) {
        //$('#response').prepend('Tag ' + val + ' saved' + (tag ? ' over ' + tag : '') + '.');
		$.ajax({
				type: "POST",
				data:{
						old_tag:tag,
						new_tag:val,
						type:'updateTag'
					 },
				url: "data_configuration_process.php",
				success:function(response){
                                    var actiontext = '';
                                    actiontext = val+" tag added successfully.";
                                    $.ajax({
                                                type: "POST",
                                                data: {
                                                    actiontext : actiontext
                                                },
                                                url: "track_history.php",
                                                success: function(response){ 
                                                    alert(val+'Tag added Successfully.');
                                                }   
                                            }); 
				}
		});
    },
    beforeTagDelete: function(field, editor, tags, val) {
        var q = confirm('Remove tag "' + val + '"?');
        if (q)
        {
             $.ajax({
                    type: "POST",
                    data:{
                                    tag:val,
                                    type:'findTag'
                             },
                    url: "data_configuration_process.php",
                    success:function(msg){
                            if(msg == 'success'){
                                                   $.ajax({
                                                            type: "POST",
                                                             data:{
                                                                    tag:val,
                                                                    type:'deleteTag'
                                                                    },
                                                            url: "data_configuration_process.php",
                                                            success:function(response){
                                                                var actiontext = '';
                                                                actiontext = val+" tag deleted successfully.";
                                                                $.ajax({
                                                                            type: "POST",
                                                                            data: {
                                                                                actiontext : actiontext
                                                                            },
                                                                            url: "track_history.php",
                                                                            success: function(response){ 
                                                                                //alert('Standared List deleted Successfully.');
                                                                            }   
                                                                        });
                                                            }
                                                        });
                                
                            }
                            else if(msg == 'failed')
                            {
                                alert('The ' + val + ' Tag has used in documents.');
                                $('.tag-editor').append('<li><div class="tag-editor-spacer">&nbsp;,</div><div class="tag-editor-tag">'+val+'</div><div class="tag-editor-delete"><i></i></div></li>');
                            }
                      }
                });
                }
                else 
                {
                        alert('Removal of ' + val + ' discarded.');
                }
                return q;
   } 
});
 

var address;
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {
				address = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

$('#file_add').change(function(){
	readURL(this);
});

/*****/

$(document).ready(function(){
	$('#text_description').css('display','none');
	$('#list_std_update').css('display','none');
	$('#add_slider').css('display','none');
});

var flag;

$(document).ready(function() {
	$('#add_std').bootstrapValidator({
        message: 'This value is not valid',
		// threshold: 11,
		fields: {
					optionsRadios: {
									validators: {
										notEmpty: {
											message: 'Select any one radio button.'
										}
									}
								},            
					listname:{
								validators: {
									notEmpty: {
											message: 'The list name is required and can\'t be empty'
										}
									}
								},
					txtarea_add_std:{
									validators: {
										notEmpty: {
											message: 'The list code and list is required and can\'t be empty'
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

var list_array = [];
var code_array = [];
var i = 0;
var id;
function add_to_list()
{
	str = "";
        var list = $('#list').val();
        var code = $('#code').val();
        if(code !=''){
            $('#text_description').css('display','block');
            str ='<option value="'+list+'::'+code+'">'+list+'-'+code+'</option>';
            $('#list_std').append(str);
            $('#list').val('');
            $('#code').val('');
        }
        else if(code == ''){
            $('#text_description').css('display','block');
            str ='<option value="'+list+'">'+list+'</option>';
            $('#list_std').append(str);
            $('#list').val('');
            $('#code').val('');
        }

}
$('#list_std').dblclick(function(){
    len = $('#list_std option').length;
    if(len>0)
    {
        str = $('#list_std option:selected').val();
        list = str.split("::");
        $('#list').val(list[0]);
        $('#code').val(list[1]);
        $('#list_std option:selected').remove();
     }
     else{
         $('#text_description').css('display','none'); 
     }
});
$('#txtarea_add_std').focusout(function(){
	text_value = $('#txtarea_add_std').val();
	if(text_value === "")
	{
		$('#text_description').css('display','none');
	}
});
function save_std_list()
{
    i=0;
	var list_name = $("#txt_list_name_add").val();
        $("#list_std > option").each(function(){
            str = $(this).val();
            list = str.split("::");
            if(list[1]!='')
            {
                list_array[i] = list[0];
                code_array[i] = list[1];
                i++;
            }
            else 
            {
                list_array[i] = list[0];
                code_array[i] = '';
                i++;
            }
        });
      	var select_option = $( "input:checked" ).val();
	$('#add_std').bootstrapValidator('validate');
	if(flag)
	{
		$.ajax({
				type: "POST",
				data:{
						list_name:list_name,
						code:code_array,
						list:list_array,
						select_option:select_option,
						type:'standardList'
					 },

				url: "data_configuration_process.php",
				success:function(response){
                                    var actiontext = '';
                                    actiontext = "User create new list/combo successfully.";
                                    $.ajax({
                                                type: "POST",
                                                data: {
                                                    actiontext : actiontext
                                                },
                                                url: "track_history.php",
                                                success: function(response){ 
                                                    alert('Standared List created Successfully.');
                                                }   
                                            }); 
					location.reload();
				}
		});
	}
}

function delete_std_list()
{
	id = $('#sel_std_list option:selected').attr('id');
	var q = confirm('Do You Really Want To Delete');
    if (q)
	{
	$.ajax({
				type: "POST",
				data:{
						id:id,
						type:'OptionListDelete'
					 },

				url: "data_configuration_process.php",
				success:function(response){
                                    var actiontext = '';
                                    actiontext = "User delete standared list successfully.";
                                    $.ajax({
                                                type: "POST",
                                                data: {
                                                    actiontext : actiontext
                                                },
                                                url: "track_history.php",
                                                success: function(response){ 
                                                    alert('Standared List deleted Successfully.');
                                                }   
                                            });
					location.reload();	
				}
	
		});
	}	
}

$( "#sel_std_list_update" ).change(function() {
	id = $('#sel_std_list_update option:selected').attr('id');
	listname = $('#sel_std_list_update option:selected').text();
	if($(this).val()!='select')
	{
		$.ajax({
				type: "POST",
				data:{
						id:id,
						type:'OptionList'
					 },

				url: "data_configuration_process.php",
				success:function(response){
                                                //alert(response);
						data = $.parseJSON(response);
						var code = data.code;
						var list = data.list;
						$('#sel_std_list_description_update').find('option').remove().end();
						var str = "<option value='select' id='select_std_list_update'>Select STD Description</option>";
						for(listcount = 0;listcount < list.length;listcount++)
						{
							if(code[listcount] != '')
							{
								str += "<option value ="+list[listcount]+"-"+code[listcount]+">"+list[listcount]+"-"+code[listcount]+"</option>";
							}
							else if(code[listcount] == '')
							{
								str += "<option value ="+list[listcount]+">"+list[listcount]+"</option>";
							}
						}
						$('#sel_std_list_description_update').append(str);
						$('#txt_edit_name').val(listname);
						$('#editlist').val("");
						$('#editcode').val("");
				}
		});
	}
	else{
	}
});

$('#sel_std_list_description_update').change(function(){
	list = $('#sel_std_list_description_update option:selected').text();
	list = list.split('-');
	if($(this).val()!='select')
	{
		$('#editlist').val(list[0]);
		$('#editcode').val(list[1]);
	}
	else
	{
	}
});

function remove_list_description()
{
	id = $('#sel_std_list_update option:selected').attr('id');
	list = $('#editlist').val();
	code = $('#editcode').val();
	var q = confirm('Do You Really Want To Delete');
    if (q)
	{
		$.ajax({
					type: "POST",
					data:{
							id:id,
							list:list,
							code:code,
							type:'OptionListUpdate'
						 },

					url: "data_configuration_process.php",
					success:function(response){
							$('#sel_std_list_update').change();
					}
			});
	}	
}
$('#sel_std_list').change(function(){
	listname = $('#sel_std_list').val();
	
	if(listname == 'select')
	{
		$('#btn_std_delete').attr('disabled',true);
	}
	else
	{
		$('#btn_std_delete').removeAttr('disabled');
	}
});

$('#btn_std_delete').click(function (){
	id = $('#sel_std_list option:selected').attr('id');
	listname = $('#sel_std_list option:selected').text();
	$('#txt_list_name_delete').val(listname);
	
});
var codearray = [];
var listarray = [];
var counter = 0;
function add_option_std_list()
{
	listname = $('#sel_std_list_update').val();
	code = $('#editcode').val();
	list = $('#editlist').val();
	str = '';
	if(listname != 'select')
	{
		
		if(list != '')
		{
			if(code != '')
			{
                            $('#list_std_update').css('display','block');
                            str ='<option value="'+list+'::'+code+'">'+list+'-'+code+'</option>';
                            $('#list_std_update').append(str);
//				str += list+'-'+code+'\n';
//				codearray[counter] = code;
//				listarray[counter] = list;
			}
			else 
			{
                            $('#list_std_update').css('display','block');
                            str ='<option value="'+list+'">'+list+'</option>';
                            $('#list_std_update').append(str);
//				str += list+'\n';
//				listarray[counter] = list;
			}
			counter++;
//			$('#update_add_std').append(str);
			code = $('#editcode').val("");
			list = $('#editlist').val('');
		}
		else
		{
			alert('List Description is Required');
		}
	}
	else
	{
		alert("Select List");
	}
}
$('#list_std_update').dblclick(function(){
    len = $('#list_std_update option').length;
    if(len>0)
    {
        str = $('#list_std_update option:selected').val();
        list = str.split("::");
        $('#editlist').val(list[0]);
        $('#editcode').val(list[1]);
        $('#list_std_update option:selected').remove();
     }
     else{
         $('#list_std_update').css('display','none'); 
     }
});
function update_std()
{
	id = $('#sel_std_list_update option:selected').attr('id');
	name = $('#txt_edit_name').val();
	textarea_value = $('#update_add_std').val();
	text_array = [];
	text_val = [];
	code = [];
	list = [];
        i=0;
        $("#list_std_update > option").each(function(){
            str = $(this).val();
            list = str.split("::");
            if(list[1]!='')
            {
                list[i] = list[0];
                code[i] = list[1];
                i++;
            }
            else 
            {
                list[i] = list[0];
                code[i] = '';
                i++;
            }
        });
	str = $('#editlist').val();
	if(str == '')
	{
		$.ajax({
					type: "POST",
					data:{
							id:id,
							list:list,
							code:code,
							name:name,
							type:'OptionListUpdateInfo'
						 },

					url: "data_configuration_process.php",
					success:function(response){
                                            var actiontext = '';
                                            actiontext = "User updated standared list successfully.";
                                            $.ajax({
                                                    type: "POST",
                                                    data: {
                                                        actiontext : actiontext
                                                    },
                                                    url: "track_history.php",
                                                    success: function(response){ 
                                                        alert('Standared List updated Successfully.');
                                                    }   
                                            });
							$('#sel_std_list_update').change();
							$('#update_add_std').val('');
					}
		
			});
	}
	else
	{
		alert('What Function Is need To Do On Edit Description Textbox ?');
	}
}
$('#txt_gallery_photo').change(function(){
	readURL(this);

});
$('#file_add').change(function(){
	readURL(this);
});

$('#addPhoto').click(function(e){
	str = $('#txt_gallery_photo').val();
	if(str != '')
	{
		$('#add_slider').css('display','block');
		$("#add_photo_form").submit();
		htmlentity='<li>';
		htmlentity+='<button type="button" class="close" onclick="deletePic(this);">';
		htmlentity+='<span aria-hidden="true" class="close1">×</span>';
		htmlentity+='<span class="sr-only">Close</span>';
		htmlentity+='</button>';
		htmlentity+='<img src="'+address+'" style="heigth:50px;" />';
		htmlentity+='</li>';
		//alert(htmlentity);

		e.preventDefault();
		
		
	}
	else{
		alert("Please select photo");
	}
});

$('#addPhotoGallery').click(function(e){
	str = $('#file_add').val();
	if(str != '')
	{
		$("#update_photo_gallary_form").submit();
		htmlentity='<li>';
		htmlentity+='<button type="button" class="close" onclick="deletePic(this);">';
		htmlentity+='<span aria-hidden="true" class="close1">×</span>';
		htmlentity+='<span class="sr-only">Close</span>';
		htmlentity+='</button>';
		htmlentity+='<img src="'+address+'" style="height:150px; width:200px;" />';
		htmlentity+='</li>';
		e.preventDefault();
		$('#file_add').val('');
	}
	else{
		alert("Please select photo");
	}
	
});


function clickupdate(e){
	$('.bx-viewport').css('height','160px');
	$('.bx-loading').css('display','none');
	$('.bx-wrapper').children(':eq(1)').css('display','none');
}


function deletePic(txt)
{
	var img_id = $(txt).parent().children(':eq(1)').attr('id');
	$(txt).parent().remove();
	//alert (img_id);
	$.ajax({
					type: "POST",
					data:{
							name:img_id,
							type:'deletePhoto'
						 },

					url: "data_configuration_process.php",
					success:function(response){
					}
		
			});
}
function deletePic1(txt)
{
	var img_id = $(txt).parent().children(':eq(1)').attr('id');
	$(txt).parent().remove();
	//alert (img_id);
	$.ajax({
					type: "POST",
					data:{
							name:img_id,
							type:'deletePhoto'
						 },

					url: "data_configuration_process.php",
					success:function(response){
					}
		
			});
}
$("#add_photo_form").submit(function(e)
{
	var formObj = $(this);
		var formData = new FormData(this);
                var imgvalue = $('#txt_gallery_photo').val();
                imgvalue = imgvalue.split('\\');
                var imgname = imgvalue[imgvalue.length - 1];
                var img_name = imgname;
                var tenantid = $('#tenantid').val();
                var tenantname =$('#tenantname').val();
                var loc = 'DMSTree_clients/'+tenantname+'_'+tenantid+'/Images/';
		$.ajax({
        	url: "data_configuration-add.php",
			type: "POST",
			data:  formData,
			mimeType:"multipart/form-data",
			contentType: false,
                        cache: false,
			processData:false,
			success: function(data)
		    {
                        
                                var actiontext = '';
                                actiontext = "Photo added in PhotoGallery successfully.";
                                            $.ajax({
                                                    type: "POST",
                                                    data: {
                                                        actiontext : actiontext
                                                    },
                                                    url: "track_history.php",
                                                    success: function(response){ 
                                                        alert('Photo added in gallary Successfully. Click on image to apply tags');
                                                        $('#txt_gallery_photo').val('');
                                                        $('#photogallery_add').slideUp();  
                                                        $('#photogallery').slideDown();
                                                        location.reload();

                                                    }   
                                            });
		    }	        
	   });
        e.preventDefault();
});

function OpenWindowWithPost(url, windowoption, name, params) {
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", url);
            form.setAttribute("target", name);
            for (var i in params) {
                if (params.hasOwnProperty(i)) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = i;
                    input.value = params[i];
                    form.appendChild(input);
                }
            }
            
            document.body.appendChild(form);
            window.open("", name, windowoption);
            form.submit();
            document.body.removeChild(form);
        }
        
        
$("#update_photo_gallary_form").submit(function(e)
{
	var formObj = $(this);
		var formData = new FormData(this);
		$.ajax({
        	url: "data_configuration-add.php",
			type: "POST",
			data:  formData,
			mimeType:"multipart/form-data",
			contentType: false,
                        cache: false,
			processData:false,
			success: function(data)
		    {
				//alert(data);
                                var actiontext = '';
                                actiontext = "PhotoGallery updated successfully.";
                                            $.ajax({
                                                    type: "POST",
                                                    data: {
                                                        actiontext : actiontext
                                                    },
                                                    url: "track_history.php",
                                                    success: function(response){ 
                                                        alert('PhotoGallery updated Successfully.');
                                                    }   
                                            });
				location.reload();
		    }	        
	   });
        e.preventDefault();
});
function refresh_std_list()
{
 $('#add_std').data('bootstrapValidator').resetForm();
}