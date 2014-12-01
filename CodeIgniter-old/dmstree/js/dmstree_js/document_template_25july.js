 /*
  *File Name: Document_template js
  *Created Date: 23 july 2014
  *Created By: Shubhangi Mate
  *Modify By:
  *Modified Date: 
  */
 
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
                        //console.log(event, ui);
                        var draggable = ui.draggable;
                        draggable = $(ui.draggable).find(".modele").clone();
                        // draggable = draggable.clone();
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
                                    //window["customize_"+ctrl_type](this.id);
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
                //alert(contentToAdd);
                //alert($("#selected-content").html());
                docReady();
               }
        }
        
        
        
        // Suppression de tableau Delete table
        var tableauToDelete = null;
        function supprimerTableau() {
            if (tableauToDelete) {   
            // alert(tableauToDelete);
            if (window.confirm("Are you sure you want to delete this container?")) {
                $("body").append($("#divDeleteTableau")); // Sinon il rï¿½apparait ...
                $(tableauToDelete).parent().remove();
                // alert($(tableauToDelete).parent().html());
                tableauToDelete = null;
                $("#divDeleteTableau").hide();
            }
            }
        }


        /*
            Preview the customized form 
            -- Opens a new window and renders html content there.
        */
       
        function preview() {
                console.log('Preview clicked');
    
                // Sample preview - opens in a new window by copying content -- use something better in production code
                var selected_content = $("#selected-content").clone();
                selected_content.find("div").each(function(i,o) {
                            var obj = $(o)
                            obj.removeClass("draggableField ui-draggable well ui-droppable ui-sortable");
                        });
                        
                        
                        var legend_text = $("#form-title")[0].value;
                        var form_desc = $("#form-description").val();
                        //    alert(form_desc);
                        if(legend_text=="") {
                        legend_text="Form builder demo";
                        }
                        selected_content.find("#form-title-div").remove();
    
                        var selected_content_html = selected_content.html();
                        var scrpt = '</'+'script>';
    
                        var dialogContent = '<!DOCTYPE HTML>\n<html lang="en-US">\n<head>\n<meta charset="UTF-8">\n<title></title>\n';
                        dialogContent+= '<link rel="stylesheet" href="jqueryui/themes/base/jquery-ui.css" />';
                        dialogContent+= '<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">\n';
                        dialogContent+='<style>\n'+$("#content-styles").html()+'\n</style>\n';
                        dialogContent+='<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">';
                        dialogContent+='<script type="text/javascript" src="bootstrap/js/jquery.js">'+scrpt;
                        dialogContent+='<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js">'+scrpt;
                        dialogContent+='<script type="text/javascript" src="js/dmstree_js/moment.min.js">'+scrpt;

                        dialogContent+='<script type="text/javascript" src="js/dmstree_js/form_temp.js">'+scrpt;
                        dialogContent+= '</head>\n<body id="temp_body">';
                        dialogContent+= '<form name="doc_template" class="doc_template" style="width:800px; margin:10px auto;">';
                        dialogContent+= '<legend>'+legend_text+'</legend>';
                        if(form_desc != '')
                            {
                                dialogContent+= '<p>'+form_desc+'</p>';        
                            }
                        dialogContent+= selected_content_html;
                        dialogContent+='<div class="row form_btn">';
                        dialogContent+='<button class="btn ctrl-btn">Cancel</button>';
                        dialogContent+='<button class="btn btn-danger ctrl-btn"><i class="icon-trash icon-white"></i>Clear</button>';
                        dialogContent+='<button class="btn btn-success ctrl-btn"><i class="icon-ok-sign icon-white"></i>Submit</button>';
                        dialogContent+='</div>';
                        dialogContent+= '\n</body></html>';

                        dialogContent+='<br/><br/><b>Source code: </b><pre>'+$('<div/>').text(dialogContent).html();+'</pre>\n\n';

                        dialogContent = dialogContent.replace('\n</body></html>','');
                        dialogContent+= '\n</form></body></html>';
    
                        // alert(dialogContent);

                        var win = window.open("about:blank");
                        win.document.write(dialogContent);
    
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
                    window.templates.radiogroup = Handlebars.compile($("#combobox-template").html());
                    window.templates.checkboxgroup = Handlebars.compile($("#combobox-template").html());
                    window.templates.text = Handlebars.compile($("#text-template").html());
                    window.templates.date = Handlebars.compile($("#date-template").html());    
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

                            // Gestion du champs obligatoire
                            var listeHiddenObligatoire = div_ctrl.find(".hiddenObligatoire");
                            if (listeHiddenObligatoire != null && listeHiddenObligatoire.length > 0) {
                            var ctrlObligatoire = listeHiddenObligatoire[0];
                            ctrlObligatoire.value = values.obligatoire;
                            }

                            var specific_save_method = save_changes[values.type];
                            if(typeof(specific_save_method)!='undefined') {
                            specific_save_method(values);		
                            }
                }
  
  
                /* Specific method to save changes to a text box */
                save_changes.textbox = function(values) {
                    var div_ctrl = $("#"+values.forCtrl);
                    var ctrlText = div_ctrl.find("input[type=text]")[0];
                    // var ctrl = div_ctrl.find("input")[0];
                    ctrlText.placeholder = values.placeholder;
                    ctrlText.name = values.name;
                    // console.log(values.obligatoire);
                }


                // Password box customization behaves same as textbox
                save_changes.passwordbox= save_changes.textbox;


                /* Specific method to save changes to a combobox */
                save_changes.combobox = function(values) {
                    console.log(values);
                    var div_ctrl = $("#"+values.forCtrl);
                    var ctrl = div_ctrl.find("select")[0];
                    ctrl.name = values.name;
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
                    $(values.options.split('\n')).each(function(i,o) {
                    var label = $(label_template).clone().text($.trim(o))
                    var radio = $(radio_template).clone();
                    radio[0].name = values.name;
                    label.prepend(radio);
                    $(ctrl).append(label);
                    });
                }
  
  
                /* Same as radio group, but separated for simplicity */
                save_changes.checkboxgroup = function(values) {
                    var div_ctrl = $("#"+values.forCtrl);

                    var label_template = $(".selectorField .ctrl-checkboxgroup span")[0];
                    var checkbox_template = $(".selectorField .ctrl-checkboxgroup input")[0];

                    var ctrl = div_ctrl.find(".ctrl-checkboxgroup");
                    ctrl.empty();
                    $(values.options.split('\n')).each(function(i,o) {
                    var label = $(label_template).clone().text($.trim(o))
                    var checkbox = $(checkbox_template).clone();
                    checkbox[0].name = values.name;
                    label.prepend(checkbox);
                    $(ctrl).append(label);
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
                    //console.log(values);
                }
  
  
                /* Specific method to save changes to a text box */
                save_changes.text = function (values) {
                    save_changes_simple_text(values, ".ctrl-text", values.texte)
                }


                /* Specific method to save changes to a text box */
                save_changes.date = function (values) {
                    save_changes_simple_text(values, ".ctrl-date", values.dateformat)
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
//                                alert(o.name+'--'+o.value);
                                if(o.name=='type')
                                    {
                                       component_type = o.value; 
                                    }
                                if(o.name=='forCtrl')
                                    {
                                        cntrl_id = o.value;
                                        $('#'+cntrl_id).find('.label_id').val(cntrl_id);
                                    }
                                if(o.name=='help')
                                    {
                                        var help_info = o.value;
                                        if(cntrl_id != '')
                                            {
                                                // alert('#'+cntrl_id);
                                                $('#'+cntrl_id).find('.control_help').text(help_info);
                                            }
                                    }
                                    
                                if(o.name == 'chkdisplay' && component_type == 'radiogroup')
                                    {
//                                        rd_classname = $('input[name=chkdisplay]:checked').val();
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
                                                $('#'+cntrl_id).find('.min_length').val(min);
                                                $('#'+cntrl_id).find('.ctrl-textbox').attr('minlength',min);
                                            }
                                        else
                                            {
                                                var max = o.value;
                                                $('#'+cntrl_id).find('.max_length').val(max);
                                                $('#'+cntrl_id).find('.ctrl-textbox').attr('maxlength',max);
                                            }
                                            j++;
                                    }
                                    // if(o.name == 'minmax_lenlimit')
                                    // {
                                    //    var lenlimit = o.value;
                                    //    $('#'+cntrl_id).find('.length_type').val(lenlimit);
                                    // }
                                if(o.type=="checkbox")
                                {
                                    val = o.checked;
                                    if(val == true)
                                    {
                                        if(cntrl_id != '')
                                            {
                                                $('#'+cntrl_id).find('.requiredcls').css('display','block');
                                            }
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
                        //apply_font(cntrl_id);
                }
   
   
 function get_required()
 {
    // alert($(controlobj))
    //alert($('.modal-body').html());
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
//                alert(chk_classname);
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
//      var classname = $('#'+cntrl_id).find('.label_font').val();
//      $('.forms_lbl').addClass(classname);
//      $('#'+cntrl_id).find('.forms_lbl ').addClass()
  }
  
  function change_size(textsize)
  {
//      alert(textsize);
            
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
