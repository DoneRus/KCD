<?php
/*
 * Versie: 1.2
 * Datum: 28-01-2026
 * Beschrijving: Verkopen pagina met datumfilter
 */

require_once 'classes/Database.php';
require_once 'classes/Verkoop.php';
require_once 'classes/Artikel.php';
require_once 'classes/Klant.php';
require_once 'includes/auth.php';

checkLogin();

// Database en objecten aanmaken
$database = new Database();
$db = $database->getConnection();
$verkoop = new Verkoop($db);
$artikel = new Artikel($db);
$klant = new Klant($db);

$melding = "";
$meldingType = "";

// Verwijderen
if (isset($_GET['verwijder'])) {
    $verkoop->verwijderen($_GET['verwijder']);
    $melding = "Verkoop verwijderd!";
    $meldingType = "success";
}

// Formulier verwerken
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $klant_id = $_POST['klant_id'];
    $artikel_id = $_POST['artikel_id'];
    
    if (empty($klant_id) || empty($artikel_id)) {
        $melding = "Vul alle velden in.";
        $meldingType = "danger";
    } else {
        $verkoop->toevoegen($klant_id, $artikel_id);
        $melding = "Verkoop geregistreerd!";
        $meldingType = "success";
    }
}

// Filter ophalen
$filterVan = isset($_GET['van']) ? $_GET['van'] : null;
$filterTot = isset($_GET['tot']) ? $_GET['tot'] : null;

// Data ophalen
$verkopen = $verkoop->haalAlleOp($filterVan, $filterTot);
$totaalOpbrengst = $verkoop->berekenTotaal($verkopen);
$artikelen = $artikel->haalAlleOp();
$klanten = $klant->haalAlleOp();

require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Opbrengst Verkopen</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verkoopModal">Nieuw</button>
</div>

<?php if (!empty($melding)): ?>
    <div class="alert alert-<?php echo $meldingType; ?>"><?php echo $melding; ?></div>
<?php endif; ?>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-header">Filter op datum</div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Van datum</label>
                <input type="date" class="form-control" name="van" value="<?php echo $filterVan; ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tot datum</label>
                <input type="date" class="form-control" name="tot" value="<?php echo $filterTot; ?>">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filteren</button>
                <a href="verkopen.php" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel -->
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Datum</th>
                    <th>Klant</th>
                    <th>Artikel</th>
                    <th>Prijs</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($verkopen as $v): ?>
                    <tr>
                        <td><?php echo $v['id']; ?></td>
                        <td><?php echo date('d-m-Y H:i', strtotime($v['verkocht_op'])); ?></td>
                        <td><?php echo htmlspecialchars($v['klant_naam'] ?? 'Onbekend'); ?></td>
                        <td><?php echo htmlspecialchars($v['artikel_naam'] ?? 'Onbekend'); ?></td>
                        <td>&euro; <?php echo number_format($v['prijs_ex_btw'] ?? 0, 2, ',', '.'); ?></td>
                        <td>
                            <a href="?verwijder=<?php echo $v['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="table-success">
                    <td colspan="4"><strong>Totaal opbrengst:</strong></td>
                    <td colspan="2"><strong>&euro; <?php echo number_format($totaalOpbrengst, 2, ',', '.'); ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<!-- Modal voor toevoegen -->
<div class="modal fade" id="verkoopModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nieuwe Verkoop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Klant</label>
                        <select class="form-select" name="klant_id" required>
                            <option value="">-- Kies --</option>
                            <?php foreach ($klanten as $k): ?>
                                <option value="<?php echo $k['id']; ?>"><?php echo htmlspecialchars($k['naam']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Artikel</label>
                        <select class="form-select" name="artikel_id" required>
                            <option value="">-- Kies --</option>
                            <?php foreach ($artikelen as $art): ?>
                                <option value="<?php echo $art['id']; ?>"><?php echo htmlspecialchars($art['naam']); ?> - &euro;<?php echo number_format($art['prijs_ex_btw'], 2, ',', '.'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Registreren</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
