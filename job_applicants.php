<?php
    include "init.php";
    $main_title = "Hire Me | Applicants";

    if(! \Models\Session::checkLogin()){
        header("Location: login.php");
        exit;
    }

    if(\Models\Session::get('user')['type'] == 'employee'){
        header("Location: 404.php");
        exit;
    }
    $job_slug = $_GET['slug'] ?? '';
    if(! $job_slug)
    {
        header("Location: 404.php");
        exit;
    }
    $job = new \Models\Job([$job_slug]);
    $applicants = $job->loadApplicants();
?>

<?php include("includes/header.php"); ?>

<section class="ptb-4 myjobs-section mt-4 mb-4">
    <div class="container">

        <h2 class="m-4"><?php echo $job->title; ?></h2>

        <div class="row applicants-list m-2">
            <?php if(!count($applicants)): ?>
                <p class="p-4">No Applicants Found.</p>
            <?php endif; ?>
            
            <?php foreach($applicants as $applicant): ?>

            <div data-email="<?php echo $applicant->email; ?>" data-slug="<?php echo $applicant->slug; ?>" class="col-md-3 applicant">
                <div class="card">
                    <img class="card-img-top" src="assets/img/<?php echo $applicant->avatar ? "avatar/" . $applicant->avatar : "user.jpg" ?>" alt="Applicant Avatar">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $applicant->username; ?></h5>
                        <?php if($applicant->about_me): ?>
                            <p title="<?php echo $applicant->about_me; ?>" class="card-text">
                                <?php echo substr($applicant->about_me, 0, 50) . '...'; ?>
                            </p>
                        <?php endif; ?>

                        <span class="text-danger d-block mb-4 font-weight-bold text-uppercase"><?php echo $applicant->status; ?></span>

                        <a id='download-applicant-resume' href="<?php $applicant->resume ? 'assets/resumes/' . $applicant->resume : '#'; ?>assets/resumes" class="border-btn2 p-2 text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                        </svg>    
                        Resume</a>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>
    
<?php include "includes/footer.php"; ?>
<script src="assets/js/models/applicant.js"></script>
</body>
</html>


