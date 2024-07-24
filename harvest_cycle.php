<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeeMo</title>
    <link rel="stylesheet" href="harvest_cycle.css">
    <link rel="icon" href="img/beemo-ico.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/b4ce5ff90a.js" crossorigin="anonymous"></script>
</head>

<body class="overflow-x-hidden">
  <!-- Sidebar -->
    <div id="sidebar" class="sidebar position-fixed top-0 bottom-0 bg-white border-end offcanvass">

        <div class="d-flex align-items-center p-3 py-5">
            <a href="admin_page.php" class="sidebar-logo fw-bold text-dark text-decoration-none fs-4"><img src="img/BeeMo Logo Side.png" width="173px" height="75px" alt="BeeMo Logo"></a>
        </div>
        <ul class="sidebar-menu p-3 py-1 m-0 mb-0">
            <li class="sidebar-menu-item">
                <a href="admin_page.php">
                    <i class="fa-solid fa-house sidebar-menu-item-icon"></i>
                    Home
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="choose_hive.php">
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
            <li class="sidebar-menu-item active">
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
            <li class="sidebar-menu-item">
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
                    <p class="d-none d-lg-block mt-3 mx-3 fw-semibold">Welcome to Harvest Cycle</p>
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
            <div class="cycle-page py-3 mt-4 border border-2 rounded-4 border-dark">
                <div class="px-4 py-3 my-4 text-center content-wrapper">
                    <p class="fs-4 mb-5 fw-bold cycle-highlight">Harvest Cycle</p>
                    <div class="container-cycle">
                    <form class="row mt-2 g-3">
                        <div class="col-md-4">
                            <label for="cycleNumber" class="form-label d-flex justify-content-start" style="font-size: 13px;">Cycle Number</label>
                            <input type="number" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="cycleNumber" required="This is required">
                        </div>
                        <div class="col-md-4">
                            <label for="cycleStart" class="form-label d-flex justify-content-start" style="font-size: 13px;">Start of Cycle</label>
                            <input type="date" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="cycleStart" required="This is required">
                        </div>
                        <div class="col-md-4">
                            <label for="cycleEnd" class="form-label d-flex justify-content-start"  style="font-size: 13px;">End of Cycle</label>
                            <input type="date" class="form-control rounded-3 py-2" style="border: 1.8px solid #2B2B2B; font-size: 13px;" id="cycleEnd" required="This is required">
                        </div>
                    </form>
                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="save-button px-4 border border-1 border-black fw-semibold">Save</button>
                    </div>
                    <div class="table-responsive mt-4" style="max-height: 130px; overflow-y: auto;">
                        <table class="table cycle-table border-dark">
                            <thead>
                                <tr>
                                    <th style="background-color: #FAEF9B;">Cycle Number</th>
                                    <th style="background-color: #FAEF9B;">Start of Cycle</th>
                                    <th style="background-color: #FAEF9B">Honey (kg)</th>
                                    <th style="background-color: #FAEF9B;">End of Harvest</th>
                                    <th style="background-color: #FAEF9B;">Edit</th>
                                    <th style="background-color: #FAEF9B;">Remove</th>
                                </tr>
                            </thead>
                            <tbody id="cycleTableBody">
                                <!-- Table body content -->
                                <tr>
                                    <td>1</td>
                                    <td>01/01/2024</td>
                                    <td>1.5</td>
                                    <td>04/06/2024</td>
                                    <td><button class="btn edit-btn"><i class="fa-solid fa-pen"></i></button></td>
                                    <td><button class="btn delete-btn"><i class="fa-regular fa-trash-can" style="color: red;"></i></button></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>01/06/2024</td>
                                    <td>1</td>
                                    <td>09/12/2024</td>
                                    <td><button class="btn edit-btn"><i class="fa-solid fa-pen"></i></button></td>
                                    <td><button class="btn delete-btn"><i class="fa-regular fa-trash-can" style="color: red;"></i></button></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>01/06/2024</td>
                                    <td>1.2</td>
                                    <td>09/12/2024</td>
                                    <td><button class="btn edit-btn"><i class="fa-solid fa-pen"></i></button></td>
                                    <td><button class="btn delete-btn"><i class="fa-regular fa-trash-can" style="color: red;"></i></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
            <div class="yellow mt-1 d-md-none fixed-bottom p-0 m-0"></div>
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
                <a href="parameter_monitoring.php">
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
            <li class="sidebar-menu-item2 active">
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
            <li class="sidebar-menu-item2">
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