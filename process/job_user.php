<?php
require_once "../init.php";

$action = $_POST['action'];
$response_data = [];


if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    if($action == 'loadMyJobs')
    {
        $response_data['success'] = 0;
        $user_id = \Models\Session::get('user')['id'] ?? 0;

        if(!$user_id)
        {
            $response_data['message'] = 'Invalid User';
            echo json_encode($response_data);
            exit;
        }

        $job_user = new \Models\JobUser();
        $myJobs = $job_user->loadJobs($user_id);
        
        $response_data['success'] = 1;
        $response_data['myJobs'] = $myJobs;
        echo json_encode($response_data);
        exit;
    }

    if($action == 'loadAuthorJobs')
    {
        $response_data['success'] = 0;
        $user_id = \Models\Session::get('user')['id'] ?? 0;

        if(!$user_id)
        {
            $response_data['message'] = 'Invalid User';
            echo json_encode($response_data);
            exit;
        }

        $job_user = new \Models\JobUser();
        $myJobs = $job_user->loadAuthorJobs($user_id);
        
        $response_data['success'] = 1;
        $response_data['myJobs'] = $myJobs;
        echo json_encode($response_data);
        exit;
    }

    if($action == 'apply')
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

        $user_id = $_SESSION['user']['id'] ?? 0;
        $user_type = $_SESSION['user']['type'] ?? '';

        if(! $user_id || ! $user_type)
        {
            $response_data['message'] = 'You must login to apply.';
            echo json_encode($response_data);
            exit;
        }

        if($user_type == 'employer')
        {
            $response_data['message'] = 'Avilable for employees only';
            echo json_encode($response_data);
            exit;
        }

        $job_id = $job->getId();
        $status = "applied";

        if(! $job_id || ! $user_id)
        {
            $response_data['message'] = 'Invalid User/Job';
            echo json_encode($response_data);
            exit;
        }

        $job_user = new \Models\JobUser([$job_id, $user_id]);
        if($job_user->getId())
        {
            $response_data['message'] = 'Already Applied for this job';
            echo json_encode($response_data);
            exit;
        }
        $job_user->user_id = $user_id;
        $job_user->job_id = $job_id;
        $job_user->status = $status;
        $job_user->apply();
        $response_data['success'] = 1;
        $response_data['message'] = 'Applied Successfully';
        echo json_encode($response_data);
        exit;
    }
}
