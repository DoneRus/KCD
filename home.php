
    <?php   
        include_once('dbFunction.php');  
        if (isset($_POST['logout'])){  
            // remove all session variables  
            session_unset();   
      
            // destroy the session   
            session_destroy();  
        }  
        if(!($_SESSION)){  
            header("Location:index.php");  
        }  
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
                            <p>Name: <?php echo $row['fname']; ?></p>
                            <p>Username: <?php echo $row['gebruikersnaam']; ?></p>
                            <p>Password: <?php echo $row['wachtwoord']; ?></p>
                            <a href="logout.php" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    </div>
            </div>
    </div>
    </body>
    </html>
