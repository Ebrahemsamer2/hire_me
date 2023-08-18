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

        if($valid)
        {
            $message = "User has been created.";
        }

        $password = password_hash($password, PASSWORD_DEFAULT);
        $user = new \Models\User;
        $user->setUsername($first_name . ' ' . $last_name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setType($type);

        $response_data['success'] = $user->register();
        $response_data['message'] = $message;
    }
}

echo json_encode($response_data);