<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start the session

include 'C:/xampp/htdocs/BeeMo_Code/connection/mysql_connection.php';

if (isset($_POST['submit'])) {
    // Sanitize and validate email
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $email = mysqli_real_escape_string($conn, $email);
    $password = $_POST['password'];

    // Check if the email exists in the admin_table
    $select_admin = "SELECT * FROM admin_table WHERE email = '$email'";
    $result_admin = mysqli_query($conn, $select_admin);

    $select_adminID = "SELECT * FROM admin_table WHERE adminID ='$adminID'";
    $result_select_adminID =mysqli_query($conn, $select_adminID);
    if (mysqli_num_rows($result_admin) > 0) {
        $row = mysqli_fetch_array($result_admin);
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // $_SESSION['email'] = $row['email'];
            $_SESSION['adminID'] = $row['adminID'];
            header('Location: admin_page.php');
            exit(); // Ensure no further code is executed after redirection
        } else {
            $_SESSION['error'] = 'Incorrect email or password';
        }
    } else {
        $_SESSION['error'] = 'Incorrect email or password';
    }

    header('Location: index.php');
    exit(); // Ensure no further code is executed after redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="index.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b4ce5ff90a.js" crossorigin="anonymous"></script>

    <title>Login Page</title>
</head>

<body>


    <!-- Contents -->
    <div id="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 bg1">
                    <div id="LoginLogo" class="container-fluid">
                        <main class="form-signin px4">
                            <form action="index.php" method="post" id="loginForm" novalidate>
                              <div class="top px-2 pt-4">
                                <a href="index.php"><img id="loginLogo"  src="img/LOGO2.png" alt="Logo"></a>
                                <p class="about pt-1">ABOUT&nbsp;US</p>
                              </div>
                              <hr class="d-block d-lg-none w-100">
                              <div class="form-content px-2">

                                <h1 class="text">Sign In.</h1>

                                <div class="reg pb-3">
                                  <p><b>Don't have an account?</p>
                                  <a href="signup_form.html" class="text-dark"><u>Register</u></a></b>
                                </div>
                                <?php
                                    if (isset($_SESSION['error'])) {
                                        echo '<span class="error-msg">' . $_SESSION['error'] . '</span>';
                                        unset($_SESSION['error']);
                                    } elseif (isset($_SESSION['status'])) {
                                        echo '<span class="status-msg">' . $_SESSION['status'] . '</span>';
                                        unset($_SESSION['status']);
                                    }
                                ?>
                                <div class="form-floating pb-3 position-relative">
                                  <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                  <label class="" for="floatingInput"><i class="fa-solid fa-envelope"></i>  Email address </label>
                                  <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>

                                <div class="form-floating pb-3">
                                  <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                                  <label class="" for="floatingPassword"><i class="fa-solid fa-lock"></i>  Password </label>
                                  <div class="password-wrapper">
                                  <span id="togglePassword" class="toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                                  </div>
                                  <div class="invalid-feedback">Please enter your password.</div>
                                </div>
                                <a href="forgot_password.php" class="href text-dark">Forgot Password?</p></a>
                                <button id="login" class="w-100 py-3" name="submit" type="submit" ><b>ACCESS MY ACCOUNT</b></button>
                              </div>

                            </form>
                          </main>

                    </div>
                </div>

                <div class="col-lg-8 bg2">
                    <div id="loginImg" class="container-fluid"></div>
                </div>
            </div>
        </div>
      </div>

</body>



<!-- JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<script src="JQ.js" type="text/javascript"></script>
</html>