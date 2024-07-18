<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include 'C:/xampp/htdocs/Capstone_BeeMo/connection/mysql_connection.php';

    // Include PHPMailer and configure SMTP settings
    require 'C:/xampp/htdocs/Capstone_BeeMo/vendor/phpmailer/phpmailer/src/Exception.php';
    require 'C:/xampp/htdocs/Capstone_BeeMo/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'C:/xampp/htdocs/Capstone_BeeMo/vendor/phpmailer/phpmailer/src/SMTP.php';

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
            $mail->Password   = 'jqic mish bckr efjm';
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
        global $conn; // Access the global connection object

        // Set PHP timezone to Asia/Manila (Philippines)
        date_default_timezone_set('Asia/Manila');

        $otp = rand(100000, 999999); // Generate random OTP
        $current_time = time(); // Current timestamp
        $otp_expiry = date('Y-m-d H:i:s', $current_time + (3 * 60)); // Add 3 minutes (3 * 60 seconds)

        // Update admin_table with new OTP and expiry time
        $update = "UPDATE admin_table SET otp='$otp', otp_expiry='$otp_expiry' WHERE email='$email'";
        mysqli_query($conn, $update);

        $_SESSION['otp_expiry'] = $otp_expiry; // Update session with OTP expiry time

        return $otp;
    }

    // Resend OTP if requested
    if (isset($_POST['resend'])) {
        if (isset($_SESSION['email']) && isset($_SESSION['admin_name'])) {
            $email = $_SESSION['email'];
            $otp = generateOTP($email);
            $name = $_SESSION['admin_name'];

            if (sendOTP($email, $otp, $name)) {
                $_SESSION['status'] = 'New OTP sent! Check your email.';
                header('Location: verify.php');
                exit;
            } else {
                $_SESSION['error'] = 'Failed to resend OTP. Please try again later.';
                header('Location: verify.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Session expired. Please log in again.';
            header('Location: signup_form.php');
            exit;
        }
    }

    // Verify OTP when form is submitted
    if (isset($_POST['submit'])) {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $otp = mysqli_real_escape_string($conn, $_POST['otp']);
            $current_time = date('Y-m-d H:i:s'); // Current time in server's timezone

            // Check if the OTP is valid and has not expired
            $query = "SELECT * FROM admin_table WHERE email='$email' AND otp='$otp' AND otp_expiry > '$current_time'";
            $result = mysqli_query($conn, $query);

            if (empty($otp)) {
                $_SESSION['error'] = 'Please enter the OTP.';
                header('Location: verify.php');
                exit;
            }

            if (mysqli_num_rows($result) > 0) {
                // Update is_verified status and clear OTP data
                $update = "UPDATE admin_table SET is_verified=1, otp='', otp_expiry=NULL WHERE email='$email'";
                mysqli_query($conn, $update);

                // Redirect to index.php upon successful verification
                $_SESSION['status'] = "Account Verified Successfully!";
                header('Location: index.php');
                exit;
            } else {
                // Handle case where OTP is invalid or expired
                $_SESSION['error'] = "Invalid OTP or OTP has expired";
                header('Location: verify.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Session expired. Please log in again.';
            header('Location: signup_form.php');
            exit;
        }
    }

    // Load OTP expiry time and generate new OTP if not set
    if (!isset($_SESSION['otp_expiry'])) {
        if (isset($_SESSION['email']) && isset($_SESSION['admin_name'])) {
            $email = $_SESSION['email'];
            $otp = generateOTP($email);
            $name = $_SESSION['admin_name']; // Replace with actual session variable for admin name

            if (sendOTP($email, $otp, $name)) {
                $_SESSION['status'] = 'OTP sent! Check your email.';
            } else {
                $_SESSION['error'] = 'Failed to send OTP. Please try again later.';
            }

            $_SESSION['otp_expiry'] = date('Y-m-d H:i:s', time() + (3 * 60)); // Set OTP expiry time (3 minutes from now)
        } else {
            $_SESSION['error'] = 'Session expired. Please log in again.';
            header('Location: signup_form.php');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="verify.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/b4ce5ff90a.js" crossorigin="anonymous"></script>

    <title>Verify OTP</title>
</head>
<body>
    <!-- Contents -->
    <div id="contents">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 bg1">
                    <div id="LoginLogo" class="container-fluid">
                      <main class="form-signin w-auto m-auto px4">
                            <form action="verify.php" method="post">
                              <div class="top px-2 pt-4">
                                <a href="index.php"><img id="loginLogo" src="img/LOGO2.png" alt="Logo"></a>
                                <p class="about pt-1">ABOUT&nbsp;US</p>
                              </div>
                              <hr class="d-block d-lg-none">

                              <div class="px-2">
                                <h1 class="text">Verify</h1>
                                <p class="fs-4 pb-5">Your code was sent to you via email</p>
                                <?php
                                    if (isset($_SESSION['error'])) {
                                        echo '<span class="error-msg">' . $_SESSION['error'] . '</span>';
                                        unset($_SESSION['error']);
                                    } elseif (isset($_SESSION['status'])) {
                                        echo '<span class="status-msg">' . $_SESSION['status'] . '</span>';
                                        unset($_SESSION['status']);
                                    }
                                ?>
                                <br>
                                <label for="otp">Enter OTP</label>
                                <div class="form-group d-flex align-items-center position-relative">

                                <input type="text" name="otp" id="otp" class="form-control">
                                <div id="countdownTimer" class="position-absolute end-0 pe-2"><span id="countdownTimer"></span></div> <!-- Timer --></div>          
                                <button name="resend" class="mt-2 border-0 bg-white" type="submit">Resend Email</button>
                                <button id="btn" name="submit" class="w-100 py-3" type="submit"><b>VERIFY</b></button>

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

    <script>
        // Function to start countdown timer
        function startCountdown(expiryTime, display) {
            var endTime = new Date(expiryTime).getTime(); // Get end time in milliseconds
            var now = new Date().getTime(); // Get current time in milliseconds
            var duration = endTime - now; // Calculate duration in milliseconds

            var intervalId = setInterval(function () {
                duration -= 1000; // Subtract 1 second
                if (duration <= 0) {
                    clearInterval(intervalId);
                    display.textContent = "Expired";
                    document.getElementById("btn").disabled = true; // Disable verify button after expiry
                    document.getElementsByName("resend")[0].disabled = false; // Enable resend button
                } else {
                    var minutes = Math.floor((duration / (1000 * 60)) % 60); // Calculate remaining minutes
                    var seconds = Math.floor((duration / 1000) % 60); // Calculate remaining seconds

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    display.textContent = minutes + ":" + seconds;
                }
            }, 1000); // Update every 1 second
        }

        // Start countdown when page fully loads
        window.addEventListener('load', function () {
            var otpExpiry = '<?php echo isset($_SESSION['otp_expiry']) ? $_SESSION['otp_expiry'] : ''; ?>';
            var countdownDisplay = document.getElementById("countdownTimer");

            if (otpExpiry) {
                startCountdown(otpExpiry, countdownDisplay);
            } else {
                console.error('OTP expiry time not set or invalid.');
            }
        });
    </script>

</body>
</html>
