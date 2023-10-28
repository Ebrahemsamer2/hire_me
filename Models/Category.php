<?php

namespace Models;

class Category extends DB\DBManager
{
    private int $id = 0;
    public string $name;
    public string $slug;

    public int $created_timestamp;
    public int $updated_timestamp;

    protected $table_name = 'categories';
    protected $primary_col_name = 'id';
    protected $load_cols = ['slug'];

    protected $fillable = ['name', 'slug'];

    public function __construct($load_data = [])
    {
        parent::__construct($load_data);
    }

    protected function init($row)
    {
        $this->id = $row->id ?? 0;
        $this->name = $row->name ?? "";
        $this->slug = $row->slug ?? "";
    }

    public function saveCategory()
    {
        $data = [$this->name, $this->slug];
        $this->id = $this->save($data);
        return $this->id ?? false;
    }

    public function loadCategories($offset = 0, $limit = 0)
    {
        $query = "SELECT c.*, count(j.id) as jobsCount FROM `categories` c LEFT JOIN jobs j ON c.id = j.category_id GROUP BY c.id";
        if($offset && $offset)
        {
            $query .= " LIMIT $offset, $limit";
        }
        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }

    public function getId()
    {
        return $this->id;
    }
}