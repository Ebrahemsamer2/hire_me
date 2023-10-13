<?php
require_once "../init.php";

$action = $_POST['action'];
$response_data = [];

if($_SERVER['REQUEST_METHOD'] === 'POST')
{

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
        if(! $user->checkOldPassword($old_password))
        {
            $response_data['success'] = 0;
            $response_data['message'] = "Wrong old password!";
            echo json_encode($response_data);
            exit;
        }

        if(! $user->checkPasswordStrength($new_password))
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

        $response_data['message'] = "User info has been updated";
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
