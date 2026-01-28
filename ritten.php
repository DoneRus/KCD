<?php
session_start();

// start ritten array als die nog niet bestaat
if (!isset($_SESSION['ritten'])) {
    $_SESSION['ritten'] = array();
}

// nieuwe ritten toevoegen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_rit'])) {
    $bestemming = $_POST['bestemming'] ?? '';
    $klant = $_POST['klant'] ?? '';
    $datum = $_POST['datum'] ?? '';
    
    if (!empty($bestemming) && !empty($klant) && !empty($datum)) {
        $id = time();
        $_SESSION['ritten'][$id] = array(
            'id' => $id,
            'bestemming' => $bestemming,
            'klant' => $klant,
            'datum' => $datum,
            'afgeleverd' => false,
            'items' => array()
        );
        // Redirect om POST data opnieuw in te dienen te voorkomen
        header('Location: ritten.php');
        exit();
    }
}

// Item toevoegen aan een rit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $rit_id = $_POST['rit_id'] ?? '';
    $item_naam = $_POST['item_naam'] ?? '';
    $item_hoeveelheid = $_POST['item_hoeveelheid'] ?? '1';
    
    if (!empty($item_naam) && isset($_SESSION['ritten'][$rit_id])) {
        $item_id = time() . rand(0, 999);
        $_SESSION['ritten'][$rit_id]['items'][$item_id] = array(
            'id' => $item_id,
            'naam' => $item_naam,
            'hoeveelheid' => $item_hoeveelheid,
            'bezorgd' => false
        );
        // Redirect om POST data opnieuw in te dienen te voorkomen
        header('Location: ritten.php');
        exit();
    }
}

// Item als bezorgd markeren
if (isset($_GET['complete_item']) && isset($_GET['rit_id'])) {
    $rit_id = $_GET['rit_id'];
    $item_id = $_GET['complete_item'];
    if (isset($_SESSION['ritten'][$rit_id]) && isset($_SESSION['ritten'][$rit_id]['items'][$item_id])) {
        $_SESSION['ritten'][$rit_id]['items'][$item_id]['bezorgd'] = true;
    }
}

// Item verwijderen
if (isset($_GET['delete_item']) && isset($_GET['rit_id'])) {
    $rit_id = $_GET['rit_id'];
    $item_id = $_GET['delete_item'];
    if (isset($_SESSION['ritten'][$rit_id]) && isset($_SESSION['ritten'][$rit_id]['items'][$item_id])) {
        unset($_SESSION['ritten'][$rit_id]['items'][$item_id]);
    }
}

// Hele rit als afgeleverd markeren
if (isset($_GET['complete'])) {
    $rit_id = $_GET['complete'];
    if (isset($_SESSION['ritten'][$rit_id])) {
        $_SESSION['ritten'][$rit_id]['afgeleverd'] = true;
        // Markeer alle items ook als bezorgd
        foreach ($_SESSION['ritten'][$rit_id]['items'] as &$item) {
            $item['bezorgd'] = true;
        }
        unset($item); // unset reference
    }
}

