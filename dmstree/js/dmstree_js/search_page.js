$(function () {
    
                $('#datetimepicker1').datetimepicker({
                    pickTime: false,
					useCurrent: false
                });
				
		$('#datetimepicker1').on("dp.show",function (e) {
                    var day=new Date();
			d=day.getDate();
			m=day.getMonth()+1;
			y=day.getFullYear();
                    var curr_day=m+"/"+d+"/"+y;
                    $('#datetimepicker1').data("DateTimePicker").setMaxDate(curr_day);//e.date);
		})

    
                $('#datetimepicker2').datetimepicker({
                    pickTime: false,
                    useCurrent: false
                });

    
                $('#datetimepicker3').datetimepicker({
                    pickTime: false,
		    useCurrent: false
                });

    
                $('#datetimepicker4').datetimepicker({
                    useCurrent: false
                });

    
                $('#datetimepicker5').datetimepicker({
                    useCurrent: false
                });
				
                                
		$("#datetimepicker4").on("dp.change",function (e) {
			var date1=$("#datetimepicker4").children(':eq(0)').val();
                        var date2=$("#datetimepicker5").children(':eq(0)').val();
			var day1,day2,mon1,mon2,year1,year2;
					if(date2!=''){
						date1=date1.split('/');
						day1=date1[0];
						mon1=date1[1];
						year1=date1[2];
						date2=date2.split('/');
						day2=date2[0];
						mon2=date2[1];
						year2=date2[2];
						var curr_day=mon2+"/"+day2+"/"+year2;
						$('#datetimepicker4').data("DateTimePicker").setMaxDate(curr_day);

					}
	            });
				
                    $("#datetimepicker4").on("dp.show",function (e) {
                        var date1=$("#datetimepicker4").children(':eq(0)').val();
                        var date2=$("#datetimepicker5").children(':eq(0)').val();
                        var day1,day2,mon1,mon2,year1,year2;
                        if(date2!=''){
                            date2=date2.split('/');
                            day2=date2[0];
                            mon2=date2[1];
                            year2=date2[2];
                            var curr_day=mon2+"/"+day2+"/"+year2;
                            $('#datetimepicker4').data("DateTimePicker").setMaxDate(curr_day);
                        }
                    });

                    $("#datetimepicker5").on("dp.change",function (e) {
			var date1=$("#datetimepicker4").children(':eq(0)').val();
			var date2=$("#datetimepicker5").children(':eq(0)').val();
					
                            if(date1!=''){
                                date1=date1.split('/');
                                day1=date1[0];
                                mon1=date1[1];
                                year1=date1[2];
                                date2=date2.split('/');
                                day2=date2[0];
                                mon2=date2[1];
                                year2=date2[2];
                                var curr_day=mon1+"/"+day1+"/"+year1;
                                $('#datetimepicker5').data("DateTimePicker").setMinDate(curr_day);
                            }
			
	            });
                    $("#datetimepicker5").on("dp.show",function (e) {
			var date1=$("#datetimepicker4").children(':eq(0)').val();
                        var date2=$("#datetimepicker5").children(':eq(0)').val();
                        var day1,day2,mon1,mon2,year1,year2;
                        if(date1!=''){
                            date1=date1.split('/');
                            day1=date1[0];
                            mon1=date1[1];
                            year1=date1[2];
                            var curr_day=mon1+"/"+day1+"/"+year1;
                            $('#datetimepicker5').data("DateTimePicker").setMinDate(curr_day);
                        }
		  });
				
    // Show/hide template select when Template Data checkbox is toggled
    $('#template_data').on('change', function() {
        if ($(this).is(':checked')) {
            $('.tempdata_txtbox').show();
        } else {
            $('.tempdata_txtbox').hide().val('');
        }
    });
});   

   

$("input:checkbox").click(function() {
    if ($(this).is(":checked")) {
        var group = "input:checkbox[name='" + $(this).attr("name") + "']";
        $(group).prop("checked", false);
        $(this).prop("checked", true);
    } else {
        $(this).prop("checked", false);
    }
});

