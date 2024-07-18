<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();
    include('C:/xampp/htdocs/BeeMo_Code/connection/mysql_connection.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeeMo</title>
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
                <a href="home.html">
                    <i class="fa-solid fa-house sidebar-menu-item-icon"></i>
                    Home
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="choosehive.html">
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
                <a href="harvestcycle.html">
                    <i class="fa-solid fa-arrows-spin sidebar-menu-item-icon"></i>
                    Harvest Cycle
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="beeguide.html">
                    <i class="fa-solid fa-book-open sidebar-menu-item-icon"></i>
                    Bee Guide
                </a>
            </li>
            <li class="sidebar-menu-item active">
                <a href="#">
                    <i class="fa-solid fa-user sidebar-menu-item-icon"></i>
                    Worker
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="#">
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
                <div class="px-4 py-4 my-4 text-center">
                    <p class="beeguide-text fs-4 mb-5 fw-bold worker-highlight">Workers</p>
                    <div class="table-responsive mt-5" style="max-height: 165px; overflow-y: auto;">
                        <table class="table worker-table border-dark">
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
                                <!-- Table body content -->
                                <tr>
                                    <td>Renz Eryll Ramelo</td>
                                    <td>renzeryll@gmail.com</td>
                                    <td>0123456789</td>
                                    <td>password123</td>
                                    <td><button class="btn edit-btn"><i class="fa-regular fa-pen-to-square"></i></button></td>
                                    <td><button class="btn delete-btn"><i class="fa-regular fa-trash-can" style="color: red;"></i></button></td>
                                </tr>
                                <tr>
                                    <td>Ceejay Ibabiosa</td>
                                    <td>ceejayibabiosa@gmail.com</td>
                                    <td>0987654321</td>
                                    <td>password456</td>
                                    <td><button class="btn edit-btn"><i class="fa-regular fa-pen-to-square"></i></button></td>
                                    <td><button class="btn delete-btn"><i class="fa-regular fa-trash-can" style="color: red;"></i></button></td>
                                </tr>
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
            <div class="yellow mt-1 d-md-none fixed-bottom p-0 m-0"></div>
            <div class="modal fade" id="addWorkerModal" tabindex="-1" aria-labelledby="addWorkerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered rounded-3" >
                    <div class="modal-content" style="border: 2px solid #2B2B2B;">
                        <div class="modal-header border-dark border-2" style="background-color: #FCF4B9;">
                            <h5 class="modal-title fw-semibold mx-4" id="addWorkerModalLabel">Add Worker</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m-5">
                            <form id="workerForm" novalidate>
                                <div class="d-grid d-sm-flex justify-content-sm-center gap-4 mb-1">
                                    <div class="col-md-6">
                                        <label for="fullName" class="form-label" style="font-size: 13px;">Full Name</label>
                                        <input type="text" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="fullName" required>
                                        <div class="invalid-feedback">Please enter a full name.</div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label" style="font-size: 13px;">Email</label>
                                        <input type="email" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="email" required>
                                        <div class="invalid-feedback">Please enter a valid email address.</div>
                                    </div>
                                </div>
                                <div class="d-grid mt-3 d-sm-flex justify-content-sm-center gap-4">
                                    <div class="col-md-6">
                                        <label for="phoneNumber" class="form-label" style="font-size: 13px;">Phone Number</label>
                                        <input type="text" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="phoneNumber" required>
                                        <div class="invalid-feedback">Please enter a phone number.</div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="password" class="form-label" style="font-size: 13px;">Password</label>
                                        <input type="password" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="password" required>
                                        <div class="invalid-feedback">Please enter a password.</div>
                                    </div>
                                </div>
                                <div class="mt-5 d-flex justify-content-center">
                                    <button type="submit" class="save-button px-4 border border-1 border-black fw-semibold"><span class="fw-bold">+</span> Add Worker</button>
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
                <a href="home.html">
                    <i class="fa-solid fa-house sidebar-menu-item-icon2"></i>
                    Home
                </a>
            </li>
            <li class="sidebar-menu-item2 py-1">
                <a href="choosehive.html">
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
                <a href="#">
                    <i class="fa-solid fa-arrows-spin sidebar-menu-item-icon2"></i>
                    Harvest Cycle
                </a>
            </li>
            <li class="sidebar-menu-item2">
                <a href="beeguide.html">
                    <i class="fa-solid fa-book-open sidebar-menu-item-icon2"></i>
                    Bee Guide
                </a>
            </li>
            <li class="sidebar-menu-item2 active">
                <a href="#">
                    <i class="fa-solid fa-user sidebar-menu-item-icon2"></i>
                    Worker
                </a>
            </li>
            <li class="sidebar-menu-item2">
                <a href="#">
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