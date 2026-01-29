<?php
/*
 * Versie: 1.2
 * Datum: 28-01-2026
 * Beschrijving: Verkoop class voor verkopen registreren
 */

class Verkoop {
    public $id;
    public $klant_id;
    public $artikel_id;
    public $verkocht_op;
    
    private $db;
    
    /*
     * Constructor: ontvangt database connectie
     */
    public function __construct($db) {
        $this->db = $db;
    }
    
    /*
     * Haalt alle verkopen op met artikel en klant gegevens
     * Optioneel gefilterd op datum
     */
    public function haalAlleOp($van = null, $tot = null) {
        $sql = "SELECT verkopen.*, artikel.naam as artikel_naam, artikel.prijs_ex_btw, klant.naam as klant_naam
                FROM verkopen 
                LEFT JOIN artikel ON verkopen.artikel_id = artikel.id 
                LEFT JOIN klant ON verkopen.klant_id = klant.id";
        
        if ($van && $tot) {
            $sql .= " WHERE DATE(verkopen.verkocht_op) BETWEEN :van AND :tot";
        }
        
        $sql .= " ORDER BY verkopen.verkocht_op DESC";
        
        $stmt = $this->db->prepare($sql);
        
        if ($van && $tot) {
            $stmt->execute(['van' => $van, 'tot' => $tot]);
        } else {
            $stmt->execute();
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*
     * Voegt nieuwe verkoop toe
     */
    public function toevoegen($klant_id, $artikel_id) {
        $sql = "INSERT INTO verkopen (klant_id, artikel_id, verkocht_op) VALUES (:klant_id, :artikel_id, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'klant_id' => $klant_id,
            'artikel_id' => $artikel_id
        ]);
    }
    
    /*
     * Verwijdert verkoop
     */
    public function verwijderen($id) {
        $sql = "DELETE FROM verkopen WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    /*
     * Berekent totale opbrengst van verkopen array
     */
    public function berekenTotaal($verkopen) {
        $totaal = 0;
        foreach ($verkopen as $v) {
            $totaal += $v['prijs_ex_btw'];
        }
        return $totaal;
    }
}
?>
