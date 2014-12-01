
 
        
<div class="well div-padding-top">
    <div class="row">
        <div class="col-md-12 form_title "><h2 class="text-muted"><b>Upload Document</b></h2></div>
    </div>
    
    <div class="div-padding">
        <form name="fileUpload" id="uploadDocumentForm" method="post" class="form-horizontal  form-action" action="javascript:void(0);" enctype="multipart/form-data">
              <input type="file" name="file subfile" style="visibility:hidden;" id="pdffile"  style="visibility:hidden;" multiple />
		
              <div class="row upload_box">
                  <div class="file_browser input-group"><input type="file" name="multiple_files[]" id="_multiple_files"  multiple /></div> <!--class="hide_broswe"-->
                  <div class="file_upload input-group"><input type="submit" value="Upload" class="upload_button" /> </div>
              </div>  
              <div class="file_boxes"></div>
                <span id="removed_files"></span>
              
                
              <div class="form-group row ">
                  <label class="control-label col-md-2" for="doc_file">Browse Document</label>
                  <div class="input-group col-md-6">
                      <input type="file" name="sfile" id="doc_file" class="form-control col-upload" multiple>	
                  </div>
              </div>
                  
              <div class="form-group row ">
                  <label class="control-label col-md-2" for="doc_scan">Scan Document</label>
                  <div class="input-group col-md-6">
                      <input type="button" name="sfile" id="doc_scan" class="btn ctrl-btn col-md-offset-1" value="Scan">	
                  </div>
              </div>


              <input type="hidden" name="count" value="2" id="hin" />
                  
              <div class="control-group form-group row" id="tag1">
                  <label class="control-label col-md-2" for="txt_tag">Tags</label>
                  <div class="controls col-md-6"> 
                      <textarea id="txt_tag" class="form-control" rows="3"></textarea>
                  </div>
              </div>

              <div class="form-group row space">
                  <label for="txt_template" class="col-md-2 control-label">Template</label>
                  <div class="col-md-9">
                      <div class="row">
                          <div class="col-md-8">	
                              <select size="3" name="listbox" class="form-control template col-md-6">
                                  
                                 <!---<select class="form-control template">-->
                                  <option value="template1" id="temp1" onmouseover="display_temp('template1')" onmouseout="display_temp1('template1')">Template 1</option>
                                  <option value="template2" id="temp2" onmouseover="display_temp('template2')" onmouseout="display_temp1('template2')">Template 2</option>
                                  <option value="template3" id="temp3" onmouseover="display_temp('template3')" onmouseout="display_temp1('template3')">Template 3</option>
                                  <option value="template4" id="temp4" onmouseover="display_temp('template4')" onmouseout="display_temp1('template4')">Template 4</option>
                                  <option value="template5" id="temp5" onmouseover="display_temp('template5')" onmouseout="display_temp1('template5')">Template 5</option>
                              </select>
                          </div>
                          <div class="col-md-4">
                              <ul>
                                  <li id="template1" class="temp">Template 1 Discription</li>
                                  <li id="template2" class="temp">Template 2 Discription</li>
                                  <li id="template3" class="temp">Template 3 Discription</li>
                                  <li id="template4" class="temp">Template 4 Discription</li>
                                  <li id="template5" class="temp">Template 5 Discription</li>
                              </ul>
                          </div>
                              
                      </div>
                  </div>
              </div>
              
              
              <!------ display page on click on select option-------------------------------------------->
              <div class="form-group row space" >
                  <div class="col-md-12" id="template">
                      
                  </div>
              </div>
              <!---------end--------------->
                  
              <div class="row">
                  <div class="form-group">
                      <label class="col-md-2 control-label mar-left " >
                          
                          <strong>Expiry Date</strong>
                      </label>
                      <div class='col-md-6' id='date1'>
                          <div class='input-group date' id='datetimepicker' data-date-format="YYYY/MM/DD">
                              <input type='text' class="form-control" name="date" />
                              <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                              </span
                          </div>
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12 ">
                      <div class="radio row">
                          <label>
                              <input type="checkbox" name="optionsRadios" id="chk_physical_loc" value="physical_loc" id="physical_loc">
                              <strong>Physical Location</strong>
                          </label>
                      </div>
                      <div class="col-md-12" id="div_pic">
                          <div class="row div-border">
                              <div class="col-md-6 col-md-offset-2 ">
                                  
                                  <input type="file" name="file" accept="image/*" style="visibility:hidden;" id="txt_pic" />
                                  <div class="input-group mar-bot">
                                      
                                      <input type="text" name="" id="txt_picture" class="form-control">
                                      <span class="input-group-btn ">
                                          <input type="button" class="btn ctrl-btn" value="Browse" onclick="$('#txt_pic').click();">
                                      </span>
                                          
                                  </div>
                                      
                                  <div class="mar-bot">
                                      
                                      <img id="target" src="" alt="your image" style=" height: 300px; width: 400px;"/>
                                  </div>
                                  <div>
                                      <button class="btn ctrl-btn  btn-space"><i class="icon-ok-sign icon-white "></i>Mark Location</button>
                                      <input type="button" class="btn ctrl-btn btn-space" value="Reset" onclick="reset_pic()">
                                      <input type="button" class="btn ctrl-btn btn-space " value="Cancel">
                                  </div>
                              </div>
                          </div>
                              
                      </div>
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-md-12">
                      <button class="btn btn-success ctrl-btn  btn-space" type="submit"><i class="icon-ok-sign icon-white "></i>Save</button>
                      <input type="reset" class="btn btn-primary btn-space" value="Reset" onclick="reset_upload();">
                      <input type="button" class="btn ctrl-btn btn-space " value="Cancel">
                          
                  </div>
                      
              </div>
        </form>
        
    </div>
    
</div>