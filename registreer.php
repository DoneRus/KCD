<?php
/*
 - Versie: 1.3
 - Datum: 29-01-2026
 - Beschrijving: Registratie pagina
 */

require_once 'classes/Database.php';
require_once 'classes/Gebruiker.php';

session_start();

$melding = "";
$meldingType = "";

// Form(storm) works
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gebruikersnaam = trim($_POST['gebruikersnaam']);
    $wachtwoord = $_POST['wachtwoord'];
    $wachtwoord2 = $_POST['wachtwoord2'];
    
    if (empty($gebruikersnaam) || empty($wachtwoord)) { //if either|| fields are empty
        $melding = "Vul alle velden in.";
        $meldingType = "danger";
    } elseif ($wachtwoord != $wachtwoord2) { // password don't match, it's littrally =/ in middle
        $melding = "Wachtwoorden komen niet overeen.";
        $meldingType = "danger";
    } elseif (strlen($wachtwoord) < 6) { // password length check
        $melding = "Wachtwoord moet minimaal 6 tekens zijn.";
        $meldingType = "danger";
    } else {
        // Intersection with database and gebruiker classes/files
        $database = new Database();
        $db = $database->getConnection();
        $gebruiker = new Gebruiker($db);
        
        // Check for existing username
        if ($gebruiker->zoekOpGebruikersnaam($gebruikersnaam)) {
            $melding = "Deze gebruikersnaam is al in gebruik.";
            $meldingType = "danger";
        } else {
            // makes user othewise, but you can't log in yet
            $gebruiker->toevoegen($gebruikersnaam, $wachtwoord, 'medewerker', 0);
            $melding = "Account aangemaakt! Wacht op goedkeuring van een admin.";
            $meldingType = "success";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren - Kringloop Duurzaam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Registreren</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($melding)): ?>
                        <div class="alert alert-<?php echo $meldingType; ?>"><?php echo $melding; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Gebruikersnaam</label>
                            <input type="text" class="form-control" name="gebruikersnaam" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Wachtwoord</label>
                            <input type="password" class="form-control" name="wachtwoord" required>
                            <small class="text-muted">Minimaal 6 tekens</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Wachtwoord bevestigen</label>
                            <input type="password" class="form-control" name="wachtwoord2" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Registreren</button>
                        </div>
                    </form>
                    
                    <hr>
                    <p class="text-center mb-0">
                        Al een account? <a href="login.php">Inloggen</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
