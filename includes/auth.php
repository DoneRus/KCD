<?php
/*
  - Versie: 1.2
  - Datum: 28-01-2026
  - Beschrijving: Spared from the gebruiker class, formerly dbFunctions.php, now standalone as auth functions
 */

// checks if there are sessions and if not starts one, with the purpose of checking if user is logged in using id
function isIngelogd() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['gebruiker_id']);
}
// checks if logged in user is admin by checking session role
function isAdmin() {
    if (!isIngelogd()) {
        return false;
    }
    return $_SESSION['rol'] == 'admin';
}

// sends you somewhere else if not logged in
function checkLogin() {
    if (!isIngelogd()) {
        header("Location: login.php");
        exit;
    }
}

// sends you somewhere else if not admin
function checkAdmin() {
    checkLogin();
    if (!isAdmin()) {
        header("Location: index.php");
        exit;
    }
}
?>
