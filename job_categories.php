<?php
    include "init.php";
    $main_title = "Hire Me | Job Categories";
    $categories = (new \Models\Category)->loadCategories();
?>

<?php include("includes/header.php"); ?>

<section class="our-services ptb-4 myjobs-section mt-4 mb-4">
    <div class="container">

        <h2 class="m-4">Job Categories</h2>

        <div class="row d-flex justify-contnet-center categories-list m-2">
            
            <?php foreach($categories as $category): ?>

            <div id='category-<?php echo $category->id; ?>' class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <div class="single-services text-center mb-30">
                    <div class="services-cap">
                        <h5><a href="job_listing.php?category=<?php echo $category->slug; ?>"><?php echo $category->name; ?></a></h5>
                        <span>(<?php echo $category->jobsCount ?>)</span>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>
    
<?php include "includes/footer.php"; ?>
</body>
</html>


