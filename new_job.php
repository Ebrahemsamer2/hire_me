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
                            <div class="mt-10">
                                <input name="title" type="text" placeholder="Job Title"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Job Title'" required
                                    class="single-input">
                            </div>

                            <div class="mt-10">
                                <textarea name="description" class="single-textarea" placeholder="Description" onfocus="this.placeholder=''"
                                    onblur="this.placeholder = 'Description'" required></textarea>
                            </div>

                            <div class="mt-10">
                                <select class="single-input form-control" name="country">
                                    <option value="0">Country</option>
                                </select>
                            </div>

                            <div class="mt-10">
                                <select class="single-input form-control" name="city">
                                    <option value="0">City</option>
                                </select>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 p-0">
                                        <div class="mt-10">
                                            <select class="single-input form-control" name="job_nature">
                                                <option value="Full Time">Full Time</option>
                                                <option value="Part Time">Part Time</option>
                                                <option value="Remotly">Remotly</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 pr-0">
                                        <div class="mt-10">
                                        <input name="salary_from" type="text" placeholder="Salary From"
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = 'Salary From'" required
                                            class="single-input form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-3 pr-0">
                                        <div class="mt-10">
                                            <input name="salary_to" type="text" placeholder="Salary To"
                                                onfocus="this.placeholder = ''" onblur="this.placeholder = 'Salary To'" required
                                                class="single-input form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-10">
                                <textarea name="required_knowledge" class="single-textarea" placeholder="Required Knowledge: each should be seperated by semicolon(;)" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Required Knowledge: each should be seperated by semicolon(;)'" required></textarea>
                            </div>

                            <div class="mt-10">
                                <textarea name="education_experience" class="single-textarea" placeholder="Education & Experience: each should be seperated by semicolon(;)" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Education & Experience: each should be seperated by semicolon(;)'" required></textarea>
                            </div>

                            <div class="mt-10">
                                <input min="1" type="number" name="vacancy_number" placeholder="Vacancy Number"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Vacancy Number'" required
                                    class="single-input">
                            </div>
                            <div class="mt-10">
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
