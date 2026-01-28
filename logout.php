<?php
    include_once('dbFunction.php');  
    if(isset($_POST['logout'])){  
        // remove all session variables  
        session_unset();   
  
        // destroy the session   
        session_destroy();  
    } ;
     if(!isset($_SESSION)){  
        header("Location:login.php");  
    }   
?>