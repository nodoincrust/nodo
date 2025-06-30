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
    <style>
   /* .login_container {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 0;
}

.login_div {
  width: 100%;
  max-width: 400px;
  background-color: #fff;
  padding: 24px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
} */


input[type="checkbox"] {
margin-bottom:8px;
}
.dms_logo img {
  max-width: 100%;
  height: auto;
  display: block;
  margin: 0 auto 16px;
}

.login_title h2 {
  text-align: center;
  font-family: 'Inter', sans-serif;
  font-weight: 600;
  font-size: 20px;
  margin-bottom: 24px;
  color: #333;
      margin-top: 1px;
}

.form-container {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.form-wrapper {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 12px;
      margin-top: -21px;
}

.form-field {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.form-label {
  font-family: 'Inter', sans-serif;
  font-weight: 500;
  font-size: 14px;
  color: #424242;
}

.f_input {
  width: 345px;
 height: 40px !important;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 8px 12px;
  box-sizing: border-box;
  font-size: 14px;
}

.form-footer {
  display: flex;
  align-items: center;
  margin-top: 8px;
  font-size: 14px;
      gap: 111px;
}

.remember-me {
  display: flex;
  align-items: center;
  gap: 6px;
  color:black;
}


.forgot-password {
  color: #00684A;
  text-decoration: none;
}

.forgot-password:hover {
  text-decoration: underline;
}

.submit-button {
  width: 345px;
  height: 40px;
  background-color: #00684A;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.submit-button:hover {
  background-color: #00503a;
}


    </style>
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
                     <div class="form-container">
            <div class="form-wrapper">
              <div class="form-group">
                
                <div class="form-field">
                  <label for="txt_user_name" class="form-label">Email</label>
                  <input
                    
                    class="form-control f_input"
                    id="txt_user_name"
                    name="username"
                    placeholder="Enter your Email"
                    
                    value="" autocomplete="off"
                  />
                </div>

                <div class="form-field">
                  <label for="txt_user_name_" class="form-label">Password</label>
                  <input
                    type="password"
                    class="form-control f_input"
                    id="txt_user_name_"
                    name="password"
                    placeholder="Enter your Password"
                    
                    value="" autocomplete="off"
                  />

                  <div class="form-footer">
                    <div class="remember-me">
                      <input type="checkbox" id="remember-me" value="remember-me" />
                      <label for="remember-me" style="font-weight: 500;color: #424242;
                     ">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                  </div>
                </div>

                <button type="submit" name="loginbtn" class="submit-button" value="login">Login</button>
              </div>
            </div>
          </div>
                            <!-- <div class="btn-align">
                                 <div class="row control-label  ">
                                     <button class="btn btn-primary btn-space" type="submit" name="loginbtn" value="login">Sign in</button>
                                     <input type="reset" class="btn ctrl-btn" role="button" value="Reset" onclick="reset_loginform()">
                                 </div>
                            </div> -->
                            
                                
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