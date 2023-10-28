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

    protected $updatable = ['status'];
    protected $fillable = ['job_id', 'user_id', 'status'];

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
        $data = [$this->job_id, $this->user_id, $this->status];
        $this->id = $this->save($data);
        return $this->id ?? false;
    }

    public function loadJobs($user_id)
    {
        $query = "SELECT ju.user_id, ju.job_id, ju.status as applicant_status , u.username, u.avatar, j.* FROM job_user ju 
        LEFT JOIN jobs j ON ju.job_id = j.id 
        LEFT JOIN users u ON j.employer_id = u.id
        WHERE ju.user_id = ?";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$user_id]);
        return $statement->fetchAll();
    }

    public function loadAuthorJobs($user_id)
    {
        $query = "SELECT u.username, u.avatar, j.* FROM jobs j 
        INNER JOIN users u ON u.id = j.employer_id 
        WHERE j.employer_id = ? AND j.status = 'opened' ORDER BY j.id DESC";
        $statement = $this->pdo->prepare($query);
        $statement->execute([$user_id]);

        return $statement->fetchAll();
    }
    
    public function getId()
    {
        return $this->id ?? 0;
    }
}