<?php
class dbConnect
{
    public $conn;
 
    public function __construct()
    {
        require_once 'config.php';
            //used to get the credits
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE . ";charset=utf8mb4";
 
            $this->conn = new PDO(
                $dsn,
                DB_USER,
                DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            ); // credits are here
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        } //error generation
    }
 
    public function close()
    {
        $this->conn = null; // end something PDO
    }
}