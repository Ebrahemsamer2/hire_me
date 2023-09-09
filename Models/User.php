<?php

namespace Models;

class User extends DB\DBManager
{
    private int $id;
    public string $username;
    public string $password;
    public string $email;
    public string $type;
    public int $created_timestamp;
    public string $updated_timestamp;

    public $table_name = 'users';
    public $primary_col_name = 'id';
    public $load_cols = ['email'];

    protected $fillable = ['username', 'password', 'email', 'type'];

    public function __construct($load_data = [])
    {
        parent::__construct($load_data);
    }

    protected function init($row)
    {
        $this->id = $row->id;
        $this->username = $row->username;
        $this->email = $row->email;
        $this->password = $row->password;
        $this->type = $row->type;
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
            Session::add('user', ['username' => $this->username, 'email' => $this->email, 'id' => $this->id, 'type' => $this->type]);
            return true;
        }
        return false;
    }

    public function login()
    {
        if($this->id)
        {
            Session::add('user', ['username' => $this->username, 'email' => $this->email, 'id' => $this->id, 'type' => $this->type]);
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

    public function getId()
    {
        return $this->id ?? 0;
    }

    public function getPassword()
    {
        return $this->password;
    }
}