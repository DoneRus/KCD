<?php
/*
 - Versie: 1.0
 - Datum: 28-01-2026
 - Beschrijving: Gebruiker class for auth and user management
 */

class Gebruiker {
    public $id;
    public $gebruikersnaam;
    public $wachtwoord;
    public $rollen;
    public $is_geverifieerd;
    
    private $db;
    
    // contrsuctor gets db connection, got confused here, but includes in other files work as intended if
    //  database.php is also included
    public function __construct($db) {
        $this->db = $db;
    }
    
    // gets all info from database, so it is read
    public function haalAlleOp() {
        $sql = "SELECT id, gebruikersnaam, rollen, is_geverifieerd FROM gebruiker ORDER BY id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // search fir akdready existing user by username
    public function zoekOpGebruikersnaam($gebruikersnaam) {
        $sql = "SELECT * FROM gebruiker WHERE gebruikersnaam = :gebruikersnaam";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['gebruikersnaam' => $gebruikersnaam]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // add new user to database with hashed password
    public function toevoegen($gebruikersnaam, $wachtwoord, $rol, $is_geverifieerd = 0) {
        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT); // this hashes the password, don't know how it works
        $sql = "INSERT INTO gebruiker (gebruikersnaam, wachtwoord, rollen, is_geverifieerd) VALUES (:gebruikersnaam, :wachtwoord, :rollen, :is_geverifieerd)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'gebruikersnaam' => $gebruikersnaam,
            'wachtwoord' => $hash,
            'rollen' => $rol,
            'is_geverifieerd' => $is_geverifieerd
        ]);
    }
    
    /*
     * Reset wachtwoord naar standaard waarde
     */
    public function resetWachtwoord($id, $nieuwWachtwoord = 'welkom123') {
        $hash = password_hash($nieuwWachtwoord, PASSWORD_DEFAULT);
        $sql = "UPDATE gebruiker SET wachtwoord = :wachtwoord WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['wachtwoord' => $hash, 'id' => $id]);
    }
    
    /*
     * Verwijdert gebruiker
     */
    public function verwijderen($id) {
        $sql = "DELETE FROM gebruiker WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    /*
     * Controleert wachtwoord bij inloggen
     */
    public function controleerWachtwoord($ingevoerd, $hash) {
        return password_verify($ingevoerd, $hash) || $ingevoerd == $hash;
    }
}
?>
