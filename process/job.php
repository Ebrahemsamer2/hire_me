<?php
require_once "../init.php";

$action = $_POST['action'];
$response_data = [];


if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if($action === 'loadAll')
    {
        $offset = intval($_POST['offset']) ?? 0;
        $filters = isset($_POST['filters']) ? $_POST['filters'] : [];
        $response_data['success'] = 1;
        $response_data['jobs'] = (new \Models\Job)->loadFilteredJobs($filters, $offset);

        $categories = (new \Models\Category)->loadAll();
        if(count($categories)) {
            $response_data['categories'] = $categories;
        }

        $locations = (new \Models\Job)->loadAllLocations();
        $locations = array_column($locations, 'location');
        $response_data['locations'] = $locations;
        echo json_encode($response_data);
        exit;
    }

    if($action === 'loadForYouJobs')
    {
        $response_data['success'] = 1;
        $jobs = (new \Models\Job)->loadAllWith('users', 'employer_id', ['username'], 0, 5);
        if(count($jobs)) {
            $response_data['jobs'] = $jobs;
        }
        echo json_encode($response_data);
        exit;
    }

    if($action === 'load')
    {
        $response_data['success'] = 0;
        $slug = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING);
        if(! $slug)
        {
            $response_data['message'] = 'Invalid Job.';
            echo json_encode($response_data);
            exit;
        }

        $job = new \Models\Job([$slug]);
        if(! $job->getId())
        {
            $response_data['message'] = 'Invalid Job.';
            echo json_encode($response_data);
            exit;
        }
        $response_data['success'] = 1;
        if($job->employer_id) {
            $user = new \Models\User;
            $user->loadById($job->employer_id);
            $job->employer = $user;
        }
        if($job->category_id) {
            $category = new \Models\Category;
            $category->loadById($job->category_id);
            $job->category = $category;
        }
        $response_data['job'] = $job;

        $job_user = new \Models\JobUser([$job->getId(), $_SESSION['user']['id'] ?? 0]);
        if($job_user->getId())
        {
            $response_data['applied_by_current_user'] = true;
        }
        
        echo json_encode($response_data);
        exit;
    }
    
    if($action === 'save')
    {
        $response_data['success'] = 0;

        $slug = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_STRING);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
        $required_knowledge = filter_input(INPUT_POST, 'required_knowledge', FILTER_SANITIZE_STRING);
        $education_experience = filter_input(INPUT_POST, 'education_experience', FILTER_SANITIZE_STRING);
        $vacancy_number = (int) filter_input(INPUT_POST, 'vacancy_number', FILTER_SANITIZE_STRING);
        $years_of_experience = filter_input(INPUT_POST, 'years_of_experience', FILTER_SANITIZE_STRING);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        
        $job_nature = filter_input(INPUT_POST, 'job_nature', FILTER_SANITIZE_STRING);
        $salary_from = (int) filter_input(INPUT_POST, 'salary_from', FILTER_SANITIZE_STRING);
        $salary_to = (int) filter_input(INPUT_POST, 'salary_to', FILTER_SANITIZE_STRING);

        if(! $title || ! $description || ! $country || ! $city || ! $required_knowledge || 
        ! $education_experience || ! $vacancy_number || !$category_id || ! $years_of_experience || ! $salary_from || ! $salary_to || ! $job_nature)
        {
            $response_data['message'] = 'Invalid job data';
            echo json_encode($response_data);
            exit;
        }

        if(strlen($required_knowledge) < 100 || strlen($education_experience) < 100)
        {
            $response_data['message'] = 'Required Knowledge and Experience should be greater than 100 characters.';
            echo json_encode($response_data);
            exit;
        }

        if($vacancy_number < 1)
        {
            $response_data['message'] = 'Invalid Vacancy Number.';
            echo json_encode($response_data);
            exit;
        }

        if($salary_from < 1 || $salary_to < 1 || $salary_from > $salary_to)
        {
            $response_data['message'] = 'Invalid Salary Range.';
            echo json_encode($response_data);
            exit;
        }

        $job = new \Models\Job([$slug]);
        if(!in_array($job_nature, $job->getJobNatures()) )
        {
            $response_data['message'] = 'Invalid Job Nature.';
            echo json_encode($response_data);
            exit;
        }

        if(!in_array($years_of_experience, $job->getJobExperiences()) )
        {
            $response_data['message'] = 'Invalid Job Nature.';
            echo json_encode($response_data);
            exit;
        }
        if(! $job->getId()) {
            $job->slug = implode('-', explode(' ', $title)) . '-' . time();
        }

        $job->title = $title;
        $job->description = $description;
        $job->location = $country . ' - ' . $city;
        $job->required_knowledge = $required_knowledge;
        $job->education_experience = $education_experience;
        $job->vacancy_number = $vacancy_number;
        $job->years_of_experience = $years_of_experience;
        $job->category_id = $category_id;
        $job->job_nature = $job_nature;
        $job->salary_from = $salary_from;
        $job->salary_to = $salary_to;
        
        $job->saveJob();
        $response_data['success'] = 1;
        $response_data['message'] = 'Job has been created';
        echo json_encode($response_data);
        exit;
    }
}
