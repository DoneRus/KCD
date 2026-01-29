<?php
/*
  - Versie: 1.0
  - Datum: 28-01-2026
  - Beschrijving: admin does this shit
 */

require_once 'classes/Database.php';
require_once 'classes/Gebruiker.php';
require_once 'includes/auth.php';

checkAdmin();

// make a new databaase here
$database = new Database();
$db = $database->getConnection(); //INTERSECTIOON again
$gebruiker = new Gebruiker($db);

$melding = "";
$meldingType = "";

// reset password, for gebruikers, only admin can do this
if (isset($_GET['reset']) && is_numeric($_GET['reset'])) { // if reset button on front end is sent then this code will take it and
    $gebruiker->resetWachtwoord($_GET['reset']); //run this function
    $melding = "Wachtwoord is gereset naar: welkom123";
    $meldingType = "success";
}

// delete button on front end
if (isset($_GET['verwijder']) && is_numeric($_GET['verwijder'])) { // if delete button on front end is sent then this code will take it and
    if ($_GET['verwijder'] != $_SESSION['gebruiker_id']) { // if also logged in user is not = to deletion
        $gebruiker->verwijderen($_GET['verwijder']); // then
        $melding = "Gebruiker verwijderd.";
        $meldingType = "success";
    } else {
        $melding = "Je kunt jezelf niet verwijderen."; // prevent admin from deleting themselves, not like there is a button
        $meldingType = "danger";
    }
}

// add new user form processing
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // catches a post request from the form
    $naam = trim($_POST['gebruikersnaam']); //this 
    $wachtwoord = $_POST['wachtwoord']; // and this
    $rol = $_POST['rol']; // and and this
    
    if (empty($naam) || empty($wachtwoord)) { // required field in form with extra steps
        $melding = "Vul alle velden in.";
        $meldingType = "danger";
    } elseif ($gebruiker->zoekOpGebruikersnaam($naam)) {
        $melding = "Deze gebruikersnaam bestaat al.";
        $meldingType = "danger";
    } else {
        $gebruiker->toevoegen($naam, $wachtwoord, $rol, 1); // add user with verified status
        $melding = "Gebruiker '$naam' is aangemaakt!";
        $meldingType = "success";
    }
}

// Select * from gebruikers basic CRUD here, now we can echo inside the html table
$gebruikers = $gebruiker->haalAlleOp();

require_once 'includes/header.php';
?>

<h1 class="mb-4">Gebruikers Beheren</h1>

<?php if (!empty($melding)): // gets messages from if statements inside this file ?>
    <div class="alert alert-<?php echo $meldingType; ?>"><?php echo $melding; ?></div> 
<?php endif; ?>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Nieuwe Gebruiker</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Gebruikersnaam</label>
                        <input type="text" class="form-control" name="gebruikersnaam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Wachtwoord</label>
                        <input type="password" class="form-control" name="wachtwoord" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select class="form-select" name="rol" required>
                            <option value="medewerker">Medewerker</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Aanmaken</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Bestaande Gebruikers</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gebruikersnaam</th>
                            <th>Rol</th>
                            <th>Geverifieerd</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gebruikers as $g): //shortcut $gebruikers to $g ?>
                            <tr>
                                <td><?php echo $g['id']; ?></td>
                                <td><?php echo htmlspecialchars($g['gebruikersnaam']); ?></td>
                                <td><?php echo htmlspecialchars($g['rollen']); ?></td>
                                <td>
                                    <?php if ($g['is_geverifieerd'] == 1): ?>
                                        <span class="badge bg-success">Ja</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Nee</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="?reset=<?php echo $g['id']; ?>" class="btn btn-sm btn-warning" onclick="return confirm('Wachtwoord resetten?')">Reset</a>
                                    <?php if ($g['id'] != $_SESSION['gebruiker_id']): //url button ?>
                                        <a href="?verwijder=<?php echo $g['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Weet je het zeker?')">Verwijder</a>
                                    <?php endif; //url button ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
