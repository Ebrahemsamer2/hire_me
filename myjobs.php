<?php
    include "init.php";
    $main_title = "Hire Me | My Jobs";

    if(! \Models\Session::checkLogin()){
        header("Location: login.php");
        exit;
    }
?>

<?php include("includes/header.php"); ?>

<section class="ptb-4 myjobs-section mt-4">
    <div class="container">
        <div class="row myjobs-list"></div>
    </div>
</section>
    
<?php include "includes/footer.php"; ?>
<script>
    let userType = "<?php echo \Models\Session::get('user')['type']; ?>";
</script>
<script src="./assets/js/models/myjobs.js"></script>

</body>
</html>