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
    
/*------------------------------------- Just added function created by Mahendra --------------------------------------*/

function reset_upload(){
    location.reload();
}  

$(function () {
		//var cur_date;
                $('#datetimepicker').datetimepicker({
                   // pickTime: true,
					useCurrent: false
                });
								
				$("#datetimepicker").on("dp.show",function (e) {
					var curr= $("#datetimepicker").children(':eq(0)').val();
					// if(curr!='')
					// {
						var day=new Date();
						d=day.getDate();
						m=day.getMonth()+1;
						y=day.getFullYear();
						//alert(d.toString().length);
						if (d.length == 1)
						{
						//	alert('in daaaaay');
							d = "0" + d;
						}
						if (m.length == 1)
						{
							m = "0" + m;
						}
						//$( '#datetimepicker').datetimepicker({ minDate: new Date()});
						// d=d-1;
						 var curr_day=m+"/"+d+"/"+y;
						// alert(curr_day);
						$('#datetimepicker').data("DateTimePicker").setMinDate(curr_day);//e.date);
						//$('#datetimepicker').datetimepicker('setStartDate', '09-01-2014');
						//alert(curr_day);
						var curr_day=d+"/"+m+"/"+y;
						if(curr >= curr_day)
						{
							alert('You can\'t select the previous date as expire date');
							$("#datetimepicker").children(':eq(0)').val("");
						}
					
					//}
					
				});
				

				
});
/*----------------------------------- new js for Physical upload by Shubhangi ----------------------------------------*/
  function add_browse_control()
{
    var file_html = '';
    var last_browse_id = $('#browse_file_group input:last').attr('id');
    var browse_id = last_browse_id.split('doc_file');
    var totalrecord = parseInt(browse_id[1]);
    totalrecord = parseInt(totalrecord);
    var newrecord = parseInt(totalrecord) + 1;
    if(newrecord <= 5)
        {
            if($('#doc_file'+totalrecord).val() != ''){
            file_html +='<div class="row" id="file_record'+newrecord+'"><span class="col-md-10">';
            file_html += '<input type="file" name="sfile'+newrecord+'" id="doc_file'+newrecord+'" class="form-control upload_control" /></span>';
            file_html += '<span class="col-md-2 file_delete"><img src="file_icons/ico_cancel.png" class="cancel_file'+newrecord+'" onclick="delete_filerecord(this)"></span></div>';
            $(file_html).insertAfter('#file_record'+totalrecord);
            }
            else
            {
              alert("Please select previous file");      
            }
        }
    else
        {
            alert("cann't add more record");
        }
}

function delete_filerecord(curr_filerecord)
{
    var ask=confirm("Are you sure you want to delete this record?");
        if(ask){
             $(curr_filerecord).parent().parent().remove();
        }
}

$('#chk_physical_loc').change(function(){
    if($('#chk_physical_loc').is(':checked'))
        {
            $('#div_pic').show();
        }
    else
        {
            $('#div_pic').hide();
        }
});

function display_template(optvalue)
{
    if(optvalue == '')
    {
        $("#template").html('');
        $("#template").removeClass('active');
        $("#template").css("border","none");
    }   
    else
    {
        var tenantname = $('.tenantname').val();
        var tenantid   = $('.tenantid').val();
        var filedata = optvalue.split('||');
        var filename = filedata[0];
        var tempid = filedata[1];
        var temppath = filedata[2];
        $('.templateid').val(tempid);
        var newpath = temppath+'/'+filename;
        $("#template").css("border","1px solid gainsboro");
        $("#template").load(newpath, function() {
            $("#template").addClass('active');
        });
    }    
}
 
 function refresh_filediv(rdname)
 {
    if(rdname == 'Single')
        {
           $('#mulitiple_add').css('display','none'); 
           $('#browse_file_group .row').each(function(){
               $(this).remove();
           });
           var filediv = '';
           filediv +='<div class="row" id="file_record1">';
           filediv +='<span class="col-md-10"><input type="file" name="sfile1" id="doc_file1" class="form-control upload_control " /></span>';
           filediv +='</div>';
           
           $('#browse_file_group').append(filediv);
        }
    if(rdname == 'Multiple') 
        {
           $('#mulitiple_add').css('display','block');
           $('#browse_file_group .row').each(function(){
               $(this).remove();
           });
           var filediv = '';
           filediv +='<div class="row" id="file_record1">';
           filediv +='<span class="col-md-10"><input type="file" name="sfile1" id="doc_file1" class="form-control upload_control " /></span>';
           filediv +='</div>';
           
           $('#browse_file_group').append(filediv);
        }
 }
 /*------------------------------------------------------------------------------------------------------------------------------------*/
 //Date:12 sep 2014
