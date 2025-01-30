<?php
class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "admin";
    private $dbname = "event_management";
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die("Database Connection Failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    public function close()
    {
        $this->conn->close();
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
