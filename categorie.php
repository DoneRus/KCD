<?php
/*
 * Versie: 1.4
 * Datum: 29-01-2026
 * Beschrijving: Categorie beheer pagina
 */

require_once 'classes/Database.php';
require_once 'classes/Categorie.php';
require_once 'includes/auth.php';

checkLogin();

// Database en Categorie object aanmaken
$database = new Database();
$db = $database->getConnection();
$categorie = new Categorie($db);

$melding = "";
$meldingType = "";
$bewerken = false;
$bewerkCategorie = null;

// Verwijderen afhandelen
if (isset($_GET['verwijder'])) {
    $categorie->verwijderen($_GET['verwijder']);
    $melding = "Categorie verwijderd!";
    $meldingType = "success";
}

// Bewerken ophalen
if (isset($_GET['bewerk'])) {
    $bewerkCategorie = $categorie->haalOpById($_GET['bewerk']);
    if ($bewerkCategorie) {
        $bewerken = true;
    }
}

// Formulier verwerken
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = trim($_POST['categorie']);
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    
    if (empty($naam)) {
        $melding = "Vul de categorie naam in.";
        $meldingType = "danger";
    } else {
        if ($id) {
            $categorie->bijwerken($id, $naam);
            $melding = "Categorie bijgewerkt!";
        } else {
            $categorie->toevoegen($naam);
            $melding = "Categorie toegevoegd!";
        }
        $meldingType = "success";
        $bewerken = false;
    }
}

// Alle categorieën ophalen
$categorien = $categorie->haalAlleOp();

require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Categorie Beheer</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categorieModal">Nieuw</button>
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
                    <th>Categorie</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorien as $cat): ?>
                    <tr>
                        <td><?php echo $cat['id']; ?></td>
                        <td><?php echo htmlspecialchars($cat['categorie']); ?></td>
                        <td>
                            <a href="?bewerk=<?php echo $cat['id']; ?>" class="btn btn-sm btn-warning">Bewerken</a>
                            <a href="?verwijder=<?php echo $cat['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal voor toevoegen -->
<div class="modal fade" id="categorieModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nieuwe Categorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Categorie naam</label>
                        <input type="text" class="form-control" name="categorie" required>
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
<?php if ($bewerken && $bewerkCategorie): ?>
<div class="modal fade show" id="bewerkModal" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Categorie Bewerken</h5>
                <a href="categorie.php" class="btn-close"></a>
            </div>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $bewerkCategorie['id']; ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Categorie naam</label>
                        <input type="text" class="form-control" name="categorie" value="<?php echo htmlspecialchars($bewerkCategorie['categorie']); ?>" required>
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
