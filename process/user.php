<?php
require_once "../init.php";

$action = $_POST['action'];
$response_data = [];

if($_SERVER['REQUEST_METHOD'] === 'POST')
{

    if($action == 'download_resume')
    {
        $slug = filter_input(INPUT_POST, 'job_slug', FILTER_SANITIZE_EMAIL);
        $email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
        if(! $email)
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Invalid Email";
            echo json_encode($response_data);
            exit;
        }
        $user = new \Models\User([$email]);
        if(!$user->getId())
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Invalid User";
            echo json_encode($response_data);
            exit;
        }
        if(!$user->resume)
        {
            $response_data['success'] = 0;
            $response_data['message'] = "User does not have resume";
            echo json_encode($response_data);
            exit;
        }
        if(!file_exists("../assets/resumes/" . $user->resume))
        {
            $response_data['success'] = 0;
            $response_data['message'] = "User resume can not be found";
            echo json_encode($response_data);
            exit;
        }
        $job = new \Models\Job([$slug]);
        if(!$job->getId())
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Invalid Job";
            echo json_encode($response_data);
            exit;
        }
        
        $job_user = new \Models\JobUser([$job->getId(), $user->getId()]);
        $job_user->status = "resume viewed";
        
        if($job_user->update())
        {
            $resume_filename = $user->resume;
            $response_data['success'] = 1;
            $response_data['message'] = "Resume will be downloaded shortly.";
            $response_data['resume_filename'] = $resume_filename;
        }
        
        echo json_encode($response_data);
        exit;
    }

    if($action === 'loadProfile')
    {
        $user_session_data = \Models\Session::get('user');
        if(! $user_session_data)
        {
            $response_data['success'] = 0;
            $response_data['message'] = "You need to login";
            echo json_encode($response_data);
            exit;
        }
        $user = new \Models\User([$user_session_data['email']]);
        if(!$user->getId())
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Invalid User";
            echo json_encode($response_data);
            exit;
        }
        $response_data['user'] = $user;
        $response_data['success'] = 1;
        echo json_encode($response_data);
        exit;
    }
    if($action === 'uploadAvatar')
    {   
        $user_session_id = \Models\Session::get('user')['id'];
        $user_session_email = \Models\Session::get('user')['email'];

        if(count($_FILES)){
            $avatar = $_FILES['avatar'];
            $avatar_path = $avatar['tmp_name'];
            $avatar_type = explode("/", $avatar['type'])[1];

            if (exif_imagetype($avatar_path) > 3) {
                $response_data['success'] = 0;
                $response_data['message'] = "Only jpg, png, jpeg and gif are allowed!";
                echo json_encode($response_data);
                exit;
            }

            $avatar_name = "avatar-$user_session_id.$avatar_type";
            if(! move_uploaded_file($avatar_path, "../assets/img/avatar/$avatar_name"))
            {
                $response_data['success'] = 0;
                $response_data['message'] = "Upload has failed, Try again!";
                echo json_encode($response_data);
                exit;
            }
            // store image in user table
            $user = new \Models\User([$user_session_email]);
            $user->avatar = $avatar_name;
            if(!$user->updateProfile())
            {
                $response_data['message'] = "Unkown Error";
                $response_data['success'] = 0;
                echo json_encode($response_data);
                exit;
            }

            $response_data['message'] = "Your avatar has been updated";
            $response_data['success'] = 1;
            $response_data['avatar_name'] = $avatar_name;
            echo json_encode($response_data);
            exit;
            
        }
    }

    
    if($action === 'uploadResume')
    {   
        $user_session_id = \Models\Session::get('user')['id'];
        $user_session_email = \Models\Session::get('user')['email'];

        if(count($_FILES)){
            $resume = $_FILES['resume'];
            $resume_path = $resume['tmp_name'];
            $resume_type = explode("/", $resume['type'])[1];
            $resume_size = $resume['size'];
            $max_resume_size = 5 * 1000 * 1000;

            if ($resume_size > $max_resume_size ) {
                $response_data['success'] = 0;
                $response_data['message'] = "File is too large, 5M is max size!";
                echo json_encode($response_data);
                exit;
            }

            if (! in_array($resume_type, ['pdf', 'docx'])) {
                $response_data['success'] = 0;
                $response_data['message'] = "Only pdf and docx resumes are allowed!";
                echo json_encode($response_data);
                exit;
            }

            $user = new \Models\User([$user_session_email]);
            $resume_name = $user->username . "-resume-$user_session_id.$resume_type";

            if(! move_uploaded_file($resume_path, "../assets/resumes/$resume_name"))
            {
                $response_data['success'] = 0;
                $response_data['message'] = "Upload has failed, Try again!";
                echo json_encode($response_data);
                exit;
            }
           
            $user->resume = $resume_name;
            if(!$user->updateProfile())
            {
                $response_data['message'] = "Unkown Error";
                $response_data['success'] = 0;
                echo json_encode($response_data);
                exit;
            }

            $response_data['message'] = "Your resume has been updated";
            $response_data['success'] = 1;
            $response_data['resume_name'] = $resume_name;
            echo json_encode($response_data);
            exit;
        }
    }

    if($action === 'saveProfile')
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $web = filter_input(INPUT_POST, 'web', FILTER_SANITIZE_STRING);
        $about_me = filter_input(INPUT_POST, 'about_me', FILTER_SANITIZE_STRING);

        $old_password = filter_input(INPUT_POST, 'old_password', FILTER_SANITIZE_STRING);
        $new_password = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
        $confirmation = filter_input(INPUT_POST, 'confirmation', FILTER_SANITIZE_STRING);
        
        $session_email =  \Models\Session::get('user')['email'];

        if(!$username || !$email)
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Username and email are required!";
            echo json_encode($response_data);
            exit;
        }

        if($new_password && $new_password != $confirmation)
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Invalid confirmation!";
            echo json_encode($response_data);
            exit;
        }

        if($new_password && !$old_password)
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Invalid old password!";
            echo json_encode($response_data);
            exit;
        }

        $user = new \Models\User([$email]);
        if($user->getId() && $session_email != $email)
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Email is already exist!";
            echo json_encode($response_data);
            exit;
        }
        $user = new \Models\User([$session_email]);
        if($new_password && ! $user->checkOldPassword($old_password))
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Wrong old password!";
            echo json_encode($response_data);
            exit;
        }

        if($new_password && ! $user->checkPasswordStrength($new_password))
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Invalid new password!";
            echo json_encode($response_data);
            exit;
        }
        
        $user->username = $username;
        $user->email = $email;
        $user->web = $web;
        $user->about_me = $about_me;

        if(!$user->updateProfile())
        {
            $response_data['message'] = "Unkown Error";
            $response_data['success'] = 0;
            echo json_encode($response_data);
            exit;
        }

        if($new_password)
        {
            $user->setPassword(password_hash($new_password, PASSWORD_DEFAULT));
            if(!$user->updatePassword($new_password))
            {
                $response_data['message'] = "Error While updating password.";
                $response_data['success'] = 0;
                echo json_encode($response_data);
                exit;
            }
        }

        $response_data['message'] = "Your profile info has been updated";
        $response_data['success'] = 1;
        echo json_encode($response_data);
        exit;
    }

    if($action === 'register')
    {
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $confirmation = filter_input(INPUT_POST, 'confirmation', FILTER_SANITIZE_STRING);

        $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING) ?? 'employee';

        $valid = 1;
        $message = "";
        if(!$last_name || !$first_name || !$email ||!$password || !$confirmation)
        {
            $valid = 0;
            $message = "All Data is required!";
        }

        if($password !== $confirmation)
        {
            $valid = 0;
            $message = "Wrong Password!";
        }

        if($type != 'employee' && $type != 'employer')
        {
            $valid = 0;
            $message = "Invalid Type";
        }

        if(! $valid)
        {
            $response_data['success'] = $valid;
            $response_data['message'] = $message;
            echo json_encode($response_data);
            exit;
        }

        $user = new \Models\User([$email]);
        if($user->getId())
        {
            $valid = 0;
            $message = "User is already exist.";

            $response_data['success'] = $valid;
            $response_data['message'] = $message;
            echo json_encode($response_data);
            exit;
        }
        else 
        {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $user->setPassword($password);
            $user->username = $first_name . ' ' . $last_name;
            $user->type = $type;

            $user->register();
            $message = "User has been created.";
            $response_data['success'] = $valid;
            $response_data['message'] = $message;
        }
        echo json_encode($response_data);
        exit;
    }

    if($action === 'login')
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        
        $valid = 1;
        $message = "";
        if(!$email || !$password)
        {
            $valid = 0;
            $message = "All Data is required!";
            $response_data['success'] = $valid;
            $response_data['message'] = $message;
            
            echo json_encode($response_data);
            exit;
        }

        $user = new \Models\User([$email]);
        if(!$user->getId())
        {
            $valid = 0;
            $message = "User does not exist.";
        }
        else 
        {
            if(!password_verify($password, $user->getPassword()))
            {
                $valid = 0;
                $message = "Wrong password";
            } else {
                $user->login();
                $message = "Success";
            }
        }
        $response_data['success'] = $valid;
        $response_data['message'] = $message;

        echo json_encode($response_data);
        exit;
    }

    if($action === 'logout')
    {
        $valid = 1;
        $message = "";

        if(!\Models\Session::checkLogin())
        {
            $valid = 0;
            $message = "You're already logged out";
        } else {
            $session_email = $_SESSION['user']['email'];
            $user = new \Models\User([$session_email]);
            \Models\Session::destroy();
            $message = "Success";
        }
        $response_data['success'] = $valid;
        $response_data['message'] = $message;

        echo json_encode($response_data);
        exit;
    }
}
