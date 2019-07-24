<?php
class Database
{
    private $host;
    private $username;
    private $password;
    private $database;
    public $connect;

    public function __construct($dbHost, $userHost, $passHost, $databaseName)
    {
        $this->host     = $dbHost;
        $this->username = $userHost;
        $this->password = $passHost;
        $this->database = $databaseName;

        $this->connect = new mysqli($this->host, $this->username, $this->password, $this->database) or die("Connect Failed : " . mysqli_error($this->connect));
        if ($this->connect) {
            return true;
        }

        return false;
    }
}
