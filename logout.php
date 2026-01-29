<?php
/*
 -Versie: 1.1
 - Datum: 28-01-2026
 - Beschrijving: logout by destroying session, pure fire wrath
 */

session_start();
session_destroy();
header("Location: login.php");
exit;
?>
