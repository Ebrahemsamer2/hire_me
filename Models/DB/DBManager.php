<?php

namespace Models\DB;

class DBManager extends DBConnection
{
    protected $primary_col_name;

    public function __construct($load_data = [])
    {
        parent::__construct();
        if(count($this->load_cols) === count($load_data))
        {
            foreach($this->load_cols as $key => $col)
                $this->$col = $load_data[$key];
            
            $this->loadBy($this->load_cols);
        }        
    }

    public function loadAll($offset = 0, $limit = 10)
    {
        $rows = [];   
        $query = "SELECT * FROM `$this->table_name` LIMIT $offset , $limit";
        $statement = $this->pdo->query($query);
        while($row = $statement->fetch())
        {
            $rows[] = $row;
        }
        return $rows;
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
    
    public function loadBy($columns)
    {
        $query = "SELECT * FROM `$this->table_name` WHERE `". implode("` = ? AND `", $columns) ."` = ?";
        $statement = $this->pdo->prepare($query);
        $executed_data = [];
        foreach($columns as $col)
            $executed_data[] = $this->$col;
        
        if(count($executed_data))
        {
            $statement->execute($executed_data);
            $row = $statement->fetch();
            if($row){
                $this->init($row);
            }
        }
    }

    public function loadById($id)
    {
        $query = "SELECT * FROM `$this->table_name` WHERE `id` = ?";
        $statement = $this->pdo->prepare($query);
        
        $statement->execute([$id]);
        $row = $statement->fetch();
        if($row){
            $this->init($row);
        }
    }

    public function deleteByPrimary($value)
    {
        $query = "DELETE FROM `$this->table_name` WHERE `$this->primary_col_name` = '$value'";
        return $this->pdo->execute($query);
    }
}
