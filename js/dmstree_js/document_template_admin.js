 /*
  *File Name: Document_template js
  *Created Date: 23 july 2014
  *Created By: Shubhangi Mate
  *Modify By:Mahendra Kadan
  *Modified Date: 
  */
  $(document).ready(function(){
        var msg = "<?php if(isset($_GET['msg'])){ echo $_GET['msg'];}?>";
        if(msg == 1)
            {
                alert("Template created successfully");
            }
    });
    function select_sub_domain(){
     var domain = $('#domain option:selected').val();
     id = $('#domain_id').val();
     str = '<option value="select"> Select Sub Domain</option>';

     if(domain != '')
     {
        $.ajax({
                type:"POST",
                data:{
                    id:id,
                    domain:domain,
                    type:"getsubdomain"
                },
                url:"view_domain_process.php",
                success:function(response){
                    data = $.parseJSON(response);
                    var subdomain = data.subDomain;
                    var len = data.subDomain.length;
                    for(index = 0; index < len; index++){
                        str +='<option value="'+ subdomain[index]+'">'+subdomain[index]+'</option>';
                    }
                    $('#sub_domain').empty();
                    $('#sub_domain').append(str);
                }
        });
    }
}
 $(document).ready(docReady); 
	/* GA tracking */
	  (function() {
		var ga = document.createElement('script');ga.type = 'text/javascript';ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(ga, s);
                      })();

        /* Make the control draggable */
        function makeDraggable() {

            $(".selectorField").draggable({helper: "clone",stack: "div",cursor: "move", cancel: null});   
        }

        var _ctrl_index = 1001;
        function docReady() {
                    console.log("document ready");
                    compileTemplates();
    
                    makeDraggable();
    
                    $( ".droppedFields" ).droppable({
                        activeClass: "activeDroppable",
                        hoverClass: "hoverDroppable",
                        accept: ":not(.ui-sortable-helper)",
                        drop: function( event, ui ) {
                        var draggable = ui.draggable;
                        draggable = $(ui.draggable).find(".modele").clone();
                        draggable.removeClass("modele");
                        draggable.removeClass("selectorField");
                        draggable.addClass("droppedField row row-fluid");
                        draggable[0].id = "CTRL-DIV-"+(_ctrl_index++); // Attach an ID to the rendered control
                        draggable.appendTo(this);				

                        /* Once dropped, attach the customization handler to the control */
                        draggable.click(function () {          
                                    // The following assumes that dropped fields will have a ctrl-defined. 
                                    //   If not required, code needs to handle exceptions here.

                                    var me = $(this)
                                    var ctrl = me.find("[class*=ctrl]")[0];
                                    var ctrl_type = $.trim(ctrl.className.match("ctrl-.*")[0].split(" ")[0].split("-")[1]);
                                    customize_ctrl(ctrl_type, this.id);
                                });

                        makeDraggable();
                    }
                    });	
    

        /* Make the droppedFields sortable and connected with other droppedFields containers*/
        $( ".droppedFields" ).sortable({
                        cancel: null, // Cancel the default events on the controls
                        connectWith: ".droppedFields"
        }).disableSelection();


        // Affichage du div pour la suppression d'un tableau
        $("#divDeleteTableau").hide();
        $('.droppedFields').mouseenter(function () {
        tableauToDelete = this;
        $("#divDeleteTableau").show();
        $("#divDeleteTableau").position({
            my: "right top",
            at: "right top",
            of: $(this).parent().children().last()
        });
        });
        $('.droppedFields').mouseleave(function () {
            $("#divDeleteTableau").hide();
        });
        $('#divDeleteTableau').mouseenter(function () {
            $("#divDeleteTableau").show();
        });

        $("#sliderNbColonne").slider({
            min: 1,
            max: 4,
            value: 1,
            slide: function (event, ui) {
                $("#nbColonne").html(ui.value);
        }
        });
        $("#nbColonne").html($("#sliderNbColonne").slider("value"));


        // Permet le trie des "tableaux"
        $("#selected-content").sortable({
        cancel: null,      
        start: function (event, ui) {
            $("#divDeleteTableau").hide();
        }
        }).disableSelection();
        
        }     /* end od docready function*/
  


        // Ajout de tableau  ADD table
        function ajouterTableau() {
                var bValid = true;          
                if (bValid) {
                var nbColonne = $("#sliderNbColonne").slider("value");


                var contentToAdd = "<div class=\"row row-fluid\">";
                var largeurSpan = 12 / nbColonne;
                for (var i = 0; i < nbColonne; i++) {
                    if($('#framebox').is(':checked'))
                    {
                        contentToAdd += "<div class=\"span" + largeurSpan + " col-md-"+largeurSpan+" framebox well droppedFields\"></div>";
                        $("#framebox").attr('checked', false); 
                    }
                    else
                    {
                        contentToAdd += "<div class=\"span" + largeurSpan + " col-md-"+largeurSpan+" well droppedFields\"></div>";   
                    }
                }
                contentToAdd += "</div>";
                $('#dialog-form-nombre-colonne').modal('hide');
                $("#selected-content").append(contentToAdd);
                docReady();
               }
        }
        
        
        
        // Suppression de tableau Delete table
        var tableauToDelete = null;
        function supprimerTableau() {
            if (tableauToDelete) {   
            if (window.confirm("Are you sure you want to delete this container?")) {
                $("body").append($("#divDeleteTableau")); 
                $(tableauToDelete).parent().remove();
                tableauToDelete = null;
                $("#divDeleteTableau").hide();
            }
            }
        }
        
        /*
            Preview the customized form 
            -- Opens a new window and renders html content there.
        */
       
        function preview() 
		{
            var result = validateTemplateForm();
			slected_domain = $('#domain option:selected').val()
			$('.domain_temp').val(slected_domain);
			if(slected_domain != 'select')
			{
                           sub_domain = $('#sub_domain option:selected').val()
                           $('.subdomain').val(sub_domain);
                            if(sub_domain != 'select')
                            {
                            
				if(result != false)
				{
					if(result == true)
					{
						if(validateTables())
						{
							 console.log('Preview clicked');
		
							// Sample preview - opens in a new window by copying content -- use something better in production code
							var selected_content = $("#selected-content").clone();
							selected_content.find("div").each(function(i,o) {
								var obj = $(o)
								obj.removeClass("draggableField ui-draggable well ui-droppable ui-sortable");
							});
							
							var form_logo = $("#logo_image").closest('div').html();
							var logo_src = $("#logo_image").attr('src');
							var legend_text = $("#form-title")[0].value;
							$('.template_name').val(legend_text);
							var legend_font = $('#form-title').closest('div').find('.titlelabel_font').val();
							var legend_size = $('#form-title').closest('div').find('.titlelabel_size').val();
							var form_desc = $("#form-description").val();
							$('.template_desc').val(form_desc);
							if(legend_text=="") {
								legend_text="Form builder demo";
							}
							selected_content.find("#form-title-div").remove();
		
							var selected_content_html = selected_content.html();
						  
							var dialogContent = '';

							dialogContent +='<style>\n'+$("#content-styles").html()+'\n</style>\n';
							dialogContent+= '<form name="doc_template" id="doc_template" class="doc_template" style="width:800px; margin:10px auto;">';
							if(logo_src != '')
							{
								dialogContent+= '<legend><div class="row row-fluid"><div class="col-md-2 span2">'+form_logo+'</div><div class="col-md-10 span10"><p class="'+legend_font+' '+legend_size+' temp_title">'+legend_text+'</p></div></div></legend>';  
							}
							else{
								dialogContent+= '<legend><p class="'+legend_font+' '+legend_size+' temp_title">'+legend_text+'</p></legend>';
							}    
							if(form_desc != '')
							{
								dialogContent+= '<p>'+form_desc+'</p>';        
							}
							dialogContent+= selected_content_html;
							dialogContent+='<div class="row form_btn">';
							dialogContent+='<input type="button" class="btn" value="Reset" onclick="#">';
							dialogContent+='</div>';
							dialogContent+='<div class="row bottom_note">';
							dialogContent+='<p><b>Note:</b></p>';
							dialogContent+='<p>The fields with <span class="manditory_fields"> * </span>are required/manditory fields.</p>'
							dialogContent+='</div>';
							dialogContent+= '\n</body></html>';

							dialogContent = dialogContent.replace('\n</body></html>','');
							dialogContent+= '\n</form>';
							
							
							var newTemplate = '';
							newTemplate += '<html lang="en-US">';
							newTemplate += '<head>';
							newTemplate += '<meta charset="UTF-8">';
							newTemplate += '<title>Template Form</title>';
							newTemplate += '<link  rel="stylesheet" href="bootstrap/css/bootstrap.min.css" media="screen">';
							newTemplate += '<script type="text/javascript" src="js/dmstree_js/doc_temp_valid.js"></script>';
							newTemplate += '<script>';
							newTemplate += '$( document ).ready(function(){ $(".datepicker").datepicker({dateFormat: "dd-mm-yy"}); $("#doc_template .droppedField").each(function(){ if(($(this).find(".table_div").length) != 0) { var btnstatus = $(this).find(".addstatus").val(); btnstatus = btnstatus.trim();if(btnstatus == "cols" && btnstatus != ""){ $(this).find(".tbl_btn").css("display","block"); } else{$(this).find(".tbl_btn").css("display","none");}} })});';
							newTemplate += '</script>';
							newTemplate += '</head>';
							newTemplate += '<body>';
							newTemplate += dialogContent;
							newTemplate += '</body>';
							newTemplate += '</html>';
							$('#template_fromdata').val(newTemplate);
							document.admin_template_form.submit();
						}
					  }  
					  else
						  {
							  alert("More than one control having Name : '"+result+"'");
							  return false;
						  }
				}   
				else
				{
						alert("Please enter the Template Name with Template control");
				}    
               }
               else{
                   alert("Please Select Sub Domian")
               }
            }
            else{
                    alert("Please Select Domain");
            }
        }
    
    
                if(typeof(console)=='undefined' || console==null) {console={};onsole.log=function(){}}
  
                /* Delete the control from the form */
                function delete_ctrl() {
                    if(window.confirm("Are you sure you want to delete this field ?")) {
                    var ctrl_id = $("#theForm").find("[name=forCtrl]").val()
                    console.log(ctrl_id);
                    $("#"+ctrl_id).remove();
                    }
                }
  
  
                /* Compile the templates for use */
                function compileTemplates() {
                    window.templates = {};
                    window.templates.common = Handlebars.compile($("#control-customize-template").html());

                    /* HTML Templates required for specific implementations mentioned below */
                    // Mostly we donot need so many templates
                    window.templates.textbox = Handlebars.compile($("#textbox-template").html());
                    window.templates.passwordbox = Handlebars.compile($("#textbox-template").html());
                    window.templates.combobox = Handlebars.compile($("#combobox-template").html());
                    window.templates.selectmultiplelist = Handlebars.compile($("#combobox-template").html());
                    window.templates.radiogroup = Handlebars.compile($("#optionbox-template").html());
                    window.templates.checkboxgroup = Handlebars.compile($("#optionbox-template").html());
                    window.templates.text = Handlebars.compile($("#text-template").html());
                    window.templates.date = Handlebars.compile($("#date-template").html()); 
                    window.templates.label = Handlebars.compile($("#label-template").html());
                    window.templates.multilabel = Handlebars.compile($("#multilabel-template").html());
                    window.templates.image = Handlebars.compile($("#image-template").html());
                    window.templates.logoimage = Handlebars.compile($("#logoimage-template").html());
                    window.templates.table = Handlebars.compile($("#table-template").html());
                    window.templates.stdcombobox = Handlebars.compile($("#stdcombobox-template").html());
                }
  
                // Object containing specific "Save Changes" method
                save_changes = {};

                // Object comaining specific "Load Values" method. 
                load_values = {};
  
                /* Common method for all controls with Label and Name */
                load_values.common = function(ctrl_type, ctrl_id) {
                var form = $("#theForm");
                var div_ctrl = $("#"+ctrl_id);    

                        // Gestion du champs obligatoire
                        var listeHiddenObligatoire = div_ctrl.find(".hiddenObligatoire");
                        if (listeHiddenObligatoire != null && listeHiddenObligatoire.length > 0) {
                        var ctrlObligatoire = listeHiddenObligatoire[0];
                        form.find("[name=obligatoire]").attr('checked', ctrlObligatoire.value == "true");
                        form.find("#pObligatoire").show();
                        }
                        else {
                        form.find("#pObligatoire").hide();
                        }
                        
                        // Gestion du chargement champs spï¿½cifiques
                        form.find("[name=label]").val(div_ctrl.find('.control-label').text())
                        var specific_load_method = load_values[ctrl_type];
                        if(typeof(specific_load_method)!='undefined') {
                        specific_load_method(ctrl_type, ctrl_id);		
                        }
                }
  
  
                /*Specific method to load values from a labelbox control to the customization dailog*/
                load_values.labelbox = function(ctrl_type, ctrl_id){
                   var form = $("#theForm");
                }
                
                		/*Specific method to load values from a multilinelabelbox control to the customization dailog*/
                load_values.multilinelabel = function(ctrl_type, ctrl_id){
                   var form = $("#theForm");
                }
  
                /*Specific method to load values from a labelbox control to the customization dailog*/
                load_values.tablebox = function(ctrl_type, ctrl_id){
                    var form = $("#theForm");
                }
                
                /* Specific method to load values from a textbox control to the customization dialog */
                load_values.textbox = function(ctrl_type, ctrl_id) {
                    var form = $("#theForm");
                    var div_ctrl = $("#" + ctrl_id);    
                    var ctrlText = div_ctrl.find("input[type=text]")[0];
                    form.find("[name=name]").val(ctrlText.name);
                    form.find("[name=placeholder]").val(ctrlText.placeholder);
                }
  
                // Passwordbox uses the same functionality as textbox - so just point to that
                load_values.passwordbox = load_values.textbox;
  
                /*Specific method to load values from a imagebox control to the customization dailog*/
                load_values.imagebox = function(ctrl_type, ctrl_id){
                    var form = $("#theForm");
                }
                
                /*Specific method to load values from a tablebox control to the customization dailog*/
                load_values.tablebox = function(ctrl_type, ctrl_id){
                    var form = $("#theForm");
                }
                
                
                /* Specific method to load values from a combobox control to the customization dialog  */
                load_values.combobox = function(ctrl_type, ctrl_id) {
                    var form = $("#theForm");
                    var div_ctrl = $("#"+ctrl_id);
                    var ctrl = div_ctrl.find("select")[0];
                    form.find("[name=name]").val(ctrl.name)
                    var options= '';
                    $(ctrl).find('option').each(function(i,o) {options+=o.text+'\n';});
                    form.find("[name=options]").val($.trim(options));
                }
                
                
                /* Specific method to load values from a stdcombobox control to the customization dialog  */
                load_values.stdcombobox = function(ctrl_type, ctrl_id) {
                    var form = $("#theForm");
                    var div_ctrl = $("#"+ctrl_id);
                    var ctrl = div_ctrl.find("select")[0];
                    form.find("[name=name]").val(ctrl.name)
                    var defaulttno = 1; 
                    var listoptions = '';
                    $.ajax({
                            type:'post',
                            url:'getstandared_combolist.php?',
                            data:{
                                    defaulttno : defaulttno
                            },
                            success:function(data){
                                var list_name = data.split('::');
                                var listlen = list_name.length;
                                for(var i= 0; i < listlen; i++)
                                    {
                                        var listitem = list_name[i];
                                        listoptions +='<input type="radio" name="stdlist" value="'+listitem+'" onChange="get_stdListValues(this,\''+form+'\');">'+listitem+'<br/>';
                                    }
                                    form.find("#slist").append(listoptions);
                            }
                            });
                }
                
                // Multi-select combobox has same customization features
                load_values.selectmultiplelist = load_values.combobox;
  
  
                /* Specific method to load values from a radio group */
                load_values.radiogroup = function(ctrl_type, ctrl_id) {
                    var form = $("#theForm");
                    var div_ctrl = $("#"+ctrl_id);
                    var options= '';
                    var ctrls = div_ctrl.find("div").find("span");
                    var radios = div_ctrl.find("div").find("input");

                    ctrls.each(function(i,o) {options+=$(o).text()+'\n';});
                    form.find("[name=name]").val(radios[0].name)
                    form.find("[name=options]").val($.trim(options));
                }
  
  
                // Checkbox group  customization behaves same as radio group
                load_values.checkboxgroup = load_values.radiogroup;
  
  
                /* Specific method to load values from a button */
                load_values.btn = function(ctrl_type, ctrl_id) {
                    var form = $("#theForm");
                    var div_ctrl = $("#"+ctrl_id);
                    var ctrl = div_ctrl.find("button")[0];
                    form.find("[name=name]").val(ctrl.name)		
                    form.find("[name=label]").val($(ctrl).text().trim())		
                }


                /* Specific method to load values from a text to the customization dialog */
                load_values.text = function (ctrl_type, ctrl_id) {    
                    var form = $("#theForm");
                    var div_ctrl = $("#" + ctrl_id);
                    var ctrlText = div_ctrl.find(".ctrl-text");
                    form.find("[name=texte]").val(ctrlText.text());
                }


                /* Specific method to load values from a date to the customization dialog */
                load_values.date = function (ctrl_type, ctrl_id) {
                    var form = $("#theForm");
                    var div_ctrl = $("#" + ctrl_id);    
                    var ctrlText = div_ctrl.find(".ctrl-date");
                    form.find("[name=dateformat]").val(ctrlText.text());
                }

  
                /* Common method to save changes to a control  - This also calls the specific methods */
                save_changes.common = function(values) {
                            var div_ctrl = $("#"+values.forCtrl);
                            div_ctrl.find('.control-label').text(values.label);
                            div_ctrl.find('.ctrl-multilabel').text(values.multilinelabel);
                            // Gestion du champs obligatoire
                            var listeHiddenObligatoire = div_ctrl.find(".hiddenObligatoire");
                            if (listeHiddenObligatoire != null && listeHiddenObligatoire.length > 0) {
                            var ctrlObligatoire = listeHiddenObligatoire[0];
                            ctrlObligatoire.value = values.obligatoire;
                            }

                            var specific_save_method = save_changes[values.type];
//                            alert("save common:"+specific_save_method);
                            if(typeof(specific_save_method)!='undefined') {
                            specific_save_method(values);		
                            }
                }
  
  
                	/* Specific method to save changes to a multilinelabel */
                save_changes.multilinelabel = function(values) {
                    var div_ctrl = $("#"+values.forCtrl);
					alert("values-label"+values.label);
					div_ctrl.find('.control-label').text(values.multilinelabel);
                    var ctrlText = div_ctrl.find("input[type=text]")[0];
                }
                
                
  
                /* Specific method to save changes to a text box */
                save_changes.textbox = function(values) {
                    var div_ctrl = $("#"+values.forCtrl);
                    var ctrlText = div_ctrl.find("input[type=text]")[0];
                    
                    if(values.placeholder != '')
                        {
                          ctrlText.placeholder = values.placeholder;  
                        }
                    if(values.label != '')
                        {
                            var textboxname =  values.label;
                            textboxname = textboxname.replace(" ","_");
                          ctrlText.name = textboxname;  
                        }
                    
                }


                // Password box customization behaves same as textbox
                save_changes.passwordbox= save_changes.textbox;


                /* Specific method to save changes to a combobox */
                save_changes.combobox = function(values) {
                    console.log(values);
                    var div_ctrl = $("#"+values.forCtrl);
                    var ctrl = div_ctrl.find("select")[0];
                    var comboboxname = values.label;
                    comboboxname = comboboxname.replace(" ","_");
                    ctrl.name = comboboxname;
                    $(ctrl).empty();
                    $(values.options.split('\n')).each(function(i,o) {
                    $(ctrl).append("<option>"+$.trim(o)+"</option>");
                    });
                }
  
                /* Specific method to save changes to a combobox */
                save_changes.stdcombobox = function(values) {
                    console.log(values);
                    var div_ctrl = $("#"+values.forCtrl);
                    var ctrl = div_ctrl.find("select")[0];
                    var stdboxname = values.label;
                        stdboxname = stdboxname.replace(" ","_");
                    ctrl.name = stdboxname;
                    $(ctrl).empty();
                    $(values.options.split('\n')).each(function(i,o) {
                    $(ctrl).append("<option>"+$.trim(o)+"</option>");
                    });
                }
  
                /* Specific method to save a radiogroup */
                save_changes.radiogroup = function(values) {
                    var div_ctrl = $("#"+values.forCtrl);

                    var label_template = $(".selectorField .ctrl-radiogroup span")[0];
                    var radio_template = $(".selectorField .ctrl-radiogroup input")[0];    
                    var ctrl = div_ctrl.find(".ctrl-radiogroup");
                    ctrl.empty();
                    var radioOptions = values.options.split('\n');
                    var radioindex = 0;
                    $(values.options.split('\n')).each(function(i,o) {
                    if(radioOptions[radioindex] != '')
                        {
                            var label = $(label_template).clone().text($.trim(o))
                            var radio = $(radio_template).clone();
                            var radioname = values.label;
                            radioname = radioname.replace(" ","_");
                            radio[0].name = radioname;
                            radio[0].value = radioOptions[radioindex];
                            label.prepend(radio);
                            $(ctrl).append(label);
                            radioindex++; 
                        }
                    });
                }
  
  
                /* Same as radio group, but separated for simplicity */
                save_changes.checkboxgroup = function(values) {
                    var div_ctrl = $("#"+values.forCtrl);

                    var label_template = $(".selectorField .ctrl-checkboxgroup span")[0];
                    var checkbox_template = $(".selectorField .ctrl-checkboxgroup input")[0];

                    var ctrl = div_ctrl.find(".ctrl-checkboxgroup");
                    ctrl.empty();
                    var chkOptions = values.options.split('\n');
                    var chkindex = 0;
                    $(values.options.split('\n')).each(function(i,o) {
                        if(chkOptions[chkindex] != '')
                            {
                                var label = $(label_template).clone().text($.trim(o))
                                var checkbox = $(checkbox_template).clone();
                                var checkboxname = values.label;
                                checkboxname = checkboxname.replace(" ","_");
                                checkbox[0].name = checkboxname;
                                checkbox[0].value = chkOptions[chkindex];
                                label.prepend(checkbox);
                                $(ctrl).append(label);
                                chkindex++;
                            }
                    });
                }
  
  
                // Multi-select customization behaves same as combobox
                save_changes.selectmultiplelist = save_changes.combobox;
  
  
                /* Specific method for Button */
                save_changes.btn = function(values) {
                    var div_ctrl = $("#"+values.forCtrl);
                    var ctrl = div_ctrl.find("button")[0];
                    $(ctrl).html($(ctrl).html().replace($(ctrl).text()," "+$.trim(values.label)));
                    ctrl.name = values.name;
                }
  
  
                /* Specific method to save changes to a text box */
                save_changes.text = function (values) {
                    var div_ctrl = $("#"+values.forCtrl);
                    var ctrlText = div_ctrl.find("textarea")[0];
                    if(values.label != '')
                        {
                            var textareaname = values.label;  
                            textareaname = textareaname.replace(" ","_");
                          ctrlText.name = textareaname;  
                        }
                }


                /* Specific method to save changes to a text box */
                save_changes.date = function (values) {
                    save_changes_simple_text(values, ".ctrl-date", values.dateformat)
                    var div_ctrl = $("#"+values.forCtrl);
                    var datefield = values.forCtrl;
                    var datefieldid =datefield.split("-");
                    var ctrlText = div_ctrl.find("input[type=text]")[0];
                    if(values.label != '')
                        {
                            var datename = values.label;
                           datename = datename.replace(" ","_"); 
                          ctrlText.name = datename; 
                          ctrlText.id = 'datectrl-'+datefieldid[2];
                        }
                }


                function save_changes_simple_text(values, ctrl, value) {
                    var div_ctrl = $("#" + values.forCtrl);
                    var ctrlText = div_ctrl.find(ctrl);
                    ctrlText.text(value);
                }

                /* Save the changes due to customization 
                    - This method collects the values and passes it to the save_changes.methods
                */
                function save_customize_changes(e, obj) {
                        //console.log('save clicked', arguments);
                        var formValues = {};
                        var val=null;
                        var cntrl_id = '';
                        var rd_classname = '';
                        var chk_classname = '';
                        var component_type= '';
                        var j =0;
                        $("#theForm").find("input, textarea, select").each(function(i,o) {
                                if(o.name=='type')
                                    {
                                       component_type = o.value; 
                                    }
                                if(o.name=='forCtrl')
                                    {
                                        cntrl_id = o.value;
                                        $('#'+cntrl_id).find('.label_id').val(cntrl_id);
                                    }
                                if(o.name=="table_rows")
                                    {
                                        var tab_rows = o.value;
                                        $('#'+cntrl_id).find('.table_rows').val(tab_rows);
                                    }
                                if(o.name=="table_cols")
                                    {
                                        var tab_cols = o.value;
                                        $('#'+cntrl_id).find('.table_cols').val(tab_cols);
                                    }    
                                if(o.name=='help')
                                    {
                                        var help_info = o.value;
                                        if(cntrl_id != '')
                                            {
                                                $('#'+cntrl_id).find('.control_help').text(help_info);
                                            }
                                    }
                                    
                                if(o.name == 'chkdisplay' && component_type == 'radiogroup')
                                    {
                                          rd_classname =$('input:radio[name=chkdisplay]').filter(":checked").val();
                                    }
                                if(o.name == 'chkdisplay' && component_type == 'checkboxgroup')
                                    {
                                          chk_classname =$('input:radio[name=chkdisplay]').filter(":checked").val();
                                    }  
                                if(o.name == '')
                                    {
                                        if(j == 0)
                                            {
                                                var min = o.value;
                                                if(min == '0')
                                                    {
                                                        $('#'+cntrl_id).find('.min_length').val('');
                                                        $('#'+cntrl_id).find('.ctrl-textbox').attr('minlength','');
                                                    }
                                                else
                                                    {
                                                        $('#'+cntrl_id).find('.min_length').val(min);
                                                        $('#'+cntrl_id).find('.ctrl-textbox').attr('minlength',min);
                                                    }
                                                
                                            }
                                        else
                                            {
                                                var max = o.value;
                                                if(max == '0')
                                                    {
                                                        $('#'+cntrl_id).find('.max_length').val('');
                                                        $('#'+cntrl_id).find('.ctrl-textbox').attr('maxlength','');
                                                    }
                                                else
                                                    {
                                                        $('#'+cntrl_id).find('.max_length').val(max);
                                                        $('#'+cntrl_id).find('.ctrl-textbox').attr('maxlength',max);
                                                    }
                                            }
                                            j++;
                                    }
                                
                                if(o.type=="checkbox")
                                {
                                    val = o.checked;
                                    
                                    if(val == true)
                                    {
                                        if($('#'+cntrl_id).children('div:nth-child(2)').find('.cntrol_comp').length > 0)
                                            {
                                                $('#'+cntrl_id).children('div:nth-child(2)').find('.cntrol_comp').addClass('required_field');
                                            }
                                        else
                                            {
                                                $('#'+cntrl_id).children('.cntrol_comp').addClass('required_field');
                                            }
                                        
                                        
                                                $('#'+cntrl_id).find('.requiredcls').css('display','block');
                                    }
                                 }
                                else 
                                {
                                    val = o.value;
                                }

                                formValues[o.name] = val;
                        });
                        

                        if(rd_classname != '' && rd_classname == 'horizontal_display')
                            {
                                $('#'+cntrl_id).find('.rd_display').val('inline_radio');
                            }
                        else if(rd_classname != '' && rd_classname == 'vertical_display')
                            {
                                $('#'+cntrl_id).find('.rd_display').val('block_radio');
                            }
                        if(chk_classname != '' && chk_classname == 'horizontal_display')
                            {
                                $('#'+cntrl_id).find('.chk_display').val('inline_radio');
                            }
                        else if(chk_classname != '' && chk_classname == 'vertical_display')
                            {
                                $('#'+cntrl_id).find('.chk_display').val('block_radio');
                            }     
                        save_changes.common(formValues);
                }
   
   
 function get_required()
 {
}

        /*
            Opens the customization window for this
        */
        function customize_ctrl(ctrl_type, ctrl_id) {
            console.log(ctrl_type);
            var ctrl_params = {};

            /* Load the specific templates */
            var specific_template = templates[ctrl_type];
            if(typeof(specific_template)=='undefined') {
            specific_template = function(){return '';};
            }
            var modal_header = $("#"+ctrl_id).find('.control-label').text();
    
            var template_params = {
            header:modal_header, 
            content: specific_template(ctrl_params), 
            type: ctrl_type,
            forCtrl: ctrl_id,
            displayNom: ctrl_type == 'text' || ctrl_type == 'date' ? 'none' : 'block'
            }
    
            // Pass the parameters - along with the specific template content to the Base template
            var s = templates.common(template_params) + "";

            $("[name=customization_modal]").remove(); // Making sure that we just have one instance of the modal opened and not leaking
            $('<div id="customization_modal" name="customization_modal" class="modal hide fade" />').append(s).modal('show');

            setTimeout(function() {
            // For some error in the code  modal show event is not firing - applying a manual delay before load
            load_values.common(ctrl_type, ctrl_id);
            },300);
        }

        function checkLength(o, n, min, max) {
            if (o.val().length > max || o.val().length < min) {
            o.addClass("ui-state-error");
            updateTips("Length of " + n + " must be between " +
                min + " and " + max + ".");
            return false;
            } else {
            return true;
            }
        }

        function checkRegexp(o, regexp, n) {
            if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            updateTips(n);
            return false;
            } else {
            return true;
            }
        }
  
  
  function change_font(a)
  {
        var maindiv_id = ''
        $("#theForm").find("input, textarea, select").each(function(i,o) {
            if(o.name=='forCtrl')
                {
                    maindiv_id = o.value;
                    if(a == 'bold')
                    {
                        $('#handlebars-textbox-label').css("font-style","normal");
                        $('#handlebars-textbox-label').css("font-weight","bold");
                        $('#'+maindiv_id).find('.label_font').val('boldfont');
                    }
                    else if(a == 'italic')
                    {
                        $('#handlebars-textbox-label').css("font-weight","normal");
                        $('#handlebars-textbox-label').css("font-style","italic");
                        $('#'+maindiv_id).find('.label_font').val('italicfont');
                    }
                    else if(a == 'normal')
                    {
                        $('#handlebars-textbox-label').css("font-weight","normal");
                        $('#handlebars-textbox-label').css("font-style","normal");
                    }    
                }   
        });
 
  }
  
  
  function apply_font()
  {
      var maindiv_id = ''
      $("#theForm").find("input, textarea, select").each(function(i,o) {
        if(o.name=='forCtrl')
            {
                maindiv_id = o.value;
                var classname = $('#'+maindiv_id).find('.label_font').val();
                var sizeclassname = $('#'+maindiv_id).find('.label_size').val();
                var rd_classname = $('#'+maindiv_id).find('.rd_display').val();
                var chk_classname = $('#'+maindiv_id).find('.chk_display').val();
                if(classname != '')
                    {
                         $('#'+maindiv_id).find('.forms_lbl').addClass(classname);
                    }
                if(sizeclassname != '')
                    {
                         $('#'+maindiv_id).find('.forms_lbl').addClass(sizeclassname);
                    }
                if(rd_classname != '')
                    {
                        $('#'+maindiv_id).find('.ctrl-radiogroup span').addClass(rd_classname);
                    }
                if(chk_classname != '')
                    {
                        $('#'+maindiv_id).find('.ctrl-checkboxgroup span').addClass(chk_classname);
                    }    
            }
      });
  }
  
  function change_size(textsize)
  {
            
            var maindiv_id = ''
            $("#theForm").find("input, textarea, select").each(function(i,o) {
                if(o.name=='forCtrl')
                    {
                        maindiv_id = o.value;
                        if(textsize == '12')
                        {
                            $('#handlebars-textbox-label').css("font-size","12px");
                            $('#'+maindiv_id).find('.label_size').val('smalllabel');
                        } 
                        else if(textsize == '14')
                        {
                            $('#handlebars-textbox-label').css("font-size","14px");
                            $('#'+maindiv_id).find('.label_size').val('midlabel');    
                        }
                        else if(textsize == '16')
                        {
                            $('#handlebars-textbox-label').css("font-size","16px");
                            $('#'+maindiv_id).find('.label_size').val('largelabel');
                        }    
                    }
            });
         
  }



function get_stdListValues(listobj,formobj)
{
    var listname = $(listobj).val();
    var listvalues = '';
    $.ajax({
                            type:'post',
                            url:'get_stdlist_values.php',
                            data:{
                                    listname : listname
                            },
                            success:function(data){
                                var listitem = data.split('::');
                                var listlen = listitem.length;
                                for(var i = 0; i < listlen; i++)
                                    {
                                           listvalues += listitem[i]+'\n';
                                           $('#std_seletedlist').find('textarea').val(listvalues);
                                    }

                            }
    });
}