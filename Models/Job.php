<?php

namespace Models;

class Job extends DB\DBManager
{
    private int $id = 0;
    public string $title;
    public string $employer_id;
    public string $description;
    public string $required_knowledge;
    public string $education_experience;
    public string $location;
    public string $salary_from;
    public string $salary_to;
    public string $job_nature;
    public string $vacancy_number;

    public int $created_timestamp;
    public int $updated_timestamp;

    public $table_name = 'jobs';
    public $primary_col_name = 'id';
    public $load_cols = ['slug'];

    protected $fillable = ['slug', 'title', 'description', 'employer_id', 'required_knowledge', 'education_experience', 
    'location', 'job_nature', "salary_from", "salary_to", "vacancy_number"];

    public function __construct($load_data = [])
    {
        parent::__construct($load_data);
    }

    protected function init($row)
    {
        $this->id = $row->id ?? 0;
        $this->title = $row->title ?? "";
        $this->employer_id = $row->employer_id ?? 0;
        $this->required_knowledge = $row->required_knowledge ?? "";
        $this->education_experience = $row->education_experience ?? "";
        $this->location = $row->location ?? "";
        $this->description = $row->description ?? "";
        $this->salary_from = $row->salary_from ?? 0;
        $this->job_nature = $row->job_nature;
        $this->salary_to = $row->salary_to ?? 0;
        $this->vacancy_number = $row->vacancy_number ?? 0;
    }

    public function getJobNatures()
    {
        return ["Full Time", "Part Time", "Remotly"];
    }

    public function saveJob()
    {
        $data = [$this->slug, $this->title, $this->description, $_SESSION['user']['id'], $this->required_knowledge, 
        $this->education_experience, $this->location, $this->job_nature, $this->salary_from, $this->salary_to, $this->vacancy_number];
        $this->id = $this->save($data);
        return $this->id ?? false;
    }

    public function getId()
    {
        return $this->id;
    }
}