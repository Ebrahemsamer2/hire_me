<?php

namespace Models;

class User extends DB\DBManager
{
    private int $id;
    private string $username;
    private string $password;
    private string $email;
    private string $type;
    private int $created_timestamp;
    private string $updated_timestamp;

    protected $table_name = 'users';
    protected $primary_col_name = 'id';

    private function init()
    {

    }

    public function isEmployer()
    {
        return $this->type == 'employer';
    }
}