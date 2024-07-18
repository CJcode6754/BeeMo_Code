<?php
session_start();
include 'C:/xampp/htdocs/BeeMo_Code/connection/mysql_connection.php';

// Set timezone to Philippines
date_default_timezone_set('Asia/Manila');

// Include PHPMailer and configure SMTP settings
require 'C:/xampp/htdocs/BeeMo_Code/vendor/phpmailer/phpmailer/src/Exception.php';
require 'C:/xampp/htdocs/BeeMo_Code/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/BeeMo_Code/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Function to send email with OTP
function sendOTP($email, $otp, $name) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ceejayibabiosa@gmail.com';
        $mail->Password   = 'jqic mish bckr efjm'; // Note: for security, consider storing the password securely
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('ceejayibabiosa@gmail.com', 'BeeMo');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Verify your email';
        $mail->Body    = "Hello, {$name}<br>Your account registration is successfully done! Now activate your account with OTP {$otp}.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

// Function to generate OTP and set expiry time
function generateOTP($email) {
    global $conn; // Access the global database connection object

    $otp = rand(100000, 999999); // Generate random OTP
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+3 minutes')); // Set OTP expiry time (3 minutes from now)

    // Update admin_table with new OTP and expiry time
    $update = "UPDATE admin_table SET otp='$otp', otp_expiry='$otp_expiry' WHERE email='$email'";
    mysqli_query($conn, $update);

    $_SESSION['otp_expiry'] = $otp_expiry; // Update session with OTP expiry time

    return array('otp' => $otp, 'otp_expiry' => $otp_expiry); // Return OTP and expiry time as an array
}

// Handle signup form submission
if (isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $name = filter_var($_POST['admin_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $M_number = isset($_POST['number']) ? filter_var($_POST['number'], FILTER_SANITIZE_SPECIAL_CHARS) : '';
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if(empty($_POST['admin_name'])){
      $_SESSION['error'] = 'Please enter your full name.';
      header('Location: signup_form.php');
      exit;
    }
    else if(empty($_POST['email'])){
      $_SESSION['error'] = 'Please enter your email address.';
      header('Location: signup_form.php');
      exit;
    }
    else if(empty($_POST['number'])){
      $_SESSION['error'] = 'Please enter your mobile number.';
      header('Location: signup_form.php');
      exit;
    }
    else if(empty($_POST['password'])){
      $_SESSION['error'] = 'Please enter your password.';
      header('Location: signup_form.php');
      exit;
    }
    else if(empty($_POST['confirm_password'])){
      $_SESSION['error'] = 'Please reenter your password.';
      header('Location: signup_form.php');
      exit;
    }

    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Invalid email format';
        header('Location: signup_form.php');
        exit;
    }

    else if(empty($_POST['check'])){
      $_SESSION['error'] = 'Please accept BeeMos terms and conditions.';
        header('Location: signup_form.php');
        exit;
    }
    else if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match';
        header('Location: signup_form.php');
        exit;
    }

    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists
    $check_email_query = "SELECT * FROM admin_table WHERE email='$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $_SESSION['error'] = 'Email Address Already Exists';
        header('Location: signup_form.php');
        exit;
    }

    // Generate OTP and set OTP expiry
    $otpData = generateOTP($email);
    $otp = $otpData['otp'];
    $otp_expiry = $otpData['otp_expiry'];

    // Insert the new user into the database
    $insert = "INSERT INTO admin_table (admin_name, email, number, password, otp, is_verified, otp_expiry)
               VALUES ('$name', '$email', '$M_number', '$password_hashed', '$otp', 0, '$otp_expiry')";

    $insert_run = mysqli_query($conn, $insert);

    if ($insert_run) {
        // Send email with OTP
        if (sendOTP($email, $otp, $name)) {
            $_SESSION['status'] = 'Registration Successful. Verify your Email Address with the OTP sent.';
            $_SESSION['email'] = $email;
            header('Location: verify.php');
            exit;
        } else {
            $_SESSION['error'] = 'Failed to send OTP. Please try again later.';
            header('Location: signup_form.php');
            exit;
        }
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: signup_form.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="registration.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b4ce5ff90a.js" crossorigin="anonymous"></script>

    <title>Signup Page</title>
</head>

<body>


    <!-- Contents -->
    <div id="contents">
        <div class="container-fluid h-100">
            <div class="row">
                <div class="col-lg-4 bg1">
                    <div id="LoginLogo" class="container-fluid">
                      <main class="form-signin px4">
                        <form action="signup_form.php" method="post" id="registerForm" novalidate>
                          <div class="top px-2 pt-4">
                            <a href="index.html"><img id="loginLogo" src="img/LOGO2.png" alt="Logo"></a>
                            <p class="about pt-1">ABOUT&nbsp;US</p>
                          </div>
                          <hr class="d-block d-lg-none w-100">

                          <div class="form-content px-2">
                            <h1 class="text">Sign Up.</h1>
                            <div class="log pb-3">
                              <p><b>Already have an account?</p>
                              <a href="index.php" class="text-dark"><u>Login?</u></a></b>
                            </div>

                            <div class="form-floating pb-3">
                              <input name="admin_name" type="text" class="form-control" id="fullName" placeholder="Full Name" required>
                              <label for="fullName"><i class="fa-solid fa-user"></i> Full Name</label>
                              <div class="invalid-feedback">Please enter your full name.</div>
                            </div>

                            <div class="form-floating pb-3">
                              <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com" required>
                              <label for="email"><i class="fa-solid fa-envelope"></i> Email</label>
                              <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>

                            <div class="form-floating pb-3">
                              <input name="number" type="text" class="form-control" id="mobileNumber" placeholder="Mobile Number" required>
                              <label for="mobileNumber"><i class="fa-solid fa-mobile"></i> Mobile Number</label>
                              <div class="invalid-feedback">Please enter a valid mobile number.</div>
                            </div>

                            <div class="form-floating pb-3">
                              <input name="password" type="password" class="form-control" id="password" placeholder="Password" required>
                              <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                              <span id="togglePassword" class="toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                              <div class="invalid-feedback">Password must be 8-32 characters long.</div>
                            </div>

                            <div class="form-floating pb-3">
                              <input name="confirm_password" type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required>
                              <label for="confirmPassword"><i class="fa-solid fa-lock"></i> Confirm Password</label>
                              <span id="toggleConfirmPassword" class="toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                              <div class="invalid-feedback">Passwords do not match.</div>
                            </div>

                            <div class="terms form-check text-start my-3">
                              <input name="check" class="form-check-input" style="background-color: #6DA4AA;" type="checkbox" value="remember-me" id="termsCheckbox" required>
                              <label class="form-check-label" for="termsCheckbox">
                                <p>I have read & accept the <u>Terms and Conditions</u></p>
                              </label>
                              <div class="invalid-feedback">You must accept the terms and conditions</div>
                            </div>

                            <button name="submit" id="btn" class="w-100 py-3" type="submit"><b>REGISTER</b></button>
                          </div>
                        </form>
                      </main>

                    </div>
                </div>

                <div class="col-lg-8 bg2">
                    <div id="SignUpImg" class="container-fluid"></div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
<script src="register.js" type="text/javascript"></script>
</html>