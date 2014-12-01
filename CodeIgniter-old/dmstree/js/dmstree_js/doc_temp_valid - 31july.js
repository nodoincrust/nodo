$(document).ready(function(){
//    alert("load function");
//    $("add_btn").click(function(e){e.preventDefault();})
    $( "#expiry-date" ).datepicker({dateFormat: "yy-mm-dd"});
});

function display_expiryCal()
{
    $( "#expiry-date" ).datepicker({dateFormat: "yy-mm-dd"});
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
//        alert(($('#form-title').attr('class')).split(" "));
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
    
    
    function display_minmaxlen_err(lenobj)
        {
                var flag1 =0;
                var inputval = $(lenobj).val();
                var parentid = $(lenobj).closest("div").parent(".droppedField").attr("id");
                var minlen = $(lenobj).closest("div").find(".min_length").val();
                var maxlen = $(lenobj).closest("div").find(".max_length").val();
                if((minlen == '' && maxlen == '') || (minlen == '0' && maxlen =='0'))
                    {
                        flag1 = 1;
                    }
                else
                    {
                        if( minlen == '0')
                            {
                                minlen = '';
                            }
                        if( maxlen == '0')
                            {
                                maxlen == '';
                            }
                        var inputlen = inputval.length;
                        if( minlen != '' && maxlen != '' && inputlen < minlen  && minlen < maxlen)
                            {
                            $('#'+parentid).find('.textbox_err_msg').text('This field required min '+minlen+' and max '+maxlen+' characters');
                            }
                        else if(minlen != '' && inputlen < minlen  && maxlen == '')
                            {
                                $('#'+parentid).find('.textbox_err_msg').text('This field required min '+minlen+' characters');
                            }
                        else if(minlen == '' && inputlen < maxlen && maxlen != '')
                            {
                                $('#'+parentid).find('.textbox_err_msg').text('This field required max '+maxlen+' characters');
                            }
                            else
                                {
                                $('#'+parentid).find('.textbox_err_msg').text(''); 
                                }
                    }
        }
    
    function create_table()
    {
                $('#table_modelbox').html('');
                var cntrl_id = '';
                var ctrl_type = '';
                $("#theForm").find("input, textarea, select").each(function(i,o) {
//                    alert(o.name+'--'+o.value);
                    if(o.name=='type')
                        {
                            ctrl_type = o.value; 
                        }
                    if(o.name=='forCtrl')
                    {
                        cntrl_id = o.value;
                    }
                });  
                if(ctrl_type == 'table')
                {
                    var tab_rows = $('#'+cntrl_id).find('.table_rows').val();
                    var tab_cols = $('#'+cntrl_id).find('.table_cols').val();
//                    alert(tab_rows);
//                    alert(tab_cols);
                    if(tab_rows == '' && tab_cols == '')
                        {
                            $('#form_table').html('');
                            $('#table_modelbox').css('display','none');
                        }
                    else
                        {
                            
                            var tbldialog = '';
                            if(cntrl_id != '' && tab_cols != '' && tab_rows != '')
                            {
                                 tbldialog = colname_popupbox(cntrl_id,tab_cols,tab_rows);
                            }    
                            else if(cntrl_id != '' && tab_cols != '' && tab_rows == '')
                            {
                                 tbldialog = changeCols_popupbox(cntrl_id,tab_cols);     
                            }
//                            alert($('#'+cntrl_id).find('#form_table tbody').html());
//                            $('#'+cntrl_id).find('#form_table tbody').html('');
                            $('#table_modelbox').html('');
//                            alert($('#'+cntrl_id).find('#form_table tbody').html());
                            $('#table_modelbox').append(tbldialog);
                            $('#table_modelbox').css('display','block');
                        }
                    
                }
      
    }
    
    function colname_popupbox(tab_id,tab_cols,tab_rows)
    {
        var tblpopup = '';
        var cols = tab_cols;
        var tablediv_id = tab_id;
        for(var i = 1; i <= cols; i++)
            {
               tblpopup +='<p class="row"><label class="col-md-3">Column'+i+' Label: </label><input class="col-md-9 col" type="text" id="col'+i+'" value=""></p>';
            }
        var tableDialog  = '';
        tableDialog += '<div id="customization_table_modal" name="customization_table_modal" class="modal hide fade in titlepopup" aria-hidden="false" style="display: block;">';
        tableDialog += '<div class="modal-header"><h3>Table Header</h3></div>';
        tableDialog += '<div class="modal-body"><form id="table_header" class="form-horizontal">';
        tableDialog += tblpopup;
        tableDialog += '</div>';
        tableDialog += '<div class="modal-footer">';
        tableDialog += '<button class="btn btn-primary" onclick="get_columnHeader('+cols+','+tab_rows+',\''+tablediv_id+'\')">Save Changes</button>';
        tableDialog += '<button class="btn" onclick="cancel_tablechanges()">Cancel</button>';
        tableDialog += '</div></div>';
//        '+tab_id+','+cols+','+tab_rows+' tblid,cols,rows
        return tableDialog;
    }
    
    function get_columnHeader(cols,rows,tblid)
    {
        var colTitle = new Array();
        $('#table_header p').each(function(){
            var colum_heading = $(this).find('input.col').val();
            colTitle.push(colum_heading);
        });
//        alert(colTitle.join("\n"));
        var no_cols = parseInt(cols);
        var ctrl_id = tblid;
        var no_rows = parseInt(rows)+ parseInt(1);
        
        var tblContent = '';
        var count = 1;
        for(var tblrow = 0; tblrow < no_rows; tblrow++)
            {
                tblContent += '<tr id="record'+count+'">';
                for(var tblcols = 0; tblcols < no_cols; tblcols++)
                    {
//                        alert(colTitle[tblcols]);
                       if(tblrow == 0) 
                           {
                               tblContent += '<th>'+colTitle[tblcols]+'</th>';
                           }
                       else
                           {
                               tblContent += '<td><input type="text" class="tbl_td"></td>';
                           }
                    }
                tblContent += '</tr>'
                count++;
            }
        $('#'+ctrl_id).find('table tbody').html('');    
        $('#'+ctrl_id).find('table').append(tblContent);    
        $('#table_modelbox').css('display','none');

    }
    
    
    function cancel_tablechanges()
    {
        $('#table_modelbox').css('display','none');
    }
    
    
    function add_rowToTable(add_btncntrl)
    {
        var colcount = 0;
        var cntrl_id = $(add_btncntrl).closest('div').parent().parent().attr('id');
        var no_cols = $('#'+cntrl_id).children().find('.table_div table tbody tr:first th').length;
        var trContent = '';
        var record_id = parseInt(no_cols) + 1;
        trContent += '<tr id="record'+record_id+'">';
        for(var i = 0; i < no_cols; i++)
            {
               trContent +='<td><input type="text" class="tbl_td"></td>';
            }
        trContent +='</tr>';  
        $('#'+cntrl_id).children().find('.table_div table tbody').append(trContent);
//        alert($('#'+cntrl_id).children().find('.table_div table tbody').html());
    }
    
    function valid_form()
    {
        
            $('#doc_template .required_field').each(function(){
                if($(this).is('input'))
                    {
                        var cntrl_id = $(this).parent().parent().attr('id');
//                        alert(cntrl_id);
                        var inputType = $(this).attr('type');
                        if(inputType == 'text')
                            {
                                if($(this).val() == '')
                                    {
                                        $(this).parent().find('.required_msg').text('This is required Text field');
                                    }
                                else
                                    {
                                        $(this).parent().find('.required_msg').text('');
                                    }
                            }
                        else if(inputType == 'password')
                            {
                                if($(this).val() == '')
                                {
                                    $(this).parent().find('.required_msg').text('This is required Password field');
                                }  
                                else
                                    {
                                        $(this).parent().find('.required_msg').text('');
                                    }
                            }
                      
                    }
                    if($(this).is('textarea'))    
                    {
                        var cntrl_id = $(this).parent().parent().attr('id');
//                        alert("textarea id:"+cntrl_id);
                        if($(this).val() == '')
                                {
                                    $(this).parent().find('.required_msg').text('This is required Textarea');
                                } 
                                else
                                    {
                                        $(this).parent().find('.required_msg').text('');
                                    }
                    }
                 if($(this).is('select'))
                    {
                        var cntrl_id = $(this).parent().parent().attr('id');
//                        alert("select id:"+cntrl_id);
                        if( ($(this).val() == '') || ($(this).val() == null))
                        {
                            $(this).parent().find('.required_msg').text('This is required Select List');
                        }
                        else
                            {
                                $(this).parent().find('.required_msg').text('');
                            }
                    }
                 if($(this).is('div'))
                    {
                        var cntrl_id = $(this).parent().attr('id');
//                        alert("div id:"+cntrl_id);
                        var radioValFlag = 0;
                        var chkValFlag = 0;
                        
                        $(this).children().each(function(){
                            
                            if($(this).children().attr('type') == 'radio')
                                {
                                   if($(this).children().is(':checked'))
                                    {
                                        radioValFlag = 1;
                                    } 
                                }
                            else if($(this).children().attr('type') == 'checkbox')
                                {
                                    if($(this).children().is(':checked'))
                                    {
                                        chkValFlag = 1;
                                    } 
                                }
                            
                        });
                       
                        if($(this).children().children().attr('type') == 'radio')
                            {
                                if( radioValFlag != '1')
                                {
                                    $(this).parent().find('.required_msg').text('This is Required RadioField');
                                }
                                else
                                    {
                                        $(this).parent().find('.required_msg').text('');
                                    }
                            }
                        else if($(this).children().children().attr('type') == 'checkbox')
                            {
                                if(chkValFlag != '1')
                                {
                                    $(this).parent().find('.required_msg').text('This is Required CheckboxField');
                                }
                                else
                                    {
                                        $(this).parent().find('.required_msg').text('');
                                    }
                            }
                            
                    }
                 
            });
    }