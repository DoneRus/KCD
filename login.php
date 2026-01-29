<?php
/*
 - Versie: 1.2
 - Datum: 28-01-2026
 - Beschrijving: Login pagina
 */

require_once 'classes/Database.php';
require_once 'classes/Gebruiker.php';

session_start();

// header to restrict access if already logged in
if (isset($_SESSION['gebruiker_id'])) {
    header("Location: index.php");
    exit;
}

$foutmelding = "";

// Formulier works
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gebruikersnaam = trim($_POST['gebruikersnaam']); //get rid of wastespace
    $wachtwoord = $_POST['wachtwoord'];
    
    if (empty($gebruikersnaam) || empty($wachtwoord)) {
        $foutmelding = "Vul alle velden in.";
    } else {
        // Database and Gebruiker object
        $database = new Database();
        $db = $database->getConnection(); // HERE is AGAIN where the gebruiker en database files are intersected
        $gebruiker = new Gebruiker($db);
        
        // check  for already existing user
        $gevonden = $gebruiker->zoekOpGebruikersnaam($gebruikersnaam);
        
        if ($gevonden && $gebruiker->controleerWachtwoord($wachtwoord, $gevonden['wachtwoord'])) { //if user found and password matches 
            if ($gevonden['is_geverifieerd'] == 1) { //then do this, only verified users can login, admins verify
                // Login is good, remember this in session
                $_SESSION['gebruiker_id'] = $gevonden['id'];
                $_SESSION['gebruikersnaam'] = $gevonden['gebruikersnaam'];
                $_SESSION['rol'] = $gevonden['rollen'];
                
                header("Location: index.php");
                exit;
            } else {
                $foutmelding = "Je account is nog niet geverifieerd.";
            }
        } else {
            $foutmelding = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen - Kringloop Duurzaam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Inloggen</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($foutmelding)): ?>
                        <div class="alert alert-danger"><?php echo $foutmelding; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Gebruikersnaam</label>
                            <input type="text" class="form-control" name="gebruikersnaam" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Wachtwoord</label>
                            <input type="password" class="form-control" name="wachtwoord" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Inloggen</button>
                        </div>
                    </form>
                    
                    <hr>
                    <p class="text-center mb-0">
                        Nog geen account? <a href="registreer.php">Registreren</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
