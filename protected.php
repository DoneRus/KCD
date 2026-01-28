<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beveiligde Pagina - Centrum Duurzaam</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<!-- Navigatiebalk voor niet-ingelogde gebruikers -->
    <nav class="navbar">
        <ul class="nav-links">
            <!-- Home (wijst naar protected want je bent niet ingelogd) -->
            <li><a href="protected.php">Centrum Duurzaam</a></li>
        
<!-- Alle menu items wijzen naar deze protected pagina, als je niet ingelogd bent -->
            <li class="dropdown">
                <!-- Ritten - niet beschikbaar zonder login -->
                <a href="protected.php" class="dropbtn">Ritten</a>
                <div class="dropdown-content">
                    <a href="protected.php">Link 1</a>
                    <a href="protected.php">Link 2</a>
                    <a href="protected.php">Link 3</a>
                </div>
                <li class="dropdown">
                <!-- Voorraad - niet beschikbaar zonder login -->
                <a href="protected.php" class="dropbtn">Voorraad beheer</a>
                <div class="dropdown-content">
                    <a href="protected.php">Link 2</a>
                    <a href="protected.php">Link 3</a>
                </div>
                <li class="dropdown">
                <!-- Admin - niet beschikbaar zonder login -->
                <a href="protected.php" class="dropbtn">Admin</a>
                <div class="dropdown-content">
                    <a href="protected.php">Link 1</a>
                    <a href="protected.php">Link 2</a>
                    <a href="protected.php">Link 3</a>
                </div>
            </li>
            <!-- Login knop zodat je kan inloggen -->
            <li class="login-link">
                <a href="login.php" class="login-btn-nav">Inloggen</a>
            </li>
        </ul>
    </nav>

    <!-- Error melding container -->
    <div class="page-container">
        <div class="error-container">
            <div class="error-box">
                <!-- Duidelijke foutmelding dat je niet ingelogd bent -->
                <h1>Toegang Geweigerd</h1>
                <p>Deze pagina is beveiligd. Je moet ingelogd zijn om deze inhoud te bekijken.</p>
                <p>Klik op de knop "Inloggen" in de navigatiebalk om in te loggen.</p>
                <!-- Link naar login pagina -->
                <a href="login.php" class="error-login-btn">Ga naar login</a>
            </div>
        </div>
    </div>

</body>
</html>
