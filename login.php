<?php
// Start de session om login gegevens op te slaan
session_start();

// Als je al ingelogd bent, stuur je meteen door naar de homepage
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit;
}

// Variable voor foutmeldingen
$error = '';

// Check of het formulier is ingestuurd (POST)
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal username en password uit het formulier
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Check de inloggegevens (hardcoded voor nu, later database)
    if($username === 'admin' && $password === 'password') {
        // Login succesvol - zet de sesie
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        // Redirect naar homepage
        header("Location: index.php");
        exit;
    } else {
        // Login mislukt
        $error = 'Gebruikersnaam of wachtwoord incorrect';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Centrum Duurzaam</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<!-- Navigatiebalk - niet-ingelogde gebruikers zien only protected links -->
    <nav class="navbar">
        <ul class="nav-links">
            <!-- Home knop -->
            <li><a href="index.php">Centrum Duurzaam</a></li>
        
<!-- Dropdowns - alles wijst naar protected pagina omdat je niet ingelogd bent -->
            <li class="dropdown">
                <!-- Ritten menu item -->
                <a href="protected.php" class="dropbtn">Ritten</a>
                <div class="dropdown-content">
                    <a href="protected.php">Link 1</a>
                    <a href="protected.php">Link 2</a>
                    <a href="protected.php">Link 3</a>
                </div>
                <li class="dropdown">
                <!-- Voorraadbeheer menu -->
                <a href="protected.php" class="dropbtn">Voorraad beheer</a>
                <div class="dropdown-content">
                    <a href="protected.php">Link 2</a>
                    <a href="protected.php">Link 3</a>
                </div>
                <li class="dropdown">
                <!-- Admin menu -->
                <a href="protected.php" class="dropbtn">Admin</a>
                <div class="dropdown-content">
                    <a href="protected.php">Link 1</a>
                    <a href="protected.php">Link 2</a>
                    <a href="protected.php">Link 3</a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Hoofd login formulier -->
    <div class="page-container">
        <div class="login-container">
            <div class="login-box">
                <h1>Inloggen</h1>
                <!-- Foutmelding tonen als login mislukt -->
                <?php if($error): ?>
                    <div class="login-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <!-- Het login formulier -->
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Gebruikersnaam</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Wachtwoord</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" class="login-btn">Inloggen</button>
                </form>
                <!-- Demo hint zodat je weet hoe in te loggen -->
                <p class="login-hint">Demo: gebruiker: admin, wachtwoord: password</p>
            </div>
        </div>
    </div>

</body>
</html>
