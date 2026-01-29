<?php
/*
 * Versie: 1.1
 * Datum: 29-01-2026
 * Beschrijving: Header met Bootstrap navigatie
 */

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kringloop Duurzaam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Kringloop Duurzaam</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                
                <?php if (isset($_SESSION['gebruiker_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="ritten.php">Ritten</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="voorraad.php">Voorraad</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Beheer</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="ritten.php">Ritten planning</a></li>
                        <li><a class="dropdown-item" href="voorraad.php">Voorraadbeheer</a></li>
                        <li><a class="dropdown-item" href="verkopen.php">Verkopen</a></li>
                        <li><a class="dropdown-item" href="categorie.php">Categorieën</a></li>
                        <li><a class="dropdown-item" href="artikel.php">Artikelen</a></li>
                        <li><a class="dropdown-item" href="klanten.php">Klanten</a></li>
                    </ul>
                </li>
                
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Admin</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="admin_gebruikers.php">Gebruikers beheren</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <?php endif; ?>
            </ul>
            
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['gebruiker_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Uitloggen</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="login.php">Aanmelden</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
