
function gettemplatedata(innerformid)
{
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

if(innerformid != undefined)
{
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
