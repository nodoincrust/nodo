<!html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Document Bouquet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="discription" content="">
        <meta name="author" content="">
        
        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/dmstree_js/moment.min.js"></script>
        <script src="justGage.1.0.1/resources/js/raphael.2.1.0.min.js"></script>
        <script src="justGage.1.0.1/resources/js/justgage.1.0.1.min.js"></script>
        <style>
            .document_bouquet_div
            {
                margin: 10px 0px;
            }
            .screen_tilte
            {
                padding-bottom: 20px !important;
                border-bottom: 1px solid darkgray;
            }
            .title_div
            {
                margin-bottom: 15px;
            }
            .bouquet_subdoc
            {
                padding: 10px 0px;
            }
            .add_doc
            {
                margin: 10px 0px;
            }
            .subdoc_tbl
            {
                margin: 10px 0px;
            }
            </style>
    </head>    
    <body>
        
       <?php include_once 'header.php'; ?> 
        <div class="row row-margin">
            <div class="col-md-3">
                <?php include_once'dash_menu.php'?>  
            </div>
            <div class="col-md-9 div-padding-left" id="body-content">
                <div class="well document_bouquet_div">
                    <div class="row title_div">
                        <center><h3 class="screen_tilte">Document Bouquet</h3></center>
                    </div>    
                    <div class="row form-group">
                        <label class="col-md-3">Add Bouquet Name:</label>
                        <div class="col-md-9">
                            <input type="text" name="boquet_name" />
                        </div>
                    </div> 
                    <div class="row form-group">
                        <label class="col-md-3">Select Master Document:</label>
                        <div class="col-md-9">
                            <input type="file" name="master_bouquet_doc">
                        </div>
                    </div> 
                    <div class="row form-group">
                        <label class="col-md-3">Bouquet Description:</label>
                        <div class="col-md-9">
                            <textarea name="boquet_desc" rows="3" cols="70" ></textarea>
                        </div>
                    </div>
                    <div class="row">
                    <table class="col-md-12" id="bouquet_subdoc" frame="box">

                         <tr class="subdoc_record1 record">
                             <td>
                             <table class="subdoc_tbl">
                                 <tr class="row">
                                     <td class="col-md-3"><label>Select subdocument:</label></td>
                                     <td class="col-md-9"><input type="file" name="bouquet_subdoc" class="bouquet_subdoc"></td>
                                 </tr> 
                                 <tr class="row">
                                     <td class="col-md-3"><label>Bouquet Description:</label></td>
                                     <td class="col-md-9"><textarea name="boquet_desc" rows="2" cols="70" ></textarea></td>
                                 </tr>    
                             </table>
                             </td>    
                         </tr>    
                    </table>
                    </div>    
                    <div class="row"><span class="col-md-9 offset-3"><input type="button" value="Add Document" class="add_doc" onclick="add_bouquet_document()"></span></div>
                </div>    
            </div>
        </div>
          
        <?php include_once 'footer.php'?>
        <script>
            function add_bouquet_document()
            {
                var bouquet_doc_html = '';
                var totalrecords=$('#bouquet_subdoc tr').length;
//                alert(totalrecords);
                var newrecord=parseInt(totalrecords);
                newrecord=newrecord+1;
                bouquet_doc_html +='<tr id="subdoc_record'+newrecord+'">';
                bouquet_doc_html +='<td>';
                bouquet_doc_html +='<table class="subdoc_tbl">';
                bouquet_doc_html +='<tr class="row">';
                bouquet_doc_html +='<td class="col-md-3"><label>Select subdocument:</label></td>';
                bouquet_doc_html +='<td class="col-md-9"><input type="file" name="bouquet_subdoc" class="bouquet_subdoc"></td>';
                bouquet_doc_html +='</tr>';
                bouquet_doc_html +='<tr class="row">';
                bouquet_doc_html +='<td class="col-md-3"><label>Bouquet Description:</label></td>';
                bouquet_doc_html +='<td class="col-md-9"><textarea name="boquet_desc" rows="2" cols="70" ></textarea></td>';
                bouquet_doc_html +='</tr>';
                bouquet_doc_html += '</table>';
                bouquet_doc_html +='</td>';
                bouquet_doc_html +='</tr>';
//                alert(bouquet_doc_html);
//                $(bouquet_doc_html).insertAfter('#bouquet_subdoc #subdoc_record'+totalrecords);
                $('#bouquet_subdoc').append(bouquet_doc_html);
            }
        </script>
    </body>
</html>