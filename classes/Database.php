<?php

/*
 - Versie: 1.0
 - Datum: 28-01-2026
 - Beschrijving: Gebruiker class for auth and user management
 */ //NOTE: FOREVER UNCHANGED

class Database {
    public $conn;
    
    // this will help with the connection to the database on new pages
    public function __construct() {
        require_once __DIR__ . '/../config.php';
        
        try {
            $this->conn = new PDO(
                "mysql:host=$dbHost;dbname=$dbNaam;charset=utf8",
                $dbGebruiker,
                $dbWachtwoord
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exceptions, ok.
        } catch (PDOException $e) { // Catch any errors
            die("Database connectie mislukt: " . $e->getMessage());
        }
    }
    

    public function getConnection() { // php inner function that is self-explanatory
        return $this->conn;
    }
}
?>
