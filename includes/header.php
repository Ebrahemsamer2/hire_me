<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $main_title; ?></title>
        <meta name="description" content="<?php echo $main_description; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

		<!-- CSS here -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/flaticon.css">
        <link rel="stylesheet" href="assets/css/slicknav.css">
        <link rel="stylesheet" href="assets/css/animate.min.css">
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="assets/css/themify-icons.css">
        <link rel="stylesheet" href="assets/css/slick.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/custom.css">
   </head>

   <body>
   <div id="message"></div>
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/logo.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!-- Header Start -->
       <div class="header-area header-transparrent">
           <div class="headder-top header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-2">
                            <!-- Logo -->
                            <div class="logo">
                                <a href="index.php"><img src="assets/img/logo/logo.png" alt=""></a>
                            </div>  
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="menu-wrapper">
                                <!-- Main-menu -->
                                <div class="main-menu">
                                    <nav class="d-none d-lg-block">
                                        <ul id="navigation">
                                            <li><a href="index.php">Home</a></li>
                                            <li><a href="job_listing.php">Find a Jobs </a></li>
                                            <li><a href="about.php">About</a></li>
                                            <li><a href="contact.php">Contact</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <!-- Header-btn -->
                                <div class="header-btn d-none f-right d-lg-block">
                                    <?php if(isset($_SESSION['user'])): ?>
                                        <a href='#' class="dropdown-toggle" type="button" id="user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="<?php echo './assets/img/user.jpg'; ?>" class="rounded-circle" style="width: 40px;" alt="Avatar" />
                                            <?php echo $_SESSION['user']['username']; ?>
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="user-dropdown">
                                            <a class="dropdown-item" href="#">Profile</a>
                                            <?php if($_SESSION['user']['type'] == 'employee'): ?>
                                                <a class="dropdown-item" href="#">My Jobs</a>
                                            <?php endif; ?>
                                            <?php if($_SESSION['user']['type'] == 'employer'): ?>
                                                <a class="dropdown-item" href="new_job.php">Create Job</a>
                                            <?php endif; ?>
                                            <a id='logout' class="dropdown-item" href="#">Logout</a>
                                        </div>

                                    <?php else: ?>
                                        <a href="register.php" class="btn head-btn1">Register</a>
                                        <a href="login.php" class="btn head-btn2">Login</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
           </div>
       </div>
        <!-- Header End -->
    </header>