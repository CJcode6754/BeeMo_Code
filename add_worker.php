<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//renz
session_start();
include('C:/xampp/htdocs/BeeMo_Code/connection/mysql_connection.php');

// Check if the admin is logged in
if (!isset($_SESSION['adminID'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit;
}

// Set timezone to Philippines
date_default_timezone_set('Asia/Manila');

// Include PHPMailer and configure SMTP settings
require 'C:/xampp/htdocs/BeeMo_Code/vendor/phpmailer/phpmailer/src/Exception.php';
require 'C:/xampp/htdocs/BeeMo_Code/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/BeeMo_Code/vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to send email with OTP
function sendOTP_user($email, $otp, $name) {
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
function generateOTP_user($email) {
    global $conn; // Access the global connection object

    $otp = rand(100000, 999999); // Generate random OTP
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+3 minutes')); // Set OTP expiry time (3 minutes from now)

    // Update user_table with new OTP and expiry time
    $update_user = "UPDATE user_table SET otp='$otp', otp_expiry='$otp_expiry' WHERE email='$email'";
    mysqli_query($conn, $update_user);

    $_SESSION['otp_expiry'] = $otp_expiry; // Update session with OTP expiry time

    return array('otp' => $otp, 'otp_expiry' => $otp_expiry); // Return OTP and expiry time as an array
}

// Handle the submission of OTP
if (isset($_POST['submit'])) {
    $name = filter_var($_POST['user_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $number = filter_var($_POST['number'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $adminID = $_SESSION['adminID'];

    // Check if email already exists
    $check_email = "SELECT * FROM user_table WHERE email = '$email'";
    $check_email_query = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($check_email_query) > 0) {
        $_SESSION['error'] = 'Email Address Already Exists';
        header('Location: add_worker.php');
        exit;
    }

    // Generate OTP and set OTP expiry
    $otpData = generateOTP_user($email);
    $otp = $otpData['otp'];
    $otp_expiry = $otpData['otp_expiry'];

    $insert_user = "INSERT INTO user_table (user_name, email, number, password, adminID, otp, is_verified, otp_expiry) VALUES ('$name', '$email', '$number', '$password_hash', '$adminID', '$otp', 0, '$otp_expiry')";
    $insert_user_run = mysqli_query($conn, $insert_user);

    if ($insert_user_run) {
       // Send email with OTP
       if (sendOTP_user($email, $otp, $name)) {
        $_SESSION['status'] = 'Registration Successful. Verify your Email Address with the OTP sent.';
        $_SESSION['email'] = $email;
        $_SESSION['user_name'] = $name; // Store user_name in session for resending OTP
        $_SESSION['adminID'] = $adminID;
        header('Location: verify_worker.php');
        exit;
        } else {
            $_SESSION['error'] = 'Failed to send OTP. Please try again later.';
            header('Location: add_worker.php');
            exit;
        }
    } else {
        $_SESSION['error'] = 'Error: ' . mysqli_error($conn);
        header('Location: add_worker.php');
        exit;
    }
}

//DELETE USER
if(isset($_POST['btn_delete'])){
    $user_ID = $_POST['user_ID'];
    $adminID = $_SESSION['adminID'];
    $delete_user = "DELETE FROM user_table WHERE user_ID = '$user_ID' AND adminID = '$adminID'";
    $delete_query = mysqli_query($conn, $delete_user);

    if($delete_query){
        $_SESSION['status'] = 'Successfully deleted';
        header('Location: add_worker.php');
        exit;
    }else{
        $_SESSION['error'] = 'Failed to deleted';
        header('Location: add_worker.php');
        exit;
    }
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker</title>
    <link rel="stylesheet" href="add_worker.css">
    <link rel="icon" href="img/beemo-ico.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b4ce5ff90a.js" crossorigin="anonymous"></script>
</head>

<body class="overflow-x-hidden">
  <!-- Sidebar -->
    <div id="sidebar" class="sidebar position-fixed top-0 bottom-0 bg-white border-end offcanvass">

        <div class="d-flex align-items-center p-3 py-5">
            <a href="#" class="sidebar-logo fw-bold text-dark text-decoration-none fs-4"><img src="img/BeeMo Logo Side.png" width="173px" height="75px" alt="BeeMo Logo"></a>
        </div>
        <ul class="sidebar-menu p-3 py-1 m-0 mb-0">
            <li class="sidebar-menu-item">
                <a href="admin_page.php">
                    <i class="fa-solid fa-house sidebar-menu-item-icon"></i>
                    Home
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="parameter_monitoring">
                    <i class="fa-solid fa-temperature-three-quarters sidebar-menu-item-icon"></i>
                    Parameters Monitoring
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#">
                    <i class="fa-solid fa-newspaper sidebar-menu-item-icon"></i>
                    Reports
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="harvest_cycle.php">
                    <i class="fa-solid fa-arrows-spin sidebar-menu-item-icon"></i>
                    Harvest Cycle
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="beeguide.php">
                    <i class="fa-solid fa-book-open sidebar-menu-item-icon"></i>
                    Bee Guide
                </a>
            </li>
            <li class="sidebar-menu-item active">
                <a href="add_worker.php">
                    <i class="fa-solid fa-user sidebar-menu-item-icon"></i>
                    Worker
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="about.php">
                    <i class="fa-solid fa-circle-info sidebar-menu-item-icon"></i>
                    About
                </a>
            </li>
        </ul>
    </div>

    <!-- Main -->
    <main class="bg-light">
        <div class="p-2">
            <!-- Navbar -->
            <nav class="px-3 py-3 rounded-4">
                <div>
                    <p class="d-none d-lg-block mt-3 mx-3 fw-semibold">Welcome to BeeMo</p>
                </div>
                <i class="fa-solid fa-bars sidebar-toggle me-3 d-block d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNav-Menu" aria-controls="offcanvasRight" aria-expanded="false" aria-label="Toggle navigation"></i>
                <h5 class="fw-bold mb-0 me-auto"></h5>
                <div class="dropdown me-3 d-sm-block">
                    <div class="navbar-link border border-1 border-black rounded-5" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class=" fa-solid fa-bell"></i>
                    </div>

                    <div class="dropdown-menu dropdown-menu-start border-dark border-2 rounded-3" style="width: 320px;">
                        <div class="d-flex justify-content-between dropdown-header border-dark border-2">
                            <div>
                                <p class="fs-5 text-dark text-uppercase">Notification <span class="badge text-dark bg-warning-subtle rounded-pill">14</span></p>
                            </div>
                            <div>
                                <i class="pt-1 px-1 fa-solid fa-ellipsis-vertical fs-5"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown me-3  d-sm-block">
                    <div class="navbar-link  border border-1 border-black rounded-5"  data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="termsandconditions.html">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            </nav>
            <!-- Content -->
            <div class="worker-page py-3 mt-4 border border-2 rounded-4 border-dark">
                <div class="px-4 py-4 my-4 text-center content-wrapper">
                    <p class="fs-4 mb-5 fw-bold worker-highlight">Workers</p>
                    <div class="container-worker">
                    <div class="table-responsive mt-5" style="max-height: 165px; overflow-y: auto;">
                        <table class="table worker-table border-dark" name = "worker_list">
                            <thead>
                                <tr>
                                    <th style="background-color: #FAEF9B;">Full Name</th>
                                    <th style="background-color: #FAEF9B;">Email</th>
                                    <th style="background-color: #FAEF9B">Contact Number</th>
                                    <th style="background-color: #FAEF9B;">Password</th>
                                    <th style="background-color: #FAEF9B;">Edit</th>
                                    <th style="background-color: #FAEF9B;">Remove</th>
                                </tr>
                            </thead>
                            <tbody id="workerTableBody">
                            <?php
                                $adminID = $_SESSION['adminID'];
                                $worker_list = "SELECT user_ID, user_name, email, number, password FROM user_table WHERE adminID = '$adminID'";
                                $list_query = mysqli_query($conn, $worker_list);
                                while($row = $list_query ->fetch_assoc()){
                                    echo "
                                    <tr>
                                        <td>". $row['user_name'] ."</td>
                                        <td>". $row['email'] ."</td>
                                        <td>". $row['number'] ."</td>
                                        <td>". $row['password'] ." </td>
                                        <td><button name='btn_edit' class='btn edit-btn'><i class='fa-regular fa-pen-to-square'></i></button></td>
                                        <td>
                                        <form method='post' action='add_worker.php'>
	                                        <input type='hidden' name='user_ID' value='". $row['user_ID'] ."'>
                                            <button type='submit' name='btn_delete' class='btn delete-btn'><i class='fa-regular fa-trash-can' style='color: red;'></i></button>
                                        </form>
                                        </td>
                                    </tr>
                                    ";
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5 d-flex justify-content-end pe-3">
                        <button class="add-button px-4 border border-1 border-black  fw-semibold" type="button" data-bs-toggle="modal" data-bs-target="#addWorkerModal">
                        <span class="fw-bold">+ </span> Add Worker
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="yellow mt-1 d-md-none fixed-bottom p-0 m-0"></div>
            <div class="modal fade" id="addWorkerModal" tabindex="-1" aria-labelledby="addWorkerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered rounded-3" >
                    <div class="modal-content" style="border: 2px solid #2B2B2B;">
                        <div class="modal-header border-dark border-2" style="background-color: #FCF4B9;">
                            <h5 class="modal-title fw-semibold mx-4" id="addWorkerModalLabel">Add Worker</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m-5">
                            <form action="add_worker.php" method="post" id="workerForm" novalidate>
                                <div class="d-grid d-sm-flex justify-content-sm-center gap-4 mb-1">
                                    <div class="col-md-6">
                                        <label for="FullName" class="form-label" style="font-size: 13px;">Full Name</label>
                                        <input name="user_name" type="text" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="FullName" required>
                                        <div class="invalid-feedback">Please enter your full name.</div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="Email" class="form-label" style="font-size: 13px;">Email</label>
                                        <input name="email" type="email" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="Email" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                </div>
                                <div class="d-grid mt-3 d-sm-flex justify-content-sm-center gap-4">
                                    <div class="col-md-6">
                                        <label for="PhoneNumber" class="form-label" style="font-size: 13px;">Phone Number</label>
                                        <input name="number" type="text" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="PhoneNumber" required>
                                        <div class="invalid-feedback">Please enter a valid mobile number.</div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="Password" class="form-label" style="font-size: 13px;">Password</label>
                                        <input name="password" type="password" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="Password" required>
                                        <div class="invalid-feedback">Password must be 8-32 characters long.</div>
                                    </div>
                                </div>
                                <div class="mt-5 d-flex justify-content-center">
                                    <button id="btn" name="submit" type="submit" class="save-button px-4 border border-1 border-black fw-semibold"><span class="fw-bold">+</span> Add Worker</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </main>

     <!-- Side Bar Mobile View -->

    <div class="offcanvas offcanvas-start sidebar2 overflow-x-hidden overflow-y-hidden" tabindex="-1" id="offcanvasNav-Menu" aria-labelledby="staticBackdropLabel">
        <div class="d-flex align-items-center p-3 py-5">
            <a href="#" class="sidebar-logo fw-bold text-dark text-decoration-none fs-4" data-bs-dismiss="offcanvas" aria-label="Close">
                <img src="img/BeeMo Logo Side.png" width="173px" height="75px" alt="BeeMo Logo">
            </a>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <ul class="sidebar-menu p-2 py-2 m-0 mb-0">
            <li class="sidebar-menu-item2">
                <a href="admin_page.php">
                    <i class="fa-solid fa-house sidebar-menu-item-icon2"></i>
                    Home
                </a>
            </li>
            <li class="sidebar-menu-item2 py-1">
                <a href="choose_hive.php">
                    <i class="fa-solid fa-temperature-three-quarters sidebar-menu-item-icon2"></i>
                    Parameters Monitoring
                </a>
            </li>
            <li class="sidebar-menu-item2">
                <a href="#">
                    <i class="fa-solid fa-newspaper sidebar-menu-item-icon2"></i>
                    Reports
                </a>
            </li>
            <li class="sidebar-menu-item2">
                <a href="harvest_cycle.php">
                    <i class="fa-solid fa-arrows-spin sidebar-menu-item-icon2"></i>
                    Harvest Cycle
                </a>
            </li>
            <li class="sidebar-menu-item2">
                <a href="beeguide.php">
                    <i class="fa-solid fa-book-open sidebar-menu-item-icon2"></i>
                    Bee Guide
                </a>
            </li>
            <li class="sidebar-menu-item2 active">
                <a href="add_worker.php">
                    <i class="fa-solid fa-user sidebar-menu-item-icon2"></i>
                    Worker
                </a>
            </li>
            <li class="sidebar-menu-item2">
                <a href="about.php">
                    <i class="fa-solid fa-circle-info sidebar-menu-item-icon2"></i>
                    About
                </a>
            </li>
        </ul>
    </div>
    </div>

    <script src="script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>