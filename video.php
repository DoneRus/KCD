<?php   
    include_once('dbFunction.php');  
    if(isset($_POST['logout'])){  
        // remove all session variables  
        session_unset();   
  
        // destroy the session   
        session_destroy();  
    } ;
            if(($_SESSION)){  
            header("Location:home.php");  
        }  
   if (($_SESSION)){
    echo "there is a session here";
   };

   
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Netflix</title>
    <link rel="stylesheet" href="css/phone.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="icon" href="img/nficon.ico" />
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="navbar__brand">
        <img src="img/logo.png" alt="Netflix logo" class="brand__logo" />
      </div>

      <div class="navbar__nav__items">
        <div class="nav__item">
          <button onclick="window.location.href='video.php'" class="signin__button">Home</button>
        </div>
        
        <?php
        //WONDERFULL SOLUTION INSTEAD OF "" of echo
        if (empty($_SESSION)) {
    echo <<<HTML
    <div class="nav__item">
        <button onclick="window.location.href='register.php'" class="signin__button">
            Sign up
        </button>
    </div>
    <div class="nav__item">
        <button onclick="window.location.href='login.php'" class="signin__button">
            Log in
        </button>
    </div>
HTML;
}
?>
          
        <?php if (($_SESSION)){
         echo <<<HTML
          <div class='nav__item'>
          <input class='signin__button' type='submit' name='logout' value='Logout' />   
        </div>
        HTML;
        } 
        ?>