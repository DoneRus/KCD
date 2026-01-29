
    <?php   
               session_start();
        include_once('dbFunction.php');
        if (isset($_POST['logout'])){  
            // remove all session variables  
            session_unset();   
      
            // destroy the session   
            session_destroy();  
        }  

// wow, clean way to check session and get user info without using if statements bellow or is_array checks

//php now know that there is a session started from login.php after succesful login
if (!isset($_SESSION['uid'])) {
    echo "Not logged in";
    exit;
}
//so? fetch the user info from database, then--
$funObj = new dbFunction();
$user = $funObj->getUserById($_SESSION['uid']);

//Did the database fail to give me a usable user
if (!$user) {
    echo "User not found";
    exit;
}
//no need to is_array or isset checks now, we have the user info


      /*  if (isset($_SESSION['uid'])) {
    $funObj = new dbFunction(); // create database object beacuse dbFunction.php doesn't create one automaticly
    $uid = $_SESSION['uid'];
    $user = $funObj->getUserById($uid);
    }*/

         /*if (($_SESSION)){
    echo "there is a session here";
   }; */ //commented out for cleaner code, test if needed

    ?>  
    <!DOCTYPE html>
    <html>
    <head>
            <title>PHP Login using OOP Approach</title>
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container">
            <h1 class="page-header text-center">PHP Login using OOP Approach</h1>
            <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                            <h2>Welcome to Homepage </h2>
                            <h4>User Info: </h4>
                            <p>Username: <?php  
    echo $user['gebruikersnaam'];
?></p>

                            <p>Wachtwoord: <?php  
    echo $user['wachtwoord'];
?></p>
                            <form method="post" action="logout.php" style="display:inline;"> <!-- friendly reminder a href loads in a GET request not a POST like form, fuck -->
                         <button type="submit" name="logout" class="btn btn-danger">
                          <span class="glyphicon glyphicon-log-out"></span> Logout
                         </button>
                                </form>
                    </div>
            </div>
    </div>
    </body>
    </html>
