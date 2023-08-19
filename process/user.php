<?php
require_once "../init.php";

$action = $_POST['action'];
$response_data = [];

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
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

        $user = new \Models\User;
        $user->setEmail($email);
        $user_found = $user->loadBy('email');

        if($user_found)
        {
            $valid = 0;
            $message = "User is already exist.";
        }
        else 
        {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $user->setUsername($first_name . ' ' . $last_name);
            $user->setPassword($password);
            $user->setType($type);

            $user->register();
            $message = "User has been created.";
        }
        $response_data['success'] = $valid;
        $response_data['message'] = $message;
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
        }

        $user = new \Models\User;
        $user->setEmail($email);

        $user_found = $user->loadBy('email');

        if(!$user_found)
        {
            $valid = 0;
            $message = "User does not exist.";
        }
        else 
        {
            if(!password_verify($password, $user_found->getPassword()))
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
            $user = new \Models\User($session_email);
            \Models\Session::destroy();
            $message = "Success";
        }
        $response_data['success'] = $valid;
        $response_data['message'] = $message;
    }
}

echo json_encode($response_data);