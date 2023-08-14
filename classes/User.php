<?php

class User extends DB
{
    private int $id;
    private string $username;
    private string $password;
    private string $email;
    private string $type;
    private int $created_timestamp;
    private string $updated_timestamp;
    
    private function init()
    {

    }

    public function isEmployer()
    {
        return $this->type == 'employer';
    }
}