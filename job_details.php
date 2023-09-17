<?php
    include "init.php";
    $main_title = "Hire Me | Find Your Dream Job.";
?>

<?php include("includes/header.php"); ?>
    <main>

        <!-- Hero Area Start-->
        <div class="slider-area ">
            <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="assets/img/hero/about.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap text-center">
                                <h2></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Area End -->
        <!-- job post company Start -->
        <div class="job-post-company pt-120 pb-120">
            <div class="container">
                <div class="row justify-content-between">
                    <!-- Left Content -->
                    <div class="col-xl-7 col-lg-8">
                        <!-- job single -->
                        <div class="single-job-items mb-50">
                            <div class="job-items">
                                <div class="company-img company-img-details">
                                    <a href="#"><img src="" alt=""></a>
                                </div>
                                <div class="job-tittle">
                                    <a href="#">
                                        <h4></h4>
                                    </a>
                                    <ul>
                                        <li class='company_name'></li>
                                        <li class='location'></li>
                                        <li class='salary'></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                          <!-- job single End -->
                       
                        <div class="job-post-details">
                            <div class="post-details1 mb-50">
                                <!-- Small Section Tittle -->
                                <div class="small-section-tittle">
                                    <h4>Job Description</h4>
                                </div>
                                <p></p>
                            </div>
                            <div class="post-details2 knowledge mb-50">
                                 <!-- Small Section Tittle -->
                                <div class="small-section-tittle">
                                    <h4>Required Knowledge, Skills, and Abilities</h4>
                                </div>
                               <ul>
                                   
                               </ul>
                            </div>
                            <div class="post-details2 experience mb-50">
                                 <!-- Small Section Tittle -->
                                <div class="small-section-tittle">
                                    <h4>Education + Experience</h4>
                                </div>
                               <ul>
                                
                               </ul>
                            </div>
                        </div>

                    </div>
                    <!-- Right Content -->
                    <div class="col-xl-4 col-lg-4">
                        <div class="post-details3  mb-50">
                            <!-- Small Section Tittle -->
                           <div class="small-section-tittle">
                               <h4>Job Overview</h4>
                           </div>
                            <ul>
                                <li class='date'>Posted date : <span></span></li>
                                <li class='location'>Location : <span></span></li>
                                <li class='vacancy'>Vacancy : <span></span></li>
                                <li class='job_nature'>Job nature : <span></span></li>
                                <li class='salary'>Salary :  <span></span></li>
                            </ul>
                         <div class="apply-btn2">
                            <?php if($_SESSION['user']['type'] == 'employer'): ?>
                                <span class="apply_employer">Only employees can apply</span>
                            <?php else: ?>
                                <a id="apply_now" href="#" class="btn">Apply Now</a>
                            <?php endif; ?>
                         </div>
                       </div>
                        <div class="post-details4  mb-50">
                            <!-- Small Section Tittle -->
                           <div class="small-section-tittle">
                               <h4>Company Information</h4>
                           </div>
                              <span class="username">Colorlib</span>
                              <p class='about_me'></p>
                            <ul>
                                <li class='username'>Name: <span>Colorlib </span></li>
                                <li class='web'>Web : <span> <a style='color: red' target="_blank" href='#'>colorlib.com</a></span></li>
                                <li class='email'>Email: <span>carrier.colorlib@gmail.com</span></li>
                            </ul>
                       </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- job post company End -->

    </main>
    <?php include("includes/footer.php"); ?>
    <script src="assets/js/models/job_details.js"></script>
    </body>
</html>