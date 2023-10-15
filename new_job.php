<?php
    include "init.php";
    $main_title = "Hire Me | Create Your Job.";
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
                                    class="form-control">
                            </div>

                            <div class="mt-10 pb-10">
                                <textarea name="description" class="form-control" placeholder="Description" onfocus="this.placeholder=''"
                                    onblur="this.placeholder = 'Description'" required></textarea>
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
                                                <option value="Full Time">Full Time</option>
                                                <option value="Part Time">Part Time</option>
                                                <option value="Remotly">Remotly</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 pr-0">
                                        <div class="mt-10 pb-10">
                                        <input name="salary_from" type="text" placeholder="Salary From"
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = 'Salary From'" required
                                            class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-3 pr-0">
                                        <div class="mt-10 pb-10">
                                            <input name="salary_to" type="text" placeholder="Salary To"
                                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Salary To'" required
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 p-0">
                                        <div class="mt-10 pb-10">
                                            <textarea rows="4" name="required_knowledge" class="form-control" placeholder="Required Knowledge: each should be seperated by semicolon(;)" onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Required Knowledge: each should be seperated by semicolon(;)'" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0">
                                        <div class="mt-10 pb-10">
                                            <textarea rows="4" name="education_experience" class="form-control" placeholder="Education & Experience: each should be seperated by semicolon(;)" onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Education & Experience: each should be seperated by semicolon(;)'" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container">
                                <div class="row">
                                    
                                    <div class="col-md-6 p-0">
                                        <div class="mt-10 pb-10">
                                            <input min="1" type="number" name="vacancy_number" placeholder="Vacancy Number"
                                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Vacancy Number'" required
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6 pr-0">
                                        <div class="mt-10 pb-10">
                                            <select class="form-control" name="years_of_experience">
                                                <option value="1-2">1-2</option>
                                                <option value="2-3">2-3</option>
                                                <option value="3-6">3-6</option>
                                                <option value="6-more..">6-more..</option>
                                            </select>
                                        </div>
                                    </div>

                                    </div>
                                </div>
                            </div>

                            <div class="mt-20 ml-3">
                                <input class="btn head-btn1" type="submit" value="Create Job" name="create_job"/>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include("includes/footer.php"); ?>
    <script src="./assets/js/models/job_form.js"></script>
    </body>
</html>
