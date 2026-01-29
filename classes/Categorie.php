<?php
/*
 * Versie: 1.1
 * Datum: 29-01-2026
 * Beschrijving: Categorie class voor CRUD operaties
 */

class Categorie {
    public $id;
    public $categorie;
    
    private $db;
    
    /*
     * Constructor: ontvangt database connectie
     */
    public function __construct($db) {
        $this->db = $db;
    }
    
    /*
     * Haalt alle categorieën op uit de database
     * Geeft array terug met Categorie objecten
     */
    public function haalAlleOp() {
        $sql = "SELECT * FROM categorie ORDER BY id";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*
     * Haalt één categorie op basis van ID
     * Geeft array terug of false als niet gevonden
     */
    public function haalOpById($id) {
        $sql = "SELECT * FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /*
     * Voegt nieuwe categorie toe aan database
     * Geeft true terug bij succes
     */
    public function toevoegen($categorie) {
        $sql = "INSERT INTO categorie (categorie) VALUES (:categorie)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['categorie' => $categorie]);
    }
    
    /*
     * Werkt bestaande categorie bij
     * Geeft true terug bij succes
     */
    public function bijwerken($id, $categorie) {
        $sql = "UPDATE categorie SET categorie = :categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['categorie' => $categorie, 'id' => $id]);
    }
    
    /*
     * Verwijdert categorie uit database
     * Geeft true terug bij succes
     */
    public function verwijderen($id) {
        $sql = "DELETE FROM categorie WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
