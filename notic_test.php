<?php
?>
<form name="form_notice" id="form_notice" method="post" action="notice_board_process.php" enctype="multipart/form-data" novalidate="novalidate" class="bv-form"><input type="hidden" name="__csrf_magic" value="sid:2bffdb616840d37f837e04b22b9467f9e76e8691,1416039020">
									<div class="form-group row space">
										<label for="sel_problem_category" class="col-md-3 control-label" id="txt_problem_category">Notice Category</label>
										<div class="col-md-6">
											<input list="notice_category" name="notice_category" id="list" class="form-control" data-bv-field="notice_category">
												<datalist id="notice_category">
													<!--<option value="select" id="select_std_list">Select </option>-->
													<option value="Creating Template" id="select_std_list1">Creating Template</option>
													<option value="Add Tags" id="select_std_list2">Adding Tags</option>
													<option value="Uploading Document" id="select_std_list3">Uploading Document </option>
													<option value="Profile Update" id="select_std_list4">Profile Update</option>
												</datalist>
										<small class="help-block" data-bv-validator="notEmpty" data-bv-for="notice_category" data-bv-result="VALID" style="display: none;">The notice category is required and can't be empty</small></div>
									</div>
									<div class="form-group row space">
										<label for="txt_notice_title" class="col-md-3 control-label" id="">Notice Title</label>
										<div class="col-md-6">
											<input type="text" class="form-control" id="txt_notice_title" placeholder="Notice Title" name="notice_title" data-bv-field="notice_title">	
										<small class="help-block" data-bv-validator="notEmpty" data-bv-for="notice_title" data-bv-result="VALID" style="display: none;">The notice title is required and can't be empty</small></div>
									</div>
									<div class="form-group row space">
										<label for="txt_notice_description" class="col-md-3 control-label" id="">Notice Description</label>
										<div class="col-md-6">
											<textarea class="form-control" id="txt_notice_description" rows="3" placeholder="Notice Description" name="notice_description" data-bv-field="notice_description"></textarea>	
										<small class="help-block" data-bv-validator="notEmpty" data-bv-for="notice_description" data-bv-result="VALID" style="display: none;">The description is required and can't be empty</small></div>
									</div>
									<div class="form-group row space">
										<label for="txt_notice_expiry_date" class="col-md-3 control-label" id="">Notice Valid Till</label>
										<div class="col-md-6">
											<div class="input-group date" id="datetimepicker" data-date-format="DD/MM/YYYY">
												<input type="text" class="form-control date1" id="expiry_date" name="date" value="" readonly="">
												<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>	
										</div>
									</div>
									<div class="form-group row space">
										<label for="txt_notice_image" class="col-md-3 control-label" id="">Image</label>
										<div class="col-md-6">
											<input type="file" id="txt_notice_image" name="notice_img">	
										</div>
									</div>
									<div class="form-group row space">
										<div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3">
											<img src="" id="notice_image" class="img-responsive" style="height:90px;width:100%;">
										</div>
									</div>
								</form>
								
								