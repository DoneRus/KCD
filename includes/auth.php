<?php
/*
 * Versie: 1.2
 * Datum: 28-01-2026
 * Beschrijving: Functies voor authenticatie (inloggen/uitloggen)
 */

/*
 * Controleert of een gebruiker is ingelogd
 * Start sessie als die nog niet actief is
 * Geeft true terug als gebruiker_id in sessie staat, anders false
 */
function isIngelogd() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['gebruiker_id']);
}

/*
 * Controleert of de ingelogde gebruiker een admin is
 * Geeft true terug als rol 'admin' is, anders false
 */
function isAdmin() {
    if (!isIngelogd()) {
        return false;
    }
    return $_SESSION['rol'] == 'admin';
}

/*
 * Beschermt een pagina voor niet-ingelogde gebruikers
 * Stuurt bezoeker naar login.php als niet ingelogd
 */
function checkLogin() {
    if (!isIngelogd()) {
        header("Location: login.php");
        exit;
    }
}

/*
 * Beschermt een pagina voor niet-admin gebruikers
 * Stuurt bezoeker naar index.php als geen admin
 */
function checkAdmin() {
    checkLogin();
    if (!isAdmin()) {
        header("Location: index.php");
        exit;
    }
}
?>
