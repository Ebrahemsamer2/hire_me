<?php
    include "init.php";
    $main_title = "Hire Me | My Profile";
?>

<?php 
if(! \Models\Session::checkLogin()){
    header("Location: login.php");
    exit;
}
?>

<?php include("includes/header.php"); ?>

<section class="ptb-4 profile-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title"><?php echo $_SESSION['username'] ?? ''; ?></h2>
                </div>

                <div class="col-lg-3">
                    <div class="media contact-info">
                        <img src="assets/img/user.jpg" alt="User Avatar" class="img-fluid avatar">
                    </div>

                    <button class="mb-2 boxed-btn w-100 upload-avatar-btn">Upload Image</button>
                    <button class="d-none boxed-btn w-100 confirm-avatar-btn">Confirm Image</button>
                    <input class="d-none" type="file" name="avatar">
                </div>

                <div class="col-lg-9">
                    <form class="form-contact profile_form" method="POST" id="profile_form" novalidate="novalidate">

                        <h4 class="mb-4">Basic Info</h4>

                        <div class="row">
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="username" id="username" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your username'" placeholder="Enter your username">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Enter your email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="web" id="web" type="url" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your website'" placeholder="Enter your website">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control" name="about_me" id="about_me" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Talk about your self'" placeholder="Talk about your self"></textarea>
                                </div>
                            </div>

                        </div>

                        <h4 class="mb-4">Password</h4>
                        <ul id="password_rules" class="mb-4 small text-warning">
                            <li>* password length must be between 8 - 16 characters.</li>
                            <li>* password must include uppercase and lowercase characters.</li>
                            <li>* password must include at least one digit.</li>
                        </ul>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="old_password" id="old_password" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your old password'" placeholder="Enter your old password">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <input class="form-control" name="new_password" id="new_password" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your new password'" placeholder="Enter your new password">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input class="form-control" name="confirmation" id="confirmation" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your confirmation password'" placeholder="Enter your confirmation password">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button save boxed-btn">Save</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </section>
<!-- ================ contact section end ================= -->
<?php include "includes/footer.php"; ?>
<script src="./assets/js/models/user_profile.js"></script>

</body>
</html>