// Modify By: Shubhangi Mate
// Screen : Upload document
 /*------------------------------------------------------------------------------------------------------------------------------------*/
 
 function validate_uploaddocument(outerform)
 {
    var fileflag   = 0;
    var filename = '';
    var filepath = '';
    var fileindex  = 0;
    var filearray  = new Array();
    var type ='new';
    var tenantname = $('.tenantname').val();
    var tenantid = $('.tenantid').val();
    var filenamecheckout = '';
    var revision = $('.revision').val();
    var documentname = $('.documentname').val();
    var flag = true;
     filenamecheckout =$('#documentid').val();
    $('#browse_file_group .row').each(function(){
        filename = $(this).find('input').val();
        if(documentname)
        {
            type = 'revision';
            var lastindex = filename.lastIndexOf('\\');
            lastindex = parseInt(lastindex)+ 1;
            filename = filename.slice(lastindex);
            var file = filename.split(".");
            //alert(file[0]+' '+filenamecheckout);
            if(file[0] == documentname)
            {
                flag = true;
            }
            else
            {
                flag = false;
            }
            
            
        }
        //alert(filenamecheckout);
//alert(flag);
        if( filename != '' && flag )
            {
                fileflag = 1;
                var lastindex = filename.lastIndexOf('\\');
                lastindex = parseInt(lastindex)+ 1;
                filename = filename.slice(lastindex);
                tenantname = tenantname.replace(/ /g,"_");
                filepath = "DMSTree_clients/"+tenantname+"_"+tenantid+"/Documents";
                filearray[fileindex] = filename;
                fileindex++;
                
            }
     });
     if(fileflag == 0)
        {
            alert("please select the document");
        }
     else
         {
             var taglistindex         = 0;
             var taglistarray         = new Array(); 
             $('.chosen-container-multi ul li').each(function(){
             if($(this).find('span').length > 0)
                 {
                     taglistarray[taglistindex] = $(this).find('span').text();
                     taglistindex++;
                 }
             });
             var selected_templatename = $('#template').find('form').length ;
             //var selected_templatename = $('.template').val();
             if((selected_templatename == 0)&&(taglistarray.length == 0))
             {
                 alert("Please apply the tags or select the template");
             } 
             else
             {
                 var innerformid = $('#template').find('form').attr('id');
                 var templateflag       = 0;
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
                 
                 var docexpirydate = $('.docexpirydate').val(); 
                 var departmenid = '';
                 if($('.departmentid').val() != '')
                 {
                     departmenid = $('.departmentid').val();
                 }    
                 var userid = $('.userid').val();
                 var tempid = '';
                 var documentid = $('.documentid').val();
                 var isPrivate = $('#makeprivate').is(':checked');
                 //alert(isPrivate);
                 if(innerformid != undefined)
                 {
                     if(valid_form())
                     {
                         tempid = $('.templateid').val();
                         templateflag = 1;
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
                                        //alert("if" +tdval+'--'+rowindex+'||'+columnindex+'--'+columnindex+'--'+tableindex);
                                        if(tdval != '')
                                            {
                                                var tddetail = rowindex+'||'+columnindex+'||'+tdval+'||'+tblid;
                                                tablearray[tableindex] = tddetail;
                                                    tableindex++;
                                            }
                                            columnindex++;
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
                     }    
                 } 
                 var physicallocurl = '';
                 if($('.physicallocationimg').length > 0)
                     {
                         physicallocurl = $('.physicallocationimg').attr('src');
                     }
                 var phyloctags = '';
                 if($('.revwithoutsess').length > 0)
                     {
                        phyloctags = $('.revwithoutsess').val();
                     }
             
                 
                 
                 var submitflag = 0;
                 
                 if((innerformid != undefined && taglistarray.length > 0) || (innerformid != undefined && taglistarray.length == 0))
                 {
                     if(templateflag == 1) { submitflag = 1}
                 } 
                 else if(innerformid == undefined && taglistarray.length > 0)
                 {
                     submitflag = 1;
                 }
                 if(submitflag == 1)
                 {
                    // alert(phyloctags+'  '+physicallocurl+' 9');
                     $.ajax({
                                        type: "POST",
                                        data: {
                                            tenantid : tenantid,
                                            departmenid: departmenid,
                                            tempid : tempid,
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
                                            filearray : filearray,
                                            filepath : filepath,
                                            userid : userid,
                                            revision:revision,
                                            documentid:filenamecheckout,
                                            type:type,
                                            physicallocurl : physicallocurl,
                                            phyloctags : phyloctags,
                                            isPrivate:isPrivate

                                        },
                                        url: "savedocument.php",
                                        success: function(msg){
										//alert(msg);
                                           if(revision != '')
                                               {
                                                   $.ajax({
                                                            type: "POST",
                                                            data: {
                                                                    revision : revision,
                                                                    filenamecheckout : filenamecheckout,
                                                                    isPrivate:isPrivate
                                                                  },
                                                            url: "setCheckoutdocumentstatus.php",
                                                            success: function(response){ 
                                                                //alert(response);
                                                            }   
                                                          });
                                               }
                                            var defaultval = 1;
                                            $.ajax({
                                                            type: "POST",
                                                            data: {
                                                                    defaultval : defaultval
                                                                  },
                                                            url: "setImagetagsession.php",
                                                            success: function(response){ 
                                                            }   
                                             });
                                             
                                            if(msg){
                                                
                                                var filecount = filearray.length;
                                                var actiontext = '';
                                                if(type == 'new')
                                                    {
                                                        actiontext = filecount+'New document are uploaded';
                                                    }
                                                else
                                                    {
                                                        actiontext = 'Created next Revision of '+documentname+' document';
                                                    }
                                                    $.ajax({
                                                            type: "POST",
                                                            data: {
                                                                    actiontext : actiontext
                                                                  },
                                                            url: "track_history.php",
                                                            success: function(response){ 
                                                                 alert("Document Save successfully");
                                                                 setTimeout(function(){document.uploadDocumentForm.submit();}, 2000);
                                                            }   
                                                    }); 
                                                
                                               //location.reload();
                                            }     
                                        }
                            });
                 }
                 else 
                 {
                     alert("Please filled the required fileds");
                 }
                                     
             }    
             
         }
 }