<?php 

namespace Models;

class JobUser extends DB\DBManager
{
    private int $id;
    public string $job_id;
    public string $user_id;
    public string $status;
    public int $created_timestamp;
    public int $updated_timestamp;

    public $table_name = 'job_user';
    public $primary_col_name = 'id';
    public $load_cols = ['job_id', 'user_id'];

    protected $fillable = ['job_id', 'user_id', 'status', 'created_timestamp', 'updated_timestamp'];

    public function __construct($load_data = [])
    {
        parent::__construct($load_data);
    }

    protected function init($row)
    {
        $this->id = $row->id;
        $this->job_id = $row->job_id;
        $this->user_id = $row->user_id;
        $this->status = $row->status;
    }
    
    public function apply()
    {
        $data = [$this->job_id, $this->user_id, $this->status, time(), time()];
        $this->id = $this->save($data);
        return $this->id ?? false;
    }

    public function updateStatus()
    {
        
    }

    public function getId()
    {
        return $this->id ?? 0;
    }
}