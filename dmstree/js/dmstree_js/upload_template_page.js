$(function()
{
	$('.chosen-select').chosen();
});
function display_template(optvalue)
 {
     var tenantname = $('.tenantname').val();
     var tenantid   = $('.tenantid').val();
     if(optvalue != ''){
        var filedata = optvalue.split('||');
        var filename = filedata[0];
        var tempid = filedata[1];
        var temppath = filedata[2];
        $('.templatename').val(filedata[3]);
        $('.templateid').val(tempid);
        tenantname = tenantname.replace(" ","_");
        var newpath = temppath+'/'+filename;
        $("#template").css("border","1px solid gainsboro");
        $("#template").load(newpath);
     }
     else{
          $("#template").css("border","none");
          $("#template").empty();
     }
 }
 function reload_page()
 {
     location.reload();
 }
 function validate_uploaddocument(outerform)
 {
	var selected_template =  $('#select_template option:selected').text();
	var tenantid = $('.tenantid').val();
        var type ='new';
	if(selected_template == "")
	{
		alert("Please Select The Template");
	}
	else
	{
		if(valid_form())
		{
			var selected_templatename = $('.template').val();
			var innerformid = $('#template').find('form').attr('id');
			var tenantname = $('.tenantname').val();
			
			var filename = '';
			var filepath = '';
			var fileflag   = 0;
			var fileindex  = 0;
			var filearray  = new Array();
			var labelindex         = 0;
			var textnameindex      = 0;
			var textvalindex       = 0;
			var datenameindex      = 0;
			var datevalindex       = 0;
			var textareanameindex  = 0;
			var textareavalindex   = 0;
			var selectnameindex    = 0;
			var selectvalindex     = 0;
			var radionameindex     = 0;
			var radiovalindex      = 0;
			var checkboxnameindex  = 0;
			var checkboxvalindex   = 0;
			var tableindex         = 0;
			var tableidindex       = 0;
			var taglistindex       = 0;    
			 
			var labelarray           = new Array();
			var textnamearray        = new Array();
			var textvalarray         = new Array();
			var datenamearray        = new Array();
			var datevalarray         = new Array();
			var textareanamearray    = new Array();
			var textareavalarray     = new Array();
			var selectnamearray      = new Array();
			var selectvalarray       = new Array();
			var radionamearray       = new Array();
			var radiovalarray        = new Array();
			var checkboxnamearray    = new Array();
			var checkboxvalarray     = new Array();
			var tablearray           = new Array();
			var tablenmarray         = new Array();
			var taglistarray         = new Array();    
			 
			$('.chosen-container-multi ul li').each(function(){
				if($(this).find('span').length > 0)
				{
					taglistarray[taglistindex] = $(this).find('span').text();
					taglistindex++;
				}
			});
			  
			var docexpirydate = $('.docexpirydate').val();
			 
			$('#'+innerformid+' label').each(function(){
				var labelname = $(this).text();
				var labelclass = $(this).attr('class');
				var searchlabelresult = labelclass.search('requiredcls');
				if(searchlabelresult == '-1')
				{
					labelarray[labelindex] = labelname;
					labelindex++;
				}
					 
			});
			 
			$('#'+innerformid+' input[type=text]').each(function(){
				var textboxname = $(this).attr('name');
				var textboxvalue = $(this).val();
				var tblinput = $(this).attr('class');
				var tblsearchresult = tblinput.search('tbl_td');
				var dateinputresult = tblinput.search('.datepicker');
				if(textboxvalue != '' && tblsearchresult == '-1' && dateinputresult == '-1')
				{
					textnamearray[textnameindex] = textboxname;
					textvalarray[textvalindex]   = textboxvalue;
					textnameindex++;
					textvalindex++;
				}   
				else if(dateinputresult > 0 && textboxvalue != '')
				{
					datenamearray[datenameindex] = textboxname;
					datevalarray[datevalindex]   = textboxvalue;
					datenameindex++;
					datevalindex++;
				}
			});
			 
			$('#'+innerformid+' textarea').each(function(){
				var textarename = $(this).attr('name');
				var textareavalue = $(this).val();
				if(textareavalue != '')
				{
					textareanamearray[textareanameindex] = textarename;
					textareavalarray[textareavalindex]   = textareavalue; 
					textareanameindex++;
					textareavalindex++;
				} 
			});
			 
			$('#'+innerformid+' select').each(function(){
				var selectname = $(this).attr('name');
				var selectvalue = $(this).val();
				var selectmultiattr = $(this).attr('multiple');
				if(selectvalue != '' && selectvalue != null)
					{
						selectnamearray[selectnameindex] = selectname;
						selectvalarray[selectvalindex]   = selectvalue;
						selectnameindex++;
						selectvalindex++;  
					} 
			 });
			 
			$('#'+innerformid+' input[type=radio]').each(function(){
				var radioname = $(this).attr('name');
				var radiovalue = $(this).val();
				if($(this).is(":checked"))
				{
					radionamearray[radionameindex] = radioname;
					radiovalarray[radiovalindex]= radiovalue;
					radionameindex++;
					radiovalindex++;
				}   
				
			});
			 
			$('#'+innerformid+' input[type=checkbox]').each(function(){
				var checkboxname = $(this).attr('name');
				var checkboxvalue = $(this).val();
				if($(this).is(":checked"))
					{
						checkboxnamearray[checkboxnameindex] = checkboxname;
						checkboxvalarray[checkboxvalindex] = checkboxvalue;
						checkboxnameindex++;
						checkboxvalindex++;
					}
			});
			 
			$('#'+innerformid+' table').each(function(){
				var tblid = $(this).attr('id');
				tablenmarray[tableidindex] = tblid;
				var rowindex = 0;
				$(this).find('tbody tr').each(function(){
					var columnindex = 0;
					$(this).children().each(function(){
						if($(this).find('input[type=text]').length)
						{
							var tdval = $(this).find('input').val();
								if(tdval != '')
								{
									var tddetail = rowindex+'||'+columnindex+'||'+tdval+'||'+tblid;
									tablearray[tableindex] = tddetail;
									columnindex++;
									tableindex++;
								}
						}
						else
						{
							var thval =$(this).text();
							var thdetail = rowindex+'||'+columnindex+'||'+thval+'||'+tblid;
							tablearray[tableindex] = thdetail;
							columnindex++;
							tableindex++;
						}
					});
					rowindex++;
				});
				tableidindex++;
			});
			 
			 
			 
			var tempid = $('.templateid').val();
			var departmenid = $('.departmentid').val();
			var userid = $('.userid').val();
			
			var tempname = $('.templatename').val();
			$.ajax({
					type: "POST",
					data: {
						tenantid : tenantid,
						departmenid: departmenid,
						tempid : tempid,
						tempname : tempname,
						labelarray:labelarray,
						textnamearray :textnamearray,
						textvalarray : textvalarray,
						textareanamearray : textareanamearray,
						textareavalarray : textareavalarray,
						selectnamearray : selectnamearray,
						selectvalarray : selectvalarray,
						radionamearray : radionamearray,
						radiovalarray : radiovalarray,
						checkboxnamearray : checkboxnamearray,
						checkboxvalarray : checkboxvalarray,
						tablenmarray : tablenmarray,
						tablearray : tablearray,
						datenamearray : datenamearray,
						datevalarray : datevalarray,
						taglistarray : taglistarray,
						docexpirydate : docexpirydate,
						userid : userid,
                        type:type
					},
					url: "savedocument.php",
					success: function(msg){
							msg = msg.trim();
                                                        if(msg){
                                                            var actiontext = '';
                                                                actiontext = tempname+' Template save successfully';
                                                                $.ajax({
                                                                        type: "POST",
                                                                        data: {
                                                                                actiontext : actiontext
                                                                            },
                                                                        url: "track_history.php",
                                                                        success: function(response){ 
                                                                            alert("Template Save successfully");
                                                                            location.reload();
                                                                        }   
                                                                }); 
							}     
						}
					});
		}
		else
		{
			alert("fail validation");
		}
	}
   
 }