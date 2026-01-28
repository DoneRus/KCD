
    <?php

    require_once 'dbConnect.php';  
   // session_start(); not gonna make the same mistake

   // use this to write function in code
class dbFunction {
    private $conn;

    public function __construct() {
        $db = new dbConnect();
        $this->conn = $db->conn;
    }


}