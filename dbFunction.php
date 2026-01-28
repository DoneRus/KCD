
    <?php
    require_once 'dbConnect.php';  
   // session_start(); not gonna make the same mistake

   // use this to write function in code  //gebruikersnaam | wachtwoord
class dbFunction { //this class makes database connection by allowing creation of objects that are similiar to it
    private $conn;

    public function __construct() {
        $db = new dbConnect();
        $this->conn = $db->conn;
    }

    /**
     * Registreer een nieuwe gebruiker.
     * Database-kolommen (zie database.txt):
     * - gebruikersnaam (varchar)
     * - wachtwoord (varchar, gehasht)
     * - rollen (text)          -> hier zetten we bv. 'gebruiker'
     * - is_geverifieerd (tinyint) -> 0 = niet geverifieerd, 1 = actief
     */
    public function UserRegister($gebruikersnaam, $wachtwoord, $rollen = 'gebruiker', $isGeverifieerd = 0) {
        // Wachtwoord veilig hashen
        $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare(
            "INSERT INTO gebruiker (gebruikersnaam, wachtwoord, rollen, is_geverifieerd)
             VALUES (:gebruikersnaam, :wachtwoord, :rollen, :is_geverifieerd)"
        );

        $stmt->bindParam(":gebruikersnaam", $gebruikersnaam);
        $stmt->bindParam(":wachtwoord", $wachtwoordHash);
        $stmt->bindParam(":rollen", $rollen);
        $stmt->bindParam(":is_geverifieerd", $isGeverifieerd, PDO::PARAM_INT);

        return $stmt->execute(); // TRUE of FALSE
    }

    /**
     * Login gebruiker.
     * - Zoekt gebruiker op gebruikersnaam
     * - Verifieert wachtwoord met password_verify
     * - Laat alleen gebruikers toe met is_geverifieerd = 1 (actief)
     */
    public function Login($gebruikersnaam, $wachtwoord) {
        $stmt = $this->conn->prepare(
            "SELECT id, gebruikersnaam, wachtwoord, rollen, is_geverifieerd
             FROM gebruiker
             WHERE gebruikersnaam = :gebruikersnaam"
        );
        $stmt->bindParam(":gebruikersnaam", $gebruikersnaam);

        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Controleer of gebruiker bestaat, wachtwoord klopt en account geverifieerd is
        if (
            $user_data &&
            password_verify($wachtwoord, $user_data['wachtwoord']) &&
            (int)$user_data['is_geverifieerd'] === 1
        ) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['login'] = true;
            $_SESSION['uid'] = $user_data['id'];
            $_SESSION['gebruikersnaam'] = $user_data['gebruikersnaam'];
            $_SESSION['rollen'] = $user_data['rollen'] ?? null;
            $_SESSION['is_geverifieerd'] = (int)$user_data['is_geverifieerd'];

            return true;
        }

        return false;
    }

public function isUserExist($gebruikersnaam) {
    // Check if the user exists in the database
    $stmt = $this->conn->prepare("SELECT id FROM gebruiker WHERE gebruikersnaam = :gebruikersnaam");
    $stmt->bindParam(":gebruikersnaam", $gebruikersnaam);
    
    if ($stmt->execute()) {
        $result = $stmt->fetch();
        // The fetch() method returns a single row, so check if $result is not false
        return $result !== false; 
    }
    
    return false; // Return false if the execution failed
}


}