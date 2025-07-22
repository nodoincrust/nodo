$(document).ready(function(){
//    alert("load function");
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
    
    
    function create_table()
    {
        alert("in function");
                $('#table_modelbox').html('');
                var cntrl_id = '';
                var ctrl_type = '';
                $("#theForm").find("input, textarea, select").each(function(i,o) {
                    alert(o.name+'--'+o.value);
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
                    alert(tab_rows);
                    alert(tab_cols);
                    if(tab_rows == '' && tab_cols == '')
                        {
                            alert("in function");
                            $('#form_table').html('');
                            $('#table_modelbox').css('display','none');
                        }
                    else
                        {
                            if(cntrl_id != '' && tab_cols != '' && tab_rows != '')
                            {
                                var tbldialog = colname_popupbox(cntrl_id,tab_cols,tab_rows);
                            }    
                            else if(cntrl_id != '' && tab_cols != '' && tab_rows == '')
                            {
                                var tbldialog = changeCols_popupbox(cntrl_id,tab_cols);     
                            }
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
        var no_cols = parseInt(cols);
        var ctrl_id = tblid;
        var no_rows = parseInt(rows)+ parseInt(1);
        
        var tblContent = '';
        var count = 0;
        for(var tblrow = 0; tblrow < no_rows; tblrow++)
            {
                tblContent += '<tr id="record'+count+'">';
                for(var tblcols = 0; tblcols < no_cols; tblcols++)
                    {
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
            }
        $('#'+ctrl_id).find('table').append(tblContent);    
        $('#table_modelbox').css('display','none');

    }
    
    
    function cancel_tablechanges()
    {
        $('#table_modelbox').css('display','none');
    }