<?php
// Verwerk login via database-functies
include 'generalrun.php';
?>
<!DOCTYPE html>
<html lang="nl" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title>Inloggen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap 5 CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >



    <link rel="icon" href="img/nficon.ico" />
</head>
<body class="bg-light">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-sm-10 col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h3 mb-4 text-center">Inloggen</h1>

                        <form name="login" method="post" action="">
                            <div class="mb-3">
                                <label for="emailsignup" class="form-label">Gebruikersnaam</label>
                                <input
                                    id="emailsignup"
                                    name="gebruikersnaamid"
                                    type="text"
                                    class="form-control"
                                    required
                                    placeholder="Vul uw gebruikersnaam in"
                                >
                            </div>

                            <div class="mb-3">
                                <label for="wachtwoord" class="form-label">Wachtwoord</label>
                                <input
                                    id="wachtwoord"
                                    name="wachtwoord"
                                    type="password"
                                    class="form-control"
                                    required
                                    placeholder="Vul uw wachtwoord in"
                                >
                            </div>

                            <div class="mb-3 form-check">
                                <input
                                    type="checkbox"
                                    class="form-check-input"
                                    name="loginkeeping"
                                    id="loginkeeping"
                                    value="loginkeeping"
                                >
                                <label class="form-check-label" for="loginkeeping">
                                    Ingelogd blijven
                                </label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" name="login" class="btn btn-primary">
                                    Inloggen
                                </button>
                            </div>

                            <p class="text-center mb-0">
                                Nog geen account?
                                <a href="register.php">Registreer nu</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
    ></script>
</body>
</html>


include 'generalrun.php';



 if (($_SESSION)){
    echo "there is a session here";
   };
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
                <!-- Het login formulier -->
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Gebruikersnaam</label>
                        <input type="text" id="username" name="gebruikersnaamid" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Wachtwoord</label>
                        <input type="password" id="password" name="wachtwoord" required>
                    </div>
                    <button type="submit" name="login" class="login-btn">Inloggen</button>
                </form>
                <!-- Demo hint zodat je weet hoe in te loggen -->
                <p class="login-hint">Demo: gebruiker: admin, wachtwoord: password</p>
            </div>
        </div>
    </div>

</body>
</html>

