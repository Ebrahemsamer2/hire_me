<?php
require_once "../init.php";

$action = $_POST['action'];
$response_data = [];


if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if($action === 'loadAll')
    {
        $response_data['success'] = 1;
        $jobs = (new \Models\Job)->loadAll();
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
        if($job->getId())
        {
            $response_data['success'] = 1;
            $user = new \Models\User;
            $user->loadById($job->employer_id);
            $job->employer = $user;

            $response_data['job'] = $job;
        }
        
        echo json_encode($response_data);
        exit;
    }
}
