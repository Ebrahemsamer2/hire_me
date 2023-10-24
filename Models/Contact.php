<?php

namespace Models;

class Contact extends DB\DBManager
{
    private int $id = 0;
    public string $name;
    public string $email;
    public string $subject;
    public string $message;

    public int $created_timestamp;
    public int $updated_timestamp;

    protected $table_name = 'contacts';
    protected $primary_col_name = 'id';
    protected $load_cols = [];

    protected $fillable = ['name', 'email', 'subject', 'message'];

    public function __construct($load_data = [])
    {
        parent::__construct($load_data);
    }

    protected function init($row)
    {
        $this->id = $row->id ?? 0;
        $this->name = $row->name ?? "";
        $this->email = $row->email ?? "";
        $this->subject = $row->subject ?? "";
        $this->message = $row->message ?? "";
    }

    public function getId()
    {
        return $this->id;
    }
}