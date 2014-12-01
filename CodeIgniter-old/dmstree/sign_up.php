<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <title>Sign up Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="dist/css/bootstrap.css"/>
    <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
    <link rel="stylesheet" href="css/stylesheet.css"/>

    <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>
     <script type="text/javascript" src="js/moment.min.js"></script> 
     <script type="text/javascript" src="js/dmstree_js/date.js"></script>
     
  </head>

  <body>

  <!-- logo of company-->
    <div class="header_nav">  
		<div class="container header-container ">
			 <div class="row">
				 <div class="col-md-4"><img src="img/LOGO-2.PNG" alt="Logo_image" id="dms_logo" width="280" height="75"></div>
			 </div>
		 </div> 
     </div> 
	 
	 
	 
	<!--Registration Page -->
	
<!--        <div class="wrapper">-->
  
	<div class="container form_container well container-narrow div-padding-top">	
            
		<div class="row ">
			<div class="col-md-12 form_title "><h2 class="text-muted"><b>Sign Up</b></h2></div>
		</div>
       
		<!-- Form start-->	
               <div class="row">
<!--               <fieldset>-->
		<form id="registrationForm" method="post" class="form-horizontal col-md-12 form-action" action="saveTenantInfo.php" >
<!--                    <div class="form-group gap">-->
                    <div class="row gap">
                            <div class="col-md-4 form-group">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="rd_individual" value="individual" checked>
                                                        Individual
                                        </label>
                                    </div>
                                <ul>
                            <li>
                                
                                <div class="radio">
                                        <label>
                                            <input type="radio" name="individualoptionsRadiosPackage" id="rd_individual_package1" value="individual_package1">
                                                        Package-1
                                        </label>
                                    </div>
                               
                            </li>
                            <li>
                                <div class="radio">
                                        <label>
                                            <input type="radio" name="individualoptionsRadiosPackage" id="rd_individual_package2" value="individual_package2">
                                                        Package-2
                                        </label>
                                    </div>
                            </li>
                            <li>
                                <div class="radio">
                                        <label>
                                            <input type="radio" name="individualoptionsRadiosPackage" id="rd_individual_package3" value="individual_package3">
                                                        Package-3
                                        </label>
                                    </div>
                                
                            </li>
                        </ul>
                            </div>
                            <div class="col-md-4 form-group">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="optionsRadios" id="rd_corporate" value="corporate">
                                                        Corporate
                                        </label>
                                    </div>
                                <ul>
                            <li>
                                <div class="radio">
                                        <label>
                                            <input type="radio" name="corporateoptionsRadiosPackage" id="rd_corporate_package1" value="corporate_package1" disabled>
                                                        Package-1
                                        </label>
                                    </div>
                            </li>
                            <li>
                                <div class="radio">
                                        <label>
                                            <input type="radio" name="corporateoptionsRadiosPackage" id="rd_corporate_package2" value="corporate_package2" disabled>
                                                        Package-2
                                        </label>
                                    </div>
                            </li>
                            <li>
                                <div class="radio">
                                        <label>
                                            <input type="radio" name="corporateoptionsRadiosPackage" id="rd_corporate_package3" value="corporate_package3" disabled>
                                                        Package-3
                                        </label>
                                    </div>
                            </li>
                        </ul>

                            </div>
<!--                    </div>   -->
                    </div>
                    <div class="form-group row space">
                         <label for="txt_company_name" class="col-md-4 control-label">Name of Company</label>
                             <div class="col-md-6">
                                   <input type="text" class="form-control" id="txt_company_name" placeholder="Name of Company" name="companyname">
                             </div>
                   </div>
                   <div class="form-group row">
                        <label for="txt_admin_name" class="col-md-4  control-label">Name of Admin</label>
                              <div class="col-md-6">
                                    <input type="text" class="form-control" id="txt_admin_name" placeholder="Name of Admin" name="adminname">
                              </div>
                  </div>
                  <div class="form-group row">
                       <label for="txt_admin_contact" class="col-md-4  control-label">Admin Contact No.</label>
                             <div class="col-md-6">
                                 <div class="row">
                                 <div class="col-md-5">
                                     <select class="form-control">
                                        <option>+91</option>
                                        <option>+92</option>
                                        <option>+93</option>
                                        <option>+94</option>
                                        <option>+95</option>
                                     </select>
<!--                                 <input type="text" class="form-control" id="" value="+91" size="2"disabled>-->
                                 </div>
                                 <div class="col-md-7 txt-padding">
                                 <input type="text" class="form-control" id="txt_admin_contact"  placeholder="Admin Contact No." name="admincontact">
                                 </div>
                                 </div>
                                 
                            </div> 
                </div>
