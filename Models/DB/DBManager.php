<?php

namespace Models\DB;

class DBManager extends DBConnection
{
    private $db;
    protected $table_name;
    protected $primary_col_name;
    protected $primary_col_value;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function load()
    {
        $query = "SELECT * FROM `$this->table_name`";
        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }
    
    public function loadByPrimary($value)
    {
        $query = "SELECT * FROM `$this->table_name` WHERE `$this->primary_col_name` = '$value' ";
        $statement = $this->pdo->query($query);
        return $statement->fetch();
    }

    public function deleteByPrimary($value)
    {
        $query = "DELETE FROM `$this->table_name` WHERE `$this->primary_col_name` = '$value'";
        return $this->pdo->execute($query);
    }
}
