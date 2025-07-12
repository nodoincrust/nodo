<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Nodo AI - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Nodo AI Login Page">
  <meta name="author" content="">
  <style>
    @font-face {
      font-family: 'Space Grotesk';
      src: url('fonts/SpaceGrotesk-VariableFont_wght.ttf') format('truetype');
      font-weight: 400 700;
      font-style: normal;
    }

    .main-title,
    .welcome-heading {
      font-family: 'Space Grotesk', Arial, sans-serif !important;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: #f8f9fa;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .header {
      background: #FFDA79;
      padding: 10px 17px;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      font-size: 18px;
      color: #1B5563;
    }

    .logo-icon {
      width: 24px;
      height: 24px;
      background: #1B5563;
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 12px;
    }

    .main-container {
      flex: 1;
      display: flex;
      min-height: calc(100vh - 64px);
      /* overflow: hidden; */
    }

    .left-section {
      flex: 1;
      /* background: rgba(255, 218, 121, 0.3); */
      background: linear-gradient(to bottom right, #FCF5E5, #FFFDE6);
      padding: 25px 60px;
      display: flex;
      flex-direction: column;
      position: relative;
    }

    .content-wrapper {
      max-width: 550px;
      text-align: start;
    }

    .main-title {
      font-size: 32px;
      font-weight: 700;
      font-family: 'Space Grotesk', Arial, sans-serif;
      color: #1B5563;
      line-height: 1.2;
      margin-bottom: 16px;
    }

    .subtitle {
      font-size: 16px;
      color: #6c757d;
      margin-bottom: 20px;
      line-height: 1.5;
      font-family: 'Inter', Arial, sans-serif;
    }

    /* .features-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      margin-top: 20px;
    } */

    /* .feature-card {
      background-color: #FFEAAD;
      border-radius: 16px;
      padding: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
    } */

    /* .feature-card:hover {
      transform: translateY(-4px);
    } */

    .feature-icon {
      width: 48px;
      height: 48px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }

    .folder-icon {
      background: #ffd43b;
      color: #b8860b;
    }

    .cloud-icon {
      background: #87ceeb;
      color: #4682b4;
    }

    .chip-icon {
      background: #ffb347;
      color: #d2691e;
    }

    .shield-icon {
      background: #98fb98;
      color: #228b22;
    }

    .right-section {
      width: 575px;
      background: white;
      padding: 60px 60px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
    }

    .login-form {
      width: 100%;
      max-width: 450px;
    }

    .login-title {
      margin-bottom: 20px;
    }

    .login-title h2 {
      font-size: 32px;
      font-weight: 700;
      color: #1B5563;
      margin-bottom: 8px;
    }

    .welcome-subtitle {
      font-size: 16px;
      color: #6c757d;
      font-weight: 400;
      font-family: 'Inter', Arial, sans-serif;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      display: block;
      font-weight: 500;
      font-size: 14px;
      color: #374151;
      margin-bottom: 8px;
    }

    .input-wrapper {
      position: relative;
    }

    .form-input {
      width: 100%;
      padding: 12px 16px 12px 44px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      background: #f9fafb;
      font-size: 14px;
      color: #374151;
      transition: all 0.2s ease;
    }

    .form-input:focus {
      outline: none;
      border-color: #1B5563;
      background: white;
      box-shadow: 0 0 0 3px rgba(27, 85, 99, 0.1);
    }

    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      width: 16px;
      height: 16px;
      color: #9ca3af;
      pointer-events: none;
    }

    .form-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: #374151;
      cursor: pointer;
    }

    .remember-me input[type="checkbox"] {
      width: 16px;
      height: 16px;
      accent-color: #1B5563;
    }

    .forgot-password {
      color: #1B5563;
      font-size: 14px;
      text-decoration: none;
      font-weight: 500;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }

    .login-button {
      width: 100%;
      padding: 12px;
      background: #1B5563;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.2s ease;
      margin-bottom: 24px;
    }

    .login-button:hover {
      background: #164449;
    }

    .login-button:active {
      transform: translateY(1px);
    }

    .signup-link {
      text-align: center;
      font-size: 14px;
      color: #6c757d;
    }

    .signup-link a {
      color: #1B5563;
      /* text-decoration: none; */
      font-weight: 600;
    }

    .signup-link a:hover {
      /* text-decoration: underline; */
    }

    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #6c757d;
      cursor: pointer;
      font-size: 12px;
      padding: 4px;
    }

    .password-toggle:hover {
      color: #1B5563;
    }

    @media (max-width: 968px) {
      .main-container {
        flex-direction: column;
      }

      .left-section {
        padding: 40px 20px;
        justify-content: center;
        align-items: center;
      }

      .right-section {
        width: 100%;
        padding: 40px 20px;
         justify-content: center;
        align-items: center;
      }

      /* .features-grid {
        grid-template-columns: 1fr;
      } */
    }

    /* Laptops - 1025px to 1280px */
    @media (min-width: 1025px) and (max-width: 1280px) {
      .header {
        padding: 10px 57px;
      }
      
    }

    /* Desktops (HD+) - 1281px and above */
    @media (min-width: 1281px) {
      .header {
        padding: 10px 57px;
      }

      .left-section {
        height: fit-content;
      }

      .right-section {
        height: fit-content;
      } 
    }
    

    /* .features-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 10px;
      padding: 20px;
      background-color: #FFF0CA;
      light background
      border-radius: 20px;
    } */

    /* .feature-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 25px rgba(255, 180, 50, 0.3);
    } */

    .feature-icon {
      font-size: 48px;
      color: #ffb700;
      filter: drop-shadow(0 2px 4px rgba(255, 200, 0, 0.4));
    }

    @font-face {
      font-family: 'Inter';
      src: url('fonts/Inter-VariableFont_opsz,wght.ttf') format('truetype');
      font-weight: 100 900;
      font-style: normal;
    }

    /* Validation error styles for login page */
    .has-error .form-label,
    .has-error .form-input,
    .has-error .form-control {
      color: #d9534f !important;
      border-color: #d9534f !important;
    }
    .help-block {
      color: #d9534f !important;
      font-size: 13px;
      margin-top: 4px;
      margin-bottom: 0;
    }
  </style>