$( "input[type='radio']" ).on( "click", function() {
  var check=$( this ).val();
  switch(check)
 {
 
            case "on_date":
                                $("#date1").css('display','block');
                                $("#date2").css('display','none');
                                $("#date3").css('display','none');
                                $("#date4").css('display','none');
                                break;
            case "before_date":
                                $("#date1").css('display','none');
				$("#date2").css('display','block');
                                $("#date3").css('display','none');
                                $("#date4").css('display','none');
                                break;
            case "after_date":
                                $("#date1").css('display','none');
                                $("#date2").css('display','none');
                                $("#date3").css('display','block');
                                $("#date4").css('display','none');
                                break;
            case "between_date":
                                $("#date1").css('display','none');
                                $("#date2").css('display','none');
                                $("#date3").css('display','none');
                                $("#date4").css('display','block');
                                break;
			case "in_week":
                                $("#date1").css('display','none');
                                $("#date2").css('display','none');
                                $("#date3").css('display','none');
                                $("#date4").css('display','none');
                                break;
			case "in_month":
                                $("#date1").css('display','none');
                                $("#date2").css('display','none');
                                $("#date3").css('display','none');
                                $("#date4").css('display','none');
							    
							   
							            
 }
 });

/*
 * Name: search page
 * Date: 22/8/2014
 * Create by :Mahendra Kadam
 * Summary : This code is used to make check box disabled . 
 */ 
 

$( "input[type='checkbox']" ).on( "click", function() {
  var check=$( this ).val();
  var chk_id=$(this).attr('id');
  if(check=='all_dateopt')
  {
      $('#rd_on_date').removeAttr('checked');
      $('#rd_before_date').removeAttr('checked');
      $('#rd_after_date').removeAttr('checked');
      $('#rd_between_date').removeAttr('checked');
      $('#rd_in_week').removeAttr('checked');
      $('#rd_in_month').removeAttr('checked');
      $("#date1").css('display','none');
      $("#date2").css('display','none');
      $("#date3").css('display','none');
      $("#date4").css('display','none');
  }
  if(check=='all' )
  {
  
	if(($('#'+chk_id).prop('checked')))
        {
		$('#comments').attr('disabled',true);
		$('#tags').attr('disabled',true);
		$('#file_name').attr('disabled',true);
		$('#template_data').attr('disabled',true);
                $('.findinfilter_andor').addClass('filter_andor1');
	}
	else{
		$('#comments').attr('disabled',false);
		$('#tags').attr('disabled',false);
		$('#file_name').attr('disabled',false);
		$('#template_data').attr('disabled',false);
                $('.findinfilter_andor').removeClass('filter_andor1');
	}
	$('#comments').attr('checked',false);
	$('#tags').attr('checked',false);
	$('#file_name').attr('checked',false);
	$('#template_data').attr('checked',false);
        $('.comment_txtbox').val('');
        $('.tag_txtbox').val('');
        $('.filename_txtbox').val('');
        $('.tempdata_txtbox').val('');
        $('.filterbox').css('display','none');
  }
  
  if(check == 'comments')
  {
       if(($('#'+chk_id).prop('checked')))
       {
          $('.comment_txtbox').css('display','block'); 
       } 
       else
       {
           $('.comment_txtbox').val('');
           $('.comment_txtbox').css('display','none'); 
       }    
         
  }
  if(check == 'tags')
  {
       if(($('#'+chk_id).prop('checked')))
       {
          $('.tag_txtbox').css('display','block'); 
       } 
       else
       {
           $('.tag_txtbox').val('');
           $('.tag_txtbox').css('display','none'); 
       }    
         
  }
  if(check == 'file_name')
  {
       if(($('#'+chk_id).prop('checked')))
       {
          $('.bouquetnm_txtbox').css('display','block'); 
       } 
       else
       {
           $('.bouquetnm_txtbox').val('');
           $('.bouquetnm_txtbox').css('display','none'); 
       }    
         
  }
  if(check == 'template_data')
  {
       if(($('#'+chk_id).prop('checked')))
       {
          $('.tempdata_txtbox').css('display','block'); 
       } 
       else
       {
           $('.tempdata_txtbox').val('');
           $('.tempdata_txtbox').css('display','none'); 
       }    
         
  }
}); 

/*-----------------------------------------------------------------------------------------------*/
/*
 * Name: search page
 * Date: 21/10/2014
 * Create by :Shubhangi Mate
 * Summary : search operation . 
 */ 

