<?php
/*
 * Versie: 1.3
 * Datum: 28-01-2026
 * Beschrijving: Klanten beheer pagina
 */

require_once 'classes/Database.php';
require_once 'classes/Klant.php';
require_once 'includes/auth.php';

checkLogin();

// Database en Klant object aanmaken
$database = new Database();
$db = $database->getConnection();
$klant = new Klant($db);

$melding = "";
$meldingType = "";
$bewerken = false;
$bewerkKlant = null;

// Verwijderen
if (isset($_GET['verwijder'])) {
    $klant->verwijderen($_GET['verwijder']);
    $melding = "Klant verwijderd!";
    $meldingType = "success";
}

// Bewerken ophalen
if (isset($_GET['bewerk'])) {
    $bewerkKlant = $klant->haalOpById($_GET['bewerk']);
    if ($bewerkKlant) {
        $bewerken = true;
    }
}

// Formulier verwerken
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = trim($_POST['naam']);
    $adres = trim($_POST['adres']);
    $plaats = trim($_POST['plaats']);
    $telefoon = trim($_POST['telefoon']);
    $email = trim($_POST['email']);
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    
    if (empty($naam) || empty($adres) || empty($plaats)) {
        $melding = "Vul minimaal naam, adres en plaats in.";
        $meldingType = "danger";
    } else {
        if ($id) {
            $klant->bijwerken($id, $naam, $adres, $plaats, $telefoon, $email);
            $melding = "Klant bijgewerkt!";
        } else {
            $klant->toevoegen($naam, $adres, $plaats, $telefoon, $email);
            $melding = "Klant toegevoegd!";
        }
        $meldingType = "success";
        $bewerken = false;
    }
}

// Alle klanten ophalen
$klanten = $klant->haalAlleOp();

require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Klanten Beheer</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#klantModal">Nieuw</button>
</div>

<?php if (!empty($melding)): ?>
    <div class="alert alert-<?php echo $meldingType; ?>"><?php echo $melding; ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Adres</th>
                    <th>Plaats</th>
                    <th>Telefoon</th>
                    <th>Email</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($klanten as $k): ?>
                    <tr>
                        <td><?php echo $k['id']; ?></td>
                        <td><?php echo htmlspecialchars($k['naam']); ?></td>
                        <td><?php echo htmlspecialchars($k['adres']); ?></td>
                        <td><?php echo htmlspecialchars($k['plaats']); ?></td>
                        <td><?php echo htmlspecialchars($k['telefoon']); ?></td>
                        <td><?php echo htmlspecialchars($k['email']); ?></td>
                        <td>
                            <a href="?bewerk=<?php echo $k['id']; ?>" class="btn btn-sm btn-warning">Bewerken</a>
                            <a href="?verwijder=<?php echo $k['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal voor toevoegen -->
<div class="modal fade" id="klantModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nieuwe Klant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Naam *</label>
                        <input type="text" class="form-control" name="naam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adres *</label>
                        <input type="text" class="form-control" name="adres" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Plaats *</label>
                        <input type="text" class="form-control" name="plaats" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefoon</label>
                        <input type="text" class="form-control" name="telefoon">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Toevoegen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal voor bewerken -->
<?php if ($bewerken && $bewerkKlant): ?>
<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Klant Bewerken</h5>
                <a href="klanten.php" class="btn-close"></a>
            </div>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $bewerkKlant['id']; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Naam *</label>
                        <input type="text" class="form-control" name="naam" value="<?php echo htmlspecialchars($bewerkKlant['naam']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adres *</label>
                        <input type="text" class="form-control" name="adres" value="<?php echo htmlspecialchars($bewerkKlant['adres']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Plaats *</label>
                        <input type="text" class="form-control" name="plaats" value="<?php echo htmlspecialchars($bewerkKlant['plaats']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telefoon</label>
                        <input type="text" class="form-control" name="telefoon" value="<?php echo htmlspecialchars($bewerkKlant['telefoon']); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($bewerkKlant['email']); ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