</head>

<body>
  <div class="header">
    <div class="logo">
      <img src="img/Logo.svg" alt="DMS Logo">
    </div>
  </div>

  <div class="main-container">
    <div class="left-section">
      <div class="content-wrapper">
        <h1 class="main-title">Intelligent Document Management, Powered by AI</h1>
        <p class="subtitle">Nodo AI helps you store, organize, edit and summarize your business documents - all in one secure platform.</p>

        <div class="features-grid">
          <img src="img/Features.svg" alt="Features" style="width:100%;height:auto;display:block;" />
        </div>
      </div>
    </div>

    <div class="right-section">
      <form id="loginForm" class="login-form" method="post" action="my_script.php">
        <div class="login-title">
          <h2 class="welcome-heading">Welcome Back!</h2>
          <p class="welcome-subtitle">Login to continue to your workspace</p>
        </div>

        <div class="form-group">
          <label for="email" class="form-label">Email</label>
          <div class="input-wrapper">
            <img src="img/sms.svg" alt="Email Icon" class="input-icon">
            <input
              type="email"
              class="form-input"
              id="email"
              name="username"
              placeholder="Enter your Email"
              autocomplete="email" />
          </div>
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <div class="input-wrapper">
            <img src="img/lock.svg" alt="Password Icon" class="input-icon">
            <input
              type="password"
              class="form-input"
              id="password"
              name="password"
              placeholder="Enter your Password"
              autocomplete="current-password" />
            <button type="button" class="password-toggle" onclick="togglePassword()">Show</button>
          </div>
        </div>

        <div class="form-options">
          <label class="remember-me">
            <input type="checkbox" name="remember" />
            <span>Remember me</span>
          </label>
          <a href="#" class="forgot-password">Forgot password?</a>
        </div>

        <button type="submit" class="login-button" name="loginbtn" value="login">
          Login
        </button>

        <p class="signup-link">
          New to Nodo.ai? <a href="http://localhost/dmstree/dmstree/sign_up.php">Sign up</a>
        </p>
      </form>
    </div>
  </div>

  <!-- jQuery (must be loaded before BootstrapValidator) -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <!-- BootstrapValidator CSS and JS -->
  <link rel="stylesheet" href="bootstrapvalidator-0.5.0/dist/css/bootstrapValidator.css" />
  <script type="text/javascript" src="bootstrapvalidator-0.5.0/dist/js/bootstrapValidator.js"></script>

  <script>
  $(document).ready(function() {
    $('#loginForm').bootstrapValidator({
      fields: {
        username: {
          validators: {
            notEmpty: {
              message: 'The email is required and can\'t be empty'
            },
            emailAddress: {
              message: 'The input is not a valid email address'
            }
          }
        },
        password: {
          validators: {
            notEmpty: {
              message: 'The password is required and can\'t be empty'
            }
          }
        }
      }
    });
  });
  </script>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleBtn = document.querySelector('.password-toggle');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleBtn.textContent = 'Hide';
      } else {
        passwordInput.type = 'password';
        toggleBtn.textContent = 'Show';
      }
    }

    // Form validation
    // document.getElementById('loginForm').addEventListener('submit', function(e) {
    //   const email = document.getElementById('email').value;
    //   const password = document.getElementById('password').value;
    //   if (!email || !password) {
    //     e.preventDefault();
    //     alert('Please fill in all fields');
    //   }
    // });
  </script>
</body>

</html>