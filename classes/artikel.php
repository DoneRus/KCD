<?php
/*
 * Versie: 1.1
 * Datum: 28-01-2026
 * Beschrijving: Artikel class voor CRUD operaties
 */

class Artikel {
    public $id;
    public $categorie_id;
    public $naam;
    public $prijs_ex_btw;
    
    private $db;
    
    /*
     * Constructor: ontvangt database connectie
     */
    public function __construct($db) {
        $this->db = $db;
    }
    
    /*
     * Haalt alle artikelen op met categorie naam
     */
    public function haalAlleOp() {
        $sql = "SELECT artikel.*, categorie.categorie as categorie_naam 
                FROM artikel 
                LEFT JOIN categorie ON artikel.categorie_id = categorie.id 
                ORDER BY artikel.id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*
     * Haalt één artikel op basis van ID
     */
    public function haalOpById($id) {
        $sql = "SELECT * FROM artikel WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /*
     * Voegt nieuw artikel toe
     */
    public function toevoegen($naam, $categorie_id, $prijs_ex_btw) {
        $sql = "INSERT INTO artikel (naam, categorie_id, prijs_ex_btw) VALUES (:naam, :categorie_id, :prijs)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'naam' => $naam,
            'categorie_id' => $categorie_id,
            'prijs' => $prijs_ex_btw
        ]);
    }
    
    /*
     * Werkt artikel bij
     */
    public function bijwerken($id, $naam, $categorie_id, $prijs_ex_btw) {
        $sql = "UPDATE artikel SET naam = :naam, categorie_id = :categorie_id, prijs_ex_btw = :prijs WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'naam' => $naam,
            'categorie_id' => $categorie_id,
            'prijs' => $prijs_ex_btw,
            'id' => $id
        ]);
    }
    
    /*
     * Verwijdert artikel
     */
    public function verwijderen($id) {
        $sql = "DELETE FROM artikel WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
