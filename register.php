<?php
include 'generalrun.php'
?>
<!DOCTYPE html>  
     <html lang="en" class="no-js">  
     <head>  
            <meta charset="UTF-8" />  
            <title>Login and Registration Form with HTML5 and CSS3</title>  
            <meta name="viewport" content="width=device-width, initial-scale=1.0">   
            <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />  
            <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />  
            <meta name="author" content="Codrops" />  
            <link rel="shortcut icon" href="../favicon.ico">   
    <link rel="stylesheet" href="css/phone.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/page-style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="icon" href="img/nficon.ico" />
        </head>  
        <body>

            <div class="grid-container">  
                                    
    <nav class="navbar">

    </nav>

                            <!--form register start, modify in the future to add more info to the database-->  
                    <div id="container_demo" >  
                         
                        <div id="wrapper">  
                                       <div id="register" class="animate form">  
                                <form name="login" method="post" action="">  
                                    <h1> Sign up </h1>   
                                    <p>   
                                        <label for="usernamesignup" class="uname" data-icon="u">Your username</label>  
                                        <input id="usernamesignup" name="gebruikersnaamid" required="required" type="text" placeholder="mysuperusername690" />  
                                    </p>  
                                    <p>   
                                        <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>  
                                        <input id="passwordsignup" name="wachtwoord" required="required" type="password" placeholder="eg. X8df!90EO"/>  
                                    </p>  
                                    <p>   
                                        <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>  
                                        <input id="passwordsignup_confirm" name="confirm_wachtwoord" required="required" type="password" placeholder="eg. X8df!90EO"/>  
                                    </p>  
                                    <p class="signin button">   
                                        <input type="submit" name="register" value="Sign up"/>   
                                    </p>  
                                    <p class="change_link">    
                                        Already a member ?  
                                        <a href="login.php" class="to_register"> Go and log in </a>  
                                    </p>  
                                </form>  
                            </div>  
                              
                        </div>  
                    </div>    
                 
            </div>  
        </body>  
    </html>  