<?php
/*
 * Versie: 1.0
 * Datum: 28-01-2026
 * Beschrijving: Homepagina met overzicht van alle functies
 */

require_once 'includes/header.php';
?>

<h1 class="mb-4">Welkom bij Kringloop Duurzaam</h1>
<p class="lead">Beheer je ritten, voorraden en klanten op één plek.</p>

<div class="row mt-5">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><strong>Ritten</strong></h5>
                <p class="card-text">Ritten plannen, bekijken en afvinken.</p>
                <a href="ritten.php" class="btn btn-primary">Ga naar ritten</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><strong>Voorraad beheer</strong></h5>
                <p class="card-text">Voorraden checken en bijhouden.</p>
                <a href="voorraad.php" class="btn btn-primary">Ga naar voorraad beheer</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><strong>Categorieën</strong></h5>
                <p class="card-text">Categorieën beheren.</p>
                <a href="categorie.php" class="btn btn-primary">Ga naar categorieën</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><strong>Klanten</strong></h5>
                <p class="card-text">Klantgegevens bekijken en beheren.</p>
                <a href="klanten.php" class="btn btn-primary">Ga naar klanten</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