// Rit verwijderen
if (isset($_GET['delete'])) {
    $rit_id = $_GET['delete'];
    if (isset($_SESSION['ritten'][$rit_id])) {
        unset($_SESSION['ritten'][$rit_id]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ritten Management</title>
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Bootstrap navigatiebalk (zelfde als index.php) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Kringloop centrum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="ritten.php">Ritten</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="voorraad.php">Voorraad beheer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Admin</a>
                    </li>
                </ul>
                <a href="login.php" class="btn btn-outline-light rounded-pill">Aanmelden</a>
            </div>
        </div>
    </nav>

    <!-- Ritten management pagina -->
    <div class="page-container">
        <div class="ritten-section">
            <h1>Ritten Beheer</h1>
            
            <!-- Formulier om een niewe rit toee te voegen -->
            <div class="rit-form-container">
                <h2>Nieuwe rit toevoegen</h2>
                <form method="POST" class="rit-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="bestemming">Bestemming</label>
                            <input type="text" id="bestemming" name="bestemming" placeholder="Bijv. Amsterdam" required>
                        </div>
                        <div class="form-group">
                            <label for="klant">Klant</label>
                            <input type="text" id="klant" name="klant" placeholder="Bedrijfsnaam" required>
                        </div>
                        <div class="form-group">
                            <label for="datum">Datum</label>
                            <input type="date" id="datum" name="datum" required>
                        </div>
                        <button type="submit" name="add_rit" class="btn-add">Rit toevoegen</button>
                    </div>
                </form>
            </div>

            <!-- Accordion met alle ritten -->
            <div class="ritten-accordion-container">
                <h2>Geplande Ritten</h2>
                <?php if (count($_SESSION['ritten']) > 0): ?>
                    <div class="accordion">
                        <?php foreach ($_SESSION['ritten'] as $rit): ?>
                            <!-- Accordion item header -->
                            <div class="accordion-item <?php echo $rit['afgeleverd'] ? 'afgeleverd' : ''; ?>">
                                <!-- Kliik hier om uit te vouwen (toggle) -->
                                <button class="accordion-header" onclick="toggleAccordion(this)">
                                    <span class="accordion-arrow">▶</span>
                                    <span class="accordion-date"><?php echo date('d-m-Y', strtotime($rit['datum'])); ?></span>
                                    <span class="accordion-dest"><?php echo htmlspecialchars($rit['bestemming']); ?></span>
                                    <span class="accordion-klant"><?php echo htmlspecialchars($rit['klant']); ?></span>
                                    <span class="accordion-status">
                                        <?php if ($rit['afgeleverd']): ?>
                                            <span class="status-badge afgeleverd">✓ Afgeleverd</span>
                                        <?php else: ?>
                                            <span class="status-badge in-transit">In transit</span>
                                        <?php endif; ?>
                                    </span>
                                </button>

                                <!-- Accordion content - uitvouwbare gedeelte -->
                                <div class="accordion-content">
                                    <!-- Items tbel (de items die moeten bezorgd worden) -->
                                    <div class="items-section">
                                        <h3>Items voor deze rit</h3>
                                        
                                        <?php if (count($rit['items']) > 0): ?>
                                            <table class="items-table">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Hoeveelheid</th>
                                                        <th>Status</th>
                                                        <th>Acties</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($rit['items'] as $item): ?>
                                                        <tr class="<?php echo $item['bezorgd'] ? 'item-bezorgd' : ''; ?>">
                                                            <td><?php echo htmlspecialchars($item['naam']); ?></td>
                                                            <td><?php echo htmlspecialchars($item['hoeveelheid']); ?></td>
                                                            <td>
                                                                <?php if ($item['bezorgd']): ?>
                                                                    <span class="status-badge afgeleverd">✓ Bezorgd</span>
                                                                <?php else: ?>
                                                                    <span class="status-badge in-transit">Te bezorgen</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <div class="item-actions">
                                                                    <button type="button" class="btn-item btn-item-danger" onclick="deleteItem(<?php echo $rit['id']; ?>, <?php echo $item['id']; ?>)">Verwijderen</button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p class="no-items">Geen items toegevoegd voor deze rit</p>
                                        <?php endif; ?>

                                        <!-- Voeg hier een item toe-->
                                        <div class="add-item-form">
                                            <h4>Item toevoegen</h4>
                                            <form method="POST" class="item-form">
                                                <input type="hidden" name="rit_id" value="<?php echo $rit['id']; ?>">
                                                <div class="item-form-row">
                                                    <input type="text" name="item_naam" placeholder="Item naam" required>
                                                    <input type="number" name="item_hoeveelheid" value="1" min="1" style="width: 80px;">
                                                    <button type="submit" name="add_item" class="btn-add-item">Toevoegen</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Acties voor deze rit -->
                                    <div class="rit-actions">
                                        <?php if (!$rit['afgeleverd']): ?>
                                            <button type="button" class="btn btn-success" onclick="completeRit(<?php echo $rit['id']; ?>)">Hele rit als afgeleverd</button>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-danger" onclick="deleteRit(<?php echo $rit['id']; ?>)">Rit verwijderen</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <!-- Laat dit zien als er geen rien zijn -->
                    <div class="empty-state">
                        <p>Geen ritten gepland. Voeg een rit toe via het formulier hierboven.</p>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>

    <!-- Togle voor accordion functie -->
    <script>
        function toggleAccordion(header) {
            const item = header.parentElement;
            const content = item.querySelector('.accordion-content');
            const arrow = header.querySelector('.accordion-arrow');
            
            // Open/dicht togelen
            item.classList.toggle('open');
        
            if (item.classList.contains('open')) {
                arrow.textContent = '▼';
            } else {
                arrow.textContent = '▶';
            }
        }

        function deleteItem(ritId, itemId) {
            if (confirm('Zeker dat je dit item wil verwijderen?')) {
                window.location.href = '?delete_item=' + itemId + '&rit_id=' + ritId;
            }
        }

        function completeRit(ritId) {
            fetch('?complete=' + ritId)
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
        }

        function deleteRit(ritId) {
            if (confirm('Zeker dat je deze rit wil verwijderen?')) {
                fetch('?delete=' + ritId)
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        }
                    });
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
    ></script>
</body>
</html>
