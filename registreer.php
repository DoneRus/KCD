<?php
/*
 * Versie: 1.0
 * Datum: 28-01-2026
 * Beschrijving: Registratie pagina
 */

require_once 'classes/Database.php';
require_once 'classes/Gebruiker.php';

session_start();

$melding = "";
$meldingType = "";

// Formulier verwerken
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gebruikersnaam = trim($_POST['gebruikersnaam']);
    $wachtwoord = $_POST['wachtwoord'];
    $wachtwoord2 = $_POST['wachtwoord2'];
    
    // Validatie
    if (empty($gebruikersnaam) || empty($wachtwoord)) {
        $melding = "Vul alle velden in.";
        $meldingType = "danger";
    } elseif ($wachtwoord != $wachtwoord2) {
        $melding = "Wachtwoorden komen niet overeen.";
        $meldingType = "danger";
    } elseif (strlen($wachtwoord) < 6) {
        $melding = "Wachtwoord moet minimaal 6 tekens zijn.";
        $meldingType = "danger";
    } else {
        // Database en Gebruiker object
        $database = new Database();
        $db = $database->getConnection();
        $gebruiker = new Gebruiker($db);
        
        // Check of gebruikersnaam al bestaat
        if ($gebruiker->zoekOpGebruikersnaam($gebruikersnaam)) {
            $melding = "Deze gebruikersnaam is al in gebruik.";
            $meldingType = "danger";
        } else {
            // Gebruiker aanmaken (niet geverifieerd)
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
