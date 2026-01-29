<?php
/*
 * Versie: 1.2
 * Datum: 29-01-2026
 * Beschrijving: Voorraad class voor CRUD operaties
 */

class Voorraad {
    public $id;
    public $artikel_id;
    public $locatie;
    public $aantal;
    public $status_id;
    public $ingeboekt_op;
    
    private $db;
    
    /*
     * Constructor: ontvangt database connectie
     */
    public function __construct($db) {
        $this->db = $db;
    }
    
    /*
     * Haalt alle voorraad items op met artikel en status naam
     */
    public function haalAlleOp() {
        $sql = "SELECT voorraad.*, artikel.naam as artikel_naam, status.status as status_naam 
                FROM voorraad 
                LEFT JOIN artikel ON voorraad.artikel_id = artikel.id 
                LEFT JOIN status ON voorraad.status_id = status.id 
                ORDER BY voorraad.id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*
     * Haalt één voorraad item op basis van ID
     */
    public function haalOpById($id) {
        $sql = "SELECT * FROM voorraad WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /*
     * Voegt nieuw voorraad item toe
     */
    public function toevoegen($artikel_id, $locatie, $aantal, $status_id) {
        $sql = "INSERT INTO voorraad (artikel_id, locatie, aantal, status_id, ingeboekt_op) VALUES (:artikel_id, :locatie, :aantal, :status_id, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'artikel_id' => $artikel_id,
            'locatie' => $locatie,
            'aantal' => $aantal,
            'status_id' => $status_id
        ]);
    }
    
    /*
     * Werkt voorraad item bij
     */
    public function bijwerken($id, $artikel_id, $locatie, $aantal, $status_id) {
        $sql = "UPDATE voorraad SET artikel_id = :artikel_id, locatie = :locatie, aantal = :aantal, status_id = :status_id WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'artikel_id' => $artikel_id,
            'locatie' => $locatie,
            'aantal' => $aantal,
            'status_id' => $status_id,
            'id' => $id
        ]);
    }
    
    /*
     * Verwijdert voorraad item
     */
    public function verwijderen($id) {
        $sql = "DELETE FROM voorraad WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
