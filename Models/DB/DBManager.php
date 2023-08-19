<?php

namespace Models\DB;

class DBManager extends DBConnection
{
    protected $primary_col_name;
    protected $primary_col_value;

    public function __construct($email = '')
    {
        parent::__construct();
        if($email)
        {
            $this->email = $email;
            $this->loadBy('email');
        }
    }

    public function save($data)
    {
        $query = "INSERT INTO `$this->table_name` (`". implode("`, `", $this->fillable) ."`) VALUES (";
        if(count($this->fillable))
        {
            foreach($this->fillable as $index => $property)
            {
                if(count($this->fillable) - 1 === $index)
                    $query .= "?)";
                else 
                    $query .= "?, ";
            }
            $statement = $this->pdo->prepare($query);
            return $statement->execute($data);
        }
        return false;
    }

    public function load()
    {
        $query = "SELECT * FROM `$this->table_name`";
        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }
    
    public function loadBy($column)
    {   
        $query = "SELECT * FROM `$this->table_name` WHERE `$column` = ? ";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$this->$column]);
        $row = $statement->fetch();
        if($row){
            return $this->init($row);
        }
        return null;
    }

    public function deleteByPrimary($value)
    {
        $query = "DELETE FROM `$this->table_name` WHERE `$this->primary_col_name` = '$value'";
        return $this->pdo->execute($query);
    }
}
