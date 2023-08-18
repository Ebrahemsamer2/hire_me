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

    protected $fillable = ['username', 'password', 'email', 'type'];

    private function init()
    {
        $this->load();
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
            Session::add('user', ['username' => $this->username, 'id' => $this->id]);
            return true;
        }
        return false;
    }

    public function login()
    {
        
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

}