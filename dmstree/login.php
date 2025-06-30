<html>
    <head>
        <meta charset="utf-8">
        <title>Login Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="discription" content="">
        <meta name="author" content="">
        
        <link rel="stylesheet" href="dist/css/bootstrap.css"/>
        <link rel="stylesheet" href="css/stylesheet.css"/>
        <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css"/>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/vendor/jquery/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>

        
    </head>
    <body>
        <!-- logo of company-->
        <!-- <div class="header_nav">  
            <div class="container header-container ">
                <div class="row">
                       <div class="col-md-4"><img src="img/LOGO-2.jpg" alt="Logo_image" id="dms_logo" width="280" height="75"></div>
                </div>
            </div> 
        </div> -->
<div class="login_container">
    <div class="login_div">
        <div class="container container-narrow div-padding">
            <div class="row form-width">
                
              
                        <form id="loginForm" class="form-signin login_form_cls" method="post" action="my_script.php"><!--Databasefiles/controller_process.php-->
                            <div class="dms_logo">
                                <img src="img/dms_Logo(2).svg" alt="">
                            </div>
                            <!-- <h2 class="form-signin-heading text-muted">Please sign in</h2> -->
                             <div class="login_title">
                                <h2>Login to DMS Tree</h2>
                             </div>
                             <!-- <h2 class="form-login-heading text-muted">Login to DMS Tree</h2> -->
                                <!-- <div class="form-group row ">
                                    <label for="txt_user_name" class="col-md-3 control-label">User Name</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" id="txt_user_name" placeholder="User Name" name="username" value="" autocomplete="off">
                                        </div>
                                </div>   
                                <div class="form-group row ">
                                    <label for="txt_user_name" class="col-md-3 control-label">Password</label>
                                        <div class="col-md-7">
                                            <input type="password" class="form-control" id="txt_user_name_" placeholder="Password" name="password" value="" autocomplete="off">
                                        </div>
                                </div> 
                                <div class="form-group row">
                                    <div class="col-md-4">
                                    <label class="checkbox">
                                        <input type="checkbox" value="remember-me"> Remember me
                                    </label>
                                    </div>
                                </div>
                            <div class="form-group row ">
                                        <div class="col-md-6">
                                            <a href="#"> Forgotten Your Password?</a>
                                        </div>
                            </div> -->
                            <div style="width: 345px;height: 236px;gap: 24px;">
                                <div style="height:172px;display:flex;gap:12px">
                                    <div style="height:64px;display:flex;gap:4px">
                                        <div style="width: 345px;height: 20px;gap: 10px;display:flex">
                                        <label for="" style="font-family: 'Inter', sans-serif;font-weight: 500;font-size: 14px; line-height: 20px; letter-spacing: 0.2%;color: #424242; width: 345px;height: 20px;">Email</label>
                                        </div>
                                        <div style="width: 345px;height: 40px;border-radius: 8px;border-width: 1px;gap: 4px;padding: 8px 12px;">
                                            <input type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-align">
                                 <div class="row control-label  ">
                                     <button class="btn btn-primary btn-space" type="submit" name="loginbtn" value="login">Sign in</button>
                                     <input type="reset" class="btn ctrl-btn" role="button" value="Reset" onclick="reset_loginform()">
                                 </div>
                            </div>
                            
                                
                        </form>

                </div>
            </div>
        </div>
</div>
</div>
        <script type="text/javascript" src="js/dmstree_js/sign_validation.js"></script>
        <script type="text/javascript" src="js/dmstree_js/formvalidation.js"></script>


    </body>
</html>