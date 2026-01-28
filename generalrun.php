<?php  
    include_once('dbFunction.php');  
       
    $funObj = new dbFunction();  
    if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = $funObj->Login($username, $password);
    // check if the user variable has the right credits
    if ($user) {
        header("Location: home.php");
        //Maybe create a session from here or not
        exit;
    } else {
        echo "<script>alert('Username / Password Not Match')</script>";
    }
}
    if(isset($_POST['register'])){  
        $username = $_POST['username'];  
        $password = $_POST['password'];  
        $confirmPassword = $_POST['confirm_password'];  
        if($password == $confirmPassword){  
            $username = $funObj->isUserExist($username);  
            if(!$username){  
                $register = $funObj->UserRegister($username, $password); 
                 //using funObj check if there is already a user with similiar name and if not create user
                if($register){  
                     echo "<script>alert('Registration Successful')</script>";  
                }else{  
                    echo "<script>alert('Registration Not Successful')</script>";  
                }  
            } else {  
                echo "<script>alert('username Already Exist')</script>";  
            }  
        } else {  
            echo "<script>alert('Password Not Match')</script>";  
          
        }  
    }  
?>   