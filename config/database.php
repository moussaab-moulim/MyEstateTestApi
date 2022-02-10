<?php
//$mysqli = new mysqli("localhost", "root", "", "live", "3308");

class Database
{
    private $host = "localhost";
    private $database_name = "my_estate_test";
    private $username = "root";
    private $password = "";
    private $port = "3306";



    //$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);


    public $conn;

    public function getConnection()
    {
        $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));

        $this->host = $cleardb_url["host"];
        $this->username = $cleardb_url["user"];
        $this->password = $cleardb_url["pass"];
        $this->database_name = substr($cleardb_url["path"], 1);
        $active_group = 'default';
        $query_builder = TRUE;
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";
                dbname=" . $this->database_name,
                $this->username,
                $this->password
            );
        } catch (PDOException $exception) {
            echo "Database could not be connected: " . $exception->getmessage();
        }
        return $this->conn;
    }
}
