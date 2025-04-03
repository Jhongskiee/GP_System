<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="loginstyle.css" />
    <title>GP SYSTEM</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="loginlogic.php" method="POST" class="sign-in-form">
          <img src="logo.png" class="logoimage" alt="" />
            <h2 class="title">GP - MOTORPOOL</h2>
            <h2 class="title">LOGIN</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" />
              <div class="pass-eye"><i class="fa-solid fa-eye toggle-password" data-target="password"></i></div>
            </div>
            <input type="submit" value="Login" class="btn solid" />
          </form>
          <form action="signup.php" method="POST" class="sign-up-form">
          <img src="logo.png" class="logoimage2" alt="" />
            <h2 class="title">GP - MOTORPOOL</h2>
            <h2 class="title">SIGN UP</h2>
            <div class="input-field">
              <i class="fas fa-id-card"></i>
              <input type="text" name="fname" placeholder="First Name" />
            </div>
            <div class="input-field">
              <i class="fas fa-id-card"></i>
              <input type="text" name="minitial" placeholder="Middle Initial" />
            </div>
            <div class="input-field">
              <i class="fas fa-id-card"></i>
              <input type="text" name="lname" placeholder="Last Name" />
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" class="password2" />
              <div class="pass-eye"><i class="fa-solid fa-eye toggle-password2" data-target="password"></i></div>
            </div>
            <input type="submit" class="btn" value="Sign up" />
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
              LOCAL GOVERNMENT UNIT - GENERAL SERVICE OFFICE<br> Purok Humayan, Brgy. Datu Abdul, Panabo City, Davao del Norte, Philippines 
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Already have an Account ?</h3>
            <p>
              LOCAL GOVERNMENT UNIT - GENERAL SERVICE OFFICE<br> Purok Humayan, Brgy. Datu Abdul, Panabo City, Davao del Norte, Philippines
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<?php
    session_start();

    if (isset($_SESSION['error_message'])) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '" . addslashes($_SESSION['error_message']) . "'
            });
        </script>";
        unset($_SESSION['error_message']);
    }

    if (isset($_SESSION['missing_message'])) {
        echo "<script>
            Swal.fire({
                icon: 'question',
                title: 'Not Found',
                text: '" . addslashes($_SESSION['missing_message']) . "'
            });
        </script>";
        unset($_SESSION['missing_message']);
    }
    ?>
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Toggle password visibility for login password field
    const togglePassword = document.querySelector(".toggle-password");
    const passwordInput = document.querySelector("input[name='password']");

    togglePassword.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            togglePassword.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            passwordInput.type = "password";
            togglePassword.classList.replace("fa-eye-slash", "fa-eye");
        }
    });

    // Toggle password visibility for signup password field
    const togglePassword2 = document.querySelector(".toggle-password2");
    const passwordInput2 = document.querySelector("input.password2");

    togglePassword2.addEventListener("click", function () {
        if (passwordInput2.type === "password") {
            passwordInput2.type = "text";
            togglePassword2.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            passwordInput2.type = "password";
            togglePassword2.classList.replace("fa-eye-slash", "fa-eye");
        }
    });
});

</script>
</html>
