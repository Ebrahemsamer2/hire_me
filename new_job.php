<?php
    include "init.php";
    $main_title = "Hire Me | Create Your Job.";

    if(! \Models\Session::checkLogin()){
        header("Location: login.php");
        exit;
    }

    if(\Models\Session::get('user')['type'] == 'employee'){
        header("Location: 404.php");
        exit;
    }

    $edit = $_GET['edit'] ?? "";
    $job = null;
    if($edit == 1)
    {
        $slug = $_GET['slug'];
        if(! $slug)
        {
            header("Location: 404.php");
            exit;
        }
        $job = new \Models\Job([$slug]);
        if(! $job->getId())
        {
            header("Location: 404.php");
            exit;
        }

        if(!$job->checkAuthor()){
            header("Location: 404.php");
            exit;
        }
    }
?>

<?php include("includes/header.php"); ?>
    <main>
        <div class="job-post-company pt-60 pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h3 class="mb-30">Create New Job</h3>
                        <form>
                            <div class="mt-10 pb-10">
                                <input name="title" type="text" placeholder="Job Title"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Job Title'" required
                                    class="form-control" value="<?php echo $job ? $job->title : ''; ?>">
                            </div>

                            <div class="mt-10 pb-10">
                                <textarea name="description" class="form-control" placeholder="Description" onfocus="this.placeholder=''"
                                    onblur="this.placeholder = 'Description'" required><?php echo $job ? $job->description : ''; ?></textarea>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 p-0">
                                        <div class="mt-10 pb-10">
                                            <select class="form-control" name="country">
                                                <option value="0">Country</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <div class="mt-10 pb-10">
                                            <select class="form-control" name="city">
                                                <option value="0">City</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 p-0">
                                        <div class="mt-10 pb-10">
                                            <select class="form-control" name="job_nature">
                                                <option <?php echo $job ? ($job->job_nature == 'full-time' ? 'selected' : '') : ''; ?> value="Full Time">Full Time</option>
                                                <option <?php echo $job ? ($job->job_nature == 'part-time' ? 'selected' : '') : ''; ?> value="Part Time">Part Time</option>
                                                <option <?php echo $job ? ($job->job_nature == 'remotly' ? 'selected' : '') : ''; ?> value="Remotly">Remotly</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 pr-0">
                                        <div class="mt-10 pb-10">
                                        <input name="salary_from" type="text" placeholder="Salary From"
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = 'Salary From'" required
                                            class="form-control" value="<?php echo $job ? $job->salary_from : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3 pr-0">
                                        <div class="mt-10 pb-10">
                                            <input name="salary_to" type="text" placeholder="Salary To"
                                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Salary To'" required
                                                class="form-control" value="<?php echo $job ? $job->salary_to : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 p-0">
                                        <div class="mt-10 pb-10">
                                            <textarea rows="4" name="required_knowledge" class="form-control" placeholder="Required Knowledge: each should be seperated by semicolon(;)" onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Required Knowledge: each should be seperated by semicolon(;)'" required><?php echo $job ? $job->required_knowledge : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <div class="mt-10 pb-10">
                                            <textarea rows="4" name="education_experience" class="form-control" placeholder="Education & Experience: each should be seperated by semicolon(;)" onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Education & Experience: each should be seperated by semicolon(;)'" required><?php echo $job ? $job->education_experience : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container">
                                <div class="row">
                                    
                                    <div class="col-md-3 p-0">
                                        <div class="mt-10 pb-10">
                                            <input min="1" type="number" name="vacancy_number" placeholder="Vacancy Number"
                                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Vacancy Number'" required
                                                class="form-control" value="<?php echo $job ? $job->vacancy_number : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3 pr-0">
                                        <div class="mt-10 pb-10">
                                            <select class="form-control" name="years_of_experience">
                                                <option <?php echo $job ? ($job->years_of_experience == '1-2' ? 'selected' : '') : ''; ?> value="1-2">1-2</option>
                                                <option <?php echo $job ? ($job->years_of_experience == '2-3' ? 'selected' : '') : ''; ?> value="2-3">2-3</option>
                                                <option <?php echo $job ? ($job->years_of_experience == '3-6' ? 'selected' : '') : ''; ?> value="3-6">3-6</option>
                                                <option <?php echo $job ? ($job->years_of_experience == '6-more' ? 'selected' : '') : ''; ?> value="6-more..">6-more..</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 pr-0">
                                        <div class="mt-10 pb-10">
                                            <select class="form-control" name="category">
                                                <option value="0">All Categories</option>
                                            </select>
                                        </div>
                                    </div>

                                    </div>
                                </div>
                            </div>

                            <div class="mt-20 ml-3">
                                <input class="btn head-btn1" type="submit" value="<?php echo $edit ? 'Update Job' : 'Create Job'; ?>" name="save_job"/>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include("includes/footer.php"); ?>
    <script src="./assets/js/models/category.js"></script>
    <script>
        let category_id = "<?php echo $job->category_id ?? ""; ?>";
        let job_location = "<?php echo $job->location ?? ""; ?>";
        let slug = "<?php echo $job->slug ?? ""; ?>";
    </script>
    <script src="./assets/js/models/job_form.js"></script>
    </body>
</html>
