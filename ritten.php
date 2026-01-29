<?php
/*
 * Versie: 1.2
 * Datum: 28-01-2026
 * Beschrijving: Ritten planning pagina
 */

require_once 'classes/Database.php';
require_once 'classes/Planning.php';
require_once 'classes/Artikel.php';
require_once 'classes/Klant.php';
require_once 'includes/auth.php';

checkLogin();

// Database en objecten aanmaken
$database = new Database();
$db = $database->getConnection();
$planning = new Planning($db);
$artikel = new Artikel($db);
$klant = new Klant($db);

$melding = "";
$meldingType = "";
$bewerken = false;
$bewerkPlanning = null;

// Verwijderen
if (isset($_GET['verwijder'])) {
    $planning->verwijderen($_GET['verwijder']);
    $melding = "Rit verwijderd!";
    $meldingType = "success";
}

// Bewerken ophalen
if (isset($_GET['bewerk'])) {
    $bewerkPlanning = $planning->haalOpById($_GET['bewerk']);
    if ($bewerkPlanning) {
        $bewerken = true;
    }
}

// Formulier verwerken
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artikel_id = $_POST['artikel_id'];
    $klant_id = $_POST['klant_id'];
    $kenteken = trim($_POST['kenteken']);
    $ophalen_of_bezorgen = $_POST['ophalen_of_bezorgen'];
    $afspraak_op = $_POST['afspraak_op'];
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    
    if (empty($artikel_id) || empty($klant_id) || empty($kenteken) || empty($afspraak_op)) {
        $melding = "Vul alle velden in.";
        $meldingType = "danger";
    } else {
        if ($id) {
            $planning->bijwerken($id, $artikel_id, $klant_id, $kenteken, $ophalen_of_bezorgen, $afspraak_op);
            $melding = "Rit bijgewerkt!";
        } else {
            $planning->toevoegen($artikel_id, $klant_id, $kenteken, $ophalen_of_bezorgen, $afspraak_op);
            $melding = "Rit toegevoegd!";
        }
        $meldingType = "success";
        $bewerken = false;
    }
}

// Data ophalen
$planningen = $planning->haalAlleOp();
$artikelen = $artikel->haalAlleOp();
$klanten = $klant->haalAlleOp();

require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ritten Planning</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#planningModal">Nieuw</button>
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
                    <th>Datum/Tijd</th>
                    <th>Type</th>
                    <th>Klant</th>
                    <th>Adres</th>
                    <th>Artikel</th>
                    <th>Kenteken</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($planningen as $plan): ?>
                    <tr>
                        <td><?php echo $plan['id']; ?></td>
                        <td><?php echo date('d-m-Y H:i', strtotime($plan['afspraak_op'])); ?></td>
                        <td>
                            <?php if ($plan['ophalen_of_bezorgen'] == 'ophalen'): ?>
                                <span class="badge bg-info">Ophalen</span>
                            <?php else: ?>
                                <span class="badge bg-success">Bezorgen</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($plan['klant_naam'] ?? 'Onbekend'); ?></td>
                        <td><?php echo htmlspecialchars(($plan['klant_adres'] ?? '') . ', ' . ($plan['klant_plaats'] ?? '')); ?></td>
                        <td><?php echo htmlspecialchars($plan['artikel_naam'] ?? 'Onbekend'); ?></td>
                        <td><?php echo htmlspecialchars($plan['kenteken']); ?></td>
                        <td>
                            <a href="?bewerk=<?php echo $plan['id']; ?>" class="btn btn-sm btn-warning">Bewerken</a>
                            <a href="?verwijder=<?php echo $plan['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- modal voor toevoegen
 -->
<div class="modal fade" id="planningModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nieuwe Rit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="ophalen_of_bezorgen" required>
                            <option value="ophalen">Ophalen</option>
                            <option value="bezorgen">Bezorgen</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Klant</label>
                        <select class="form-select" name="klant_id" required>
                            <option value="">-- Kies --</option>
                            <?php foreach ($klanten as $k): ?>
                                <option value="<?php echo $k['id']; ?>"><?php echo htmlspecialchars($k['naam'] . ' - ' . $k['adres']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Artikel</label>
                        <select class="form-select" name="artikel_id" required>
                            <option value="">-- Kies --</option>
                            <?php foreach ($artikelen as $art): ?>
                                <option value="<?php echo $art['id']; ?>"><?php echo htmlspecialchars($art['naam']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kenteken</label>
                        <input type="text" class="form-control" name="kenteken" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Afspraak datum/tijd</label>
                        <input type="datetime-local" class="form-control" name="afspraak_op" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Toevoegen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal voor beewerken -->
<?php if ($bewerken && $bewerkPlanning): ?>
<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rit Bewerken</h5>
                <a href="ritten.php" class="btn-close"></a>
            </div>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $bewerkPlanning['id']; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="ophalen_of_bezorgen" required>
                            <option value="ophalen" <?php echo ($bewerkPlanning['ophalen_of_bezorgen'] == 'ophalen') ? 'selected' : ''; ?>>Ophalen</option>
                            <option value="bezorgen" <?php echo ($bewerkPlanning['ophalen_of_bezorgen'] == 'bezorgen') ? 'selected' : ''; ?>>Bezorgen</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Klant</label>
                        <select class="form-select" name="klant_id" required>
                            <?php foreach ($klanten as $k): ?>
                                <option value="<?php echo $k['id']; ?>" <?php echo ($k['id'] == $bewerkPlanning['klant_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($k['naam'] . ' - ' . $k['adres']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Artikel</label>
                        <select class="form-select" name="artikel_id" required>
                            <?php foreach ($artikelen as $art): ?>
                                <option value="<?php echo $art['id']; ?>" <?php echo ($art['id'] == $bewerkPlanning['artikel_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($art['naam']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kenteken</label>
                        <input type="text" class="form-control" name="kenteken" value="<?php echo htmlspecialchars($bewerkPlanning['kenteken']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Afspraak datum/tijd</label>
                        <input type="datetime-local" class="form-control" name="afspraak_op" value="<?php echo date('Y-m-d\TH:i', strtotime($bewerkPlanning['afspraak_op'])); ?>" required>
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