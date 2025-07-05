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

  .login_container {
    /* width: 1440px; */
    width: 100%;
    /* background: #E9F4F0; */
    display: flex;
    justify-content: center;
     align-items: center;
       background-image: url('img/Main Frame.svg'); /* Replace with your image path */
  background-size: cover;       /* Ensures the image covers the entire container */
  background-position: center;  /* Centers the image */
  background-repeat: no-repeat; /* Prevents tiling */
     
}

.login_div{
        width: 400px;
    min-height: 400px;
     transform: rotate(0deg);
    opacity: 1;
    border-radius: 12px;
    border: 1px solid #E0E0E0;
    background: #FFFFFF;
    box-shadow: 0px 0px 8px 0px #00422F0D;
    padding: 24px;
    display: flex
;
    gap: 16px;
}
.form-width{   
   display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 50px;
    gap: 24px;}


.div-padding{
  padding:0;
}


.login_form{width: 100%;
    height: 100%;}


.login_form_cls{
    background-color: #fff !important;
}

.form-signin {
    padding: 19px 29px 29px;
    background-color: #fff;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
    -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
    box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
    background-color: #f5f5f5;
    border-radius: 20px;
}


.dms_logo {
    display: flex
;
    justify-content: center;
}


.login_title {
    display: flex
;
    flex-direction: row;
    gap: 10px;
    padding: 0;
    justify-content: center;
}



.login_title h2 {
    font-weight: 600;
    font-size: 22px;
    color: #2E2E2E;
    line-height: 32px;
    letter-spacing: -0.25%;
}





/* .form-container {
    width: 352px;
    height: 246px;
    gap: 24px;
} */



form-inner {
    /* height: 172px; */
    /* display: block; */
    gap: 12px;
}


.form-group {
    margin-bottom: 16px;
}

.form-label {
    display: block;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    font-size: 14px;
    line-height: 20px;
    color: #424242;
    margin-bottom: 8px;
}


.form-input {
  width: 345px;
  height: 40px;
  border-radius: 8px;
  padding: 8px 12px;
  display: flex;
  align-items: center;
  gap: 4px;
  box-sizing: border-box;
  box-shadow: 0px 1px 2px 0px #1018280D;
border: 1px solid #E0E0E0;
background: #FAFAFA;
}
.form-input:focus{
  outline:0;
}
.form-options {
  display: flex;
  justify-content: space-between;
  width: 345px;
  height: 24px;
  margin-top: 8px;
}

.remember-me {
  display: flex;
  align-items: center;
  gap: 4px;
  font-size: 14px;
  color: #424242;
  font-weight: 500;
}


input[type="checkbox"] {
    accent-color: #00684A;
      width: 15px;
  height: 15px;
  margin:0;
}
.forgot-password {
  color: #00684A;
  font-size: 14px;
  text-decoration: none;
   font-family: 'Inter', sans-serif;
font-weight: 500;
font-style: normal; /* "Medium" is not valid for font-style */
font-size: 14px;
line-height: 20px;
letter-spacing: 0.002em; /* 0.2% converted to em */
text-align: right;
}

.login-button {
  width: 345px;
  height: 40px;
  border-radius: 8px;
  padding: 12px;
  background: #00684A;
  color: #fff;
  border: 2px solid rgba(16, 24, 40, 0.05);
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  font-family: 'Inter', sans-serif;
  font-weight: 500;
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

<!-- </div> -->
 <div class="login_container">

   <div class="login_div">
    <!-- <div class="row form-width"> -->
        <!-- <form id="loginForm" class="form-signin login_form_cls log_form"  method="post" action="my_script.php"> -->
          <form id="loginForm" method="post" action="my_script.php">
           <div class="dms_logo">
                                <img src="img/dms_Logo(2).svg" alt="">
                            </div>
                             <div class="login_title">
                                <h2>Login to DMS Tree</h2>
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
                             </div>
                              <div class="form-container">
                    <div class="form-inner">
                      <!-- Email Section -->
                      <div class="form-group">
                        <label for="txt_user_name" class="form-label">Email</label>
                        <input
                          
                          class="form-input"
                          id="txt_user_name"
                          name="username"
                          placeholder="Enter your Email"
                          autocomplete="off"
                        />
                      </div>

                      <!-- Password Section -->
                      <div class="form-group">
                        <label for="txt_user_name_" class="form-label">Password</label>
                        <input
                          type="password"
                          class="form-input"
                          id="txt_user_name_"
                          name="password"
                          placeholder="Enter your Password"
                          autocomplete="off"
                        />
                        
                      </div>
                          <div class="form-options">
                          <label class="remember-me">
                            <input type="checkbox" class="checkbox" /> Remember me
                          </label>
                          <a href="#" class="forgot-password">Forgot Password?</a>
                        </div>
                      <!-- Login Button -->
                       <div class="form-options">
                      <button
                        class="login-button"
                        type="submit"
                        name="loginbtn"
                        value="login"
                      >
                        Login
                      </button>
                      </div>
                    </div>
                  </div>

        <script type="text/javascript" src="js/dmstree_js/sign_validation.js"></script>
        <script type="text/javascript" src="js/dmstree_js/formvalidation.js"></script>
  </form>

                <!-- </div> -->
            </div>
        </div>
</div>

    </body>
</html>