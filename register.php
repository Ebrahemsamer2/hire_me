<?php include "init.php"; ?>

<?php 
if(\Models\Session::checkLogin()){
    header("Location: index.php");
    exit;
}
?>

<?php include "includes/header.php"; ?>
<link rel="stylesheet" href="assets/css/register.css">

<div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            <h3>Welcome</h3>
            <p>Get Hired OR Hire talents to grow your business.</p>
            <a class="btnRegister login" href="login.php">Login</a><br/>
        </div>
        <div class="col-md-9 register-right">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Employee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Hirer</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h3 class="register-heading">Apply as a Employee</h3>
                    <div class="row register-form">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" placeholder="First Name *" value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="last_name" placeholder="Last Name *" value="" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Your Email *" value="" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password *" value="" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="confirmation" placeholder="Confirm Password *" value="" />
                            </div>
                            <input type="hidden" name="type" value="employee" />
                            <input type="submit" name='register' class="btnRegister" value="Register as a Employee"/>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h3  class="register-heading">Apply as a Hirer</h3>
                    <div class="row register-form">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" name="first_name" placeholder="First Name *"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="last_name" placeholder="Last Name *"/>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Your Email *"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Password *"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="confirmation" placeholder="Confirm Password *"/>
                        </div>
                        <input type="hidden" name="type" value="employer" />
                        <input type="submit" name='register' class="btnRegister"  value="Register as a Hirer"/>
                    </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>

</body>
</html>