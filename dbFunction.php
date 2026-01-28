
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
     * - Gebruikersnaam moet uniek zijn (wordt elders gecheckt met isUserExist)
     * - Wachtwoord wordt veilig gehasht met password_hash
     * - Standaard rol = 'gebruiker'
     * - Standaard status = 'niet_geverifieerd'
     */
    public function UserRegister($gebruikersnaam, $wachtwoord, $rol = 'gebruiker', $status = 'niet_geverifieerd') {
        // Hash password veilig
        $wachtwoordHash = password_hash($wachtwoord, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        $stmt = $this->conn->prepare(
            "INSERT INTO gebruiker (gebruikersnaam, wachtwoord, rol, status)
             VALUES (:gebruikersnaam, :wachtwoord, :rol, :status)"
        );

        // Bind parameters
        $stmt->bindParam(":gebruikersnaam", $gebruikersnaam);
        $stmt->bindParam(":wachtwoord", $wachtwoordHash);
        $stmt->bindParam(":rol", $rol);
        $stmt->bindParam(":status", $status);

        // Execute and return the result
        return $stmt->execute(); // returns TRUE or FALSE
    }

    /**
     * Login gebruiker.
     * - Zoekt gebruiker op gebruikersnaam
     * - Verifieert wachtwoord met password_verify
     * - Zet basis sessiegegevens, inclusief rol en status
     */
    public function Login($gebruikersnaam, $wachtwoord) {
        $stmt = $this->conn->prepare(
            "SELECT id, gebruikersnaam, wachtwoord, rol, status
             FROM gebruiker
             WHERE gebruikersnaam = :gebruikersnaam"
        );
        $stmt->bindParam(":gebruikersnaam", $gebruikersnaam);

        $stmt->execute();
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Controleer of gebruiker bestaat én wachtwoord klopt
        if ($user_data && password_verify($wachtwoord, $user_data['wachtwoord'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['login'] = true;
            $_SESSION['uid'] = $user_data['id'];
            $_SESSION['gebruikersnaam'] = $user_data['gebruikersnaam'];
            $_SESSION['rol'] = $user_data['rol'] ?? null;
            $_SESSION['status'] = $user_data['status'] ?? null;

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