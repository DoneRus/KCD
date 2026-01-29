<?php
/*
 * Versie: 1.2
 * Datum: 28-01-2026
 * Beschrijving: Artikel beheer pagina
 */

require_once 'classes/Database.php';
require_once 'classes/Artikel.php';
require_once 'classes/Categorie.php';
require_once 'includes/auth.php';

checkLogin();

// Database en objecten aanmaken
$database = new Database();
$db = $database->getConnection();
$artikel = new Artikel($db);
$categorie = new Categorie($db);

$melding = "";
$meldingType = "";
$bewerken = false;
$bewerkArtikel = null;

// Verwijderen
if (isset($_GET['verwijder'])) {
    $artikel->verwijderen($_GET['verwijder']);
    $melding = "Artikel verwijderd!";
    $meldingType = "success";
}

// Bewerken ophalen
if (isset($_GET['bewerk'])) {
    $bewerkArtikel = $artikel->haalOpById($_GET['bewerk']);
    if ($bewerkArtikel) {
        $bewerken = true;
    }
}

// Formulier verwerken
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = trim($_POST['naam']);
    $categorie_id = $_POST['categorie_id'];
    $prijs = $_POST['prijs_ex_btw'];
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    
    if (empty($naam) || empty($categorie_id) || empty($prijs)) {
        $melding = "Vul alle velden in.";
        $meldingType = "danger";
    } else {
        if ($id) {
            $artikel->bijwerken($id, $naam, $categorie_id, $prijs);
            $melding = "Artikel bijgewerkt!";
        } else {
            $artikel->toevoegen($naam, $categorie_id, $prijs);
            $melding = "Artikel toegevoegd!";
        }
        $meldingType = "success";
        $bewerken = false;
    }
}

// Data ophalen
$artikelen = $artikel->haalAlleOp();
$categorien = $categorie->haalAlleOp();

require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Artikel Beheer</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#artikelModal">Nieuw</button>
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
                    <th>Categorie</th>
                    <th>Prijs (ex BTW)</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($artikelen as $art): ?>
                    <tr>
                        <td><?php echo $art['id']; ?></td>
                        <td><?php echo htmlspecialchars($art['naam']); ?></td>
                        <td><?php echo htmlspecialchars($art['categorie_naam'] ?? 'Geen'); ?></td>
                        <td>&euro; <?php echo number_format($art['prijs_ex_btw'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="?bewerk=<?php echo $art['id']; ?>" class="btn btn-sm btn-warning">Bewerken</a>
                            <a href="?verwijder=<?php echo $art['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal voor toevoegen -->
<div class="modal fade" id="artikelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nieuw Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Naam</label>
                        <input type="text" class="form-control" name="naam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categorie</label>
                        <select class="form-select" name="categorie_id" required>
                            <option value="">-- Kies --</option>
                            <?php foreach ($categorien as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['categorie']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prijs (ex BTW)</label>
                        <input type="number" class="form-control" name="prijs_ex_btw" step="0.01" required>
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
<?php if ($bewerken && $bewerkArtikel): ?>
<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Artikel Bewerken</h5>
                <a href="artikel.php" class="btn-close"></a>
            </div>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $bewerkArtikel['id']; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Naam</label>
                        <input type="text" class="form-control" name="naam" value="<?php echo htmlspecialchars($bewerkArtikel['naam']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categorie</label>
                        <select class="form-select" name="categorie_id" required>
                            <?php foreach ($categorien as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $bewerkArtikel['categorie_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['categorie']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prijs (ex BTW)</label>
                        <input type="number" class="form-control" name="prijs_ex_btw" step="0.01" value="<?php echo $bewerkArtikel['prijs_ex_btw']; ?>" required>
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
