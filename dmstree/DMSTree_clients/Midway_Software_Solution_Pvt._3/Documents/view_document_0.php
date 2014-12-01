<?php 
$docname = '';
if( isset($_POST['selected_doc']))
{
    $docname = $_POST['selected_doc']; 
}
 else {
    $docname = '';
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Dash-Board</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="discription" content="">
        <meta name="author" content="">
        
        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
        <link rel="stylesheet" href="css/jquery.tag-editor.css">
		
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script type="text/javascript" src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
	<script type="text/javascript" src="js/dmstree_js/jquery.textover.js"></script>
	<script type="text/javascript" src="js/dmstree_js/time_function.js"></script>
	<!--<script type="text/javascript" src="jquery_docsviewer/jquery.gdocsviewer.min.js"></script>-->
       <script>
           /*function view_template(tempnm)
           {
               var dochtml = 'Templates/'+tempnm;
               $('.document_template').load(dochtml);
           }*/
           $(document).ready(function(){
               var tempname = "<?php echo $docname;?>";
               if(tempname != '')
               {
                   $('.document_template').load('Templates/'+tempname);
                   $.ajax({
                        type: "POST",
                        data:{
                            tempname : tempname
                        },
                        //dataType: "json",
                        url: "getdocumentmetadata.php",
                        success: function(response){ 
                            var data = $.parseJSON(response);
                            var radioarr = data.radiobtn;
                            var tablearr = data.tablectrl;
                            var radiolen = data.radiobtn.length;
                            var tablelen = data.tablectrl.length;
                            for( var radioindex = 0; radioindex < radiolen; radioindex++)
                             {
                                 var ctrl_name = radioarr[radioindex].Name;
                                 var ctrl_val  = radioarr[radioindex].SelectedOption;
                                 $('#doc_template').find('input[name="'+ctrl_name+'"][value="'+ctrl_val+'"]').prop('checked', true);
                             }
                             
                            for(var tableindex = 0; tableindex < tablelen; tableindex++)
                                {
                                  var tableid = tablearr[tableindex].TableId;
                                  var tblarr  = tablearr[tableindex].Values;
                                  var tblarrlen = tblarr.length;
                                  if(tableid == 'tbl-CTRL-DIV-1002'){
                                  for(var valindex = 0; valindex < tblarrlen; valindex++)
                                      {
                                          var cols   = tblarr[valindex].Column;
                                          var row    = tblarr[valindex].Row;
                                          var tblval = tblarr[valindex].Value;
                                          //alert(tblval);
                                          alert($('#'+tableid+' tr:nth-child('+row+')').html());
                                          alert(tableid);
                                          //$('#'+tableid+' tr:eq('+row+') td:eq('+cols+')').text();
                                          //alert($('#'+tableid+' tr:eq('+row+') td:eq('+cols+')').text());
                                      }
                                  }
                                      /*alert($('#'+tableid).find('tbody tr:eq(0) th:eq(2)').text());
                                      alert($('#'+tableid).find('tbody tr:eq(0) th:nth-child(2)').text());
                                      alert($('#'+tableid).find('tbody tr:eq(0) th:nth-child(3)').text());*/
                                      //alert($('#'+tableid).find('tbody').html());
                                      //alert($('#doc_template').find('#'+tableid).html());
                                }
                             
                        /*alert(radioarr);
                         var radioarr = $.parseJSON(radioarr,tablearr);
                         alert(radioarr.length);
                         
                         /*var textboxarr = $.parseJSON(textboxarr);
                         alert(textboxarr);
                         var textarr = $.parseJSON(textarr);
                         var custlistarr = $.parseJSON(custlistarr);
                         var radioarr = $.parseJSON(radioarr);
                         var checkboxarr = $.parseJSON(checkboxarr);
                         var tablearr = $.parseJSON(tablearr);
                         alert(labelarr.length);
                         alert(textboxarr.length);
                         alert(textarr.length);
                         alert(custlistarr.length);
                         alert(radioarr.length);
                         alert(checkboxarr.length);
                         alert(tablearr.length);*/
                         //alert(textboxarr);
                         //alert(Object.keys(response).length); 
                        }
                    });
               }    
               
               
           });
       </script>
    </head>
    <body >
        
    <?php include_once 'header.php'; ?> 
    <div class="row row-margin">
         <div class="col-md-3 col-sm-3" id="body1">
              <?php include_once'dash_menu.php'?>  
         </div>
         <div class="col-md-9 col-sm-9 div-padding-left" id="body-content">
                <!--------- dash board body------------------------------------------------> 
				
        	<div class="well div-padding-top">
		<div class="row">
                     <div class="col-md-12 col-sm-12 form_title"><h3 class="text-muted"><b>View Document</b></h3></div>
		</div>
		<div class="div-padding">
			<form id="uploadDocumentForm" method="post" class="form-horizontal  form-action" action="">
			    <div class="form-group row">
				<div class="col-md-12">
                                    <iframe src="Seven.pdf" style="width: 100%; height: 50%; margin-left: 12px; border: 1px ridge black;"></iframe>
				</div>
                            </div>
									
                            <div class="control-group form-group row" id="tag1">
                                <label class="control-label col-md-2 col-sm-2" for="txt_tag">Tags</label>
                                <div class="col-md-8 col-sm-8" id="tag_diaplay" style="background-color:#f5f5f5; max-width:900px;margin:auto">
                                    <textarea class="hero-demo" >example tags, sortable, autocomplete, edit in place, tab/cursor navigation</textarea>
                                </div>
                                <div class="col-md-2 checkin">
                                    <img src="img/checkin.png" style="height:25px;width:20px"/>
                                </div>
                            </div>

         	            <div class="form-group row space">
<!--			    <label for="txt_template" class="col-md-2 col-sm-2 control-label">Template</label>-->
<!--			    <div class="col-md-10 col-sm-10">	-->		
				<div class="col-md-12 col-sm-12">	
<!--				<div class="row ">
				<div class="col-md-12 form_title "><h3 class="text-muted"><b>Demo</b></h3></div>
				</div>-->
				<div class="row">
                                   <div class="document_template" style="border:1px solid gainsboro">
                                       <?php                                                          
                                           
                                       ?>
                                   </div>    
                                </div>
                             </div>
			</div>

                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-2 col-sm-2 control-label mar-left " ><strong>Expiry Date</strong></label>
                                <div class='col-md-6 col-sm-6' id='date9'>
                                    <div class='input-group date' id='datetimepicker' data-date-format="DD/MM/YYYY">
                                        <input type='text' class="form-control date1" name="date" readonly/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 col-sm-12">
                                <label><strong>Physical Location</strong></label>
                                <div class="col-md-12 col-sm-12" id="div_pic">
                                <div class="row">
                                     <div class="col-md-6 col-sm-6 col-md-offset-2 col-sm-offset-2">
                                            <div class="mar-bot">
                                                <img id="target" src="img/News-Paper-rack.jpg" alt="your image" style=" height: 300px; width: 400px;"/>
                                            </div>
                                     </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div id="data"></div>
                                    </div>    
                                </div>
                                </div>
                            </div>
                        </div>
								
								<div class="col-md-6 col-md-offset-2">
									<!--<div class="row col-md-12">
										<div class="div-padding" id="add-comment1">
												<a>View More Comments </a>
										</div>

										<div class="more-comment div-padding" >
											<a><i>Jay:</i></a> Some text comment
											<div class="date colour">Wed Jul 30 2014 at 19:15</div>
										</div>
										<div class="more-comment div-padding">
											<a><i>Manish:</i></a> Some text comment
											<div class="date colour">Wed Jul 30 2014 at 19:15</div>
										</div>

									</div>
									<div class="form-group row add-comment">
										<div class="col-md-7">
											<input type="text" class="form-control txt_comment1" id="txt_comment1" placeholder="Comment" name="">
										</div>
										<div class="col-md-2">
											 <input type="button" id="btn_comment" class="btn ctrl-btn btn_comment" value="Comment">
										</div>

									</div>-->
								</div>
								<!--<div>
								<embed width="100%" height="100%" name="plugin" src="http://localhost/dmstree_20_8_2014/DMStree.docx" type="application/vnd.ms-excel.sheet.binary.macroEnabled.12">
								</div>-->
								
								<!--<a href=".28aug_meetings.xlsx/Seven.pdf" id="embedURL" >PDF test</a>-->
								
								<div class="form-group row">
									<div class="col-md-12 col-sm-12">
										<input type="button" class="btn ctrl-btn btn-success btn-space " value="Revise" data-toggle="modal" data-target="#myModal" onclick="">
										<!--<button class="btn btn-success ctrl-btn  btn-space" type=""><i class="icon-ok-sign icon-white "></i>Revise</button>-->
										<!--<input type="reset" class="btn btn-primary btn-space" value="Reset" onclick="reset_upload();">-->
										<input type="button" class="btn ctrl-btn btn-space " value="Cancel">
										<input type="button" class="btn btn-danger btn-space " value="Check Out">
									
									</div>
								
								</div>
								
													<!-- Modal -->
								<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<h4 class="modal-title" id="myModalLabel">View Document</h4>
											</div>
											<div class="modal-body">
												Do You Want To Save.
											</div>										
											<div class="modal-footer control-label form-model-padding">
												<button class="btn btn-primary btn-space" type="button" id="sub" data-dismiss="modal"  onclick="updateRevision();">Confirm Save</button>
												<input type="button" class="btn btn-default" data-dismiss="modal" onclick="" value="Close"/>
											</div>
											
											
										</div>
									</div>
								</div>
							</form>
						<!--</div>-->
					
					</div>
					
				</div>
            </div>
            
        </div>

         <!--------- dash board footer------------------------------------------------>
        <?php include_once 'footer.php'?>
		
		<script src="jqueryui/ui/minified/jquery-ui.min.js"></script>
		<script src="js/dmstree_js/jquery.tag-editor.js"></script>
        <script type="text/javascript" src="js/dmstree_js/menu.js"></script>
        <script type="text/javascript" src="js/dmstree_js/view_document_page.js"></script>

    </body>
</html>