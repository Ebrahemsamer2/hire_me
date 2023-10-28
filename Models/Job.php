<?php

namespace Models;

class Job extends DB\DBManager
{
    private int $id = 0;
    public string $title;
    public string $employer_id;
    public string $category_id;
    public string $description;
    public string $required_knowledge;
    public string $education_experience;
    public string $location;
    public string $salary_from;
    public string $salary_to;
    public string $job_nature;
    public string $vacancy_number;
    public string $years_of_experience;
    public string $status = 'opened';

    public int $created_timestamp;
    public int $updated_timestamp;

    protected $table_name = 'jobs';
    protected $primary_col_name = 'id';
    protected $load_cols = ['slug'];

    protected $fillable = ['slug', 'title', 'description', 'employer_id', 'category_id', 'required_knowledge', 'education_experience', 
    'location', 'job_nature', "salary_from", "salary_to", "vacancy_number", "years_of_experience"];

    protected $updatable = ['slug', 'title', 'description', 'category_id', 'required_knowledge', 'education_experience', 
    'location', 'job_nature', "salary_from", "salary_to", "vacancy_number", "years_of_experience"];

    public function __construct($load_data = [])
    {
        parent::__construct($load_data);
    }

    protected function init($row)
    {
        $this->id = $row->id ?? 0;
        $this->title = $row->title ?? "";
        $this->employer_id = $row->employer_id ?? 0;
        $this->category_id = $row->category_id ?? 0;
        $this->required_knowledge = $row->required_knowledge ?? "";
        $this->education_experience = $row->education_experience ?? "";
        $this->location = $row->location ?? "";
        $this->description = $row->description ?? "";
        $this->salary_from = $row->salary_from ?? 0;
        $this->job_nature = $row->job_nature;
        $this->salary_to = $row->salary_to ?? 0;
        $this->vacancy_number = $row->vacancy_number ?? 0;
        $this->years_of_experience = $row->years_of_experience ?? 0;
        $this->status = $row->status ?? 'opened';
    }

    public function getJobNatures()
    {
        return ["Full Time", "Part Time", "Remotly"];
    }

    public function getJobExperiences()
    {
        return ["1-2", "2-3", "3-6", "6-more.."];
    }

    public function loadAllLocations()
    {
        $query = "SELECT DISTINCT location FROM jobs";
        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }

    public function loadApplicants()
    {
        $id = $this->getId();
        $query = "SELECT j.slug, u.email, u.username, u.avatar, u.about_me, u.resume, ju.* FROM job_user ju 
        INNER JOIN users u ON ju.user_id = u.id
        INNER JOIN jobs j ON ju.job_id = j.id
        WHERE ju.job_id = $id";

        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }

    public function loadAuthor()
    {
        $id = $this->getId();
        $query = "SELECT u.username, u.avatar, u.about_me, u.resume, ju.* FROM job_user ju INNER JOIN users u ON ju.user_id = u.id WHERE ju.job_id = $id";
        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }

    public function checkAuthor()
    {
        $user_id = \Models\Session::get('user')['id'];
        return $this->employer_id == $user_id;
    }

    public function loadFilteredJobs($filters = [], $offset = 0, $limit = 50)
    {
        $query = "SELECT u.username, j.* FROM jobs j INNER JOIN users u ON u.id = j.employer_id WHERE 1 ";
        $parameters = [];

        if(isset($filters['title']) && !empty($filters['title']))
        {
            $query .= "AND title LIKE ? ";
            $title = $filters['title'];
            $parameters[] = "%$title%";
        }

        if(isset($filters['category']) && !empty($filters['category']))
        {
            $query .= "AND category_id = (SELECT id FROM categories WHERE slug = ?)";
            $parameters[] = $filters['category'];
        }

        if(isset($filters['location']) && !empty($filters['location']))
        {
            $query .= " AND location = ? ";
            $location = urldecode($filters['location']);
            $parameters[] = $location;
        }

        if(isset($filters['job_nature']) && !empty($filters['job_nature']))
        {
            $job_natures = urldecode($filters['job_nature']);
            $job_natures_exploded = explode(",", $job_natures);
            $job_natures_imploded = implode("','", $job_natures_exploded);
            $query .= " AND job_nature IN ('$job_natures_imploded') ";
        }
        
        if(isset($filters['experience']) && !empty($filters['experience']))
        {
            $experiences = urldecode($filters['experience']);
            $experiences_exploded = explode(",", $experiences);
            $experiences_imploded = implode("','", $experiences_exploded);
            $query .= " AND years_of_experience IN ('$experiences_imploded') ";
        }

        $query .= " ORDER BY j.id DESC LIMIT $offset, $limit";
        if(count($parameters)) {
            $statement = $this->pdo->prepare($query);
            $statement->execute($parameters);
        } else {
            $statement = $this->pdo->query($query);
        }
        return $statement->fetchAll();
    }

    public function saveJob()
    {
        if($this->getId()){
            $this->updated_timestamp = time();
            return $this->update();
        }
        $data = [$this->slug, $this->title, $this->description, $_SESSION['user']['id'], $this->category_id, $this->required_knowledge, 
        $this->education_experience, $this->location, $this->job_nature, $this->salary_from, $this->salary_to, 
        $this->vacancy_number, $this->years_of_experience];
        $this->id = $this->save($data);
        return $this->id ?? false;
    }

    public function getId()
    {
        return $this->id;
    }
}