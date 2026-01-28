
    <?php

    require_once 'dbConnect.php';  
   // session_start(); not gonna make the same mistake

   // use this to write function in code
class dbFunction { //this class makes database connection by allowing creation of objects that are similiar to it
    private $conn;

    public function __construct() {
        $db = new dbConnect();
        $this->conn = $db->conn;
    }

        public function UserRegister($username, $password) {
        // Hash password with md5
        $password = md5($password);

        $stmt = $this->conn->prepare(
            "INSERT INTO user (username , password) VALUES (?, ?)"
        );

        $stmt->bind_param("ss", $username, $password);

        return $stmt->execute(); // returns TRUE or FALSE
    }

    public function Login($username, $password) {
        $password = md5($password);

        $stmt = $this->conn->prepare(
            "SELECT id, username FROM user WHERE username = ? AND password = ?"
        );

        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user_data = $result->fetch_assoc();

            $_SESSION['login'] = true;
            $_SESSION['uid'] = $user_data['id'];
            $_SESSION['username'] = $user_data['username'];

            return true;
        }

        return false;
    }

    public function isUserExist($username) {
        $stmt = $this->conn->prepare(
            "SELECT id FROM user WHERE username = ?"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

}