<!--                <div class="form-group row ">
                    <label for="txt_admin_contact" class="col-md-4  control-label">Admin Contact No.</label>
                    <div class="col-md-6">
                        <div class="input-group">
                        <div class="input-group-addon">+91</div>
                        <input class="form-control" type="text" id="txt_admin_contact" placeholder="Admin Contact No." name="admincontact">
                </div> 
                </div>
                </div>-->
                <div class="form-group row">
                    <label for="txt_admin_mail" class="col-md-4 control-label">Admin E-Mail</label>
                         <div class="col-md-6">
                             <input type="text" class="form-control" id="txt_admin_mail" placeholder="Admin E-Mail" name="adminemail">
                         </div>
                </div>
<div class="individual">
                <div class="form-group row ">
                    <label for="txt_user_name" class="col-md-4 control-label">Name of User</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="txt_user_name" placeholder="Name of User" name="individualname">
                    </div>
                </div>
                <div class="form-group row ">
                    <label for="txt_user_contact" class="col-md-4  control-label">User Contact No.</label>
                    <div class="col-md-6">
                        <div class="row">
                                 <div class="col-md-5">
                                     <select class="form-control">
                                        <option>+91</option>
                                        <option>+92</option>
                                        <option>+93</option>
                                        <option>+94</option>
                                        <option>+95</option>
                                     </select>
<!--                                 <input type="text" class="form-control" id="" value="+91" size="2"disabled>-->
                                 </div>
                                 <div class="col-md-7 txt-padding">
                                 <input type="text" class="form-control" id="txt_user_contact" placeholder="User Contact No." name="usercontact">
                                 </div>
                                 </div>   
                    </div>
                </div>
<!--                <div class="form-group row ">
                    <label for="txt_user_contact" class="col-md-4  control-label">User Contact No.</label>
                    <div class="col-md-6">
                        <div class="input-group">
                        <div class="input-group-addon">+91</div>
                        <input class="form-control" type="text" id="txt_user_contact" placeholder="User Contact No." name="usercontact">
                </div> 
                </div>
                </div>-->
                <div class="form-group row ">
                    <label for="txt_user_mail" class="col-md-4 control-label s">User E-Mail</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="txt_user_mail" placeholder="User E-Mail" name="useremail">
                    </div>
                </div>
</div>
<!--                    <button class="btn btn-success ctrl-btn"><i class="icon-ok-sign icon-white"></i> Save Button</button>
                    <button class="btn btn-danger ctrl-btn"><i class="icon-trash icon-white"></i> Delete Button</button>
                     <button class="btn ctrl-btn">Submit</button>-->
                    
                    
                       
             <div class="form-group row ">
                            <label for="txt_user_mail" class="col-md-4 control-label">Package Selected</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="txt_package" placeholder="Package Selected" value="" name="" disabled>
                            </div>
            </div>
            <div class="form-group row ">
                            <label for="txt_user_mail" class="col-md-4 control-label">Date of Recharge</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="txt_recharge_date" placeholder="Date of Recharge" value="" name="" disabled>
                            </div>
            </div>
            <div class="form-group row ">
                            <label for="txt_user_mail" class="col-md-4 control-label">Package Price</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="txt_package_price" placeholder="Package Price" value="" name="" disabled>
                            </div>
            </div>
            <div class="form-group row ">
                            <label for="txt_user_mail" class="col-md-4  control-label">Taxes</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="txt_taxes" placeholder="Taxes" name="" value="" disabled>
                            </div>
            </div>
            <div class="form-group row ">
                            <label for="txt_user_mail" class="col-md-4 control-label">Total amount to be paid</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control add-more" id="txt_total_amount" placeholder="Total Amount to be Paid" name="" disabled>
                            </div>
            </div>
<!--            <form method="post" action="verify.php">-->
             <div class="row control-label">
                 <div>
                    <?php
                    require_once('recaptcha-php/recaptchalib.php');
                    $publickey = "6LfQePcSAAAAAL2qmeWyCJzYwbOKPeWIXzK1F8iz"; // you got this from the signup page for dmstree
                    //$publickey = "6LdmDPgSAAAAAHSetV7qYiSj-SXYt5C8h88_ELhB"; // you got this from the signup page for incrustsoftware
                    echo recaptcha_get_html($publickey);
                    ?>
                </div>
<!--                <input type="submit" />-->
             </div>
<!--           </form>-->
                    	
            <div class="row control-label">
            <div class="col-md-12 ">
                <button class="btn btn-success ctrl-btn  btn-space"><i class="icon-ok-sign icon-white "></i> Submit</button>
                <input type="reset" class="btn btn-primary btn-space" value="Reset" onclick="reset_registrationform()">
                <input type="button" class="btn ctrl-btn btn-space " value="Cancel">
            </div>
            </div>
                

					
		</form>
		<!--- Form ends-->
<!--                </fieldset>-->
                   </div>
               </div>
  
	


	
<br><br>

    <script type="text/javascript" src="js/dmstree_js/sign_validation.js"></script>
    <script type="text/javascript" src="js/dmstree_js/formvalidation.js"></script>

  </body>
</html>
