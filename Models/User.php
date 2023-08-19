<?php

namespace Models;

class User extends DB\DBManager
{
    private int $id;
    private string $username;
    private string $password;
    protected string $email;
    private string $type;
    private int $created_timestamp;
    private string $updated_timestamp;

    protected $table_name = 'users';
    protected $primary_col_name = 'id';

    protected $fillable = ['username', 'password', 'email', 'type'];

    public function __construct($email = '')
    {
        parent::__construct($email);
    }

    protected function init($row)
    {
        $this->id = $row->id;
        $this->username = $row->username;
        $this->email = $row->email;
        $this->password = $row->password;
        $this->type = $row->type;

        return $this;
    }

    public function isEmployer()
    {
        return $this->type == 'employer';
    }
    
    public function register()
    {
        $data = [$this->username, $this->password, $this->email, $this->type];
        $this->id = $this->save($data);

        if($this->id)
        {
            Session::add('user', ['username' => $this->username, 'email' => $this->email, 'id' => $this->id]);
            return true;
        }
        return false;
    }

    public function login()
    {
        if($this->id)
        {
            Session::add('user', ['username' => $this->username, 'email' => $this->email, 'id' => $this->id]);
            return true;
        }
        return false;
    }

    public function setUsername($username) 
    {
        $this->username = $username;
    }

    public function setEmail($email) 
    {
        $this->email = $email;
    }

    public function setPassword($password) 
    {
        $this->password = $password;
    }

    public function setType($type) 
    {
        $this->type = $type;
    }

    public function getPassword()
    {
        return $this->password;
    }
}