<?php
/*
 * Versie: 1.0
 * Datum: 28-01-2026
 * Beschrijving: Klant class voor CRUD operaties
 */

class Klant {
    public $id;
    public $naam;
    public $adres;
    public $plaats;
    public $telefoon;
    public $email;
    
    private $db;
    
    /*
     * Constructor: ontvangt database connectie
     */
    public function __construct($db) {
        $this->db = $db;
    }
    
    /*
     * Haalt alle klanten op
     */
    public function haalAlleOp() {
        $sql = "SELECT * FROM klant ORDER BY naam";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*
     * Haalt één klant op basis van ID
     */
    public function haalOpById($id) {
        $sql = "SELECT * FROM klant WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /*
     * Voegt nieuwe klant toe
     */
    public function toevoegen($naam, $adres, $plaats, $telefoon, $email) {
        $sql = "INSERT INTO klant (naam, adres, plaats, telefoon, email) VALUES (:naam, :adres, :plaats, :telefoon, :email)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'naam' => $naam,
            'adres' => $adres,
            'plaats' => $plaats,
            'telefoon' => $telefoon,
            'email' => $email
        ]);
    }
    
    /*
     * Werkt klant bij
     */
    public function bijwerken($id, $naam, $adres, $plaats, $telefoon, $email) {
        $sql = "UPDATE klant SET naam = :naam, adres = :adres, plaats = :plaats, telefoon = :telefoon, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'naam' => $naam,
            'adres' => $adres,
            'plaats' => $plaats,
            'telefoon' => $telefoon,
            'email' => $email,
            'id' => $id
        ]);
    }
    
    /*
     * Verwijdert klant
     */
    public function verwijderen($id) {
        $sql = "DELETE FROM klant WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
