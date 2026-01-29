<?php
/*
 * Versie: 1.0
 * Datum: 28-01-2026
 * Beschrijving: Voorraad beheer pagina
 */

require_once 'classes/Database.php';
require_once 'classes/Voorraad.php';
require_once 'classes/Artikel.php';
require_once 'includes/auth.php';

checkLogin();

// Database en objecten aanmaken
$database = new Database();
$db = $database->getConnection();
$voorraad = new Voorraad($db);
$artikel = new Artikel($db);

$melding = "";
$meldingType = "";
$bewerken = false;
$bewerkVoorraad = null;

// Verwijderen
if (isset($_GET['verwijder'])) {
    $voorraad->verwijderen($_GET['verwijder']);
    $melding = "Voorraad item verwijderd!";
    $meldingType = "success";
}

// Bewerken ophalen
if (isset($_GET['bewerk'])) {
    $bewerkVoorraad = $voorraad->haalOpById($_GET['bewerk']);
    if ($bewerkVoorraad) {
        $bewerken = true;
    }
}

// Formulier verwerken
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $artikel_id = $_POST['artikel_id'];
    $locatie = trim($_POST['locatie']);
    $aantal = $_POST['aantal'];
    $status_id = $_POST['status_id'];
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    
    if (empty($artikel_id) || empty($locatie) || empty($status_id)) {
        $melding = "Vul alle velden in.";
        $meldingType = "danger";
    } else {
        if ($id) {
            $voorraad->bijwerken($id, $artikel_id, $locatie, $aantal, $status_id);
            $melding = "Voorraad bijgewerkt!";
        } else {
            $voorraad->toevoegen($artikel_id, $locatie, $aantal, $status_id);
            $melding = "Voorraad toegevoegd!";
        }
        $meldingType = "success";
        $bewerken = false;
    }
}

// Data ophalen
$voorraadItems = $voorraad->haalAlleOp();
$artikelen = $artikel->haalAlleOp();

// Status ophalen
$sqlStat = "SELECT * FROM status ORDER BY id";
$resultStat = $db->query($sqlStat);
$statussen = $resultStat->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Voorraad Beheer</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#voorraadModal">Nieuw</button>
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
                    <th>Artikel</th>
                    <th>Locatie</th>
                    <th>Aantal</th>
                    <th>Status</th>
                    <th>Ingeboekt op</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($voorraadItems as $item): ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo htmlspecialchars($item['artikel_naam'] ?? 'Onbekend'); ?></td>
                        <td><?php echo htmlspecialchars($item['locatie']); ?></td>
                        <td><?php echo $item['aantal']; ?></td>
                        <td><?php echo htmlspecialchars($item['status_naam'] ?? 'Onbekend'); ?></td>
                        <td><?php echo date('d-m-Y H:i', strtotime($item['ingeboekt_op'])); ?></td>
                        <td>
                            <a href="?bewerk=<?php echo $item['id']; ?>" class="btn btn-sm btn-warning">Bewerken</a>
                            <a href="?verwijder=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal voor toevoegen -->
<div class="modal fade" id="voorraadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nieuw Voorraad Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
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
                        <label class="form-label">Locatie</label>
                        <input type="text" class="form-control" name="locatie" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Aantal</label>
                        <input type="number" class="form-control" name="aantal" value="1" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status_id" required>
                            <option value="">-- Kies --</option>
                            <?php foreach ($statussen as $st): ?>
                                <option value="<?php echo $st['id']; ?>"><?php echo htmlspecialchars($st['status']); ?></option>
                            <?php endforeach; ?>
                        </select>
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
<?php if ($bewerken && $bewerkVoorraad): ?>
<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Voorraad Bewerken</h5>
                <a href="voorraad.php" class="btn-close"></a>
            </div>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $bewerkVoorraad['id']; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Artikel</label>
                        <select class="form-select" name="artikel_id" required>
                            <?php foreach ($artikelen as $art): ?>
                                <option value="<?php echo $art['id']; ?>" <?php echo ($art['id'] == $bewerkVoorraad['artikel_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($art['naam']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Locatie</label>
                        <input type="text" class="form-control" name="locatie" value="<?php echo htmlspecialchars($bewerkVoorraad['locatie']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Aantal</label>
                        <input type="number" class="form-control" name="aantal" value="<?php echo $bewerkVoorraad['aantal']; ?>" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status_id" required>
                            <?php foreach ($statussen as $st): ?>
                                <option value="<?php echo $st['id']; ?>" <?php echo ($st['id'] == $bewerkVoorraad['status_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($st['status']); ?></option>
                            <?php endforeach; ?>
                        </select>
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

