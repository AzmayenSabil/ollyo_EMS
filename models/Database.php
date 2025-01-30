<?php
class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "admin";
    private $dbname = "event_management";
    public $conn;

    public function __construct()
    {
        // Create a new connection
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
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