function display_filter()
{
  if ( $( "#filter:first" ).is( ":hidden" ) ) {
    $( "#filter" ).show( "slow" );
  } else {
    $( "#filter" ).slideUp();
  } 
}

function change_findinoption(allopt)
{
    var allchk_id = $(allopt).attr('id');
    if(allopt.checked)
        {
            $('#comments').attr('checked', false);
            $('#tags').attr('checked', false);
            $('#file_name').attr('checked', false);
            $('#template_data').attr('checked', false);
            $('#comments').attr('disabled','disabled');
            $('#tags').attr('disabled',true);
            $('#file_name').attr('disabled',true);
            $('#template_data').attr('disabled',true);
        }
        else
        { 
            $('#comments').attr('disabled',false);
            $('#tags').attr('disabled',false);
            $('#file_name').attr('disabled',false);
            $('#template_data').attr('disabled',false);
        }
       
}

$.facebox.settings.closeImage = 'img/closelabel.png';
$.facebox.settings.loadingImage = 'img/loading.gif';
    
function display_search_result(tenantid, departid)
{
	$( "#filter" ).slideUp();
  var searchstr = $('#search_string').val();
  
  var documentlimit = '';
  if($('input:radio[name=documentlimit]:checked'))
      {
         documentlimit = $('input:radio[name=documentlimit]:checked').val();
      }
   var selectopt = '';
   var datbasetype ='';
   var dateoption = '';
   var searchdate1 = '';
   var searchdate2 = '';
   var findfilter_nameindex = 0;
   var findfilter_valindex  = 0;
   var taglistindex         = 0; 
   var fileextindex         = 0;
   var bouquetlistindex     = 0;
   var findfilter_namearr   = new Array();
   var findfilter_valarr    = new Array();
   var taglistarray         = new Array(); 
   var fileextarray         = new Array();
   var bouquetlistarray     = new Array();
   
   
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
                                       
                                       
   
   if($('.chk_all').is(':checked')){selectopt = $('.chk_all').val();}
   if($('input[name=rd_date]:checked'))
       {
          dateoption = $('input[name=rd_date]:checked').val();
          switch(dateoption)
            {
                case "on_date"      :searchdate1 = $('#datetimepicker1 input').val();
                                        $('#datetimepicker2 input').val('');
                                        $('#datetimepicker3 input').val('');
                                        $('#datetimepicker4 input').val('');
                                        $('#datetimepicker5 input').val('');
                                        break;
                case "before_date"  :searchdate1 = $('#datetimepicker2 input').val();
                                        $('#datetimepicker1 input').val('');
                                        $('#datetimepicker3 input').val('');
                                        $('#datetimepicker4 input').val('');
                                        $('#datetimepicker5 input').val('');
                                        break;
                case "after_date"   :searchdate1 = $('#datetimepicker3 input').val();
                                        $('#datetimepicker1 input').val('');
                                        $('#datetimepicker2 input').val('');
                                        $('#datetimepicker4 input').val('');
                                        $('#datetimepicker5 input').val('');
                                        break; 
                case "between_date" :searchdate1 = $('#datetimepicker4 input').val();
                                        searchdate2 = $('#datetimepicker5 input').val();
                                        $('#datetimepicker1 input').val('');
                                        $('#datetimepicker2 input').val('');
                                        $('#datetimepicker3 input').val('');
                                        break;
                case "in_week"      :searchdate1 = '';
                                        searchdate2 = '';
                                        $('#datetimepicker1 input').val('');
                                        $('#datetimepicker2 input').val('');
                                        $('#datetimepicker3 input').val('');
                                        $('#datetimepicker4 input').val('');
                                        $('#datetimepicker5 input').val('');
                                        break; 
                case "in_month"     :searchdate1 = '';
                                        searchdate2 = '';
                                        $('#datetimepicker1 input').val('');
                                        $('#datetimepicker2 input').val('');
                                        $('#datetimepicker3 input').val('');
                                        $('#datetimepicker4 input').val('');
                                        $('#datetimepicker5 input').val('');
                                        break;                         
            }
       }
     datbasetype = $('#datatypes_select option:selected').val();
     var tempid = '';
     var andorarr = new Array();
     var andorindex = 0;
        $('#findin_chk_tbl .findin_chk').each(function(){
        var chk_id=$(this).attr('id');
        if(($('#'+chk_id).prop('checked')))
        {
            var chk_filternm = $('#'+chk_id).val();
            var rd_andor_opt1 = '';
            var rd_andor_opt2 = '';
            var rd_andor_opt3 = '';
            if($('input[name=findinfilter_andor_opt1]:checked')) {rd_andor_opt1 = $('input[name=findinfilter_andor_opt1]:checked').val();andorarr[andorindex] = rd_andor_opt1;andorindex++;}
            if($('input[name=findinfilter_andor_opt2]:checked')) {rd_andor_opt2 = $('input[name=findinfilter_andor_opt2]:checked').val();andorarr[andorindex] = rd_andor_opt2;andorindex++;}
            if($('input[name=findinfilter_andor_opt3]:checked')) {rd_andor_opt3 = $('input[name=findinfilter_andor_opt3]:checked').val();andorarr[andorindex] = rd_andor_opt3;andorindex++;}
            switch(chk_filternm)
            {
                case 'all'           :findfilter_namearr[findfilter_nameindex] = chk_filternm;
                                       findfilter_valarr[findfilter_valindex]   = chk_filternm;
                                       findfilter_nameindex++;
                                       findfilter_valindex++;
                                        break;
                case 'comments'      :var chk_commentval = $('.comment_txtbox').val();
                                       if(chk_commentval != ''){
                                         findfilter_namearr[findfilter_nameindex] = chk_filternm;
                                         findfilter_valarr[findfilter_valindex]   = chk_commentval;
                                         findfilter_nameindex++;
                                         findfilter_valindex++;  
                                       } 
                                        break;
                case 'tags'          :$('.tag_txtbox .chosen-container-multi ul li').each(function(){
                                        if($(this).find('span').length > 0)
                                        {
                                            taglistarray[taglistindex] = $(this).find('span').text();
                                            taglistindex++;
                                        }
                                        });
                                       if(taglistarray.length > 0){
                                         findfilter_namearr[findfilter_nameindex] = chk_filternm;
                                         findfilter_valarr[findfilter_valindex]   = taglistarray;
                                         findfilter_nameindex++;
                                         findfilter_valindex++;  
                                       } 
                                        break;                        
                case 'file_name'     :$('.bouquetnm_txtbox .chosen-container-multi ul li').each(function(){
                                        if($(this).find('span').length > 0)
                                            {
                                                bouquetlistarray[bouquetlistindex] = $(this).find('span').text();
                                                bouquetlistindex++;
                                            }
                                        });
                                        if(bouquetlistarray.length > 0)
                                        {
                                        findfilter_namearr[findfilter_nameindex] = chk_filternm;
                                        findfilter_valarr[findfilter_valindex]   = bouquetlistarray;
                                        findfilter_nameindex++;
                                        findfilter_valindex++;   
                                        }
                                        break;
                case 'template_data' :var searchtemp = $('.tempdata_txtbox option:selected').val();
                                       searchtemp = searchtemp.split('||');
                                       var tempname = searchtemp[0];
                                       tempid = searchtemp[1];
                                       findfilter_namearr[findfilter_nameindex] = chk_filternm;
                                       findfilter_valarr[findfilter_valindex]   = tempid;
                                       findfilter_nameindex++;
                                       findfilter_valindex++;
                                       var innerformid = $('#template').find('form').attr('id');
                                       
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
                                                    if($(this).find('input[type=text]').length > 0)
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
                                                });
                                                rowindex++;
                                            });
                                            tableidindex++;
                                        });
                                        
                                       if((textnamearray.length > 0) && (textvalarray.length > 0))
                                       {
                                            findfilter_namearr[findfilter_nameindex] = 'TextBoxName';
                                            findfilter_valarr[findfilter_valindex]   = textnamearray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;
                                            findfilter_namearr[findfilter_nameindex] = 'TextBoxValue';
                                            findfilter_valarr[findfilter_valindex]   = textvalarray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;
                                       }    
                                       if((datenamearray.length > 0) && (datevalarray.length > 0))
                                       {
                                            findfilter_namearr[findfilter_nameindex] = 'DateName';
                                            findfilter_valarr[findfilter_valindex]   = datenamearray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;
                                            findfilter_namearr[findfilter_nameindex] = 'DateValue';
                                            findfilter_valarr[findfilter_valindex]   = datevalarray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;   
                                       }
                                       if((textareanamearray.length > 0) && (textareavalarray.length > 0))
                                       {
                                            findfilter_namearr[findfilter_nameindex] = 'TextAreaName';
                                            findfilter_valarr[findfilter_valindex]   = textareanamearray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;
                                            findfilter_namearr[findfilter_nameindex] = 'TextAreaValue';
                                            findfilter_valarr[findfilter_valindex]   = textareavalarray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;
                                       }  
                                       if((selectnamearray.length > 0) && (selectvalarray.length > 0))
                                       {
                                            findfilter_namearr[findfilter_nameindex] = 'CustomListName';
                                            findfilter_valarr[findfilter_valindex]   = selectnamearray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;
                                            findfilter_namearr[findfilter_nameindex] = 'CustomListValue';
                                            findfilter_valarr[findfilter_valindex]   = selectvalarray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;   
                                       }
                                       if((radionamearray.length > 0) && (radiovalarray.length > 0))
                                       {
                                            findfilter_namearr[findfilter_nameindex] = 'RadioButtonName';
                                            findfilter_valarr[findfilter_valindex]   = radionamearray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;
                                            findfilter_namearr[findfilter_nameindex] = 'RadioButtonValue';
                                            findfilter_valarr[findfilter_valindex]   = radiovalarray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;   
                                       }
                                      
                                       if((checkboxnamearray.length > 0) && (checkboxvalarray.length > 0))
                                       {
                                            findfilter_namearr[findfilter_nameindex] = 'MultipleCheckBoxName';
                                            findfilter_valarr[findfilter_valindex]   = checkboxnamearray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;
                                            findfilter_namearr[findfilter_nameindex] = 'MultipleCheckBoxValue';
                                            findfilter_valarr[findfilter_valindex]   = checkboxvalarray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;   
                                       }
                                       if((tablenmarray.length > 0) && (tablearray.length > 0))
                                       {
                                            findfilter_namearr[findfilter_nameindex] = 'TableidName';
                                            findfilter_valarr[findfilter_valindex]   = tablenmarray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;
                                            findfilter_namearr[findfilter_nameindex] = 'TableValue';
                                            findfilter_valarr[findfilter_valindex]   = tablearray;
                                            findfilter_nameindex++;
                                            findfilter_valindex++;   
                                       }

                                        break;                           
            }
        } 
        });
        if($('#txt__file_type').val() != '')
            {
                var fileextarr =$('#txt__file_type').val();
                fileextarr = fileextarr.split(',');
                for(var extindex =0 ;extindex <fileextarr.length;extindex++)
                {
                    fileextarray[fileextindex] = fileextarr[extindex];
                    fileextindex++;
                }    
            }
            
        $('.predefinefiletype_txtbox .chosen-container-multi ul li').each(function(){
             if($(this).find('span').length > 0)
                 {
                     var optfiletext = $(this).find('span').text();
                     $('.predefinefiletype_txtbox select option').each(function(){
                            var opttext  = $(this).text();
                            var optvalue = $(this).val();
                            if(optfiletext == opttext)
                                {
                                    optvalue = optvalue.split(',');
                                    if(optvalue.length > 0)
                                        {
                                            for(var optexindex =0; optexindex < optvalue.length; optexindex++)
                                                {
                                                    fileextarray[fileextindex] = optvalue[optexindex];
                                                    fileextindex++;
                                                }
                                        }
                                    else
                                        {
                                            fileextarray[fileextindex] = optvalue;
                                            fileextindex++;
                                        }
                                }
                     });
                 }
        });

        $.ajax({
             type: "POST",
             data:{
                    searchstr          : searchstr,
                    tenantid           : tenantid,
                    departid           : departid,
                    dateoption         : dateoption,
                    searchdate1        : searchdate1,
                    searchdate2        : searchdate2,
                    findfilter_namearr : findfilter_namearr,
                    findfilter_valarr  : findfilter_valarr,
                    fileextarray       : fileextarray,
                    documentlimit      : documentlimit,
                    andorarr           : andorarr,
                    datbasetype        : datbasetype,
                    tempid             : tempid
                  },
             url: "getsmartsearchresult.php",
             success: function(response){
                 //alert(response);
                 if(response == 0)
                     {
                        var msg = "No result match !!";
                        $('.error_msg').text(msg);
                        $('#search_result_container').html('');
                        $('.error_msg').css('display','block');
                     }
                 else
                     {
                        $('.error_msg').css('display','none'); 
                        var data = response;
                        var documenthtml = '';
                        var templatelist = $('.templatenamearr').val();
                        templatelist = templatelist.split('::');
                        for(var docindex = 0; docindex < data.length; docindex++)
                            {
                                var documentid = (data[docindex]._id && data[docindex]._id['$id']) ? data[docindex]._id['$id'] : '';
                                var docname    = data[docindex].DocumentName;
                                var templateid;
                                if('TemplateId' in data[docindex]){
                                    templateid = data[docindex].TemplateId.$id;
                                }
                                // Use the first DocumentInfo element
                                var docInfo = (data[docindex].DocumentInfo && data[docindex].DocumentInfo.length > 0) ? data[docindex].DocumentInfo[0] : {};
                                var revisionno = docInfo.RevisionNo;
                                var filename   = docInfo.FileName;
                                var docexpire  = docInfo.UploadDate;
                                var docexpsec  = docexpire ? docexpire.sec : '';
                                var t = new Date(1970,0,1);
                                if(docexpsec !== '') t.setSeconds(docexpsec);
                                var revdate  = docexpsec !== '' ? moment(t).format('L') : '';
                                var fileext    = filename ? filename.split(".") : ['',''];
                                var filetype   = fileext[1] || '';
                                var templatename = '';
                                var templatfilename = '';
                                if(templateid != ''){
                                    for(var tempindex = 0; tempindex <templatelist.length; tempindex++)
                                    {
                                        var templateinfo = templatelist[tempindex].split('||');
                                        if(templateinfo[1] == templateid)
                                        {
                                            templatename    = templateinfo[0];
                                            templatfilename = templateinfo[2];
                                        }
                                    }
                                }
                                documenthtml += '<div class=" well div-padding-top div-padding-well">';
                                documenthtml += '<div class="row div-margin">';
                                if(filetype != ''){ documenthtml += '<div class="col-md-2"><img src="file_icons/'+filetype+'.png" class="fileextension" style=" height: 60px; width: 90px; object-fit:contain; border: 1px #e5e5e5;"></div>';}
                                documenthtml += '<div class="col-md-9">';
                                if(docname != '') { documenthtml += '<p class="documentname">Document Name:<a onclick="dynamicURL(\''+docname+'\',\''+revisionno+'\',\''+templatfilename+'\',\''+documentid+'\');" rel="facebox">'+docname+'</a><span class=docid" style="display:none">'+documentid+'</span></p>';}
                                documenthtml += '<p class="documentrev">Document latest revision:<span>'+revisionno+'</span></p>';
                                if(templateid != '' && templatename != ''){ documenthtml += '<p>Document Template:<span>'+templatename+'</span></p>'; }
                                if(revdate != ''){  documenthtml += '<p class="documentdate">Document Date:<span>'+revdate+'</span></p>';}
                                documenthtml += '</div>';
                                documenthtml += '<div class="col-md-1"><input type="checkbox" name="search_check" value="'+docname+'::'+revisionno+'" style="margin:auto"></div>';
                                documenthtml += '</div>';
                                documenthtml += '</div>';
                            }
                        $('#search_result_container').html(documenthtml);
                     }
             }
   });            
     
}


function dynamicURL(documentName,revisionNo,htmltemp,docid)
{
    $.facebox.settings.closeImage = 'img/close_button.png';
    $.facebox.settings.loadingImage = 'img/loading.gif';
    var ajaxpostID = "view_document.php?doc="+documentName+"&revision="+revisionNo+"&tempname="+htmltemp+"&documentid="+docid; 
    jQuery.facebox({ajax: ajaxpostID});

}
function dynamicURL1(documentName,revisionNo,docid)
{
	$.facebox.settings.closeImage = 'img/close_button.png';
    $.facebox.settings.loadingImage = 'img/loading.gif';
    var ajaxpostID = "view_document.php?doc="+documentName+"&revision="+revisionNo+"&documentid="+docid; 
    jQuery.facebox({ajax: ajaxpostID});

}
 