<?php 

namespace Models\DB;

class DBConnection
{
    private string $dbname = 'hire_me';
    private string $user = 'root';
    private string $password = '';
    private string $host = 'localhost';
    private $options = [
		\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
		\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
	];
    protected $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new \PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password, $this->options);
        } catch (PDOException $e) {
            echo "Database Connection Error.";
            exit;
        }
    }
}