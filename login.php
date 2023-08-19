<?php include "init.php"; ?>

<?php 
if(\Models\Session::checkLogin()){
    header("Location: index.php");
    exit;
}
?>

<?php include "includes/header.php"; ?>
<link rel="stylesheet" href="assets/css/login.css">
    
<div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            <h3>Welcome</h3>
            <p>Get Hired OR Hire talents to grow your business.</p>
        </div>
        <div class="col-md-9 register-right">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row login-form">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name='email' type="email" class="form-control" placeholder="Your Email *" />
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" name='password' type="password" class="form-control" placeholder="Password *" />
                            </div>
                            
                            <input type="submit" name="login" class="btnRegister"  value="Login"/>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>


<?php include "includes/footer.php"; ?>