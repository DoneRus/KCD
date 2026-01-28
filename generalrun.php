<?php  
    include_once('dbFunction.php');  
       

    // NOTE $funObj is a database variable that will contain all neccesarry database creds | wachtwoord | gebruikersnaam
    $funObj = new dbFunction();  
    if (isset($_POST['login'])) {
    $gebruikersnaamid = $_POST['gebruikersnaamid'] ?? '';
    $wachtwoord = $_POST['wachtwoord'] ?? '';

    $user = $funObj->Login($gebruikersnaamid, $wachtwoord);
    // check if the user variable has the right credits
    if ($user) {
        header("Location: home.php"); //each submit that is right sends you to .....
        //Maybe create a session from here or not
        exit;
    } else {
        echo "<script>alert('gebruikersnaam / wachtwoord Not Match')</script>";
    }
}
    if(isset($_POST['register'])){  
        $gebruikersnaamid = $_POST['gebruikersnaamid'];  
        $wachtwoord = $_POST['wachtwoord'];  
        $confirmWachtwoord = $_POST['confirm_wachtwoord'];  
        if($wachtwoord == $confirmWachtwoord){  
            $gebruikersnaam = $funObj->isUserExist($gebruikersnaamid);  
            if(!$gebruikersnaam){  
                $register = $funObj->UserRegister($gebruikersnaamid, $wachtwoord); 
                 //using funObj check if there is already a user with similiar name and if not create user
                if($register){  
                     echo "<script>alert('Registration Successful')</script>";  
                }else{  
                    echo "<script>alert('Registration Not Successful')</script>";  
                }  
            } else {  
                echo "<script>alert('gebruikersnaam Already Exist')</script>";  
            }  
        } else {  
            echo "<script>alert('Password Not Match')</script>";  
          
        }  
    }  
?>   