<?php
/*
 * Versie: 1.3
 * Datum: 29-01-2026
 * Beschrijving: Planning class voor ritten CRUD operaties
 */

class Planning {
    public $id;
    public $artikel_id;
    public $klant_id;
    public $kenteken;
    public $ophalen_of_bezorgen;
    public $afspraak_op;
    
    private $db;
    
    
     /* Cons ontvangt de database connectie*/
    public function __construct($db) {
        $this->db = $db;
    }
    
    
     /* Haalt alle ritten op met artikel en klant gegevens*/
    public function haalAlleOp() {
        $sql = "SELECT planning.*, artikel.naam as artikel_naam, klant.naam as klant_naam, klant.adres as klant_adres, klant.plaats as klant_plaats
                FROM planning 
                LEFT JOIN artikel ON planning.artikel_id = artikel.id 
                LEFT JOIN klant ON planning.klant_id = klant.id 
                ORDER BY planning.afspraak_op ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*Haalt één rit op basis van ID*/
    public function haalOpById($id) {
        $sql = "SELECT * FROM planning WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /*Voegt nieuwe rit toe*/
    public function toevoegen($artikel_id, $klant_id, $kenteken, $ophalen_of_bezorgen, $afspraak_op) {
        $sql = "INSERT INTO planning (artikel_id, klant_id, kenteken, ophalen_of_bezorgen, afspraak_op) VALUES (:artikel_id, :klant_id, :kenteken, :ophalen_of_bezorgen, :afspraak_op)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'artikel_id' => $artikel_id,
            'klant_id' => $klant_id,
            'kenteken' => $kenteken,
            'ophalen_of_bezorgen' => $ophalen_of_bezorgen,
            'afspraak_op' => $afspraak_op
        ]);
    }
    
    /*Werkt rit bij*/
    public function bijwerken($id, $artikel_id, $klant_id, $kenteken, $ophalen_of_bezorgen, $afspraak_op) {
        $sql = "UPDATE planning SET artikel_id = :artikel_id, klant_id = :klant_id, kenteken = :kenteken, ophalen_of_bezorgen = :ophalen_of_bezorgen, afspraak_op = :afspraak_op WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'artikel_id' => $artikel_id,
            'klant_id' => $klant_id,
            'kenteken' => $kenteken,
            'ophalen_of_bezorgen' => $ophalen_of_bezorgen,
            'afspraak_op' => $afspraak_op,
            'id' => $id
        ]);
    }
    
/*Verwiijdert de gekozen rit*/
    public function verwijderen($id) {
        $sql = "DELETE FROM planning WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>
