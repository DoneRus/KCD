
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

        $stmt = $this->conn->prepare(
            "INSERT INTO gebruiker (gebruikersnaam , wachtwoord) VALUES (?, ?)"
        );

        $stmt->bind_param("ss", $gebruikersnaam, $wachtwoord);

        return $stmt->execute(); // returns TRUE or FALSE
    }

    public function Login($gebruikersnaam, $wachtwoord) {
        $wachtwoord = md5($wachtwoord);

        $stmt = $this->conn->prepare(
            "SELECT id, gebruikersnaam FROM gebruiker WHERE gebruikersnaam = ? AND wachtwoord = ?"
        );

        $stmt->bind_param("ss", $gebruikersnaam, $wachtwoord);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user_data = $result->fetch_assoc(); //dont forget to learn this

            $_SESSION['login'] = true;
            $_SESSION['uid'] = $user_data['id'];
            $_SESSION['gebruikersnaam'] = $user_data['gebruikersnaam'];

            return true;
        }

        return false;
    }

    public function isUserExist($gebruikersnaam) { // check if the user  exists in the database self-explanatory
        $stmt = $this->conn->prepare(
            "SELECT id FROM gebruiker WHERE gebruikersnaam = ?"
        );

        $stmt->bind_param("s", $gebruikersnaam);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }



}