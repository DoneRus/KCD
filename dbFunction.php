
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

public function UserRegister($gebruikersnaam, $wachtwoord) {
    // Hash password with md5
    $wachtwoord = md5($wachtwoord);

    // Prepare the SQL statement
    $stmt = $this->conn->prepare(
        "INSERT INTO gebruiker (gebruikersnaam, wachtwoord) VALUES (:gebruikersnaam, :wachtwoord)"
    );

    // Bind parameters for username and password
    $stmt->bindParam(":gebruikersnaam", $gebruikersnaam);
    $stmt->bindParam(":wachtwoord", $wachtwoord);

    // Execute and return the result
    return $stmt->execute(); // returns TRUE or FALSE
}

    public function Login($gebruikersnaam, $wachtwoord) {
        $wachtwoord = md5($wachtwoord);

        $stmt = $this->conn->prepare(
            "SELECT id, gebruikersnaam FROM gebruiker WHERE gebruikersnaam = :gebruikersnaam AND wachtwoord = :wachtwoord"
        );
        $stmt->bindParam( ":gebruikersnaam", $gebruikersnaam);
        $stmt->bindParam( ":wachtwoord", $wachtwoord);

        $stmt->execute();

        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    // fixed to only fetching one time using fetch() instead of fethcing with a different variable, i was stupid // before it ultimately returned false because the second fetch found nothing
        if ($user_data) {
            $_SESSION['login'] = true;
            $_SESSION['uid'] = $user_data['id'];
            $_SESSION['gebruikersnaam'] = $user_data['gebruikersnaam'];
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

//want to get user info by id

public function getUserById($uid) {
    $stmt = $this->conn->prepare("SELECT * FROM gebruiker WHERE id = :uid");
    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


}